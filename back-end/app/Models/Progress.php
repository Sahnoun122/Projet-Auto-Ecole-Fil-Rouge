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

protected function cleanArray($array)
{
    if (!is_array($array) && !($array instanceof \Illuminate\Support\Collection)) {
        return $array;
    }

    $cleaned = [];
    foreach ($array as $key => $value) {
        if (is_array($value) || $value instanceof \Illuminate\Support\Collection) {
            $cleaned[$key] = $this->cleanArray($value);
        } else {
            $cleaned[$key] = is_string($value) || is_int($value) ? $value : strval($value);
        }
    }
    
    return $cleaned;
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

protected static function booted()
{
    static::saving(function ($progress) {
        if (is_null($progress->course_id) && is_null($progress->quiz_id)) {
            throw new \Exception("Un progrès doit être lié à un cours ou un quiz");
        }
    });
}
}