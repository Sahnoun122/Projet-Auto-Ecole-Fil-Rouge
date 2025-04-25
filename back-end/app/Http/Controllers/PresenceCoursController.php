<?php

namespace App\Http\Controllers;

use App\Models\CoursConduite;
use App\Models\PresenceCours;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PresenceCoursController extends Controller
{
    public function index()
    {
        $cours = CoursConduite::with(['candidat', 'vehicule', 'presences'])
                ->where('moniteur_id', Auth::id())
                ->orderBy('date_heure', 'desc')
                ->paginate(10);

        return view('moniteur.conduite', compact('cours'));
    }

    public function updatePresences(Request $request, $courseId)
    {
        $request->validate([
            'present' => 'nullable|array',
            'notes' => 'nullable|array',
            'notes.*' => 'nullable|string|max:500'
        ]);

        $cours = CoursConduite::where('moniteur_id', Auth::id())
                 ->findOrFail($courseId);
        
        DB::beginTransaction();
        
        try {
            PresenceCours::where('cours_conduite_id', $courseId)->delete();
            
            if ($request->has('present')) {
                foreach ($request->present as $candidatId => $value) {
                    PresenceCours::create([
                        'cours_conduite_id' => $courseId,
                        'candidat_id' => $candidatId,
                        'present' => true,
                        'notes' => $request->notes[$candidatId] ?? null
                    ]);
                }
            }
            
            if ($request->has('notes')) {
                foreach ($request->notes as $candidatId => $notes) {
                    if (!empty($notes) && !isset($request->present[$candidatId])) {
                        PresenceCours::create([
                            'cours_conduite_id' => $courseId,
                            'candidat_id' => $candidatId,
                            'present' => false,
                            'notes' => $notes
                        ]);
                    }
                }
            }
            
            DB::commit();
            return redirect()->route('moniteur.conduite')
                ->with('success', 'Les présences et notes ont été enregistrées avec succès');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Une erreur est survenue lors de l\'enregistrement des présences: ' . $e->getMessage());
        }
    }
}
