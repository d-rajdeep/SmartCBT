<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Exam;
use App\Models\Result;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalExams = Exam::count();
        $totalAttempts = Result::count();
        $averageScore = Result::avg('percentage');

        // Recent exams
        $recentExams = Exam::latest()->take(5)->get();

        // Recent results
        $recentResults = Result::with(['user', 'exam'])
            ->latest()
            ->take(10)
            ->get();

        // Chart data
        $chartData = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            'users' => [10, 25, 40, 55, 70, $totalUsers],
            'exams' => [5, 8, 12, 15, 18, $totalExams],
        ];

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalExams',
            'totalAttempts',
            'averageScore',
            'recentExams',
            'recentResults',
            'chartData'
        ));
    }
}
