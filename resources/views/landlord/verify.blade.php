@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <x-page-header title="Verify Your Account" subtitle="Submit your documents to get the verified badge"
            icon="bi bi-shield-check" :breadcrumb="[['label' => 'Dashboard', 'link' => route('dashboard')], ['label' => 'Verification']]" />

        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow rounded-4 border-0">
                    <div class="card-body p-4">
                        @if (session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if(Auth::user()->is_verified)
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="bi bi-patch-check-fill text-success display-1"></i>
                                </div>
                                <h3 class="fw-bold text-success">Verified Landlord</h3>
                                <p class="text-muted">Congratulations! Your account is fully verified.</p>
                                <a href="{{ route('dashboard') }}" class="btn btn-primary rounded-pill px-4">Go to Dashboard</a>
                            </div>
                        @elseif($verificationRequest && $verificationRequest->status == 'pending')
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="bi bi-hourglass-split text-warning display-1"></i>
                                </div>
                                <h3 class="fw-bold">Verification Pending</h3>
                                <p class="text-muted">Your request has been submitted and is currently under review by our admin
                                    team.</p>
                                <a href="{{ route('dashboard') }}" class="btn btn-primary rounded-pill px-4">Back to
                                    Dashboard</a>
                            </div>
                        @elseif($verificationRequest && $verificationRequest->status == 'approved')
                            <div class="text-center py-5">
                                <div class="mb-3">
                                    <i class="bi bi-check-circle-fill text-success display-1"></i>
                                </div>
                                <h3 class="fw-bold text-success">Verification Approved</h3>
                                <p class="text-muted">Your request has been approved. You will be verified soon.</p>
                                <a href="{{ route('dashboard') }}" class="btn btn-primary rounded-pill px-4">Go to Dashboard</a>
                            </div>
                        @else
                            @if($verificationRequest && $verificationRequest->status == 'rejected')
                                <div class="alert alert-danger mb-4 shadow-sm border-0">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="bi bi-exclamation-circle-fill fs-4 me-2"></i>
                                        <h5 class="mb-0 fw-bold">Verification Rejected</h5>
                                    </div>
                                    <p class="mb-1">Unfortunately, your verification request was rejected.</p>
                                    @if($verificationRequest->admin_notes)
                                        <div
                                            class="bg-white bg-opacity-50 p-3 rounded mt-2 text-danger border border-danger border-opacity-25">
                                            <strong>Reason:</strong> {{ $verificationRequest->admin_notes }}
                                        </div>
                                    @endif
                                    <div class="mt-2 text-sm text-danger-emphasis">
                                        Please review the reason above and submit a new document.
                                    </div>
                                </div>
                            @endif

                            <form action="{{ route('landlord.verification.submit') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-4">
                                    <label class="form-label fw-bold">National ID / Identity Document</label>
                                    <p class="text-muted small">Please upload a clear picture of your National ID or Passport
                                        for verification.</p>
                                    <input type="file" name="document" class="form-control form-control-lg" required
                                        accept="image/*,.pdf">
                                    @error('document')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-bold">National ID Number (Optional)</label>
                                    <input type="text" name="national_id_number" class="form-control"
                                        placeholder="Enter your ID number if applicable"
                                        value="{{ old('national_id_number') }}">
                                </div>

                                <div class="d-grid">
                                    <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm">
                                        <i class="bi bi-send-check me-2"></i>
                                        {{ $verificationRequest && $verificationRequest->status == 'rejected' ? 'Resubmit Verification' : 'Submit for Verification' }}
                                    </button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection