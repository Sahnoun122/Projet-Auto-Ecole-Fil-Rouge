<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'admin_id', 'type_permis',];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function Views()
    {
        return $this->hasManyThrough(CourseView::class, Course::class);
    }

    public function getProgressForUser($userId)
    {
        $viewedCourses = $this->courses()
            ->whereHas('views', fn($q) => $q->where('user_id', $userId))
            ->count();
            
        $totalCourses = $this->courses()->count();

        return [
            'viewed' => $viewedCourses,
            'total' => $totalCourses,
            'percentage' => $totalCourses ? round(($viewedCourses / $totalCourses) * 100) : 0
        ];
    }

    public function uniqueCandidatesCount()
    {
        return $this->courseViews()
            ->distinct('user_id')
            ->count('user_id');
    }
}