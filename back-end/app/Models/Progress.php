<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'course_id' => null, 
        'quiz_id' => null,
        'progress_percentage',
        'is_completed',
        'completed_at',
        'details'
    ];

    protected $casts = [
    'details' => 'array',
    'is_completed' => 'boolean',
    'completed_at' => 'datetime'
];

public function setDetailsAttribute($value)
{
    $this->attributes['details'] = json_encode(
        $this->cleanArray($value),
        JSON_UNESCAPED_UNICODE
    );
}

    public function candidate()
    {
        return $this->belongsTo(User::class, 'candidate_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }


}