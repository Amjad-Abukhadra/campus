@extends('layouts.app')

@section('content')
<div class="container-lg py-5">

    {{-- Header Section --}}
    <div class="mb-5">
        <h1 class="fw-bold text-dark mb-2">
            <i class="bi bi-pencil-square text-primary me-2"></i>Create Roommate Post
        </h1>
        <p class="text-muted fs-6">Share your apartment and find the perfect roommate</p>
        <hr class="border-primary border-3 w-25 opacity-50">
    </div>

    {{-- Show general form errors --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show rounded-4 mb-4">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            <strong>Oops!</strong> Please fix the following errors:
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-lg-8">
            {{-- Form Card --}}
            <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5">
                <form action="{{ route('student.roommates.store') }}" method="POST" novalidate>
                    @csrf

                    {{-- Title --}}
                    <div class="mb-4">
                        <label for="title" class="form-label fw-semibold mb-2">
                            <i class="bi bi-type text-primary me-2"></i>Post Title
                        </label>
                        <input type="text" 
                            id="title"
                            name="title" 
                            class="form-control form-control-lg rounded-3 @error('title') is-invalid @enderror" 
                            placeholder="e.g., Looking for a clean and quiet roommate"
                            value="{{ old('title') }}"
                            required>
                        @error('title')
                            <div class="invalid-feedback d-block">
                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div class="mb-4">
                        <label for="description" class="form-label fw-semibold mb-2">
                            <i class="bi bi-chat-left-text text-primary me-2"></i>Description
                        </label>
                        <textarea id="description"
                            name="description" 
                            class="form-control rounded-3 @error('description') is-invalid @enderror" 
                            rows="5"
                            placeholder="Tell potential roommates about yourself, your lifestyle, and what you're looking for..."
                            required>{{ old('description') }}</textarea>
                        <small class="text-muted d-block mt-2">
                            <i class="bi bi-info-circle me-1"></i>Be detailed to attract the right roommates
                        </small>
                        @error('description')
                            <div class="invalid-feedback d-block">
                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Cleanliness --}}
                    <div class="mb-4">
                        <label for="cleanliness" class="form-label fw-semibold mb-2">
                            <i class="bi bi-hand-thumbs-up text-primary me-2"></i>Cleanliness Level
                        </label>
                        <select id="cleanliness"
                            name="cleanliness" 
                            class="form-select form-select-lg rounded-3 @error('cleanliness') is-invalid @enderror"
                            required>
                            <option value="" selected disabled>Select cleanliness preference...</option>
                            <option value="5" {{ old('cleanliness') == '5' ? 'selected' : '' }}>Very Clean</option>
                            <option value="4" {{ old('cleanliness') == '4' ? 'selected' : '' }}>Clean</option>
                            <option value="3" {{ old('cleanliness') == '3' ? 'selected' : '' }}>Moderate</option>
                            <option value="2" {{ old('cleanliness') == '2' ? 'selected' : '' }}>Relaxed</option>
                            <option value="1" {{ old('cleanliness') == '1' ? 'selected' : '' }}>Dirty</option>
                        </select>
                        @error('cleanliness')
                            <div class="invalid-feedback d-block">
                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Max Roommates --}}
                    <div class="mb-4">
                        <label for="max_roommates" class="form-label fw-semibold mb-2">
                            <i class="bi bi-people text-primary me-2"></i>Maximum Roommates
                        </label>
                        <input type="number" 
                            id="max_roommates"
                            name="max_roommates" 
                            class="form-control form-control-lg rounded-3 @error('max_roommates') is-invalid @enderror"
                            placeholder="How many roommates are you looking for?"
                            value="{{ old('max_roommates') }}"
                            min="1" 
                            max="10"
                            required>
                        @error('max_roommates')
                            <div class="invalid-feedback d-block">
                                <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Smoking --}}
                    <div class="mb-4 p-3 bg-light rounded-3 border border-1">
                        <div class="form-check">
                            <input class="form-check-input" 
                                type="checkbox" 
                                id="smoking"
                                name="smoking" 
                                value="1"
                                {{ old('smoking') ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold" for="smoking">
                                <i class="bi bi-cigarette text-danger me-2"></i>Is Smoking Allowed?
                            </label>
                        </div>
                    </div>

                    {{-- Buttons --}}
                    <div class="d-grid gap-2 d-md-flex justify-content-end">
                        <a href="{{ route('student.roommates.index') }}" class="btn btn-outline-secondary px-4 fw-semibold rounded-3 py-2">
                            <i class="bi bi-arrow-left me-2"></i>Cancel
                        </a>
                        <button type="submit" class="btn btn-primary px-5 fw-semibold rounded-3 py-2">
                            <i class="bi bi-check-circle me-2"></i>Create Post
                        </button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
@endsection
