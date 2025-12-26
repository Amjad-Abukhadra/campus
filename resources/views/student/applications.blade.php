@extends('layouts.app')

@section('content')
    <div class="container-lg py-5">
        {{-- Header Section --}}
        <x-page-header title="My Applications" subtitle="Track and manage your apartment applications and payments"
            icon="bi bi-send-check" :breadcrumb="[
            ['label' => 'Apartments', 'link' => route('student.apartments')],
            ['label' => 'My Applications']
        ]" />
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
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-calendar-event text-primary me-2" style="font-size: 1.1rem;"></i>
                                    <span class="text-muted fs-6">
                                        Applied: {{ $app->created_at->format('M d, Y') }}
                                    </span>
                                </div>

                                {{-- Payment Status --}}
                                @if($app->status === 'accepted')
                                    <div class="mb-3 p-3 bg-light rounded-3">
                                        @if($app->payment_status === 'unpaid')
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="bi bi-exclamation-circle text-warning me-2"></i>
                                                <span class="text-muted small">Payment Required</span>
                                            </div>
                                        @elseif($app->payment_status === 'paid')
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="bi bi-check-circle-fill text-success me-2"></i>
                                                <span class="text-success small fw-bold">Paid</span>
                                            </div>
                                            <div class="text-muted small">
                                                <div>Amount: <strong>{{ $app->payment_amount }} JD</strong></div>
                                                <div>Paid: {{ $app->paid_at->format('M d, Y') }}</div>
                                                @if($app->canCancel())
                                                    <div class="text-warning mt-1">
                                                        <i class="bi bi-clock me-1"></i>
                                                        Cancel by: {{ $app->cancellation_deadline->format('M d, h:i A') }}
                                                    </div>
                                                @endif
                                            </div>
                                        @elseif($app->payment_status === 'refunded')
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-arrow-counterclockwise text-info me-2"></i>
                                                <span class="text-info small fw-bold">Refunded</span>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                {{-- Action Buttons --}}
                                <div class="d-grid gap-2">
                                    @if($app->status === 'accepted' && $app->payment_status === 'unpaid')
                                        <a href="{{ route('student.payment.initiate', $app->id) }}"
                                            class="btn btn-success fw-semibold rounded-3 py-2">
                                            <i class="bi bi-credit-card me-2"></i>Pay Now
                                        </a>
                                    @elseif($app->status === 'accepted' && $app->canCancel())
                                        <form action="{{ route('student.payment.cancel', $app->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to cancel and refund this payment?');">
                                            @csrf
                                            <button type="submit" class="btn btn-warning fw-semibold rounded-3 py-2 w-100">
                                                <i class="bi bi-x-circle me-2"></i>Cancel & Refund
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Review Button for Paid Apartments --}}
                                    @if($app->isPaid())
                                        @php
                                            $hasReviewed = $app->apartment->reviews->where('student_id', Auth::id())->count() > 0;
                                        @endphp
                                        @if(!$hasReviewed)
                                            <button type="button" class="btn btn-info fw-semibold rounded-3 py-2" data-bs-toggle="modal"
                                                data-bs-target="#reviewModal{{ $app->id }}">
                                                <i class="bi bi-star me-2"></i>Rate Apartment
                                            </button>
                                        @else
                                            <button class="btn btn-outline-success fw-semibold rounded-3 py-2" disabled>
                                                <i class="bi bi-check-circle me-2"></i>Already Reviewed
                                            </button>
                                        @endif
                                    @endif

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

    {{-- Review Modals --}}
    @if($applications->count() > 0)
        @foreach ($applications as $app)
            @if($app->isPaid())
                <div class="modal fade" id="reviewModal{{ $app->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Rate {{ $app->apartment->title }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <form action="{{ route('student.reviews.store', $app->apartment->id) }}" method="POST">
                                @csrf
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Rating</label>
                                        <div class="star-rating">
                                            @for($i = 5; $i >= 1; $i--)
                                                <input type="radio" id="star{{ $i }}-{{ $app->id }}" name="rating" value="{{ $i }}"
                                                    required />
                                                <label for="star{{ $i }}-{{ $app->id }}">★</label>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Comment (Optional)</label>
                                        <textarea name="comment" class="form-control" rows="4"
                                            placeholder="Share your experience..."></textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Submit Review</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    @endif

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

        /* Star Rating Styles */
        .star-rating {
            direction: rtl;
            display: inline-flex;
            font-size: 2rem;
        }

        .star-rating input[type="radio"] {
            display: none;
        }

        .star-rating label {
            color: #ddd;
            cursor: pointer;
            transition: color 0.2s;
        }

        .star-rating label:hover,
        .star-rating label:hover~label,
        .star-rating input[type="radio"]:checked~label {
            color: #ffc107;
        }
    </style>
@endsection