@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h2 class="mb-4 text-primary fw-bold">Available Apartments</h2>
        <p class="text-muted mb-4">Browse through apartments and apply for the ones you like.</p>

        {{-- Success/Error Messages --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row g-4">
            @forelse($apartments as $apartment)
                @php
                    $status = $applications[$apartment->id] ?? null;
                @endphp

                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden">
                        {{-- Apartment Image --}}
                        <div class="position-relative">
                            @if ($apartment->image)
                                <img src="{{ asset('storage/apartments/' . $apartment->image) }}" class="card-img-top"
                                    style="height: 200px;">
                            @else
                                <div class="bg-secondary d-flex align-items-center justify-content-center"
                                    style="height: 200px;">
                                    <i class="bi bi-building fs-1 text-white opacity-50"></i>
                                </div>
                            @endif
                            {{-- Rent Badge --}}
                            <span
                                class="position-absolute top-2 end-2 bg-primary text-white px-3 py-1 rounded-pill fw-bold shadow-sm">
                                {{ $apartment->rent }} JD/mo
                            </span>
                        </div>

                        {{-- Card Body --}}
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">{{ $apartment->title }}</h5>
                            <p class="text-muted mb-2" style="flex-grow: 1;">{{ Str::limit($apartment->description, 80) }}
                            </p>

                            <p class="mb-1">
                                <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                <small>{{ $apartment->location }}</small>
                            </p>

                            {{-- Apply Button / Status --}}
                            <div class="mt-3">
                                @if ($status)
                                    <button
                                        class="btn 
                                    @if ($status == 'pending') btn-warning
                                    @elseif($status == 'approved') btn-success
                                    @else btn-danger @endif w-100"
                                        disabled>
                                        {{ ucfirst($status) }}
                                    </button>
                                @else
                                    <form action="{{ route('student.apartments.apply', $apartment->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary w-100 fw-bold">
                                            Apply Now
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        No apartments available at the moment. Please check back later.
                    </div>
                </div>
            @endforelse
        </div>
    </div>

    <style>
        /* Intensified card shadow and hover effect */
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            /* default shadow */
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 110px 110px rgba(0, 0, 0, 0.2);
            /* stronger shadow on hover */
        }

        /* Optional: scale image slightly on hover for effect */
        .card img {
            transition: transform 0.3s ease;
        }

        .card:hover img {
            transform: scale(1.05);
        }
    </style>
@endsection
