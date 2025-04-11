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
            $titles = Title::all();
        } else {
            $titles = Title::where('type_permis', Auth::user()->type_permis)->get();
        }
        
        return response()->json($titles);
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

        return response()->json($title, 201);
    }

    public function show(Title $title)
    {
        Gate::authorize('view', $title); 

        $title->load('courses');
        return response()->json($title);
    }

    public function update(Request $request, Title $title)
    {
        Gate::authorize('update', $title); 

        $request->validate([
            'name' => 'required|string|max:255',
            'type_permis' => 'required|string|in:A,B,C,D'
        ]);

        $title->update($request->all());

        return response()->json($title);
    }

    public function destroy(Title $title)
    {
        Gate::authorize('delete', $title);  

        $title->delete();
        return response()->json(['message' => 'Titre supprimé avec succès']);
    }
}
