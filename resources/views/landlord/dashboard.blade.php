@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4"
        style="background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%); min-height: 100vh;">
        <div class="container">

            <!-- Header -->
            <x-page-header title="Dashboard" subtitle="Manage your apartment listings and track performance"
                icon="bi bi-speedometer2" :breadcrumb="[
                    ['label' => 'Home', 'link' => url('/')],
                    ['label' => 'Dashboard']
                ]">
                <x-slot name="action">
                    <div class="d-flex gap-2">
                         <a href="{{ route('landlord.verification.form') }}" class="btn btn-outline-primary px-4 py-2 rounded-3 shadow-sm fw-bold">
                            <i class="bi bi-shield-check me-2"></i>Verify Account
                        </a>
                        <a href="{{ route('posts.create') }}" class="btn btn-primary px-4 py-2 rounded-3 shadow-sm fw-bold">
                            <i class="bi bi-plus-lg me-2"></i>Add New Property
                        </a>
                    </div>
                </x-slot>
            </x-page-header>

            <!-- Stats Cards -->
            <div class="row g-4 mb-4">
                <!-- Total Apartments -->
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm h-100 hover-lift">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted small mb-1 fw-medium">Total Apartments</p>
                                    <h2 class="fw-bold mb-0">{{ $totalApartments }}</h2>
                                </div>
                                <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                                    <i class="bi bi-building text-primary fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rented Apartments -->
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm h-100 hover-lift">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted small mb-1 fw-medium">Rented</p>
                                    <h2 class="fw-bold mb-0 text-success">{{ $rentedApartments }}</h2>
                                </div>
                                <div class="bg-success bg-opacity-10 rounded-circle p-3">
                                    <i class="bi bi-check-circle text-success fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Available Apartments -->
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm h-100 hover-lift">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-muted small mb-1 fw-medium">Available</p>
                                    <h2 class="fw-bold mb-0 text-warning">{{ $availableApartments }}</h2>
                                </div>
                                <div class="bg-warning bg-opacity-10 rounded-circle p-3">
                                    <i class="bi bi-hourglass-split text-warning fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total Rent -->
                <div class="col-md-6 col-lg-3">
                    <div class="card border-0 shadow-sm h-100 hover-lift"
                        style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="text-white text-opacity-75 small mb-1 fw-medium">Total Rent</p>
                                    <h2 class="fw-bold mb-0 text-white">{{ $totalRent }} JD</h2>
                                </div>
                                <div class="bg-white bg-opacity-25 rounded-circle p-3">
                                    <i class="bi bi-currency-dollar text-white fs-4"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Apartments Table Card -->
            <div class="card border-0 shadow-sm">
                <!-- Header -->
                <div class="card-header border-0 py-3"
                    style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);">
                    <div
                        class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3">
                        <div class="text-white">
                            <h5 class="mb-1 fw-semibold">My Apartments</h5>
                            <small class="text-white text-opacity-75">Manage all your property listings</small>
                        </div>
                        <a href="{{ route('posts.create') }}" class="btn btn-light">
                            <i class="bi bi-plus-circle me-2"></i>Add New Apartment
                        </a>
                    </div>
                </div>

                <!-- Table -->
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th class="px-4 py-3 text-muted small fw-semibold">#</th>
                                    <th class="px-4 py-3 text-muted small fw-semibold">TITLE</th>
                                    <th class="px-4 py-3 text-muted small fw-semibold">LOCATION</th>
                                    <th class="px-4 py-3 text-muted small fw-semibold">RENT (JD)</th>
                                    <th class="px-4 py-3 text-muted small fw-semibold">STATUS</th>
                                    <th class="px-4 py-3 text-muted small fw-semibold">APPLICATIONS</th>
                                    <th class="px-4 py-3 text-muted small fw-semibold">ACTIONS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($apartments as $index => $apartment)
                                    @php
                                        $isRented = $apartment->applications->where('status', 'accepted')->count() > 0;
                                        $applicationCount = $apartment->applications->count();
                                    @endphp
                                    <tr>
                                        <td class="px-4 py-3">
                                            <span class="fw-medium">{{ $index + 1 }}</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="fw-semibold">{{ $apartment->title }}</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="d-flex align-items-center text-muted">
                                                <i class="bi bi-geo-alt me-2"></i>
                                                <span>{{ $apartment->location }}</span>
                                            </div>
                                        </td>
                                        <td class="px-4 py-3">
                                            <span class="fw-semibold">{{ $apartment->rent }}</span>
                                        </td>
                                        <td class="px-4 py-3">
                                            @if($apartment->status == 'pending')
                                                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-25 rounded-pill px-3 py-2">
                                                    <i class="bi bi-clock-fill" style="font-size: 0.5rem;"></i> Pending Review
                                                </span>
                                            @elseif($apartment->status == 'rejected')
                                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 rounded-pill px-3 py-2">
                                                    <i class="bi bi-x-circle-fill" style="font-size: 0.5rem;"></i> Rejected
                                                </span>
                                            @elseif ($isRented)
                                                <span
                                                    class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3 py-2">
                                                    <i class="bi bi-circle-fill" style="font-size: 0.5rem;"></i> Rented
                                                </span>
                                            @else
                                                <span
                                                    class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-25 rounded-pill px-3 py-2">
                                                    <i class="bi bi-circle-fill" style="font-size: 0.5rem;"></i> Available
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            <span
                                                class="badge bg-primary rounded-circle d-inline-flex align-items-center justify-content-center"
                                                style="width: 32px; height: 32px;">
                                                {{ $applicationCount }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="d-flex gap-2">
                                                <!-- View Button -->
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-primary rounded-circle action-btn"
                                                    data-bs-toggle="modal" data-bs-target="#viewModal{{ $apartment->id }}"
                                                    title="View Details">
                                                    <i class="bi bi-eye"></i>
                                                </button>

                                                <!-- Edit Button -->
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-secondary rounded-circle action-btn"
                                                    data-bs-toggle="modal" data-bs-target="#editModal{{ $apartment->id }}"
                                                    title="Edit">
                                                    <i class="bi bi-pencil"></i>
                                                </button>

                                                <!-- Delete Button -->
                                                <form action="{{ route('apartments.destroy', $apartment->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-outline-danger rounded-circle action-btn"
                                                        onclick="return confirm('Are you sure you want to delete this apartment?')"
                                                        title="Delete">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- View Modal -->
                                    <div class="modal fade" id="viewModal{{ $apartment->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content border-0 shadow-lg rounded-4">
                                                <div class="modal-header border-0 py-4"
                                                    style="background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);">
                                                    <h5 class="modal-title text-white fw-semibold">Apartment Details</h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <div class="row">
                                                        @if ($apartment->image)
                                                            <div class="col-md-5 mb-3 mb-md-0">
                                                                <img src="{{ asset('storage/apartments/' . $apartment->image) }}"
                                                                    class="img-fluid rounded-3 shadow-sm"
                                                                    style="width: 100%; height: 300px; object-fit: cover;"
                                                                    alt="Apartment Image">
                                                            </div>
                                                        @endif

                                                        <div class="col-md-7">
                                                            <div class="mb-3">
                                                                <label
                                                                    class="text-muted small fw-semibold text-uppercase mb-1">Title</label>
                                                                <p class="fs-5 fw-semibold mb-0">{{ $apartment->title }}
                                                                </p>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label
                                                                    class="text-muted small fw-semibold text-uppercase mb-1">Location</label>
                                                                <p class="mb-0">{{ $apartment->location }}</p>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label
                                                                    class="text-muted small fw-semibold text-uppercase mb-1">Monthly
                                                                    Rent</label>
                                                                <p class="fs-4 fw-bold text-primary mb-0">
                                                                    {{ $apartment->rent }} JD
                                                                </p>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label
                                                                    class="text-muted small fw-semibold text-uppercase mb-1">Applications</label>
                                                                <p class="mb-0">{{ $applicationCount }} pending</p>
                                                            </div>

                                                            <div>
                                                                <label
                                                                    class="text-muted small fw-semibold text-uppercase mb-2 d-block">Description</label>
                                                                <p class="text-muted small mb-0" style="line-height: 1.6;">
                                                                    {{ $apartment->description }}
                                                                </p>
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

                                    <!-- Edit Modal -->
                                    <div class="modal fade" id="editModal{{ $apartment->id }}" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content border-0 shadow-lg rounded-4">
                                                <div class="modal-header border-0 py-4 bg-secondary text-white">
                                                    <h5 class="modal-title fw-semibold">Edit Apartment</h5>
                                                    <button type="button" class="btn-close btn-close-white"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body p-4">
                                                    <form action="{{ route('apartments.update', $apartment->id) }}"
                                                        method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        @method('PUT')

                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">Title</label>
                                                            <input type="text" name="title" value="{{ $apartment->title }}"
                                                                class="form-control form-control-lg" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">Location</label>
                                                            <input type="text" name="location"
                                                                value="{{ $apartment->location }}"
                                                                class="form-control form-control-lg" required>
                                                        </div>

                                                        <!-- Map Selection -->
                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">Pin Location on Map</label>
                                                            <div id="map-edit-{{ $apartment->id }}" class="edit-map"
                                                                data-id="{{ $apartment->id }}"
                                                                data-lat="{{ $apartment->latitude }}"
                                                                data-lng="{{ $apartment->longitude }}"
                                                                style="height: 300px; width: 100%; border-radius: 8px;"></div>
                                                            <input type="hidden" name="latitude" id="latitude-{{ $apartment->id }}" value="{{ $apartment->latitude }}">
                                                            <input type="hidden" name="longitude" id="longitude-{{ $apartment->id }}" value="{{ $apartment->longitude }}">
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">Rent (JD)</label>
                                                            <input type="number" name="rent" value="{{ $apartment->rent }}"
                                                                class="form-control form-control-lg" required>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label class="form-label fw-semibold">Description</label>
                                                            <textarea name="description" rows="4"
                                                                class="form-control">{{ $apartment->description }}</textarea>
                                                        </div>

                                                        <div class="mb-4">
                                                            <label class="form-label fw-semibold">Image</label>
                                                            <input type="file" name="image" class="form-control">
                                                        </div>

                                                        <div class="d-flex justify-content-end gap-2 pt-3 border-top">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary">
                                                                <i class="bi bi-check-circle me-2"></i>Save Changes
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="py-5">
                                                <i class="bi bi-building text-muted" style="font-size: 4rem;"></i>
                                                <h5 class="mt-3 mb-2">No apartments yet</h5>
                                                <p class="text-muted mb-4">Get started by adding your first apartment</p>
                                                <a href="{{ route('posts.create') }}" class="btn btn-primary">
                                                    <i class="bi bi-plus-circle me-2"></i>Add Apartment
                                                </a>
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

    <!-- Map Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Listen for modal show event
            var modals = document.querySelectorAll('.modal');
            modals.forEach(function(modal) {
                modal.addEventListener('shown.bs.modal', function(event) {
                    var mapContainer = modal.querySelector('.edit-map');
                    if (mapContainer && !mapContainer.classList.contains('initialized')) {
                        var id = mapContainer.getAttribute('data-id');
                        var initialLat = mapContainer.getAttribute('data-lat') || 31.9539;
                        var initialLng = mapContainer.getAttribute('data-lng') || 35.9106;

                        var map = L.map('map-edit-' + id).setView([initialLat, initialLng], 13);
                        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '&copy; OpenStreetMap'
                        }).addTo(map);

                        var marker;
                        if (mapContainer.getAttribute('data-lat') && mapContainer.getAttribute('data-lng')) {
                             marker = L.marker([initialLat, initialLng], {draggable: true}).addTo(map);
                        }

                        map.on('click', function(e) {
                            var lat = e.latlng.lat;
                            var lng = e.latlng.lng;

                            if (marker) {
                                marker.setLatLng(e.latlng);
                            } else {
                                marker = L.marker(e.latlng, {draggable: true}).addTo(map);
                            }

                            document.getElementById('latitude-' + id).value = lat;
                            document.getElementById('longitude-' + id).value = lng;
                            
                             // Update input on drag
                             marker.on('dragend', function(e) {
                                var lat = e.target.getLatLng().lat;
                                var lng = e.target.getLatLng().lng;
                                document.getElementById('latitude-' + id).value = lat;
                                document.getElementById('longitude-' + id).value = lng;
                            });
                        });
                        
                        // Handle marker dragging if it exists initially
                         if(marker) {
                            marker.on('dragend', function(e) {
                                var lat = e.target.getLatLng().lat;
                                var lng = e.target.getLatLng().lng;
                                document.getElementById('latitude-' + id).value = lat;
                                document.getElementById('longitude-' + id).value = lng;
                            });
                         }

                        mapContainer.classList.add('initialized');
                    }
                });
            });
        });
    </script>

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