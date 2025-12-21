@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body text-center p-5">
                        <div class="mb-4">
                            <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                        </div>

                        <h2 class="fw-bold mb-3">Payment Successful!</h2>
                        <p class="text-muted mb-4">Your payment has been processed successfully.</p>

                        <div class="alert alert-success border-0 mb-4">
                            <div class="row">
                                <div class="col-6 text-start">
                                    <strong>Payment ID:</strong>
                                </div>
                                <div class="col-6 text-end">
                                    <code>{{ $application->payment_id }}</code>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-6 text-start">
                                    <strong>Amount Paid:</strong>
                                </div>
                                <div class="col-6 text-end">
                                    <strong class="text-success">{{ $application->payment_amount }} JD</strong>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-6 text-start">
                                    <strong>Paid At:</strong>
                                </div>
                                <div class="col-6 text-end">
                                    {{ $application->paid_at->format('M d, Y h:i A') }}
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-warning border-0 mb-4">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>Cancellation Window:</strong>
                            <p class="mb-0 mt-2">
                                You can cancel this payment and get a full refund until:<br>
                                <strong>{{ $application->cancellation_deadline->format('M d, Y h:i A') }}</strong>
                            </p>
                        </div>

                        <div class="d-grid gap-2">
                            <a href="{{ url('/student/applications') }}" class="btn btn-primary btn-lg">
                                <i class="bi bi-list-check me-2"></i>View My Applications
                            </a>
                            <a href="{{ url('/student/apartments') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-house-door me-2"></i>Browse More Apartments
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection