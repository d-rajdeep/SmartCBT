<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = ['user_exam_id', 'question_id', 'option_id', 'is_correct', 'marked_for_review'];

    public function userExam()
    {
        return $this->belongsTo(UserExam::class);
    }
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
    public function option()
    {
        return $this->belongsTo(Option::class);
    }
}
