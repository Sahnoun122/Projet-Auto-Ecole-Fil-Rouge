<?php
namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\User;
use App\Models\ExamResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notifications\ExamScheduled;
use App\Notifications\ExamResultPublished;

class ExamController extends Controller
{

    public function index(Request $request)
    {
        $query = Exam::with(['admin', 'candidat', 'examResults']);

        // Filtres de recherche
        if ($search = $request->input('search')) {
            $query->where(function($q) use ($search) {
                $q->where('lieu', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%")
                  ->orWhere('statut', 'like', "%{$search}%")
                  ->orWhereHas('candidat', function($subQuery) use ($search) {
                      $subQuery->where('nom', 'like', "%{$search}%")
                               ->orWhere('prenom', 'like', "%{$search}%");
                  });
            });
        }

        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        if ($statut = $request->input('statut')) {
            $query->where('statut', $statut);
        }

        $exams = $query->latest()->paginate(10);
        $candidats = User::where('role', 'candidat')->get();

        return view('admin.exams', compact('exams', 'candidats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:theorique,pratique',
            'date_exam' => 'required|date|after:now',
            'lieu' => 'required|string|max:100',
            'places_max' => 'required|integer|min:1|max:50',
            'candidat_id' => 'nullable|exists:users,id',
            'instructions' => 'nullable|string|max:500',
            'statut' => 'required|in:planifie,en_cours,termine,annule'
        ]);

        try {
            DB::beginTransaction();

            $exam = Exam::create([
                ...$validated,
                'admin_id' => Auth::id()
            ]);

            if ($exam->candidat_id) {
                $exam->candidat->notify(new ExamScheduled($exam));
            }

            DB::commit();

            return redirect()->route('admin.exams')
                ->with('success', 'Examen créé avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la création de l\'examen : ' . $e->getMessage());
        }
    }



    public function update(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'type' => 'required|in:theorique,pratique',
            'date_exam' => 'required|date|after:now',
            'lieu' => 'required|string|max:100',
            'places_max' => 'required|integer|min:1|max:50',
            'candidat_id' => 'nullable|exists:users,id',
            'instructions' => 'nullable|string|max:500',
            'statut' => 'required|in:planifie,en_cours,termine,annule'
        ]);

        try {
            DB::beginTransaction();

            $exam->update([
                ...$validated,
                'admin_id' => $exam->admin_id ?? Auth::id()
            ]);

            if ($exam->candidat_id) {
                $exam->candidat->notify(new ExamScheduled($exam));
            }

            DB::commit();

            return redirect()->route('admin.exams')
                ->with('success', 'Examen mis à jour avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la mise à jour de l\'examen : ' . $e->getMessage());
        }
    }

 
    public function destroy(Exam $exam)
    {
        try {
            DB::beginTransaction();

            $exam->delete();

            DB::commit();

            return redirect()->route('admin.exams')
                ->with('success', 'Examen supprimé avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la suppression de l\'examen : ' . $e->getMessage());
        }
    }
    public function storeResult(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'candidat_id' => 'required|exists:users,id',
            'present' => 'required|boolean',
            'score' => 'required_if:present,1|nullable|integer|min:0|max:100',
            'resultat' => 'required_if:present,1|nullable|in:excellent,tres_bien,bien,moyen,insuffisant',
            'feedbacks' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $existingResult = ExamResult::where('exam_id', $exam->id)
                ->where('user_id', $validated['candidat_id'])
                ->first();

            if ($existingResult) {
                DB::rollBack();
                return back()->with('error', 'Un résultat existe déjà pour ce candidat.');
            }

            $result = ExamResult::create([
                'exam_id' => $exam->id,
                'user_id' => $validated['candidat_id'],
                'present' => $validated['present'],
                'score' => $validated['present'] ? $validated['score'] : null,
                'resultat' => $validated['present'] ? $validated['resultat'] : null,
                'feedbacks' => $validated['feedbacks'] ?? null
            ]);

            $exam->updateStats();

            $user = User::findOrFail($validated['candidat_id']);
            $user->notify(new ExamResultPublished($exam));

            DB::commit();

            return back()->with('success', 'Résultat enregistré avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de l\'enregistrement du résultat : ' . $e->getMessage());
        }
    }

    public function updateResult(Request $request, Exam $exam, User $candidat)
    {
        $validated = $request->validate([
            'present' => 'required|boolean',
            'score' => 'required_if:present,1|nullable|integer|min:0|max:100',
            'resultat' => 'required_if:present,1|nullable|in:excellent,tres_bien,bien,moyen,insuffisant',
            'feedbacks' => 'nullable|string|max:500'
        ]);

        try {
            DB::beginTransaction();

            $result = ExamResult::where('exam_id', $exam->id)
                ->where('user_id', $candidat->id)
                ->firstOrFail();

            $result->update([
                'present' => $validated['present'],
                'score' => $validated['present'] ? $validated['score'] : null,
                'resultat' => $validated['present'] ? $validated['resultat'] : null,
                'feedbacks' => $validated['feedbacks'] ?? null
            ]);

            $exam->updateStats();

            DB::commit();

            return back()->with('success', 'Résultat mis à jour avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la mise à jour du résultat : ' . $e->getMessage());
        }
    }

    public function checkResult(Exam $exam, User $user)
    {
        $result = ExamResult::where('exam_id', $exam->id)
            ->where('user_id', $user->id)
            ->first();

        return response()->json([
            'exists' => $result !== null,
            'result' => $result ? [
                'present' => $result->present,
                'score' => $result->score,
                'resultat' => $result->resultat,
                'feedbacks' => $result->feedbacks
            ] : null
        ]);
    }
}