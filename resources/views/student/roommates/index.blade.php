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

        {{-- Action Buttons --}}
        <div class="d-flex flex-wrap gap-2 mb-4">
            <a href="{{ route('student.roommates.create') }}" class="btn btn-primary px-4 fw-semibold rounded-3">
                <i class="bi bi-pencil-square me-2"></i>Create Post
            </a>
            <a href="{{ route('student.roommates.manage') }}" class="btn btn-warning px-4 fw-semibold rounded-3">
                <i class="bi bi-inbox me-2"></i>Manage Applications
            </a>
            <a href="{{ route('student.roommates.myPosts') }}" class="btn btn-secondary px-4 fw-semibold rounded-3">
                <i class="bi bi-file-earmark-text me-2"></i>My Posts
            </a>
        </div>

        {{-- Display Validation Errors --}}
        @if($errors->any())
            <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>There were some problems with your input:</strong>
                <ul class="mb-0 mt-2">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Display Session Error --}}
        @if(session('error'))
            <div class="alert alert-danger border-0 rounded-4 shadow-sm mb-4 d-flex align-items-center justify-content-between"
                role="alert">
                <div>
                    <i class="bi bi-x-circle-fill me-2"></i>
                    <strong>Error:</strong> {{ session('error') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Display Session Success --}}
        @if(session('success'))
            <div class="alert alert-success border-0 rounded-4 shadow-sm mb-4 d-flex align-items-center justify-content-between"
                role="alert">
                <div>
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <strong>Success:</strong> {{ session('success') }}
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Posts Grid --}}
        @if($posts->count() > 0)
            <div class="row g-4">
                @foreach($posts as $post)
                    <div class="col-md-6 col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden transition-all"
                            style="transition: all 0.3s ease;">

                            {{-- Apartment Image --}}
                            @if($post->apartment->image)
                                <div class="position-relative overflow-hidden" style="height: 200px;">
                                    <img src="{{ asset('storage/apartments/' . $post->apartment->image) }}" class="w-100 h-100"
                                        alt="Apartment Image" style=" transition: transform 0.3s ease;">
                                </div>
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="bi bi-building fs-1 text-secondary opacity-25"></i>
                                </div>
                            @endif

                            {{-- Card Body --}}
                            <div class="card-body d-flex flex-column p-4">
                                {{-- Title --}}
                                <h5 class="fw-bold text-dark mb-2">
                                    <i class="bi bi-chat-square-text me-2 text-primary"></i>{{ $post->title }}
                                </h5>

                                {{-- Description --}}
                                <p class="text-muted mb-3 fs-6" style="line-height: 1.5;">
                                    {{ Str::limit($post->description, 85) }}
                                </p>

                                {{-- Preferences --}}
                                <div class="mb-4 pb-3 border-bottom">
                                    <h6 class="fw-semibold text-dark mb-2">
                                        <i class="bi bi-sliders text-primary me-2"></i>Preferences
                                    </h6>
                                    <div class="d-flex flex-wrap gap-2">
                                        <span class="badge bg-info bg-opacity-10 text-info px-2 py-1 rounded-pill fs-6">
                                            cleanliness <i class="bi bi-hand-thumbs-up me-1"></i>{{ $post->cleanliness_level }}
                                        </span>
                                        <span
                                            class="badge bg-{{ $post->smoking ? 'danger' : 'success' }} bg-opacity-10 text-{{ $post->smoking ? 'danger' : 'success' }} px-2 py-1 rounded-pill fs-6">
                                            {!! $post->smoking ? '&#128684;' : '&#128685;' !!} <!-- 🚬 or 🚭 -->
                                            {{ $post->smoking ? 'Smoking' : 'No Smoking' }}
                                        </span>


                                    </div>
                                </div>

                                {{-- Apartment Info --}}
                                <div class="mb-4">
                                    <h6 class="fw-semibold text-dark mb-3">
                                        <i class="bi bi-house-door text-primary me-2"></i>Apartment Details
                                    </h6>
                                    <div class="d-flex align-items-start mb-2">
                                        <i class="bi bi-person-fill text-primary me-2 mt-1" style="font-size: 0.9rem;"></i>
                                        <div>
                                            <small class="text-muted d-block">Landlord</small>
                                            <span class="text-dark fw-500">{{ $post->apartment->landlord->name ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start mb-2">
                                        <i class="bi bi-geo-alt-fill text-primary me-2 mt-1" style="font-size: 0.9rem;"></i>
                                        <div>
                                            <small class="text-muted d-block">Address</small>
                                            <span class="text-dark fw-500">{{ $post->apartment->location ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-start">
                                        <i class="bi bi-cash-coin text-primary me-2 mt-1" style="font-size: 0.9rem;"></i>
                                        <div>
                                            <small class="text-muted d-block">Monthly Rent</small>
                                            <span class="text-dark fw-bold fs-5">{{ $post->apartment->rent ?? 'N/A' }} JD</span>
                                        </div>
                                    </div>
                                </div>

                                {{-- Apply Button --}}
                                <form action="{{ route('student.roommates.apply', $post->id) }}" method="POST"
                                    class="d-grid mt-auto">
                                    @csrf
                                    <button type="submit" class="btn btn-primary fw-semibold rounded-3 py-2">
                                        <i class="bi bi-hand-index me-2"></i>Apply as Roommate
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            {{-- Empty State --}}
            <div class="row">
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4 py-5 text-center">
                        <div class="card-body">
                            <i class="bi bi-inbox text-secondary mb-4" style="font-size: 4rem; opacity: 0.3;"></i>
                            <h5 class="fw-bold text-dark mb-2">No Roommate Posts Found</h5>
                            <p class="text-muted mb-4">There are currently no available roommate posts. Check back later or
                                create your own post!</p>
                            <a href="{{ route('student.roommates.create') }}"
                                class="btn btn-primary px-4 rounded-3 fw-semibold">
                                <i class="bi bi-pencil-square me-2"></i>Create Your Post
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
@endsection