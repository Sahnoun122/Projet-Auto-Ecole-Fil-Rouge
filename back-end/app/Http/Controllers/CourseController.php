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
        // Gate::authorize('viewAny', Course::class);

        $courses = $title->courses()->with('title')->get();
        return view('admin.courses', compact('title', 'courses'));
    }

    public function store(Request $request, Title $title)
    {
        // Gate::authorize('create', Course::class);

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

        return response()->json([
            'success' => true,
            'course' => $course,
            'message' => 'Cours créé avec succès'
        ]);
    }

    public function update(Request $request, Course $course)
    {
        // Gate::authorize('update', $course);

        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'duration' => 'nullable|integer|min:1'
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

        return response()->json([
            'success' => true,
            'course' => $course,
            'message' => 'Cours mis à jour avec succès'
        ]);
    }

    public function destroy(Course $course)
    {
        // Gate::authorize('delete', $course);

        if ($course->image) Storage::delete('public/'.$course->image);
        $course->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cours supprimé avec succès'
        ]);
    }
}