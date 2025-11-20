@extends('layouts.app')

@section('content')
    <div class="container-lg py-5">

        {{-- Header Section --}}
        <div class="mb-5">
            <h1 class="fw-bold text-dark mb-2">
                <i class="bi bi-file-earmark-text text-primary me-2"></i>My Roommate Posts
            </h1>
            <p class="text-muted fs-6">Manage your roommate search posts and applications</p>
            <hr class="border-primary border-3 w-25 opacity-50">
        </div>

        {{-- Error / Success Messages --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 rounded-4 mb-4" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 rounded-4 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Posts Grid --}}
        <div class="row g-4">
            @forelse($posts as $post)
                <div class="col-md-6 col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">

                        {{-- Image Section --}}
                        @if($post->apartment->image)
                            <div class="position-relative overflow-hidden" style="height: 220px;">
                                <img src="{{ asset('storage/apartments/' . $post->apartment->image) }}" class="w-100 h-100"
                                    style=" transition: transform 0.3s ease;">
                            </div>
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center" style="height: 220px;">
                                <i class="bi bi-building fs-1 text-secondary opacity-25"></i>
                            </div>
                        @endif

                        {{-- Card Body --}}
                        <div class="card-body p-4 d-flex flex-column">

                            {{-- Title --}}
                            <h5 class="fw-bold text-dark mb-2">{{ $post->title }}</h5>

                            {{-- Description --}}
                            <p class="text-muted mb-3 fs-6" style="line-height: 1.5;">
                                {{ Str::limit($post->description, 90) }}
                            </p>

                            {{-- Post Details --}}
                            <div class="mb-4 pb-3 border-bottom">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-hand-thumbs-up text-primary me-2"></i>
                                    <span class="text-muted fs-6"><strong>Cleanliness:</strong>
                                        {{ $post->cleanliness_level }}</span>
                                </div>
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-{{ $post->smoking ? 'cigarette' : 'ban-smoking' }} text-primary me-2"></i>
                                    <span class="text-muted fs-6"><strong>Smoking:</strong>
                                        {{ $post->smoking ? 'Allowed' : 'Not Allowed' }}</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-people text-primary me-2"></i>
                                    <span class="text-muted fs-6"><strong>Max Roommates:</strong>
                                        {{ $post->max_roommates }}</span>
                                </div>
                            </div>

                            {{-- Application Count Badge --}}
                            <div class="mb-4">
                                @if($post->roommates->count() > 0)
                                    <span class="badge bg-info px-3 py-2 rounded-pill fw-semibold">
                                        <i class="bi bi-file-earmark-check me-1"></i>{{ $post->roommates->count() }}
                                        Application{{ $post->roommates->count() != 1 ? 's' : '' }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary bg-opacity-50 px-3 py-2 rounded-pill fw-semibold">
                                        <i class="bi bi-inbox me-1"></i>No Applications Yet
                                    </span>
                                @endif
                            </div>

                            {{-- Action Buttons --}}
                            <div class="d-grid gap-2 mt-auto">
                                <button class="btn btn-primary fw-semibold rounded-3 py-2" data-bs-toggle="modal"
                                    data-bs-target="#viewPostModal{{ $post->id }}">
                                    <i class="bi bi-eye me-2"></i>View Applications
                                </button>
                                <button class="btn btn-warning fw-semibold rounded-3 py-2" data-bs-toggle="modal"
                                    data-bs-target="#editPostModal{{ $post->id }}">
                                    <i class="bi bi-pencil me-2"></i>Edit Post
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ================= VIEW POST MODAL ================= --}}
                <div class="modal fade" id="viewPostModal{{ $post->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        <div class="modal-content shadow-lg border-0 rounded-4">
                            <div class="modal-header bg-primary text-white rounded-top-4 border-0">
                                <h5 class="modal-title fw-bold">
                                    <i class="bi bi-file-earmark-check me-2"></i>Applications for: {{ $post->title }}
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body p-4">
                                @if($post->roommates->count() > 0)
                                    <div class="list-group">
                                        @foreach($post->roommates as $app)
                                            <div
                                                class="list-group-item border rounded-3 mb-3 p-3 d-flex justify-content-between align-items-start">
                                                <div class="flex-grow-1">
                                                    {{-- Student Name --}}
                                                    <h6 class="fw-bold text-dark mb-2">
                                                        <i class="bi bi-person-fill text-primary me-2"></i>{{ $app->student->name }}
                                                    </h6>

                                                    {{-- Email --}}
                                                    <div class="d-flex align-items-center mb-1">
                                                        <i class="bi bi-envelope text-muted me-2" style="font-size: 0.9rem;"></i>
                                                        <a href="mailto:{{ $app->student->email }}"
                                                            class="text-muted text-decoration-none fs-6">
                                                            {{ $app->student->email }}
                                                        </a>
                                                    </div>

                                                    {{-- Phone --}}
                                                    <div class="d-flex align-items-center">
                                                        <i class="bi bi-telephone text-muted me-2" style="font-size: 0.9rem;"></i>
                                                        <span class="text-muted fs-6">
                                                            {{ $app->student->phone ?? 'N/A' }}
                                                        </span>
                                                    </div>
                                                </div>

                                                {{-- Status Badge --}}
                                                <div class="ms-3">
                                                    @if($app->status == 'accepted')
                                                        <span class="badge bg-success px-3 py-2 rounded-pill fw-semibold">
                                                            <i class="bi bi-check-circle-fill me-1"></i>Accepted
                                                        </span>
                                                    @elseif($app->status == 'rejected')
                                                        <span class="badge bg-danger px-3 py-2 rounded-pill fw-semibold">
                                                            <i class="bi bi-x-circle-fill me-1"></i>Rejected
                                                        </span>
                                                    @else
                                                        <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-semibold">
                                                            <i class="bi bi-hourglass-split me-1"></i>Pending
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center py-5">
                                        <i class="bi bi-inbox fs-1 text-secondary opacity-50 d-block mb-3"></i>
                                        <p class="text-muted">No applications yet. Share your post to attract roommates!</p>
                                    </div>
                                @endif
                            </div>
                            <div class="modal-footer bg-light border-top-0 rounded-bottom-4">
                                <button class="btn btn-secondary rounded-3 fw-semibold" data-bs-dismiss="modal">
                                    <i class="bi bi-x-lg me-2"></i>Close
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ================= EDIT POST MODAL ================= --}}
                <div class="modal fade" id="editPostModal{{ $post->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content shadow-lg border-0 rounded-4">
                            <div class="modal-header bg-warning text-dark rounded-top-4 border-0">
                                <h5 class="modal-title fw-bold">
                                    <i class="bi bi-pencil me-2"></i>Edit Post: {{ $post->title }}
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('student.roommates.updatePost', $post->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-body p-4">
                                    {{-- Title Field --}}
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold mb-2">
                                            <i class="bi bi-type text-primary me-2"></i>Title
                                        </label>
                                        <input name="title" class="form-control rounded-3" value="{{ $post->title }}" required>
                                    </div>

                                    {{-- Description Field --}}
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold mb-2">
                                            <i class="bi bi-chat-left-text text-primary me-2"></i>Description
                                        </label>
                                        <textarea name="description" class="form-control rounded-3" rows="3"
                                            required>{{ $post->description }}</textarea>
                                    </div>

                                    {{-- Cleanliness Field --}}
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold mb-2">
                                            <i class="bi bi-hand-thumbs-up text-primary me-2"></i>Cleanliness Level
                                        </label>
                                        <select name="cleanliness" class="form-select rounded-3" required>
                                            <option value="Very Clean" {{ $post->cleanliness_level == 'Very Clean' ? 'selected' : '' }}>Very Clean</option>
                                            <option value="Clean" {{ $post->cleanliness_level == 'Clean' ? 'selected' : '' }}>
                                                Clean
                                            </option>
                                            <option value="Moderate" {{ $post->cleanliness_level == 'Moderate' ? 'selected' : '' }}>
                                                Moderate</option>
                                            <option value="Relaxed" {{ $post->cleanliness_level == 'Relaxed' ? 'selected' : '' }}>
                                                Relaxed</option>
                                        </select>
                                    </div>

                                    {{-- Max Roommates Field --}}
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold mb-2">
                                            <i class="bi bi-people text-primary me-2"></i>Max Roommates
                                        </label>
                                        <input name="max_roommates" class="form-control rounded-3" type="number"
                                            value="{{ $post->max_roommates }}" min="1" required>
                                    </div>

                                    {{-- Smoking Checkbox --}}
                                    <div class="form-check p-3 bg-light rounded-3 border">
                                        <input class="form-check-input" type="checkbox" name="smoking" value="1"
                                            id="smoking{{ $post->id }}" {{ $post->smoking ? 'checked' : '' }}>
                                        <label class="form-check-label fw-semibold" for="smoking{{ $post->id }}">
                                            <i class="bi bi-ban-smoking text-danger me-2"></i>Smoking Allowed?
                                        </label>
                                    </div>
                                </div>
                                <div class="modal-footer bg-light border-top-0 rounded-bottom-4">
                                    <button type="button" class="btn btn-secondary rounded-3 fw-semibold"
                                        data-bs-dismiss="modal">
                                        <i class="bi bi-x-lg me-2"></i>Cancel
                                    </button>
                                    <button type="submit" class="btn btn-warning rounded-3 fw-semibold">
                                        <i class="bi bi-save me-2"></i>Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4 p-5 text-center">
                        <i class="bi bi-inbox text-secondary" style="font-size: 4rem; opacity: 0.3;"></i>
                        <h5 class="fw-bold text-dark mb-2">No Posts Yet</h5>
                        <p class="text-muted mb-4">You haven't created any roommate posts yet. Start by creating your first
                            post!</p>
                        <a href="{{ route('student.roommates.create') }}" class="btn btn-primary px-4 rounded-3 fw-semibold">
                            <i class="bi bi-pencil-square me-2"></i>Create Your First Post
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

    </div>
@endsection