<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ExamAttempt extends Model
{
    use HasFactory;

    protected $table = 'exam_attempts';

    protected $fillable = [
        'user_id',
        'exam_id',
        'started_at',
        'completed_at',
        'answers',
        'marked_questions',
        'score',
        'percentage',
        'status',
        'tab_switch_count',
        'time_spent'
    ];

    protected $casts = [
        'answers' => 'array',
        'marked_questions' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
        'score' => 'integer',
        'percentage' => 'integer',
        'tab_switch_count' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function result()
    {
        return $this->hasOne(Result::class);
    }
}
