@extends('layouts.app')

@section('content')
    <div class="container-lg py-5">
        {{-- Header Section --}}
        <div class="mb-5">
            <h1 class="fw-bold text-dark mb-2">
                <i class="bi bi-file-earmark-check text-primary me-2"></i>My Applications
            </h1>
            <p class="text-muted fs-6">Track and manage your apartment applications</p>
            <hr class="border-primary border-3 w-25 opacity-50">
        </div>

        {{-- Applications Grid --}}
        @if($applications->count() > 0)
            <div class="row g-4">
                @foreach ($applications as $app)
                    <div class="col-md-6 col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100 transition-all"
                            style="transition: all 0.3s ease; overflow: hidden;">

                            {{-- Image Section --}}
                            @if ($app->apartment->image)
                                <div class="position-relative overflow-hidden" style="height: 220px;">
                                    <img src="{{ asset('storage/apartments/' . $app->apartment->image) }}" class="w-100 h-100"
                                        alt="{{ $app->apartment->title }}" style="object-fit: cover; transition: transform 0.3s ease;">

                                    {{-- Status Badge --}}
                                    <div class="position-absolute top-0 end-0 m-3">
                                        @if ($app->status == 'pending')
                                            <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-semibold shadow-sm">
                                                <i class="bi bi-hourglass-split me-1"></i>Pending
                                            </span>
                                        @elseif($app->status == 'accepted')
                                            <span class="badge bg-success px-3 py-2 rounded-pill fw-semibold shadow-sm">
                                                <i class="bi bi-check-circle-fill me-1"></i>Accepted
                                            </span>
                                        @else
                                            <span class="badge bg-danger px-3 py-2 rounded-pill fw-semibold shadow-sm">
                                                <i class="bi bi-x-circle-fill me-1"></i>Rejected
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 220px;">
                                    <i class="bi bi-building fs-1 text-secondary opacity-25"></i>
                                </div>
                            @endif

                            {{-- Card Body --}}
                            <div class="card-body d-flex flex-column p-4">
                                {{-- Title --}}
                                <h5 class="fw-bold text-dark mb-3 flex-grow-1">
                                    <i class="bi bi-house-door-fill text-primary me-2"></i>
                                    {{ $app->apartment->title }}
                                </h5>

                                {{-- Location --}}
                                <div class="d-flex align-items-center mb-2 pb-2 border-bottom">
                                    <i class="bi bi-geo-alt-fill text-primary me-2" style="font-size: 1.1rem;"></i>
                                    <span class="text-muted fs-6">{{ $app->apartment->location }}</span>
                                </div>

                                {{-- Landlord --}}
                                <div class="d-flex align-items-center mb-2 pb-2 border-bottom">
                                    <i class="bi bi-person-fill text-primary me-2" style="font-size: 1.1rem;"></i>
                                    <span class="text-muted fs-6">{{ $app->apartment->landlord->name }}</span>
                                </div>

                                {{-- Rent --}}
                                <div class="d-flex align-items-center mb-3 pb-3 border-bottom">
                                    <i class="bi bi-cash-coin text-primary me-2" style="font-size: 1.1rem;"></i>
                                    <span class="fw-semibold text-dark fs-6">{{ $app->apartment->rent }} JD/month</span>
                                </div>

                                {{-- Application Date --}}
                                <div class="d-flex align-items-center mb-4">
                                    <i class="bi bi-calendar-event text-primary me-2" style="font-size: 1.1rem;"></i>
                                    <span class="text-muted fs-6">
                                        Applied: {{ $app->created_at->format('M d, Y') }}
                                    </span>
                                </div>

                                {{-- Action Buttons --}}
                                <div class="d-grid gap-2">
                                    <a class="btn btn-outline-primary fw-semibold rounded-3 py-2">
                                        <i class="bi bi-eye me-2"></i>View Apartment
                                    </a>
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
                    <div class="card border-0 shadow-sm rounded-4 py-5">
                        <div class="card-body text-center">
                            <div class="mb-4">
                                <i class="bi bi-inbox text-secondary" style="font-size: 4rem; opacity: 0.3;"></i>
                            </div>
                            <h5 class="fw-bold text-dark mb-2">No Applications Yet</h5>
                            <p class="text-muted mb-4">You haven't applied for any apartments yet. Start exploring available
                                properties!</p>
                            <a href="{{ url('/student/apartments') }}" class="btn btn-primary px-4 rounded-3 fw-semibold">
                                <i class="bi bi-building-add me-2"></i>Browse Apartments
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>

    <style>
        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 1.5rem 3rem rgba(0, 0, 0, 0.15) !important;
        }

        .card img:hover {
            transform: scale(1.08);
        }

        .btn-outline-primary:hover,
        .btn-outline-danger:hover {
            transform: translateY(-2px);
        }

        @media (max-width: 768px) {
            .card-body {
                padding: 1.25rem !important;
            }
        }
    </style>
@endsection