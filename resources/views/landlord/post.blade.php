@extends('layouts.app')

@section('content')
    <div class="container py-5">
        <x-page-header title="Add Property" subtitle="List your apartment for potential tenants" icon="bi bi-building-plus"
            icon="bi bi-building-add" :breadcrumb="[
            ['label' => 'Dashboard', 'link' => route('dashboard')],
            ['label' => 'Post']
        ]" />
        <form action="{{ route('store.post') }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf
            <div class="row justify-content-center">
                <div class="col-lg-10"> <!-- Full width but centered -->

                    <!-- CARD 1: Basic Info -->
                    <div class="card shadow border-1 rounded-3 mb-4 w-100">
                        <div class="card-header border-0 pt-4 pb-3 bg-white">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle p-3 me-3 bg-light">
                                    <i class="bi bi-house-add fs-4 text-secondary"></i>
                                </div>
                                <div>
                                    <h2 class="mb-1 fw-bold">Basic Information</h2>
                                    <p class="mb-0 text-muted small">Add essential apartment details</p>
                                </div>
                            </div>
                        </div>

                        <div class="card-body px-4 pb-4">

                            <!-- Title -->
                            <div class="mb-4">
                                <div class="form-floating">
                                    <input type="text" name="title" id="title"
                                        class="form-control form-control-lg rounded-3 @error('title') is-invalid @enderror"
                                        placeholder="e.g., Cozy 2BR near campus" value="{{ old('title') }}" required>
                                    <label for="title"><i class="bi bi-tag me-1"></i> Apartment Title <span
                                            class="text-danger">*</span></label>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Location -->
                            <div class="mb-4">
                                <div class="form-floating">
                                    <input type="text" name="location" id="location"
                                        class="form-control form-control-lg rounded-3 @error('location') is-invalid @enderror"
                                        placeholder="Address or area" value="{{ old('location') }}" required>
                                    <label for="location"><i class="bi bi-geo-alt me-1"></i> Location <span
                                            class="text-danger">*</span></label>
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Rent -->
                            <div class="mb-4">
                                <div class="form-floating">
                                    <input type="number" name="rent" id="rent"
                                        class="form-control form-control-lg rounded-3 @error('rent') is-invalid @enderror"
                                        placeholder="0.00" step="0.01" value="{{ old('rent') }}" required>
                                    <label for="rent"><i class="bi bi-cash-coin me-1"></i> Monthly Rent ($) <span
                                            class="text-danger">*</span></label>
                                    @error('rent')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- CARD 2: Image, Description, Tips -->
                    <div class="card shadow border-1 rounded-3 w-100">
                        <div class="card-header border-0 pt-4 pb-3 bg-white">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle p-3 me-3 bg-light">
                                    <i class="bi bi-image fs-4 text-secondary"></i>
                                </div>
                                <div>
                                    <h2 class="mb-1 fw-bold">Media & Description</h2>
                                    <p class="mb-0 text-muted small">Add photos and describe your apartment</p>
                                </div>
                            </div>
                        </div>

                        <div class="card-body px-4 pb-4">

                            <!-- Apartment Image -->
                            <div class="mb-4">
                                <label class="form-label fw-semibold text-dark" for="image">
                                    <i class="bi bi-image me-1"></i> Apartment Photos
                                </label>
                                <div class="rounded-3 p-4 text-center bg-light border border-2"
                                    style="border-style: dashed;">
                                    <i class="bi bi-cloud-upload fs-1 text-muted mb-2 d-block"></i>
                                    <input type="file" id="image" name="image" class="form-control border-0 bg-white"
                                        accept="image/*" aria-label="Upload apartment photos">
                                    <small class="text-muted d-block mt-2">Upload clear photos (JPG, PNG)</small>
                                    <img id="imagePreview" src="#" alt="Preview" class="img-fluid rounded-3 mt-3"
                                        style="display: none; max-height: 300px;">
                                    @error('image')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                            </div>

                            <!-- Description -->
                            <div class="mb-4">
                                <div class="form-floating">
                                    <textarea name="description" id="description"
                                        class="form-control rounded-3 @error('description') is-invalid @enderror"
                                        placeholder="Describe your apartment..."
                                        style="height: 140px">{{ old('description') }}</textarea>
                                    <label for="description"><i class="bi bi-card-text me-1"></i> Description</label>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Tips -->
                            <div class="mb-4 p-3 bg-light rounded-3">
                                <h6 class="fw-bold text-dark mb-2">
                                    <i class="bi bi-lightbulb me-2 text-warning"></i> Tips for a Great Listing
                                </h6>
                                <ul class="mb-0 small text-dark">
                                    <li class="mb-1">Use clear, well-lit photos of all rooms</li>
                                    <li class="mb-1">Be specific about location and proximity to campus</li>
                                    <li class="mb-1">List all amenities and utilities included</li>
                                    <li class="mb-1">Mention any rules or requirements upfront</li>
                                </ul>
                            </div>

                            <!-- Buttons -->
                            <div class="d-flex flex-column flex-md-row gap-2 justify-content-md-end pt-3">
                                <a href="{{ url()->previous() }}" class="btn btn-outline-secondary btn-lg px-4 rounded-3">
                                    <i class="bi bi-x-circle me-1"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg px-5 rounded-3">
                                    <i class="bi bi-check-circle me-1"></i> Post Apartment
                                </button>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </form>
    </div>
    <script>
        const imageInput = document.getElementById('image');
        const imagePreview = document.getElementById('imagePreview');

        imageInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            } else {
                imagePreview.style.display = 'none';
            }
        });
    </script>

@endsection