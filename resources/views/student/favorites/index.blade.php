@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-secondary fw-bold">Saved Items</h2>

    {{-- Saved Apartments --}}
    <h4 class="mb-3 border-bottom pb-2">Saved Apartments</h4>
    @if($savedApartments->count() > 0)
        <div class="row g-4 mb-5">
            @foreach($savedApartments as $apartment)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden">
                        <div class="position-relative">
                            @if ($apartment->image)
                                <img src="{{ asset('storage/apartments/' . $apartment->image) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                            @else
                                <div class="bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <i class="bi bi-building fs-1 text-white opacity-50"></i>
                                </div>
                            @endif
                            <span class="position-absolute top-0 end-0 bg-primary text-white px-3 py-1 rounded-pill fw-bold shadow-sm m-2">
                                {{ $apartment->rent }} JD/mo
                            </span>
                            
                            {{-- Unsave Button --}}
                            <form action="{{ route('student.favorites.toggle') }}" method="POST" class="position-absolute top-0 start-0 m-2">
                                @csrf
                                <input type="hidden" name="id" value="{{ $apartment->id }}">
                                <input type="hidden" name="type" value="apartment">
                                <button type="submit" class="btn btn-light rounded-circle shadow-sm p-2 d-flex align-items-center justify-content-center" 
                                        style="width: 40px; height: 40px;" title="Unsave">
                                    <i class="bi bi-heart-fill text-danger"></i>
                                </button>
                            </form>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title fw-bold">{{ $apartment->title }}</h5>
                            <p class="text-muted small"><i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $apartment->location }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info mb-5">No saved apartments.</div>
    @endif

    {{-- Saved Roommate Posts --}}
    <h4 class="mb-3 border-bottom pb-2">Saved Roommate Posts</h4>
    @if($savedPosts->count() > 0)
        <div class="row g-4">
            @foreach($savedPosts as $post)
                <div class="col-md-6">
                    <div class="card shadow-sm rounded-4 border-0 h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="fw-bold mb-0 text-truncate">{{ $post->title }}</h5>
                                <form action="{{ route('student.favorites.toggle') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $post->id }}">
                                    <input type="hidden" name="type" value="roommate_post">
                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0 rounded-circle p-2" title="Unsave">
                                        <i class="bi bi-bookmark-fill fs-5"></i>
                                    </button>
                                </form>
                            </div>
                            <p class="text-muted small mb-2">{{ Str::limit($post->description, 100) }}</p>
                            <div class="small">
                                <span class="me-3"><i class="bi bi-geo-alt text-danger me-1"></i> {{ $post->apartment->location ?? 'N/A' }}</span>
                                <span><i class="bi bi-cash text-success me-1"></i> {{ $post->apartment->rent ?? 'N/A' }} JD</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">No saved roommate posts.</div>
    @endif
</div>
@endsection
