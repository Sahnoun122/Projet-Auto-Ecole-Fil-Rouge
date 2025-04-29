<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\ExamFeedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExamFeedbackController extends Controller
{
    public function index(Exam $exam)
    {
        $feedback = $exam->feedbacks()->where('candidat_id', Auth::id())->first();
        
        return response()->json([
            'feedback' => $feedback,
            'exists' => $feedback !== null
        ]);
    }

    public function store(Request $request, Exam $exam)
    {
        $validated = $request->validate([
            'exam_feedback' => 'nullable|string|max:1000',
            'school_comment' => 'nullable|string|max:1000',
            'school_rating' => 'required|integer|min:1|max:5'
        ]);

        $feedback = $exam->feedbacks()->updateOrCreate(
            ['candidat_id' => Auth::id()],
            $validated
        );

        return response()->json([
            'success' => true,
            'feedback' => $feedback,
            'message' => 'Feedback enregistré avec succès!'
        ]);
    }

    public function destroy(Exam $exam)
    {
        $exam->feedbacks()->where('candidat_id', Auth::id())->delete();
        
        return response()->json([
            'success' => true,
            'message' => 'Feedback supprimé avec succès!'
        ]);
    }

    public function adminIndex(Exam $exam)
    {
        $feedbacks = $exam->feedbacks()->with('candidat')->get();
        
        return view('admin.exams.feedbacks', compact('exam', 'feedbacks'));
    }
}