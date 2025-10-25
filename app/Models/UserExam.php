<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserExam extends Model
{
    protected $fillable = ['user_id', 'exam_id', 'started_at', 'submitted_at', 'score', 'submitted', 'question_order'];
    protected $casts = ['question_order' => 'array'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }
}
