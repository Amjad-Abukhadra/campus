@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <div class="row g-4">
            {{-- Left Sidebar: Profile Card --}}
            <div class="col-lg-4">
                <div class="card shadow-sm border-0 " style="top: 20px;">
                    <div class="card-body text-center p-4">
                        {{-- Profile Image --}}
                        <div class="position-relative d-inline-block mb-3">
                            @if ($landlord->image && file_exists(public_path('storage/apartments/' . $landlord->image)))
                                <img src="{{ asset('storage/apartments/' . $landlord->image) }}" alt="Profile Image"
                                    class="rounded-circle border border-3 border-light shadow" width="120" height="120"
                                    style="object-fit: cover;">
                            @else
                                <div class="rounded-circle border border-3 border-light shadow"
                                    style="width: 120px; height: 120px; background-color: #fff;"></div>
                            @endif
                        </div>
                        {{-- Profile Info --}}
                        <h4 class="mb-1">{{ $landlord->name }}</h4>
                        <p class="text-muted mb-3">
                            <i class="bi bi-telephone-fill me-1"></i>
                            {{ $landlord->phone_number }}
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
                            <form action="{{ route('updateProfile') }}" method="POST" enctype="multipart/form-data"
                                class="text-start">
                                @csrf

                                {{-- Image upload --}}
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Profile Image</label>
                                    <input type="file" name="image" class="form-control form-control-sm"
                                        accept="image/*">
                                </div>

                                {{-- Name --}}
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Name</label>
                                    <input type="text" name="name" value="{{ $landlord->name }}" class="form-control"
                                        required>
                                </div>

                                {{-- Phone --}}
                                <div class="mb-3">
                                    <label class="form-label small fw-semibold">Phone Number</label>
                                    <input type="text" name="phone_number" value="{{ $landlord->phone_number }}"
                                        class="form-control" required>
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
                                <h5 class="mb-0 text-primary">{{ $landlord->apartments->count() }}</h5>
                                <small class="text-muted">Properties</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right Content: Apartments Grid --}}
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="mb-0">
                        <i class="bi bi-building me-2"></i>My Apartments
                    </h3>
                    <a href="{{ route('posts.create') }}" class="btn btn-primary">+ Add New Apartment</a>

                </div>

                <div class="row g-4">
                    @forelse ($landlord->apartments as $apartment)
                        <div class="col-md-6">
                            <div class="card h-100 shadow-sm border-0 hover-lift transition">
                                @if ($apartment->image)
                                    <div class="position-relative overflow-hidden">
                                        <img src="{{ asset('storage/apartments/' . $apartment->image) }}"
                                            class="card-img-top" alt="Apartment Image"
                                            style="height: 220px; transition: transform 0.3s;">
                                        <span class="position-absolute top-0 end-0 m-3 badge bg-primary">
                                            {{ $apartment->rent }} JD/month
                                        </span>
                                    </div>
                                @endif

                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title mb-2">{{ $apartment->title }}</h5>
                                    <p class="card-text text-muted small flex-grow-1">
                                        {{ Str::limit($apartment->description, 100) }}
                                    </p>

                                    <div class="mb-3">
                                        <p class="mb-1 small">
                                            <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                                            <strong>Location:</strong> {{ $apartment->location }}
                                        </p>
                                    </div>

                                    <div class="d-flex gap-2 mt-auto">
                                        <!-- View Modal Trigger -->
                                        <button class="btn btn-sm btn-outline-primary flex-fill" data-bs-toggle="modal"
                                            data-bs-target="#viewApartmentModal{{ $apartment->id }}">
                                            <i class="bi bi-eye"></i> View
                                        </button>

                                        <!-- Edit Modal Trigger -->
                                        <button class="btn btn-sm btn-outline-secondary flex-fill" data-bs-toggle="modal"
                                            data-bs-target="#editApartmentModal{{ $apartment->id }}">
                                            <i class="bi bi-pencil"></i> Edit
                                        </button>

                                        <form action="{{ route('apartments.destroy', $apartment->id) }}" method="POST"
                                            class="flex-fill">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger w-100"
                                                onclick="return confirm('Are you sure you want to delete this apartment?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="card shadow-sm border-0 text-center py-5">
                                <div class="card-body">
                                    <a href="{{ route('posts.create') }}" class="btn btn-primary">
                                        <i class="bi bi-plus-circle me-1"></i> Add Your First Apartment
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <!-- ================= VIEW MODAL ================= -->
    <div class="modal fade" id="viewApartmentModal{{ $apartment->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-eye me-2"></i> {{ $apartment->title }}
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row align-items-center">
                        {{-- Left: Image --}}
                        @if ($apartment->image)
                            <div class="col-md-5 text-center mb-3 mb-md-0">
                                <img src="{{ asset('storage/apartments/' . $apartment->image) }}"
                                    class="img-fluid rounded" alt="Apartment Image"
                                    style="max-height: 250px; object-fit: cover;">
                            </div>
                        @endif

                        {{-- Right: Info --}}
                        <div class="col-md-7">
                            <p class="fs-5"><strong>Location:</strong> {{ $apartment->location }}</p>
                            <p class="fs-5"><strong>Rent:</strong> {{ $apartment->rent }} JD/month</p>
                            <p class="fs-5"><strong>Description:</strong></p>
                            <p class="fs-6 text-muted">{{ $apartment->description }}</p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>



    <!-- ================= EDIT MODAL ================= -->
    <div class="modal fade" id="editApartmentModal{{ $apartment->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header bg-secondary text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-pencil-square me-2"></i> Edit Apartment
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('apartments.update', $apartment->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" value="{{ $apartment->title }}"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Rent (JD/month)</label>
                                <input type="number" name="rent" value="{{ $apartment->rent }}"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Location</label>
                                <input type="text" name="location" value="{{ $apartment->location }}"
                                    class="form-control" required>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Description</label>
                                <textarea name="description" class="form-control" rows="3">{{ $apartment->description }}</textarea>
                            </div>
                            <div class="col-md-12">
                                <label class="form-label">Image</label>
                                @if ($apartment->image)
                                    <img src="{{ asset('storage/apartments/' . $apartment->image) }}" width="100"
                                        class="rounded mb-2 d-block">
                                @endif
                                <input type="file" name="image" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
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
