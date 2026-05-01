<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'category_id',
        'duration',
        'total_questions',
        'passing_percentage',
        'max_attempts',
        'is_published',
        'start_date',
        'end_date',
        'randomize_questions',
        'show_result_immediately',
        'settings'
    ];

    protected $casts = [
        'settings' => 'array',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_published' => 'boolean',
        'randomize_questions' => 'boolean',
        'show_result_immediately' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($exam) {
            if (empty($exam->slug)) {
                $exam->slug = Str::slug($exam->title) . '-' . time();
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function examAttempts()
    {
        return $this->hasMany(ExamAttempt::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }

    public function isAvailable()
    {
        $now = now();
        $isWithinDateRange = true;

        if ($this->start_date && $this->start_date > $now) {
            $isWithinDateRange = false;
        }

        if ($this->end_date && $this->end_date < $now) {
            $isWithinDateRange = false;
        }

        return $this->is_published && $isWithinDateRange;
    }

    public function getUserAttemptCount($userId)
    {
        return $this->examAttempts()
            ->where('user_id', $userId)
            ->where('status', 'completed')
            ->count();
    }

    public function canUserAttempt($userId)
    {
        $attemptsMade = $this->getUserAttemptCount($userId);
        return $attemptsMade < $this->max_attempts && $this->isAvailable();
    }
}
