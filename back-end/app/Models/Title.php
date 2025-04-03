<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Title extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'admin_id']; 

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
