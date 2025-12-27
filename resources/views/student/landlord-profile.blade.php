@extends('layouts.app')

@section('content')
    <div class="container-lg py-5">

        {{-- Landlord Info Section --}}
        <div class="card border-0 shadow-lg rounded-4 mb-5 overflow-hidden">
            <div class="card-body p-4 p-md-5">
                <div class="row align-items-center">
                    {{-- Landlord Image --}}
                    <div class="col-auto mb-3 mb-md-0">
                        @if ($landlord->image)
                            <img src="{{ asset('storage/landlord/' . $landlord->image) }}" alt="{{ $landlord->name }}"
                                class="rounded-circle border-4 border-primary shadow-sm"
                                style="width: 120px; height: 120px; object-fit: cover;">
                        @else
                            <div class="rounded-circle bg-light border-4 border-primary d-flex align-items-center justify-content-center shadow-sm"
                                style="width: 120px; height: 120px;">
                                <i class="bi bi-person-circle text-primary" style="font-size: 3.5rem;"></i>
                            </div>
                        @endif
                    </div>

                    {{-- Landlord Basic Info --}}
                    <div class="col">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h1 class="fw-bold text-dark mb-2">{{ $landlord->name }}</h1>
                                <div class="d-flex flex-column gap-2">
                                    @if ($landlord->phone_number)
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-telephone-fill text-primary" style="font-size: 1.1rem;"></i>
                                            <a href="tel:{{ $landlord->phone_number }}" class="text-dark text-decoration-none">
                                                {{ $landlord->phone_number }}
                                            </a>
                                        </div>
                                    @endif

                                    @if ($landlord->gender)
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-gender-ambiguous text-primary" style="font-size: 1.1rem;"></i>
                                            <span class="text-dark">{{ ucfirst($landlord->gender) }}</span>
                                        </div>
                                    @endif

                                    @if ($landlord->date_of_birth)
                                        <div class="d-flex align-items-center gap-2">
                                            <i class="bi bi-calendar-event text-primary" style="font-size: 1.1rem;"></i>
                                            <span class="text-dark">{{ $landlord->date_of_birth->format('F j, Y') }}</span>
                                        </div>
                                    @endif

                                    <div>
                                        <span
                                            class="badge bg-primary bg-opacity-10 text-primary px-3 py-2 rounded-pill fw-semibold">
                                            <i class="bi bi-building-fill me-2"></i>Landlord
                                        </span>
                                    </div>
                                </div>
                            </div>
                            @if(auth()->id() !== $landlord->id)
                                <a href="{{ route('chat.start', $landlord->id) }}"
                                    class="btn btn-primary rounded-pill px-4 py-2 shadow-sm d-flex align-items-center gap-2">
                                    <i class="bi bi-chat-dots-fill"></i> Message Landlord
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Apartments Section Header --}}
        <div class="mb-5">
            <h2 class="fw-bold text-dark mb-2">
                <i class="bi bi-houses text-primary me-2"></i>
                Available Apartments
            </h2>
            <p class="text-muted fs-6">{{ $apartments->count() }} properties by {{ $landlord->name }}</p>
            <hr class="border-primary border-3 w-25 opacity-50">
        </div>

        {{-- Apartments List --}}
        @if ($apartments->count() > 0)
            <div class="row g-4 mb-5">
                @foreach ($apartments as $apartment)
                    <div class="col-md-6 col-lg-4">
                        <div class="card border-0 shadow-sm rounded-4 h-100 transition-all hover-shadow"
                            style="transition: all 0.3s ease;">

                            {{-- Image Container --}}
                            <div class="position-relative overflow-hidden rounded-top-4" style="height: 200px;">
                                @if ($apartment->image)
                                    <img src="{{ asset('storage/apartments/' . $apartment->image) }}" class="w-100 h-100"
                                        alt="{{ $apartment->title }}" style="object-fit: cover; transition: transform 0.3s ease;">
                                @else
                                    <div class="bg-gradient bg-light w-100 h-100 d-flex align-items-center justify-content-center">
                                        <i class="bi bi-building fs-1 text-secondary opacity-25"></i>
                                    </div>
                                @endif

                                {{-- Rent Badge --}}
                                <div class="position-absolute top-0 end-0 m-3">
                                    <span class="badge bg-danger px-3 py-2 rounded-pill fs-6 fw-bold shadow-sm">
                                        {{ $apartment->rent }} <small>JD/mo</small>
                                    </span>
                                </div>
                            </div>

                            {{-- Card Body --}}
                            <div class="card-body d-flex flex-column p-4">
                                <h5 class="fw-bold text-dark mb-2 flex-grow-1">
                                    <i class="bi bi-house-door-fill me-2 text-primary"></i> {{-- Icon for title --}}
                                    {{ $apartment->title }}
                                </h5>
                                <p class="text-muted mb-4 fs-6" style="line-height: 1.5;">
                                    <i class="bi bi-card-text me-2 text-primary"></i> {{-- Icon for description --}}
                                    {{ Str::limit($apartment->description, 85) }}
                                </p>

                                {{-- Footer --}}
                                <div class="d-grid gap-2">
                                    <a href="{{ route('student.apartments') }}"
                                        class="btn btn-primary fw-semibold rounded-3 py-2 hover-lift"
                                        style="transition: all 0.2s ease;">
                                        <i class="bi bi-eye me-2"></i>View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="alert alert-info alert-dismissible fade show border-0 rounded-4" role="alert">
                <i class="bi bi-info-circle me-2"></i>
                <strong>No apartments available</strong> - This landlord currently has no listings.
            </div>
        @endif

    </div>
@endsection