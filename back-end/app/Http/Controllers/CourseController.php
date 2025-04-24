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
        $courses = $title->courses()->with('title')->get();
        return view('admin.courses', compact('title', 'courses'));
    }

    public function store(Request $request, Title $title)
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

        Course::create([
            'title_id' => $title->id,
            'admin_id' => Auth::id(),
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.courses', $title->id)
            ->with('success', 'Cours créé avec succès');
    }

    public function update(Request $request, Course $course)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|max:2048',
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
        ]);

        return redirect()->route('admin.courses', $course->title_id)
            ->with('success', 'Cours mis à jour avec succès');
    }

    public function destroy(Course $course)
    {
        if ($course->image) Storage::delete('public/'.$course->image);
        $course->delete();

        return redirect()->route('admin.courses', $course->title_id)
            ->with('success', 'Cours supprimé avec succès');
    }

    public function showCoursesByTitle(Title $title)
    {
        $user = Auth::user();
        
        if ($title->type_permis !== $user->type_permis) {
            abort(403, "Accès non autorisé à ces cours");
        }

        $courses = $title->courses()->get();

        return view('candidats.cours', [
            'title' => $title,
            'courses' => $courses,
            'typePermis' => $user->type_permis
        ]);
    }
}