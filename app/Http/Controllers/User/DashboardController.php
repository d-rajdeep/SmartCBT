<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\UserExam;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Fetch all published exams (you can filter by start/end time if needed)
        $exams = Exam::where('published', true)
            ->orderByDesc('created_at')
            ->get();

        // Fetch user attempts
        $userExams = UserExam::where('user_id', $user->id)
            ->get()
            ->keyBy('exam_id'); // so we can easily check attempt status

        // Stats
        $completedCount = $userExams->where('submitted', true)->count();
        $totalScore = $userExams->where('submitted', true)->sum('score');

        return view('user.dashboard', compact('exams', 'userExams', 'completedCount', 'totalScore'));
    }
}
