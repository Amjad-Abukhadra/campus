@extends('layouts.app')

@section('content')
    <div class="container py-5">

        <h3 class="fw-bold mb-3">Manage Roommate Applications</h3>

        @foreach($requests as $req)
            <div class="card p-3 mb-3">
                <h5>{{ $req->student->name }}</h5>

                <p>Status:
                    <span class="badge bg-secondary">{{ $req->status }}</span>
                </p>

                <div class="d-flex gap-2">
                    <form action="{{ route('student.roommates.update', [$req->id, 'accepted']) }}" method="POST">
                        @csrf
                        <button class="btn btn-success btn-sm">Accept</button>
                    </form>

                    <form action="{{ route('student.roommates.update', [$req->id, 'rejected']) }}" method="POST">
                        @csrf
                        <button class="btn btn-danger btn-sm">Reject</button>
                    </form>
                </div>
            </div>
        @endforeach

    </div>
@endsection