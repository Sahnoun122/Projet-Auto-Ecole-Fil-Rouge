<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['title_id', 'admin_id', 'title', 'description', 'image'];

    public function courseTitle()
    {
        return $this->belongsTo(Title::class, 'title_id');
    }

    public function views()
    {
        return $this->hasMany(CourseView::class);
    }

    public function markAsViewed($userId)
    {
        return $this->views()->firstOrCreate([
            'user_id' => $userId,
            'course_id' => $this->id
        ]);
    }

    public function hasBeenViewedBy($userId)
    {
        return $this->views()->where('user_id', $userId)->exists();
    }
}