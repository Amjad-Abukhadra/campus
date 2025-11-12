@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <h3 class="mb-4">My Applications</h3>

        <div class="row">
            @forelse ($applications as $app)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm h-100">
                        @if ($app->apartment->image)
                            <div class="position-relative overflow-hidden">
                                <img src="{{ asset('storage/apartments/' . $app->apartment->image) }}" class="card-img-top"
                                    alt="Apartment Image" style="height: 220px; transition: transform 0.3s;">
                            </div>
                        @endif
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">{{ $app->apartment->title }}</h5>
                            <p class="card-text">{{ $app->apartment->location }}</p>
                            <p class="card-text"><strong>Rent:</strong> ${{ $app->apartment->rent }}</p>
                            <div class="mt-auto">
                                @if ($app->status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @elseif($app->status == 'accepted')
                                    <span class="badge bg-success">Accepted</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card shadow-sm border-0 text-center py-5">
                        <div class="card-body">
                            <p class="text-muted mb-3">You haven’t applied for any apartments yet.</p>
                            <a href="{{ url('/student/apartments') }}" class="btn btn-primary">
                                <i class="bi bi-building-add me-1"></i> Browse Apartments
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
@endsection
