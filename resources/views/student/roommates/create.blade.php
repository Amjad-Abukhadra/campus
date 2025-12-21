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

                    {{-- Dynamic Preferences Section --}}
                    <div class="mb-4">
                        <label class="form-label fw-semibold mb-2">
                            <i class="bi bi-list-stars text-primary me-2"></i>Preferences
                        </label>
                        <p class="text-muted small mb-2">Add preferences for your potential roommate (e.g., "Non-smoker", "Quiet hours after 10 PM", "Cleanliness level").</p>
                        
                        <div id="preferences-container">
                            {{-- Initial Empty State or Old Inputs (if any validation failed) --}}
                            @if(old('preferences'))
                                @foreach(old('preferences') as $index => $pref)
                                    <div class="preference-item card mb-3 bg-light border-0">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h6 class="card-title mb-0">Preference #{{ $index + 1 }}</h6>
                                                <button type="button" class="btn btn-sm btn-outline-danger remove-preference">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                            <div class="mb-2">
                                                <input type="text" name="preferences[{{ $index }}][name]" class="form-control form-control-sm" placeholder="Preference Name (e.g. Non-smoker)" value="{{ $pref['name'] }}" required>
                                            </div>
                                            <div>
                                                <input type="text" name="preferences[{{ $index }}][description]" class="form-control form-control-sm" placeholder="Description (Optional)" value="{{ $pref['description'] }}">
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <button type="button" id="add-preference-btn" class="btn btn-outline-primary btn-sm mt-2">
                            <i class="bi bi-plus-circle me-1"></i> Add Preference
                        </button>
                    </div>

                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            const container = document.getElementById('preferences-container');
                            const addBtn = document.getElementById('add-preference-btn');
                            let preferenceCount = {{ old('preferences') ? count(old('preferences')) : 0 }};

                            addBtn.addEventListener('click', function() {
                                const index = preferenceCount++;
                                const template = `
                                    <div class="preference-item card mb-3 bg-light border-0 fade-in">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h6 class="card-title mb-0">Preference #` + (index + 1) + `</h6>
                                                <button type="button" class="btn btn-sm btn-outline-danger remove-preference">
                                                    <i class="bi bi-trash"></i>
                                                </button>
                                            </div>
                                            <div class="mb-2">
                                                <input type="text" name="preferences[` + index + `][name]" class="form-control form-control-sm" placeholder="Preference Name (e.g. Non-smoker)" required>
                                            </div>
                                            <div>
                                                <input type="text" name="preferences[` + index + `][description]" class="form-control form-control-sm" placeholder="Description (Optional)">
                                            </div>
                                        </div>
                                    </div>
                                `;
                                container.insertAdjacentHTML('beforeend', template);
                            });

                            container.addEventListener('click', function(e) {
                                if (e.target.closest('.remove-preference')) {
                                    e.target.closest('.preference-item').remove();
                                }
                            });
                        });
                    </script>

                    <style>
                        .fade-in {
                            animation: fadeIn 0.3s ease-in-out;
                        }
                        @keyframes fadeIn {
                            from { opacity: 0; transform: translateY(10px); }
                            to { opacity: 1; transform: translateY(0); }
                        }
                    </style>

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
