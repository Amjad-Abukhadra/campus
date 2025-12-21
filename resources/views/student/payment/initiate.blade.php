@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <h3 class="mb-0"><i class="bi bi-credit-card me-2"></i>Complete Payment</h3>
                    </div>
                    <div class="card-body p-5">
                        <!-- Demo PayPal Interface -->
                        <div class="text-center mb-4">
                            <img src="https://www.paypalobjects.com/webstatic/mktg/logo/pp_cc_mark_111x69.jpg" alt="PayPal"
                                class="mb-3">
                            <p class="text-muted small">Demo Payment Mode - No Real Transaction</p>
                        </div>

                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            This is a demo payment interface. Click "Pay Now" to simulate the payment.
                        </div>

                        <div class="row mb-4">
                            <div class="col-6">
                                <strong>Apartment:</strong>
                            </div>
                            <div class="col-6 text-end">
                                {{ $application->apartment->title }}
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-6">
                                <strong>Landlord:</strong>
                            </div>
                            <div class="col-6 text-end">
                                {{ $application->apartment->landlord->name }}
                            </div>
                        </div>

                        <div class="row mb-4 pb-3 border-bottom">
                            <div class="col-6">
                                <strong>Monthly Rent:</strong>
                            </div>
                            <div class="col-6 text-end">
                                {{ $amount }} JD
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-6">
                                <h5>Total Amount:</h5>
                            </div>
                            <div class="col-6 text-end">
                                <h5 class="text-success">{{ $amount }} JD</h5>
                            </div>
                        </div>

                        <form action="{{ route('student.payment.execute', $application->id) }}" method="POST">
                            @csrf
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg py-3">
                                    <i class="bi bi-lock-fill me-2"></i>Pay Now (Demo)
                                </button>
                                <a href="{{ url('/student/applications') }}" class="btn btn-outline-secondary">
                                    Cancel
                                </a>
                            </div>
                        </form>

                        <div class="text-center mt-4">
                            <small class="text-muted">
                                <i class="bi bi-shield-check me-1"></i>
                                7-day cancellation policy applies
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection