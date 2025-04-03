<?php

namespace App\Http\Controllers;

use App\Models\Progress;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;

class ProgressController extends Controller
{
    public function show($candidateId, $courseId)
    {
        $progress = Progress::where('candidate_id', $candidateId)
                            ->where('course_id', $courseId)
                            ->first();

        if ($progress) {
            return response()->json($progress);
        } else {
            return response()->json(['message' => 'No progress found for this candidate and course'], 404);
        }
    }

    public function update(Request $request, $candidateId, $courseId)
    {
        $request->validate([
            'progress_percentage' => 'required|integer|min:0|max:100',
        ]);

        $progress = Progress::updateProgress($candidateId, $courseId, $request->progress_percentage);

        return response()->json($progress);
    }
}
