@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h2 class="fw-bold mb-4">Roommate Posts</h2>

        @forelse($posts as $post)
            <div class="card shadow-sm p-3 mb-3">
                <h4>{{ $post->title }}</h4>
                <p class="text-muted">{{ $post->description }}</p>

                <p><strong>Apartment:</strong> {{ $post->apartment->title }}</p>
                <p><strong>Posted By:</strong> {{ $post->student->name }}</p>

                @if(auth()->id() !== $post->student_id)
                    <form action="{{ route('student.roommates.apply', $post->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-primary w-100">Apply as Roommate</button>
                    </form>
                @else
                    <span class="badge bg-secondary">Your Post</span>
                @endif
            </div>
        @empty
            <div class="alert alert-info">No roommate posts yet.</div>
        @endforelse
    </div>
@endsection