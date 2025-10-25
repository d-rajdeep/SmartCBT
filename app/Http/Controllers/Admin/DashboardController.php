<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\User;
use App\Models\UserExam;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = User::where('role', 'user')->count(); // total users
        $examCount = Exam::count(); // total exams
        $attemptCount = UserExam::count(); // total attempts
        $latestExams = Exam::latest()->take(5)->get(); // recent exams

        return view('admin.dashboard', compact('userCount', 'examCount', 'attemptCount', 'latestExams'));
    }
}
