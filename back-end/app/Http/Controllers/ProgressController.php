<?php

namespace App\Http\Controllers;

use App\Models\Progress;
use App\Models\Course;
use App\Models\Quiz;
use App\Models\Title;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgressController extends Controller
{
    public function trackCourseProgress(Request $request, Course $course)
    {
        $request->validate([
            'progress_percentage' => 'required|integer|min:0|max:100',
            'is_completed' => 'sometimes|boolean'
        ]);

        $progress = Progress::updateOrCreate(
            [
                'candidate_id' => Auth::id(),
                'course_id' => $course->id
            ],
            [
                'progress_percentage' => $request->progress_percentage,
                'is_completed' => $request->is_completed ?? false,
                'completed_at' => $request->is_completed ? now() : null
            ]
        );

        return response()->json($progress);
    }

    public function trackQuizProgress(Request $request, Quiz $quiz)
    {
        $validated = $request->validate([
            'score' => 'required|integer',
            'passed' => 'required|boolean',
            'details' => 'required|array'
        ]);
    
        $details = $this->cleanDetails($validated['details']);
    
        $progress = Progress::create([
            'candidate_id' => Auth::id(),
            'quiz_id' => $quiz->id,
            'course_id' => null,
            'progress_percentage' => ($validated['score'] / 40) * 100,
            'is_completed' => true,
            'completed_at' => now(),
            'details' => $details
        ]);
    
        return response()->json($progress);
    }

    
    
    protected function cleanDetails(array $details)
    {
        return collect($details)->map(function ($item) {
            if (is_array($item)) {
                return $this->cleanDetails($item);
            }
            return is_string($item) || is_int($item) ? $item : strval($item);
        })->toArray();
    }

    public function getUserProgress()
    {
        $user = Auth::user();

        $theoreticalProgress = Title::where('type_permis', $user->type_permis)
            ->with(['courses' => function($query) use ($user) {
                $query->with(['progress' => function($q) use ($user) {
                    $q->where('candidate_id', $user->id);
                }]);
            }])
            ->get();

        $quizProgress = Progress::where('candidate_id', $user->id)
            ->whereNotNull('quiz_id')
            ->with('quiz')
            ->orderBy('completed_at', 'desc')
            ->get();

        return response()->json([
            'theoretical' => $theoreticalProgress,
            'quizzes' => $quizProgress
        ]);
    }

    public function showProgressPage()
    {
        $user = Auth::user();

        $theoreticalProgress = Title::where('type_permis', $user->type_permis)
            ->with(['courses' => function($query) use ($user) {
                $query->with(['progress' => function($q) use ($user) {
                    $q->where('candidate_id', $user->id);
                }]);
            }])
            ->get();

        $quizProgress = Progress::where('candidate_id', $user->id)
            ->whereNotNull('quiz_id')
            ->with('quiz')
            ->orderBy('completed_at', 'desc')
            ->get();

        return view('candidats.progress', [
            'theoreticalProgress' => $theoreticalProgress,
            'quizProgress' => $quizProgress
        ]);
    }
}