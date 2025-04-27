<?php

namespace App\Http\Controllers;

use App\Models\Title;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TitleController extends Controller
{
    public function index(Request $request)
    {
        $activeTab = $request->get('tab', 'titles');
        $search = $request->input('search');
        
        $titles = Title::withCount('courses')
            ->when($search, function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('type_permis', 'like', "%$search%");
            })
            ->get();

        return view('admin.titles', compact('titles', 'activeTab'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:titles',
            'type_permis' => 'required|string|max:10'
        ]);

        $title = Title::create([
            'name' => $request->name,
            'type_permis' => $request->type_permis,
            'admin_id' => Auth::id(),
        ]);

        return response()->json(['success' => true, 'title' => $title]);
    }

    public function update(Request $request, Title $title)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:titles,name,'.$title->id,
            'type_permis' => 'required|string|max:10'
        ]);

        $title->update($request->only(['name', 'type_permis']));

        return response()->json(['success' => true, 'title' => $title]);
    }

    public function destroy(Title $title)
    {
        $title->delete();
        return redirect()->route('admin.titles')
            ->with('success', 'Titre supprimé avec succès');
    }

    public function indexForCandidat(Request $request)
    {
        $user = Auth::user();
        $activeTab = $request->get('tab', 'titles');
        $searchTerm = $request->get('search');

        $query = Title::where('type_permis', $user->type_permis)
                    ->withCount('courses');

        if ($searchTerm) {
            $query->where('name', 'like', "%{$searchTerm}%");
        }

        $titles = $query->paginate(10);

        return view('candidats.titres', [
            'titles' => $titles,
            'typePermis' => $user->type_permis,
            'activeTab' => $activeTab,
            'searchTerm' => $searchTerm
        ]);
    }

    public function showForCandidat(Title $title)
    {
        $user = Auth::user();
        
        if ($title->type_permis !== $user->type_permis) {
            abort(403, "Accès non autorisé à ces cours");
        }
    
        $courses = $title->courses()->get();
    
        return view('candidats.titres', [  
            'title' => $title,
            'courses' => $courses,
            'typePermis' => $user->type_permis
        ]);
    }

    public function progress(Title $title, Request $request)
    {
        $search = $request->input('search');
        
        $candidates = User::where('role', 'candidat')
            ->where('type_permis', $title->type_permis)
            ->when($search, function($query) use ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('prenom', 'like', "%$search%")
                      ->orWhere('nom', 'like', "%$search%")
                      ->orWhere('email', 'like', "%$search%");
                });
            })
            ->withCount(['courseViews as total_views' => function($q) use ($title) {
                $q->whereHas('course', function($q) use ($title) {
                    $q->where('title_id', $title->id);
                });
            }])
            ->paginate(10);
    
        return view('admin.progress', [
            'title' => $title,
            'candidates' => $candidates,
            'totalCourses' => $title->courses()->count(),
            'search' => $search
        ]);
    }
    
    public function candidateProgress(Title $title, User $candidate)
    {
        abort_if(
            $candidate->role !== 'candidat' || 
            $candidate->type_permis !== $title->type_permis, 
            403, 
            "Accès non autorisé"
        );
        
        $courses = $title->courses()
            ->with(['views' => function($q) use ($candidate) {
                $q->where('user_id', $candidate->id);
            }])
            ->get();
            $progress = [
            'viewed' => $courses->filter(function($course) {
                return $course->views->count() > 0;
            })->count(),
            'total' => $courses->count(),
            'percentage' => $courses->count() ? 
                round(($courses->filter(function($course) {
                    return $course->views->count() > 0;
                })->count() / $courses->count()) * 100) : 0
        ];
    
        $lastActivity = $candidate->courseViews()
            ->whereHas('course', fn($q) => $q->where('title_id', $title->id))
            ->latest()
            ->first();
    
        return view('admin.candidate-progress', [
            'title' => $title,
            'candidate' => $candidate,
            'courses' => $courses,
            'progress' => $progress,
            'lastActivity' => $lastActivity
        ]);
    }
}