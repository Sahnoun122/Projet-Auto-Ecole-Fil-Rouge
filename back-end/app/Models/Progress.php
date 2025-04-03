<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;

    protected $fillable = ['candidate_id', 'course_id', 'progress_percentage'];

    public function candidate()
    {
        return $this->belongsTo(User::class, 'candidate_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public static function updateProgress($candidateId, $courseId, $percentage)
    {
        $progress = Progress::where('candidate_id', $candidateId)
                            ->where('course_id', $courseId)
                            ->first();

        if (!$progress) {
            $progress = Progress::create([
                'candidate_id' => $candidateId,
                'course_id' => $courseId,
                'progress_percentage' => $percentage,
            ]);
        } else {
            $progress->update(['progress_percentage' => $percentage]);
        }

        return $progress;
    }
}
