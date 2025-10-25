@extends('layouts.app')
@section('content')
    <div class="container py-4">
        <h4>Profile</h4>
        <form method="POST" action="{{ route('user.profile.update') }}">@csrf
            <input type="text" name="name" value="{{ auth()->user()->name }}" class="form-control mb-2">
            <input type="email" name="email" value="{{ auth()->user()->email }}" class="form-control mb-2">
            <input type="text" name="phone" value="{{ auth()->user()->phone }}" class="form-control mb-2">
            <button class="btn btn-primary">Update</button>
        </form>
    </div>
@endsection