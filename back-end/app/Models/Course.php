<?php
// app/Models/Course.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['title_id', 'admin_id', 'title', 'description', 'image']; 

    public function title()
    {
        return $this->belongsTo(Title::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function progress()
    {
        return $this->hasMany(Progress::class);
    }

    public function getCandidateProgress($candidateId)
    {
        $progress = $this->progress()->where('candidate_id', $candidateId)->first();

        return [
            'percentage' => $progress ? $progress->progress_percentage : 0,
            'completed' => $progress ? $progress->is_completed : false
        ];
    }


}


