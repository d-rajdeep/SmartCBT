<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Exam;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreventExamReattempt
{
    public function handle(Request $request, Closure $next)
    {
        $examId = $request->route('exam');

        if (!$examId) {
            return $next($request);
        }

        $exam = Exam::findOrFail($examId);

        $userId = Auth::id();

        if (!$exam->canUserAttempt($userId)) {
            return redirect()->route('user.dashboard')
                ->with('error', 'You cannot attempt this exam again.');
        }

        return $next($request);
    }
}