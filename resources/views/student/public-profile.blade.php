@extends('layouts.app')

@section('content')
    <div class="container-lg py-5">

        {{-- Student Info Section --}}
        <div class="card border-0 shadow-lg rounded-4 mb-5 overflow-hidden">
            <div class="card-body p-4 p-md-5">
                <div class="row align-items-center">
                    {{-- Student Image --}}
                    <div class="col-auto mb-3 mb-md-0">
                        @if ($student->image)
                            <img src="{{ asset('storage/students/' . $student->image) }}" alt="{{ $student->name }}"
                                class="rounded-circle border-4 border-primary shadow-sm"
                                style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-light border-4 border-primary d-flex align-items-center justify-content-center shadow-sm"
                                style="width: 120px; height: 120px;">
                                <i class="bi bi-person-circle text-primary" style="font-size: 3.5rem;"></i>
                            </div>
                        @endif
                    </div>

                    {{-- Student Basic Info --}}
                    <div class="col">
                        <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                            <div>
                                <h1 class="fw-bold text-dark mb-2">{{ $student->name }}</h1>
                                <div class="row gx-5 gy-5">
                                    <div class="col-md-6">
                                        @if ($student->major)
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <i class="bi bi-book-half text-primary" style="font-size: 1.1rem;"></i>
                                                <span class="text-dark"><strong>Major:</strong> {{ $student->major }}</span>
                                            </div>
                                        @endif

                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <i class="bi bi-envelope-fill text-primary" style="font-size: 1.1rem;"></i>
                                            <a href="mailto:{{ $student->email }}"
                                                class="text-dark text-decoration-none">{{ $student->email }}</a>
                                        </div>

                                        @if ($student->phone_number)
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <i class="bi bi-telephone-fill text-primary" style="font-size: 1.1rem;"></i>
                                                <a href="tel:{{ $student->phone_number }}"
                                                    class="text-dark text-decoration-none">
                                                    {{ $student->phone_number }}
                                                </a>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-md-6">
                                        @if ($student->gender)
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <i class="bi bi-gender-ambiguous text-primary" style="font-size: 1.1rem;"></i>
                                                <span class="text-dark">{{ ucfirst($student->gender) }}</span>
                                            </div>
                                        @endif

                                        @if ($student->date_of_birth)
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <i class="bi bi-calendar-event text-primary" style="font-size: 1.1rem;"></i>
                                                <span
                                                    class="text-dark">{{ \Carbon\Carbon::parse($student->date_of_birth)->age }}
                                                    years old</span>
                                            </div>
                                        @endif

                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <i class="bi bi-calendar-check text-primary" style="font-size: 1.1rem;"></i>
                                            <span class="text-dark">Joined {{ $student->created_at->format('M Y') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <span
                                        class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-semibold">
                                        <i class="bi bi-mortarboard-fill me-2"></i>Student
                                    </span>
                                </div>
                            </div>
                        </div>
                        @if(auth()->id() !== $student->id)
                            <a href="{{ route('chat.start', $student->id) }}"
                                class="btn btn-primary rounded-pill px-4 py-2 shadow-sm d-flex align-items-center gap-2">
                                <i class="bi bi-chat-dots-fill"></i> Message Student
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Roommate Posts Section Header --}}
    <div class="mb-5">
        <h2 class="fw-bold text-dark mb-2">
            <i class="bi bi-people-fill text-primary me-2"></i>
            Roommate Posts
        </h2>
        <p class="text-muted fs-6">{{ $posts->count() }} post(s) by {{ $student->name }}</p>
        <hr class="border-primary border-3 w-25 opacity-50">
    </div>

    {{-- Posts List --}}
    @if ($posts->count() > 0)
        <div class="row g-4 mb-5">
            @foreach ($posts as $post)
                <div class="col-12">
                    <div class="card border-0 shadow-sm rounded-4 h-100 transition-all hover-shadow overflow-hidden"
                        style="transition: all 0.3s ease;">
                        <div class="row g-0">
                            <div class="col-md-3">
                                <div class="h-100 min-vh-20">
                                    @if ($post->apartment && $post->apartment->image)
                                        <img src="{{ asset('storage/apartments/' . $post->apartment->image) }}" class="w-100 h-100"
                                            alt="Apartment Image" style="object-fit: cover;">
                                    @else
                                        <div class="bg-light w-100 h-100 d-flex align-items-center justify-content-center"
                                            style="min-height: 150px;">
                                            <i class="bi bi-building fs-1 text-secondary opacity-25"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-9">
                                <div class="card-body p-4">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h5 class="fw-bold text-dark mb-0">{{ $post->title }}</h5>
                                        <span class="text-muted small">
                                            <i class="bi bi-clock me-1"></i>{{ $post->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <p class="text-muted mb-3">{{ Str::limit($post->description, 150) }}</p>

                                    <div class="d-flex flex-wrap gap-2 mb-3">
                                        @foreach($post->preferences as $preference)
                                            <span class="badge bg-primary bg-opacity-10 text-primary rounded-pill px-2 py-1 small">
                                                {{ $preference->name }}
                                            </span>
                                        @endforeach
                                    </div>

                                    <div class="d-flex justify-content-between align-items-center mt-auto">
                                        <div class="text-dark small">
                                            <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                            {{ $post->apartment->location ?? 'N/A' }}
                                            <span class="mx-2">•</span>
                                            <i class="bi bi-cash-stack text-success me-1"></i>
                                            {{ $post->apartment->rent ?? 'N/A' }} JD
                                        </div>
                                        <a href="{{ route('student.roommates.index') }}"
                                            class="btn btn-outline-primary btn-sm rounded-pill px-3">
                                            View in Listings
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info border-0 rounded-4" role="alert">
            <i class="bi bi-info-circle me-2"></i>
            This student hasn't posted any roommate requests yet.
        </div>
    @endif

    </div>
@endsection