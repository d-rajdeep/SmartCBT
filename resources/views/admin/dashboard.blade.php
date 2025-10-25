@extends('layouts.app')
@section('content')
    <div class="container py-4">
        <h3 class="mb-4">Admin Dashboard</h3>
        <div class="row text-center mb-4">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h4>{{ $userCount }}</h4>
                        <p>Users</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h4>{{ $examCount }}</h4>
                        <p>Exams</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <div class="card-body">
                        <h4>{{ $attemptCount }}</h4>
                        <p>Attempts</p>
                    </div>
                </div>
            </div>
        </div>
        <h5>Recent Exams</h5>
        <ul class="list-group">
            @foreach($latestExams as $exam)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $exam->title }}
                    <span>{{ $exam->created_at->diffForHumans() }}</span>
                </li>
            @endforeach
        </ul>
    </div>
@endsection