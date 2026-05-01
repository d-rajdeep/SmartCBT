<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')
            ->withCount('examAttempts')
            ->latest()
            ->paginate(15);

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user)
    {
        $results = Result::where('user_id', $user->id)
            ->with('exam')
            ->latest()
            ->paginate(10);

        $stats = [
            'total_exams' => $user->examAttempts()->count(),
            'average_score' => round($user->results()->avg('percentage') ?? 0, 1),
            'passed_exams' => $user->results()->where('is_passed', true)->count(),
            'total_time' => $user->examAttempts()->sum('time_spent') ?? 0,
        ];

        return view('admin.users.show', compact('user', 'results', 'stats'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'user';

        User::create($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully!');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'is_active' => 'boolean',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = Hash::make($request->password);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        // Check if user has exam attempts
        if ($user->examAttempts()->count() > 0) {
            return back()->with('error', 'Cannot delete user with exam history.');
        }

        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully!');
    }

    public function toggleStatus(User $user)
    {
        $user->is_active = !$user->is_active;
        $user->save();

        return response()->json(['success' => true]);
    }
}
