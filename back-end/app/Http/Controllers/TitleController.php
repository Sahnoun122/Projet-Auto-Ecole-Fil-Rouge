<?php

namespace App\Http\Controllers;

use App\Models\Title;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class TitleController extends Controller
{
    public function index()
    {
        Gate::authorize('viewAny', Title::class);

        if (Auth::user()->role === 'admin' && Auth::user()->type_permis === 'moniteur') {
            $titles = Title::withCount('courses')->get();
        } else {
            $titles = Title::where('type_permis', Auth::user()->type_permis)
                          ->withCount('courses')
                          ->get();
        }
        
        return view('admin.titles', compact('titles'));
    }

    public function store(Request $request)
    {
        Gate::authorize('create', Title::class);

        $request->validate([
            'name' => 'required|string|max:255|unique:titles',
            'type_permis' => 'required|string|in:A,B,C,D'
        ]);

        $title = Title::create([
            'name' => $request->name,
            'type_permis' => $request->type_permis,
            'admin_id' => Auth::id(),
        ]);

        return response()->json([
            'success' => true,
            'title' => $title,
            'message' => 'Titre créé avec succès'
        ]);
    }

    public function update(Request $request, Title $title)
    {
        Gate::authorize('update', $title);

        $request->validate([
            'name' => 'required|string|max:255|unique:titles,name,'.$title->id,
            'type_permis' => 'required|string|in:A,B,C,D'
        ]);

        $title->update($request->all());

        return response()->json([
            'success' => true,
            'title' => $title,
            'message' => 'Titre mis à jour avec succès'
        ]);
    }

    public function destroy(Title $title)
    {
        Gate::authorize('delete', $title);

        $title->delete();
        return response()->json([
            'success' => true,
            'message' => 'Titre supprimé avec succès'
        ]);
    }
}