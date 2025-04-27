<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Title;
use App\Models\CourseView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index(Title $title)
    {
        $courses = $title->courses()->with('courseTitle')->get();
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

    public function showCourses(Title $title, Request $request)
    {
        $user = Auth::user();
        
        if ($title->type_permis !== $user->type_permis) {
            abort(403);
        }

        $courses = $title->courses()
            ->withCount(['views' => fn($q) => $q->where('user_id', $user->id)])
            ->when($request->search, fn($q, $search) => $q->where('title', 'like', "%{$search}%"))
            ->get();

        $progress = $title->getProgressForUser($user->id);

        return view('candidats.cours', [
            'title' => $title,
            'courses' => $courses,
            'progress' => $progress,
            'searchTerm' => $request->search ?? '', 
            'typePermis' => $user->type_permis
        ]);
    }

    public function showCourseDetail($courseId)
    {
        $user = Auth::user();
        
        $course = Course::with('courseTitle')->find($courseId);
        
        if (!$course) {
            return response()->json(['error' => 'Cours non trouvé'], 404);
        }
        
        if (!$course->courseTitle) {
            return response()->json(['error' => 'Ce cours n\'a pas de titre associé'], 404);
        }
        
        if ($course->courseTitle->type_permis !== $user->type_permis) {
            return response()->json(['error' => 'Accès non autorisé'], 403);
        }

        $course->markAsViewed($user->id);

        $progress = $course->courseTitle->getProgressForUser($user->id);

        return response()->json([
            'id' => $course->id,
            'title' => $course->title,
            'description' => $course->description,
            'image' => $course->image ? asset('storage/'.$course->image) : null,
            'progress' => $progress
        ]);
    }
}