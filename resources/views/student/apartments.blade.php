@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <x-page-header title="Browse Apartments" subtitle="Find your next home on campus and apply for your favorite ones"
            icon="bi bi-search" :breadcrumb="[
            ['label' => 'Home', 'link' => url('/')],
            ['label' => 'Apartments']
        ]" />

        {{-- Filters --}}
        <div class="card shadow-sm border-0 rounded-4 mb-4">
            <div class="card-body">
                <form action="{{ route('student.apartments') }}" method="GET" class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i
                                    class="bi bi-geo-alt text-primary"></i></span>
                            <input type="text" name="location" class="form-control border-start-0 ps-0"
                                placeholder="Search by location..." value="{{ request('location') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i
                                    class="bi bi-cash text-success"></i></span>
                            <input type="number" name="min_price" class="form-control border-start-0 ps-0"
                                placeholder="Min Price" value="{{ request('min_price') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0"><i
                                    class="bi bi-cash-stack text-success"></i></span>
                            <input type="number" name="max_price" class="form-control border-start-0 ps-0"
                                placeholder="Max Price" value="{{ request('max_price') }}">
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
                                <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="bi bi-building fs-1 text-white opacity-50"></i>
                                </div>
                            @endif
                            {{-- Rent Badge --}}
                            <span class="position-absolute top-0 end-0 bg-primary text-white px-3 py-1 
                                                                             rounded-pill fw-bold shadow-sm m-2">
                                {{ $apartment->rent }} JD/mo
                            </span>

                            {{-- Save Button --}}
                            <form action="{{ route('student.favorites.toggle') }}" method="POST"
                                class="position-absolute top-0 start-0 m-2">
                                @csrf
                                <input type="hidden" name="id" value="{{ $apartment->id }}">
                                <input type="hidden" name="type" value="apartment">
                                <button type="submit"
                                    class="btn btn-light rounded-circle shadow-sm p-2 d-flex align-items-center justify-content-center"
                                    style="width: 40px; height: 40px;"
                                    title="{{ $student->favorites->where('favoritable_id', $apartment->id)->where('favoritable_type', 'App\Models\Apartment')->count() ? 'Unsave' : 'Save' }}">
                                    <i
                                        class="bi {{ $student->favorites->where('favoritable_id', $apartment->id)->where('favoritable_type', 'App\Models\Apartment')->count() ? 'bi-heart-fill text-danger' : 'bi-heart' }}"></i>
                                </button>
                            </form>

                        </div>

                        {{-- Card Body --}}
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">{{ $apartment->title }}</h5>
                            <p class="text-muted mb-2" style="flex-grow: 1;">{{ Str::limit($apartment->description, 80) }}
                            </p>
                            <p class="mb-1">
                                <i class="bi bi-person-circle text-primary me-1"></i>

                                <a href="{{ route('student.landlord.profile', $apartment->landlord->id) }}"
                                    class="badge bg-info text-dark px-2 py-1 rounded-pill text-decoration-none">
                                    {{ $apartment->landlord->name ?? 'Unknown' }}
                                </a>
                            </p>


                            <p class="mb-1">
                                <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                <small>{{ $apartment->location }}</small>
                            </p>

                            {{-- Rating Stars --}}
                            <div class="mb-2">
                                @php
                                    $avgRating = round($apartment->averageRating(), 1);
                                    $reviewCount = $apartment->reviews->count();
                                @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star{{ $i <= $avgRating ? '-fill' : '' }} text-warning"
                                        style="font-size: 0.9rem;"></i>
                                @endfor
                                <small class="text-muted ms-1">({{ $avgRating }})</small>
                                <small class="text-muted">· {{ $reviewCount }} reviews</small>
                            </div>


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