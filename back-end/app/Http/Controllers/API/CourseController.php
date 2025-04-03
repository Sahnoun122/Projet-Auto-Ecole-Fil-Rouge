<?php
// app/Http/Controllers/CourseController.php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Title;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index($titleId)
    {
        $title = Title::findOrFail($titleId);
        $courses = $title->courses;  
        return response()->json($courses);
    }

    public function store(Request $request, $titleId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('courses', 'public');
        }

        $course = Course::create([
            'title_id' => $titleId,
            'admin_id' => Auth::id(), 
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return response()->json($course, 201); 
    }

    public function show($titleId, $courseId)
    {
        $course = Course::where('title_id', $titleId)->findOrFail($courseId);
        return response()->json($course);
    }

    public function update(Request $request, $titleId, $courseId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
        ]);

        $course = Course::where('title_id', $titleId)->findOrFail($courseId);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('courses', 'public');
        }

        $course->update([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return response()->json($course);
    }

    public function destroy($titleId, $courseId)
    {
        $course = Course::where('title_id', $titleId)->findOrFail($courseId);
        $course->delete();

        return response()->json(['message' => 'Cours supprimé avec succès']);
    }
}
