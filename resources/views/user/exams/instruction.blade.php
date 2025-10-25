@include('layouts.app')
@section('content')
    <div class="container py-4">
        <h3>{{ $exam->title }}</h3>
        <p>{{ $exam->description }}</p>
        <ul>
            <li>Duration: {{ $exam->duration }} minutes</li>
            <li>Total Questions: {{ $exam->questions->count() }}</li>
        </ul>
        <form action="{{ route('user.exam.start', $exam->id) }}" method="POST">@csrf
            <button class="btn btn-primary">Start Exam</button>
        </form>
    </div>
@endsection