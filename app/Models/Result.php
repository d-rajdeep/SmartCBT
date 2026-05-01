<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Result extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_attempt_id',
        'user_id',
        'exam_id',
        'total_questions',
        'correct_answers',
        'wrong_answers',
        'skipped_answers',
        'total_marks_obtained',
        'total_marks',
        'percentage',
        'is_passed',
        'section_wise_performance',
        'time_spent_per_question'
    ];

    protected $casts = [
        'is_passed' => 'boolean',
        'section_wise_performance' => 'array',
        'time_spent_per_question' => 'array',
        'percentage' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function examAttempt()
    {
        return $this->belongsTo(ExamAttempt::class);
    }
}
