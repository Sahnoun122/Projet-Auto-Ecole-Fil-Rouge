<?php

namespace App\Http\Controllers;

use App\Models\Progress;
use App\Models\Course;
use App\Models\Title;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ProgressController extends Controller
{
    public function show(Course $course)
    {
        Gate::authorize('view', $course);

        $progress = Progress::where('course_id', $course->id)
                           ->where('candidate_id', Auth::id())
                           ->firstOrFail();
        
        return response()->json($progress);
    }

    public function update(Request $request, Course $course)
    {
        Gate::authorize('update', $course);

        $request->validate([
            'progress_percentage' => 'required|integer|min:0|max:100',
            'is_completed' => 'required|boolean'
        ]);

        $progress = Progress::updateOrCreate(
            [
                'course_id' => $course->id,
                'candidate_id' => Auth::id()
            ],
            [
                'progress_percentage' => $request->progress_percentage,
                'is_completed' => $request->is_completed
            ]
        );

        return response()->json($progress);
    }

    
    public function getUserProgress()
    {
        $user = Auth::user();

        Gate::authorize('viewAny', Progress::class);

        $titles = Title::where('type_permis', $user->type_permis)
                      ->with(['courses' => function($query) use ($user) {
                          $query->with(['progress' => function($q) use ($user) {
                              $q->where('candidate_id', $user->id);
                          }]);
                      }])
                      ->get();

        return response()->json($titles);
    }

}
