@extends('layouts.app')

@section('content')
    <div class="container py-5">

        {{-- Header Section --}}
        <x-page-header title="My Applications" subtitle="Track your requests to join other students' roommate posts"
            icon="bi bi-journal-check" :breadcrumb="[
            ['label' => 'Roommates', 'link' => route('student.roommates.index')],
            ['label' => 'My Applications']
        ]" />

        <div class="row g-4">

            @forelse ($applications as $application)
                <div class="col-md-6">
                    <div class="card h-100 shadow-sm border-0 hover-lift">

                        <div class="card-body d-flex flex-column">

                            {{-- POST INFO --}}
                            <h5 class="card-title mb-2">
                                {{ $application->post->title }}
                            </h5>

                            <p class="card-text text-muted small flex-grow-1">
                                {{ Str::limit($application->post->description, 120) }}
                            </p>

                            {{-- STATUS --}}
                            <div class="mb-2">
                                <span class="badge 
                                        {{ $application->status === 'accepted'
                ? 'bg-success'
                : ($application->status === 'pending'
                    ? 'bg-warning text-dark'
                    : 'bg-danger') }}">
                                    {{ ucfirst($application->status) }}
                                </span>
                            </div>

                            {{-- APPLIED DATE --}}
                            <div class="text-muted small mt-auto">
                                <i class="bi bi-clock me-1"></i>
                                Applied on {{ $application->created_at->format('d M Y') }}
                            </div>

                        </div>
                    </div>
                </div>

            @empty

                {{-- Empty State --}}
                <div class="col-12">
                    <div class="card shadow-sm border-0 text-center py-5">
                        <div class="card-body">
                            <i class="bi bi-inbox fs-1 text-muted mb-3 d-block"></i>
                            <p class="text-muted mb-3">
                                You haven’t applied to any posts yet.
                            </p>
                            <a href="{{ route('student.roommates.index') }}" class="btn btn-primary">
                                Browse Posts
                            </a>
                        </div>
                    </div>
                </div>
            @endforelse

        </div>
    </div>

    {{-- Design only --}}
    <style>
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
        }
    </style>
@endsection