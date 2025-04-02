<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = ['admin_id', 'title', 'description'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
