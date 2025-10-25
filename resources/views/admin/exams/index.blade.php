@include('layouts.app')
@section('content')
    <div class="container py-4">
        <div class="d-flex justify-content-between mb-3">
            <h4>Exams</h4>
            <a href="{{ route('admin.exams.create') }}" class="btn btn-primary btn-sm">Add Exam</a>
        </div>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Duration</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($exams as $exam)
                    <tr>
                        <td>{{ $exam->title }}</td>
                        <td>{{ $exam->duration }} min</td>
                        <td>{{ $exam->published ? 'Published' : 'Draft' }}</td>
                        <td>
                            <a href="{{ route('admin.exams.edit', $exam->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form method="POST" action="{{ route('admin.exams.destroy', $exam->id) }}" class="d-inline">@csrf
                                @method('DELETE')<button class="btn btn-sm btn-danger">Delete</button></form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection