@include('layouts.app')
@section('content')
    <div class="container py-4 text-center">
        <h3>Exam Result</h3>
        <p><strong>Score:</strong> {{ $userExam->score }}</p>
        <p><strong>Total Questions:</strong> {{ $userExam->exam->questions->count() }}</p>
        <a href="{{ route('user.dashboard') }}" class="btn btn-primary mt-3">Back to Dashboard</a>
    </div>
@endsection