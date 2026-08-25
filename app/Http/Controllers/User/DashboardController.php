<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamAttempt;
use App\Models\Result;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Get user statistics
        $totalExamsTaken = ExamAttempt::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();

        $averageScore = Result::where('user_id', $user->id)->avg('percentage') ?? 0;

        $totalSecondsSpent = ExamAttempt::where('user_id', $user->id)
            ->where('status', 'completed')
            ->get()
            ->sum(function ($attempt) {
                if ($attempt->started_at && $attempt->completed_at) {
                    return max(0, $attempt->completed_at->timestamp - $attempt->started_at->timestamp);
                }
                return 0;
            });

        $totalMinutesSpent = intdiv($totalSecondsSpent, 60);
        $spentHours = intdiv($totalMinutesSpent, 60);
        $spentMinutes = $totalMinutesSpent % 60;
        $totalTimeSpent = $spentHours > 0
            ? $spentHours . 'h' . ($spentMinutes > 0 ? ' ' . $spentMinutes . 'm' : '')
            : $spentMinutes . 'm';

        $globalRank = Result::where('percentage', '>', $averageScore)
            ->where('exam_id', '!=', null)
            ->distinct('user_id')
            ->count() + 1;

        // Get available exams
        $availableExams = Exam::where('is_published', true)
            ->where(function ($query) {
                $query->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            })
            ->get()
            ->map(function ($exam) use ($user) {
                $attemptsTaken = $exam->getUserAttemptCount($user->id);
                $bestScore = Result::where('user_id', $user->id)
                    ->where('exam_id', $exam->id)
                    ->max('percentage') ?? 0;

                $canAttempt = $exam->canUserAttempt($user->id);

                return (object)[
                    'id' => $exam->id,
                    'title' => $exam->title,
                    'description' => $exam->description,
                    'duration' => $exam->duration,
                    'total_questions' => $exam->total_questions,
                    'attempts_taken' => $attemptsTaken,
                    'max_attempts' => $exam->max_attempts,
                    'best_score' => round($bestScore, 1),
                    'can_attempt' => $canAttempt,
                ];
            });

        // Chart data (last 6 attempts)
        $recentResults = Result::where('user_id', $user->id)
            ->with('exam')
            ->latest()
            ->take(6)
            ->get();

        $chartLabels = $recentResults->pluck('exam.title')->toArray();
        $chartData = $recentResults->pluck('percentage')->toArray();

        // Recent activities
        $recentActivities = Result::where('user_id', $user->id)
            ->with('exam')
            ->latest()
            ->take(5)
            ->get()
            ->map(function ($result) {
                return (object)[
                    'exam_name' => $result->exam->title,
                    'score' => round($result->percentage, 1),
                    'created_at' => $result->created_at,
                ];
            });

        // Recommended exams (based on weak areas - simplified)
        $recommendedExams = Exam::where('is_published', true)
            ->inRandomOrder()
            ->take(3)
            ->get()
            ->map(function ($exam) {
                return (object)[
                    'id' => $exam->id,
                    'title' => $exam->title,
                    'difficulty_level' => 'Medium',
                    'based_on_exam' => 'Your performance',
                ];
            });

        // Statistics array for the view
        $statistics = [
            'total_exams' => $totalExamsTaken,
            'average_score' => round($averageScore, 1),
            'passed_exams' => Result::where('user_id', $user->id)->where('is_passed', true)->count(),
            'best_score' => round(Result::where('user_id', $user->id)->max('percentage') ?? 0, 1),
        ];

        return view('user.dashboard', compact(
            'totalExamsTaken',
            'averageScore',
            'totalTimeSpent',
            'globalRank',
            'availableExams',
            'chartLabels',
            'chartData',
            'recentActivities',
            'recommendedExams',
            'statistics'  // Make sure to include this
        ));
    }
}
