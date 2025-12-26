@extends('layouts.app')

@section('content')
    <div class="container-lg py-5">

        {{-- Header Section --}}
        <x-page-header title="Roommate Finder" subtitle="Find your perfect roommate and connect with others"
            icon="bi bi-people-fill" :breadcrumb="[
            ['label' => 'Apartments', 'link' => route('student.apartments')],
            ['label' => 'Roommates']
        ]">
            <x-slot name="action">
                <a href="{{ route('student.roommates.create') }}"
                    class="btn btn-primary px-4 py-2 rounded-3 shadow-sm fw-bold">
                    <i class="bi bi-plus-lg me-2"></i>Create Post
                </a>
            </x-slot>
        </x-page-header>

        {{-- Filters Section --}}
        <div class="card shadow-sm border-0 rounded-4 mb-5 overflow-hidden">
            <div class="card-header bg-white border-0 py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-sliders2-vertical me-2 text-primary"></i>Filter Posts
                </h5>
                <a href="{{ route('student.roommates.index') }}"
                    class="btn btn-link btn-sm text-decoration-none text-muted">
                    <i class="bi bi-arrow-counterclockwise me-1"></i>Reset All
                </a>
            </div>
            <div class="card-body bg-light bg-opacity-50 p-4">
                <form action="{{ route('student.roommates.index') }}" method="GET" class="row g-3">
                    {{-- Search & Location --}}
                    <div class="col-lg-3 col-md-6">
                        <div class="form-floating">
                            <input type="text" name="location" id="location" class="form-control border-0 shadow-sm"
                                placeholder="Location" value="{{ request('location') }}">
                            <label for="location"><i class="bi bi-geo-alt text-primary me-2"></i>Apartment Location</label>
                        </div>
                    </div>

                    {{-- Price Range --}}
                    <div class="col-lg-3 col-md-6">
                        <div class="row g-2">
                            <div class="col-6">
                                <div class="form-floating">
                                    <input type="number" name="min_price" id="min_price"
                                        class="form-control border-0 shadow-sm" placeholder="Min"
                                        value="{{ request('min_price') }}">
                                    <label for="min_price">Min Rent</label>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-floating">
                                    <input type="number" name="max_price" id="max_price"
                                        class="form-control border-0 shadow-sm" placeholder="Max"
                                        value="{{ request('max_price') }}">
                                    <label for="max_price">Max Rent</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Gender --}}
                    <div class="col-lg-2 col-md-6">
                        <div class="form-floating">
                            <select name="gender" id="gender" class="form-select border-0 shadow-sm">
                                <option value="">All Genders</option>
                                <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>Female</option>
                            </select>
                            <label for="gender"><i class="bi bi-gender-ambiguous text-info me-2"></i>Target Gender</label>
                        </div>
                    </div>

                    {{-- DOB --}}
                    <div class="col-lg-2 col-md-6 custom-datepicker-filter">
                        <x-form-datepicker name="dob" label="Born On" :value="request('dob')" />
                    </div>

                    {{-- Submit --}}
                    <div class="col-lg-2 col-md-12 d-grid">
                        <button type="submit" class="btn btn-primary fw-bold rounded-3 shadow-sm py-3">
                            <i class="bi bi-search me-2"></i>Search
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <style>
            .form-floating>.form-control,
            .form-floating>.form-select {
                height: calc(3.5rem + 2px);
                line-height: 1.25;
            }

            .form-floating>label {
                padding: 1rem 0.75rem;
            }

            /* Styling for the custom datepicker within filters */
            .custom-datepicker-filter .mb-3 {
                margin-bottom: 0 !important;
            }

            .custom-datepicker-filter .form-label {
                display: none;
                /* Hide internal component label for cleaner layout */
            }

            .custom-datepicker-filter .input-group-text {
                border-top-left-radius: 0.5rem;
                border-bottom-left-radius: 0.5rem;
                border: none;
                background: white;
                box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075);
            }

            .custom-datepicker-filter input {
                border: none;
                box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075);
                height: calc(3.5rem + 2px);
                border-top-right-radius: 0.5rem;
                border-bottom-right-radius: 0.5rem;
            }
        </style>

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
                                                        @if($post->student)
                                                            <span class="mx-2">•</span>
                                                            <span
                                                                class="badge bg-info bg-opacity-10 text-info border-0 rounded-pill px-2">
                                                                <i
                                                                    class="bi bi-gender-{{ $post->student->gender == 'male' ? 'male' : 'female' }} me-1"></i>
                                                                {{ ucfirst($post->student->gender) }}
                                                            </span>
                                                            @if($post->student->date_of_birth)
                                                                <span
                                                                    class="badge bg-secondary bg-opacity-10 text-secondary border-0 rounded-pill px-2">
                                                                    <i class="bi bi-calendar3 me-1"></i>
                                                                    {{ \Carbon\Carbon::parse($post->student->date_of_birth)->age }} years
                                                                </span>
                                                            @endif
                                                        @endif
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