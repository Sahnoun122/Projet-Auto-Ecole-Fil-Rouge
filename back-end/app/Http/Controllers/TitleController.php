<?php

namespace App\Http\Controllers;

use App\Models\Title;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TitleController extends Controller
{
    public function index()
    {
        $titles = Title::withCount('courses')->get();
        return view('admin.titles', compact('titles'));
    }

    public function create()
    {
        return view('admin.titles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:titles',
            'type_permis' => 'required|string|max:10'
        ]);

        Title::create([
            'name' => $request->name,
            'type_permis' => $request->type_permis,
            'admin_id' => Auth::id(),
        ]);

        return redirect()->route('admin.titles')
            ->with('success', 'Titre créé avec succès');
    }

    public function edit(Title $title)
    {
        return view('admin.titles.edit', compact('title'));
    }

    public function update(Request $request, Title $title)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:titles,name,'.$title->id,
            'type_permis' => 'required|string|max:10'
        ]);

        $title->update($request->only(['name', 'type_permis']));

        return redirect()->route('admin.titles')
            ->with('success', 'Titre mis à jour avec succès');
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
        $typePermis = $user->type_permis;
        
        $query = Title::where('type_permis', $typePermis)
                    ->withCount('courses');
    
        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%")
                  ;
            });
        }
    
        $titles = $query->paginate(10); 
    
        return view('candidats.titres', [
            'titles' => $titles,
            'typePermis' => $typePermis,
            'searchTerm' => $request->search ?? null
        ]);
    }
    public function showForCandidat(Title $title)
    {
        $user = Auth::user();
        
        if ($title->type_permis !== $user->type_permis) {
            abort(403, "Accès non autorisé à ces cours");
        }
    
        $courses = $title->courses()->get();
    
        return view('candidats.titres.show', [  
            'title' => $title,
            'courses' => $courses,
            'typePermis' => $user->type_permis
        ]);
    }
}