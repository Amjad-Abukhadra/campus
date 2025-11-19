@extends('layouts.app')

@section('content')
    <div class="container py-5">

        {{-- Landlord Info Section --}}
        <div class="d-flex align-items-center mb-4 p-3 bg-white shadow-sm rounded-4">

            {{-- Landlord Image --}}
            <div class="me-3">
                @if ($landlord->image)
                    <img src="{{ asset('storage/landlord/' . $landlord->image) }}" alt="Landlord Image"
                        class="rounded-circle border" style="width: 90px; height: 90px; object-fit: cover;">
                @else
                    <i class="bi bi-person-circle text-primary" style="font-size: 4.5rem;"></i>
                @endif
            </div>

            {{-- Landlord Basic Info --}}
            <div>
                <h2 class="fw-bold mb-1">{{ $landlord->name }}</h2>

                @if ($landlord->phone)
                    <p class="text-muted mb-1">
                        <i class="bi bi-telephone-fill text-primary me-1"></i>
                        {{ $landlord->phone }}
                    </p>
                @endif

                <p class="text-muted mb-0">Landlord</p>
            </div>
        </div>

        {{-- Apartments Title --}}
        <h4 class="fw-bold text-primary mb-3">Apartments by {{ $landlord->name }}</h4>

        {{-- Apartments List --}}
        <div class="row g-4">
            @foreach ($apartments as $apartment)
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm border-0 rounded-4 h-100">
                        @if ($apartment->image)
                            <img src="{{ asset('storage/apartments/' . $apartment->image) }}" class="card-img-top"
                                style="height: 180px; object-fit: cover;">
                        @else
                            <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 180px;">
                                <i class="bi bi-building fs-1 text-white opacity-50"></i>
                            </div>
                        @endif

                        <div class="card-body">
                            <h5 class="fw-bold">{{ $apartment->title }}</h5>
                            <p class="text-muted mb-2">{{ Str::limit($apartment->description, 80) }}</p>

                            <span class="badge bg-primary px-3 py-1 rounded-pill">
                                {{ $apartment->rent }} JD/mo
                            </span>

                            <div class="mt-3">
                                <a href="{{ route('student.apartments') }}" class="btn btn-outline-primary w-100">
                                    View in Listings
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection