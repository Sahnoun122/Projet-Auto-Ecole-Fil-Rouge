<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'admin_id' , 'type_permis']; 

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function getCandidateProgress($candidateId)
    {
        $totalCourses = $this->courses()->count();
        if ($totalCourses === 0) return 0;

        $totalProgress = 0;
        $completedCourses = 0;

        foreach ($this->courses as $course) {
            $progress = $course->getCandidateProgress($candidateId);
            $totalProgress += $progress['percentage'];
            if ($progress['completed']) $completedCourses++;
        }

        return [
            'percentage' => round($totalProgress / $totalCourses),
            'completed_courses' => $completedCourses,
            'total_courses' => $totalCourses
        ];
    }
}
