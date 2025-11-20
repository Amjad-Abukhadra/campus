@extends('layouts.app')

@section('content')
    <div class="container-lg py-5">

        {{-- Header Section --}}
        <div class="mb-5">
            <h1 class="fw-bold text-dark mb-2">
                <i class="bi bi-inbox-fill text-primary me-2"></i>Manage Roommate Applications
            </h1>
            <p class="text-muted fs-6">Review and manage applications from potential roommates</p>
            <hr class="border-primary border-3 w-25 opacity-50">
        </div>

        {{-- Error Messages --}}
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 rounded-4 mb-4" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                <strong>Error!</strong> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Success Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show border-0 rounded-4 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        {{-- Applications List --}}
        @forelse($requests as $req)
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <div class="row align-items-start">
                        {{-- Student Image --}}
                        <div class="col-auto mb-3 mb-md-0">
                            @if($req->student->image)
                                <img src="{{ asset('storage/students/' . $req->student->image) }}" alt="{{ $req->student->name }}"
                                    class="rounded-circle border-3 border-primary shadow-sm"
                                    style="width: 100px; height: 100px; object-fit: cover;">
                            @else
                                <img src="{{ asset('images/default-user.png') }}" alt="Default Image"
                                    class="rounded-circle border-3 border-primary shadow-sm"
                                    style="width: 100px; height: 100px; object-fit: cover;">
                            @endif
                        </div>

                        {{-- Student Info --}}
                        <div class="col">
                            {{-- Name --}}
                            <h4 class="fw-bold text-dark mb-3">{{ $req->student->name }}</h4>

                            {{-- Email --}}
                            <div class="d-flex align-items-center mb-2 pb-2 border-bottom">
                                <i class="bi bi-envelope-fill text-primary me-3" style="font-size: 1.1rem;"></i>
                                <div>
                                    <small class="text-muted d-block">Email</small>
                                    <a href="mailto:{{ $req->student->email }}" class="text-dark text-decoration-none fw-500">
                                        {{ $req->student->email }}
                                    </a>
                                </div>
                            </div>

                            {{-- Phone --}}
                            <div class="d-flex align-items-center mb-4 pb-4 border-bottom">
                                <i class="bi bi-telephone-fill text-primary me-3" style="font-size: 1.1rem;"></i>
                                <div>
                                    <small class="text-muted d-block">Phone</small>
                                    @if($req->student->phone_number)
                                        <a href="tel:{{ $req->student->phone_number }}"
                                            class="text-dark text-decoration-none fw-500">
                                            {{ $req->student->phone_number }}
                                        </a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Current Status Badge --}}
                            <div class="mb-4">
                                <small class="text-muted d-block mb-2">Current Status</small>
                                @if($req->status == 'pending')
                                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-semibold">
                                        <i class="bi bi-hourglass-split me-1"></i>Pending Review
                                    </span>
                                @elseif($req->status == 'accepted')
                                    <span class="badge bg-success px-3 py-2 rounded-pill fw-semibold">
                                        <i class="bi bi-check-circle-fill me-1"></i>Accepted
                                    </span>
                                @else
                                    <span class="badge bg-danger px-3 py-2 rounded-pill fw-semibold">
                                        <i class="bi bi-x-circle-fill me-1"></i>Rejected
                                    </span>
                                @endif
                            </div>

                            {{-- Status Update Form --}}
                            <form action="{{ route('student.roommates.update', [$req->id, $req->status]) }}" method="POST"
                                class="d-flex flex-wrap gap-2 align-items-end">
                                @csrf

                                <div>
                                    <label for="status-{{ $req->id }}" class="form-label fw-semibold mb-2">
                                        <i class="bi bi-sliders text-primary me-2"></i>Update Status
                                    </label>
                                    <select name="status" id="status-{{ $req->id }}" class="form-select rounded-3"
                                        style="min-width: 160px;">
                                        <option value="pending" {{ $req->status == 'pending' ? 'selected' : '' }}>
                                            <i class="bi bi-hourglass-split"></i> Pending
                                        </option>
                                        <option value="accepted" {{ $req->status == 'accepted' ? 'selected' : '' }}>
                                            <i class="bi bi-check-circle-fill"></i> Accepted
                                        </option>
                                        <option value="rejected" {{ $req->status == 'rejected' ? 'selected' : '' }}>
                                            <i class="bi bi-x-circle-fill"></i> Rejected
                                        </option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary fw-semibold rounded-3 px-4 py-2"
                                    style="transition: all 0.2s ease;">
                                    <i class="bi bi-save me-2"></i>Save Changes
                                </button>

                                <a href="mailto:{{ $req->student->email }}"
                                    class="btn btn-outline-secondary fw-semibold rounded-3 px-4 py-2">
                                    <i class="bi bi-chat-dots me-2"></i>Contact
                                </a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        @empty
            {{-- Empty State --}}
            <div class="card border-0 shadow-sm rounded-4 p-5">
                <div class="card-body text-center">
                    <div class="mb-4">
                        <i class="bi bi-inbox text-secondary" style="font-size: 4rem; opacity: 0.3;"></i>
                    </div>
                    <h5 class="fw-bold text-dark mb-2">No Applications Yet</h5>
                    <p class="text-muted mb-4">You don't have any roommate applications at the moment. Check back later when
                        someone applies!</p>
                    <a href="{{ route('student.roommates.index') }}" class="btn btn-primary px-4 rounded-3 fw-semibold">
                        <i class="bi bi-arrow-left me-2"></i>Back to Posts
                    </a>
                </div>
            </div>
        @endforelse

    </div>
@endsection