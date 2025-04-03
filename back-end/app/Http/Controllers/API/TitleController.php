<?php
// app/Http/Controllers/TitleController.php

namespace App\Http\Controllers;

use App\Models\Title;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TitleController extends Controller
{
    public function index()
    {
        $titles = Title::all();
        return response()->json($titles);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $title = Title::create([
            'name' => $request->name,
            'admin_id' => Auth::id(), 
        ]);

        return response()->json($title, 201);
    }

    public function show($id)
    {
        $title = Title::findOrFail($id);
        return response()->json($title);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $title = Title::findOrFail($id);
        $title->update([
            'name' => $request->name,
        ]);

        return response()->json($title);
    }

    public function destroy($id)
    {
        $title = Title::findOrFail($id);
        $title->delete();

        return response()->json(['message' => 'Titre supprimé avec succès']);
    }
}
