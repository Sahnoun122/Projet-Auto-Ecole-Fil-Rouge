<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'admin_id', 'type_permis'];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

public function courses()
{
    return $this->hasMany(Course::class);
}

public function getProgressForUser($userId)
{
    $viewedCourses = $this->courses()->whereHas('views', function($q) use ($userId) {
        $q->where('user_id', $userId);
    })->count();

    $totalCourses = $this->courses()->count();

    return [
        'count' => $viewedCourses,
        'total' => $totalCourses,
        'percentage' => $totalCourses > 0 ? round(($viewedCourses / $totalCourses) * 100) : 0
    ];
}
}
