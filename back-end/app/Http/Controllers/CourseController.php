<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Title;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;

class CourseController extends Controller
{
    public function index(Title $title)
    {
        Gate::authorize('viewAny', Course::class);

        $courses = $title->courses()->with('title')->get();
        return response()->json($courses);
    }

    public function store(Request $request, Title $title)
    {
        Gate::authorize('create', Course::class);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'duration' => 'required|integer|min:1'
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('courses', 'public');
        }

        $course = Course::create([
            'title_id' => $title->id,
            'admin_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'duration' => $request->duration,
        ]);

        return response()->json($course, 201);
    }

    public function show(Course $course)
    {
        // Autoriser l'action view pour ce cours spécifique
        Gate::authorize('view', $course);

        $course->load(['title', 'progress' => function($q) {
            $q->where('candidate_id', Auth::id());
        }]);
        
        return response()->json($course);
    }

    public function update(Request $request, Course $course)
    {
        Gate::authorize('update', $course);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
            'duration' => 'required|integer|min:1'
        ]);

        $imagePath = $course->image;
        if ($request->hasFile('image')) {
            if ($imagePath) Storage::delete('public/'.$imagePath);
            $imagePath = $request->file('image')->store('courses', 'public');
        }

        $course->update([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'duration' => $request->duration,
        ]);

        return response()->json($course);
    }

    public function destroy(Course $course)
    {
        Gate::authorize('delete', $course);

        if ($course->image) Storage::delete('public/'.$course->image);
        $course->delete();

        return response()->json(['message' => 'Cours supprimé avec succès']);
    }
}
