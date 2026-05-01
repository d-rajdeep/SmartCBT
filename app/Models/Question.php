<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'question_text',
        'difficulty',
        'marks',
        'negative_marks',
        'explanation',
        'type',
        'order'
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function getCorrectOption()
    {
        return $this->options()->where('is_correct', true)->first();
    }
}
