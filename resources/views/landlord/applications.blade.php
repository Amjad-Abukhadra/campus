@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4"
        style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); min-height: 100vh;">
        <div class="container">

            <!-- Header -->
            <div class="mb-4">
                <h1 class="fw-bold mb-2">Applications</h1>
            </div>

            <!-- Applications Table Card -->
            <div class="card border-0 shadow-sm">
                <!-- Header -->
                <div class="card-header border-0 py-3"
                    style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);">
                    <div class="text-white">
                        <h5 class="mb-1 fw-semibold">
                            <i class="bi bi-envelope-paper me-2"></i>Rental Applications
                        </h5>
                    </div>
                </div>

                <!-- Table -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="px-4 py-3 text-muted small fw-semibold">#</th>
                                    <th class="px-4 py-3 text-muted small fw-semibold">APARTMENT</th>
                                    <th class="px-4 py-3 text-muted small fw-semibold">STUDENT</th>
                                    <th class="px-4 py-3 text-muted small fw-semibold">RENT</th>
                                    <th class="px-4 py-3 text-muted small fw-semibold">STATUS</th>
                                    <th class="px-4 py-3 text-muted small fw-semibold">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($applications as $index => $application)
                                    <tr>
                                        <td class="px-4 py-3">
                                            <span class="fw-medium">{{ $index + 1 }}</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="d-flex align-items-center">
                                                @if ($application->apartment->image)
                                                    <img src="{{ asset('storage/apartments/' . $application->apartment->image) }}"
                                                        class="rounded me-3" style="width: 60px; height: 60px; object-fit: cover;"
                                                        alt="Apartment Image">
                                                @else
                                                    <div class="bg-light rounded me-3 d-flex align-items-center justify-content-center"
                                                        style="width: 60px; height: 60px;">
                                                        <i class="bi bi-building text-muted"></i>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="fw-semibold">{{ $application->apartment->title }}</div>
                                                    <small class="text-muted">
                                                        <i class="bi bi-geo-alt me-1"></i>{{ $application->apartment->location }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div>
                                                <div class="fw-semibold">
                                                    <i class="bi bi-person-circle text-primary me-1"></i>
                                                    {{ $application->student->name }}
                                                </div>
                                                <small class="text-muted">{{ $application->student->email }}</small>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="fw-semibold">{{ $application->apartment->rent }} JD</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            @if ($application->status == 'pending')
                                                <span
                                                    class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill px-3 py-2">
                                                    <i class="bi bi-circle-fill" style="font-size: 0.5rem;"></i> Pending
                                                </span>
                                            @elseif ($application->status == 'accepted')
                                                <span
                                                    class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-2">
                                                    <i class="bi bi-circle-fill" style="font-size: 0.5rem;"></i> Accepted
                                                </span>
                                            @else
                                                <span
                                                    class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-3 py-2">
                                                    <i class="bi bi-circle-fill" style="font-size: 0.5rem;"></i> Rejected
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            <button type="button"
                                                class="btn btn-sm btn-outline-primary action-btn rounded-circle"
                                                data-bs-toggle="modal" data-bs-target="#viewModal{{ $application->id }}"
                                                title="View Details">
                                                <i class="bi bi-eye"></i>
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- View Modal -->
                                    <div class="modal fade" id="viewModal{{ $application->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content border-0 shadow-lg rounded-4">
                                                <div class="modal-header border-0 py-4"
                                                    style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);">
                                                    <h5 class="modal-title text-white fw-semibold">
                                                        <i class="bi bi-envelope-paper me-2"></i>Application Details
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <div class="row">
                                                        {{-- Apartment Image --}}
                                                        @if ($application->apartment->image)
                                                            <div class="col-md-5 mb-4 mb-md-0">
                                                                <img src="{{ asset('storage/apartments/' . $application->apartment->image) }}"
                                                                    class="img-fluid rounded-3 shadow-sm"
                                                                    style="width: 100%; height: 300px; object-fit: cover;"
                                                                    alt="Apartment Image">
                                                            </div>
                                                        @endif

                                                        {{-- Apartment Info --}}
                                                        <div class="{{ $application->apartment->image ? 'col-md-7' : 'col-12' }}">
                                                            <div class="mb-4 pb-3 border-bottom">
                                                                <h6 class="text-primary fw-bold mb-3">
                                                                    <i class="bi bi-building me-2"></i>Apartment Information
                                                                </h6>
                                                                <div class="mb-3">
                                                                    <label
                                                                        class="text-muted small fw-semibold text-uppercase mb-1">Title</label>
                                                                    <p class="fs-5 fw-semibold mb-0">
                                                                        {{ $application->apartment->title }}</p>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label
                                                                        class="text-muted small fw-semibold text-uppercase mb-1">Location</label>
                                                                    <p class="mb-0">
                                                                        <i class="bi bi-geo-alt-fill text-primary me-1"></i>
                                                                        {{ $application->apartment->location }}
                                                                    </p>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label
                                                                        class="text-muted small fw-semibold text-uppercase mb-1">Monthly
                                                                        Rent</label>
                                                                    <p class="fs-4 fw-bold text-primary mb-0">
                                                                        {{ $application->apartment->rent }} JD</p>
                                                                </div>
                                                                <div>
                                                                    <label
                                                                        class="text-muted small fw-semibold text-uppercase mb-2 d-block">Description</label>
                                                                    <p class="text-muted small mb-0"
                                                                        style="line-height: 1.6;">
                                                                        {{ $application->apartment->description }}</p>
                                                                </div>
                                                            </div>

                                                            {{-- Student Info --}}
                                                            <div class="mb-4 pb-3 border-bottom">
                                                                <h6 class="text-primary fw-bold mb-3">
                                                                    <i class="bi bi-person-circle me-2"></i>Student Information
                                                                </h6>
                                                                <div class="mb-3">
                                                                    <label
                                                                        class="text-muted small fw-semibold text-uppercase mb-1">Name</label>
                                                                    <p class="fw-semibold mb-0">{{ $application->student->name }}</p>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label
                                                                        class="text-muted small fw-semibold text-uppercase mb-1">Email</label>
                                                                    <p class="mb-0">{{ $application->student->email }}</p>
                                                                </div>
                                                                @if ($application->student->phone_number)
                                                                    <div>
                                                                        <label
                                                                            class="text-muted small fw-semibold text-uppercase mb-1">Phone</label>
                                                                        <p class="mb-0">{{ $application->student->phone_number }}</p>
                                                                    </div>
                                                                @endif
                                                            </div>

                                                            {{-- Roommate Info (if any) --}}
                                                            @if ($application->roommate)
                                                                <div class="mb-4 pb-3 border-bottom">
                                                                    <h6 class="text-primary fw-bold mb-3">
                                                                        <i class="bi bi-people me-2"></i>Roommate Information
                                                                    </h6>
                                                                    <div class="mb-3">
                                                                        <label
                                                                            class="text-muted small fw-semibold text-uppercase mb-1">Name</label>
                                                                        <p class="fw-semibold mb-0">{{ $application->roommate->name }}</p>
                                                                    </div>
                                                                    <div>
                                                                        <label
                                                                            class="text-muted small fw-semibold text-uppercase mb-1">Email</label>
                                                                        <p class="mb-0">{{ $application->roommate->email }}</p>
                                                                    </div>
                                                                </div>
                                                            @endif

                                                            {{-- Status Update --}}
                                                            <div>
                                                                <h6 class="text-primary fw-bold mb-3">
                                                                    <i class="bi bi-gear me-2"></i>Update Application Status
                                                                </h6>
                                                                <form action="{{ route('landlord.applications.update', $application->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="d-flex gap-2">
                                                                        <select name="status" class="form-select form-select-lg">
                                                                            <option value="pending"
                                                                                {{ $application->status == 'pending' ? 'selected' : '' }}>
                                                                                Pending
                                                                            </option>
                                                                            <option value="accepted"
                                                                                {{ $application->status == 'accepted' ? 'selected' : '' }}>
                                                                                Accepted
                                                                            </option>
                                                                            <option value="rejected"
                                                                                {{ $application->status == 'rejected' ? 'selected' : '' }}>
                                                                                Rejected
                                                                            </option>
                                                                        </select>
                                                                        <button type="submit" class="btn btn-success">
                                                                            <i class="bi bi-check-circle me-2"></i>Save
                                                                        </button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer border-0 pt-0 pb-4">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-5">
                                            <div class="py-5">
                                                <i class="bi bi-envelope-paper text-muted" style="font-size: 4rem;"></i>
                                                <h5 class="mt-3 mb-2">No Applications Found</h5>
                                                <p class="text-muted mb-4">You haven't received any applications yet.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
        }

        .action-btn {
            width: 36px;
            height: 36px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0;
            transition: all 0.2s ease;
        }

        .action-btn:hover {
            transform: scale(1.1);
        }

        .table>tbody>tr {
            transition: background-color 0.2s ease;
        }

        .modal-content {
            overflow: hidden;
        }

        .rounded-4 {
            border-radius: 1rem !important;
        }
    </style>
@endsection
