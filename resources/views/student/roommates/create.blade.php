@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h3 class="fw-bold mb-3">Create Roommate Post</h3>

        <form action="{{ route('student.roommates.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Description</label>
                <textarea name="description" class="form-control" rows="4" required></textarea>
            </div>

            <div class="mb-3">
                <label>Cleanliness Level</label>
                <input name="cleanliness" class="form-control">
            </div>

            <div class="form-check mb-3">
                <input class="form-check-input" type="checkbox" name="smoking" value="1">
                <label>Smoking Allowed?</label>
            </div>

            <button class="btn btn-primary w-100">Create Post</button>
        </form>
    </div>
@endsection