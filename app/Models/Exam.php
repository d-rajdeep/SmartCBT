<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = ['title', 'description', 'duration', 'total_marks', 'start_at', 'end_at', 'published'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
