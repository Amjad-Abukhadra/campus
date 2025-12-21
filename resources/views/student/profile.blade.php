@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row g-4">
            {{-- Left Sidebar: Profile Card --}}
            <div class="col-lg-4">
                <div class="card shadow-sm border-0" style="top: 20px;">
                    <div class="card-body text-center p-4">
                        {{-- Profile Image --}}
                        <div class="position-relative d-inline-block mb-3">
                            @if ($student->image && file_exists(public_path('storage/students/' . $student->image)))
                                <img src="{{ asset('storage/students/' . $student->image) }}" alt="Profile Image"
                                    class="rounded-circle border border-3 border-light shadow" width="120" height="120"
                                    style="object-fit: cover;">
                            @else
                                <div class="rounded-circle border border-3 border-light shadow"
                                    style="width: 120px; height: 120px; background-color: #fff;"></div>
                            @endif
                        </div>

                        {{-- Profile Info --}}
                        <h4 class="mb-1">{{ $student->name }}</h4>
                        <p class="text-muted mb-3">
                            <i class="bi bi-envelope-fill me-1"></i>
                            {{ $student->email }}
                        </p>

                        <div class="d-grid gap-2 mb-3">
                            <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse"
                                data-bs-target="#editProfileForm" aria-expanded="false">
                                <i class="bi bi-pencil-square me-1"></i> Edit Profile
                            </button>
                        </div>

                        {{-- Collapsible Edit Form --}}
                        <div class="collapse" id="editProfileForm">
                            <hr class="my-3">
                            <form action="{{ route('student.updateProfile') }}" method="POST" enctype="multipart/form-data"
                                class="text-start">
                                @csrf

                                {{-- Image upload --}}
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Profile Image</label>
                                    <input type="file" name="image" class="form-control form-control-sm" accept="image/*">
                                </div>

                                {{-- Name --}}
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Name</label>
                                    <input type="text" name="name" value="{{ $student->name }}" class="form-control"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Phone Number</label>
                                    <input type="text" name="phone_number" value="{{ $student->phone_number }}"
                                        class="form-control" required>
                                </div>

                                {{-- Gender --}}
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Gender</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i
                                                class="bi bi-gender-ambiguous"></i></span>
                                        <select name="gender" class="form-select" required>
                                            <option value="" disabled {{ !$student->gender ? 'selected' : '' }}>Select
                                                Gender</option>
                                            <option value="male" {{ $student->gender == 'male' ? 'selected' : '' }}>Male
                                            </option>
                                            <option value="female" {{ $student->gender == 'female' ? 'selected' : '' }}>Female
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                {{-- Date of Birth --}}
                                <x-form-datepicker name="date_of_birth" label="Date of Birth"
                                    :value="$student->date_of_birth" :required="true" />


                                {{-- Major --}}
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Major</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="bi bi-mortarboard"></i></span>
                                        <input type="text" name="major" value="{{ $student->major }}" class="form-control"
                                            placeholder="Enter your major">
                                    </div>
                                </div>
                                {{-- Email --}}
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Email</label>
                                    <input type="email" name="email" value="{{ $student->email }}" class="form-control"
                                        required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle me-1"></i> Save Changes
                                    </button>
                                    <button type="button" class="btn btn-light" data-bs-toggle="collapse"
                                        data-bs-target="#editProfileForm">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>

                        <hr class="my-3">
                        <div class="row text-center">
                            <div class="col-12">
                                <h5 class="mb-0 text-primary">{{ $student->applications->count() }}</h5>
                                <small class="text-muted">Applications</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Content: Applications Grid --}}
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="mb-0">
                        <i class="bi bi-building me-2"></i>My Applications
                    </h3>
                </div>

                <div class="row g-4">
                    @forelse ($student->applications as $application)
                        <div class="col-md-6">
                            <div class="card h-100 shadow-sm border-0 hover-lift transition">
                                <div class="position-relative overflow-hidden">
                                    @if ($application->apartment->image)
                                        <img src="{{ asset('storage/apartments/' . $application->apartment->image) }}"
                                            class="card-img-top" alt="Apartment Image" style="height: 220px;">
                                    @endif
                                    <span
                                        class="position-absolute top-0 end-0 m-3 badge 
                                                                            {{ $application->status === 'accepted' ? 'bg-success' : ($application->status === 'pending' ? 'bg-warning text-dark' : 'bg-danger') }}">
                                        {{ ucfirst($application->status) }}
                                    </span>
                                </div>

                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title mb-2">{{ $application->apartment->title }}</h5>
                                    <p class="card-text text-muted small flex-grow-1">
                                        {{ Str::limit($application->apartment->description, 100) }}
                                    </p>

                                    <div class="mb-3">
                                        <p class="mb-1 small">
                                            <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                            <strong>Location:</strong> {{ $application->apartment->location }}
                                        </p>
                                    </div>

                                    <!-- View Apartment Button (Opens Modal) -->
                                    <button type="button" class="btn btn-sm btn-outline-primary mt-auto w-100"
                                        data-bs-toggle="modal"
                                        data-bs-target="#viewApartmentModal{{ $application->apartment->id }}">
                                        <i class="bi bi-eye"></i> View Apartment
                                    </button>
                                </div>
                            </div>

                            <!-- Modal: Always render -->
                            <div class="modal fade" id="viewApartmentModal{{ $application->apartment->id }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                    <div class="modal-content shadow-lg border-0">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">
                                                <i class="bi bi-eye me-2"></i> {{ $application->apartment->title }}
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row align-items-center">
                                                {{-- Left: Image --}}
                                                @if ($application->apartment->image)
                                                    <div class="col-md-5 text-center mb-3 mb-md-0">
                                                        <img src="{{ asset('storage/apartments/' . $application->apartment->image) }}"
                                                            class="img-fluid rounded" alt="Apartment Image"
                                                            style="max-height: 250px; object-fit: cover;">
                                                    </div>
                                                @endif

                                                {{-- Right: Info --}}
                                                <div class="{{ $application->apartment->image ? 'col-md-7' : 'col-12' }}">
                                                    <p class="fs-5 mb-2"><strong>Location:</strong>
                                                        {{ $application->apartment->location }}</p>
                                                    <p class="fs-5 mb-2"><strong>Rent:</strong>
                                                        {{ $application->apartment->rent }} JD/month</p>
                                                    <p class="fs-5 mb-1"><strong>Description:</strong></p>
                                                    <p class="fs-6 text-muted">{{ $application->apartment->description }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-center">
                                            <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        </div>
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
        </div>
    </div>

    <style>
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
        }

        .hover-lift:hover img {
            transform: scale(1.05);
        }

        .card {
            border-radius: 12px;
            overflow: hidden;
        }
    </style>
@endsection