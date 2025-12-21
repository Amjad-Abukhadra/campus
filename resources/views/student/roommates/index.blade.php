@extends('layouts.app')

@section('content')
    <div class="container-lg py-5">

        {{-- Header Section --}}
        <div class="mb-5">
            <h1 class="fw-bold text-dark mb-3">
                <i class="bi bi-people-fill text-primary me-2"></i>Roommate Posts
            </h1>
            <p class="text-muted fs-6">Find your perfect roommate and connect with others</p>
            <hr class="border-primary border-3 w-25 opacity-50">
        </div>

        {{-- Filters --}}
        <div class="card shadow-sm border-0 rounded-4 mb-5">
            <div class="card-body">
                <form action="{{ route('student.roommates.index') }}" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i
                                    class="bi bi-geo-alt text-primary"></i></span>
                            <input type="text" name="location" class="form-control border-start-0 ps-0"
                                placeholder="Filter by apartment location..." value="{{ request('location') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i
                                    class="bi bi-cash text-success"></i></span>
                            <input type="number" name="min_price" class="form-control border-start-0 ps-0"
                                placeholder="Min Rent" value="{{ request('min_price') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i
                                    class="bi bi-cash-stack text-success"></i></span>
                            <input type="number" name="max_price" class="form-control border-start-0 ps-0"
                                placeholder="Max Rent" value="{{ request('max_price') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100 fw-bold rounded-pill">
                            <i class="bi bi-filter me-1"></i> Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Action Buttons --}}
        <div class="d-flex flex-wrap gap-3 mb-5 justify-content-start">
            <a href="{{ route('student.roommates.create') }}"
                class="btn btn-primary d-flex align-items-center px-4 py-2 rounded-4 shadow-sm fw-semibold transition-hover">
                <i class="bi bi-plus-square me-2 fs-5"></i>
                Create Post
            </a>
            <a href="{{ route('student.roommates.manage') }}"
                class="btn btn-warning d-flex align-items-center px-4 py-2 rounded-4 shadow-sm fw-semibold transition-hover text-dark">
                <i class="bi bi-list-check me-2 fs-5"></i>
                Manage Applications
            </a>
            <a href="{{ route('student.roommates.myPosts') }}"
                class="btn btn-secondary d-flex align-items-center px-4 py-2 rounded-4 shadow-sm fw-semibold transition-hover text-white">
                <i class="bi bi-journal-text me-2 fs-5"></i>
                My Posts
            </a>
            <a href="{{ route('student.roommates.applications') }}"
                class="btn btn-success d-flex align-items-center px-4 py-2 rounded-4 shadow-sm fw-semibold transition-hover">
                <i class="bi bi-calendar-check me-2 fs-5"></i>
                Reservation
            </a>
        </div>
        {{-- Display Validation Errors --}}
        @if ($errors->any())
            <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>There were some problems with your input:</strong>
                <ul class="mb-0 mt-2">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Session Messages --}}
        @if (session('error'))
            <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4 d-flex align-items-center justify-content-between"
                role="alert">
                <div><i class="bi bi-x-circle-fill me-2"></i><strong>Error:</strong> {{ session('error') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success border-0 rounded-4 shadow-sm mb-4 d-flex align-items-center justify-content-between"
                role="alert">
                <div><i class="bi bi-check-circle-fill me-2"></i><strong>Success:</strong> {{ session('success') }}</div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Posts Grid --}}
        @if ($posts->count() > 0)
            <div class="row g-4">
                @foreach ($posts as $post)
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="card shadow-lg rounded-lg border-0 h-100 overflow-hidden">
                                <div class="row g-0 align-items-center " style="min-height: 180px; max-height: 250px;">
                                    {{-- Image Section --}}
                                    <div class="col-md-4">
                                        <div class="position-relative " style="max-height: 220px; overflow: hidden;">
                                            @if ($post->apartment->image)
                                                <img src="{{ asset('storage/apartments/' . $post->apartment->image) }}"
                                                    style="height:300px ; width:300px" alt="Apartment Image">
                                            @else
                                                <div class="bg-light d-flex align-items-center justify-content-center h-100"
                                                    style="min-height:180px;">
                                                    <i class="bi bi-building fs-1 text-secondary opacity-25"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    {{-- Content Section --}}
                                    <div class="col-md-8">
                                        <div class="card-body p-3 d-flex flex-column ">
                                            {{-- Title & Author --}}
                                            <div class="d-flex justify-content-between align-items-start mb-1">
                                                <div class="flex-grow-1">
                                                    <h5 class="fw-bold mb-1 text-truncate">
                                                        {{ $post->title }}
                                                    </h5>
                                                    <div class="text-muted small">
                                                        <i class="bi bi-person-circle me-1"></i>
                                                        {{ $post->student->name ?? 'N/A' }}
                                                        <span class="mx-2">•</span>
                                                        <i class="bi bi-clock me-1"></i>{{ $post->created_at->diffForHumans() }}
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Description --}}
                                            <p class="text-muted mb-2 small"
                                                style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                                {{ $post->description }}
                                            </p>

                                            {{-- Preferences Tags --}}
                                            <div class="mb-2 d-flex flex-wrap gap-1">
                                                @foreach($post->preferences as $preference)
                                                    <span
                                                        class="badge bg-primary bg-opacity-10 text-primary px-2 py-1 rounded-pill fs-7"
                                                        title="{{ $preference->description }}">
                                                        <i class="bi bi-tag-fill me-1"></i>{{ $preference->name }}
                                                    </span>
                                                @endforeach
                                            </div>

                                            {{-- Apartment Info --}}
                                            <div class="row g-2 mb-2 small text-muted">
                                                <div class="col-6 col-lg-4 d-flex align-items-center">
                                                    <i class="bi bi-geo-alt-fill text-danger me-2 fs-6"></i>
                                                    <div>
                                                        <small class="d-block">Location</small>
                                                        <strong class="text-dark">{{ $post->apartment->location ?? 'N/A' }}</strong>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-4 d-flex align-items-center">
                                                    <i class="bi bi-cash-coin text-success me-2 fs-6"></i>
                                                    <div>
                                                        <small class="d-block">Rent</small>
                                                        <strong class="text-dark">{{ $post->apartment->rent ?? 'N/A' }}
                                                            JD</strong>
                                                    </div>
                                                </div>
                                                <div class="col-6 col-lg-4 d-flex align-items-center">
                                                    <i class="bi bi-person-badge text-primary me-2 fs-6"></i>
                                                    <div>
                                                        <small class="d-block">Landlord</small>
                                                        <strong
                                                            class="text-dark">{{ $post->apartment->landlord->name ?? 'N/A' }}</strong>
                                                    </div>
                                                </div>
                                            </div>

                                            {{-- Action Buttons --}}
                                            <div class="d-flex gap-2 mt-auto">
                                                <form action="{{ route('student.roommates.apply', $post->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-primary btn-sm px-3">
                                                        <i class="bi bi-send me-1"></i>Apply
                                                    </button>
                                                </form>
                                                <button type="button" class="btn btn-outline-secondary btn-sm">
                                                    <i class="bi bi-eye"></i>
                                                </button>

                                                {{-- Save Button --}}
                                                <form action="{{ route('student.favorites.toggle') }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $post->id }}">
                                                    <input type="hidden" name="type" value="roommate_post">
                                                    <button type="submit" class="btn btn-outline-secondary btn-sm"
                                                        title="{{ Auth::user()->favorites->where('favoritable_id', $post->id)->where('favoritable_type', 'App\Models\RoommatePost')->count() ? 'Unsave' : 'Save' }}">
                                                        <i
                                                            class="bi {{ Auth::user()->favorites->where('favoritable_id', $post->id)->where('favoritable_type', 'App\Models\RoommatePost')->count() ? 'bi-bookmark-fill text-primary' : 'bi-bookmark' }}"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Empty State --}}
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm border-0 text-center py-5">
                        <div class="card-body">
                            <i class="bi bi-inbox text-secondary mb-4" style="font-size: 4rem; opacity: 0.3;"></i>
                            <h4 class="fw-bold mb-3">No Roommate Posts Yet</h4>
                            <p class="text-muted mb-4">
                                There are currently no available roommate posts.<br>
                                Be the first to create one and find your perfect roommate!
                            </p>
                            <a href="{{ route('student.roommates.create') }}" class="btn btn-primary btn-lg px-5">
                                <i class="bi bi-plus-circle me-2"></i>Create Your First Post
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
    <style>
        .transition-hover {
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .transition-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
    </style>
@endsection