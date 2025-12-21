<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <img src="{{ asset('images/campus.png') }}" height="45" class="me-2">
            <span class="fw-bold">CAMPUS <span class="text-info">MATE</span></span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">

                {{-- Guest (not logged in) --}}
                @guest
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                            <i class="bi bi-house-door nav-icon"></i> Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('listings*') ? 'active' : '' }}" href="{{ url('/listings') }}">
                            <i class="bi bi-list-ul nav-icon"></i> Listings
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="{{ url('/about') }}">
                            <i class="bi bi-info-circle nav-icon"></i> About
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('contact') ? 'active' : '' }}" href="{{ url('/contact') }}">
                            <i class="bi bi-envelope nav-icon"></i> Contact
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-info text-dark fw-semibold ms-2 d-flex align-items-center"
                            href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Login
                        </a>
                    </li>
                @endguest


                {{-- Authenticated users --}}
                @auth
                    {{-- 🔹 LANDLORD LINKS --}}
                    @if (auth()->user()->hasRole('landlord'))
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                                href="{{ route('dashboard') }}">
                                <i class="bi bi-speedometer2 nav-icon"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('applications') ? 'active' : '' }}"
                                href="{{ route('applications') }}">
                                <i class="bi bi-file-earmark-text nav-icon"></i> Applications
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('posts.create') ? 'active' : '' }}"
                                href="{{ route('posts.create') }}">
                                <i class="bi bi-plus-square nav-icon"></i> Posts
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}"
                                href="{{ route('profile') }}">
                                <i class="bi bi-person-circle nav-icon"></i> Profile
                            </a>
                        </li>
                    @endif

                    {{-- 🔹 ADMIN LINKS --}}
                    @if (auth()->user()->hasRole('admin'))
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/dashboard*') ? 'active' : '' }}"
                                href="{{ url('/admin/dashboard') }}">
                                <i class="bi bi-speedometer nav-icon"></i> Admin Dashboard
                            </a>
                        </li>
                    @endif

                    {{-- 🔹 STUDENT LINKS --}}
                    @if (auth()->user()->hasRole('student'))
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('student/apartments*') ? 'active' : '' }}"
                                href="{{ url('/student/apartments') }}">
                                <i class="bi bi-houses nav-icon"></i> Apartments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('student/roommates*') ? 'active' : '' }}"
                                href="{{ route('student.roommates.index') }}">
                                <i class="bi bi-people nav-icon"></i> Roommates
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('student/applications*') ? 'active' : '' }}"
                                href="{{ url('/student/applications') }}">
                                <i class="bi bi-file-earmark-check nav-icon"></i> Applications
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('saved-items*') ? 'active' : '' }}"
                                href="{{ route('student.favorites.index') }}">
                                <i class="bi bi-heart nav-icon"></i> Saved Items
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('student/profile*') ? 'active' : '' }}"
                                href="{{ url('/student/profile') }}">
                                <i class="bi bi-person-circle nav-icon"></i> Profile
                            </a>
                        </li>
                    @endif

                    {{-- Logout --}}
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-info text-dark fw-semibold ms-2 d-flex align-items-center">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<style>
    .navbar-nav .nav-link {
        display: flex;
        align-items: center;
        transition: color 0.2s ease-in-out;
    }

    .nav-icon {
        max-width: 0;
        opacity: 0;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        display: inline-block;
        white-space: nowrap;
    }

    .navbar-nav .nav-link:hover .nav-icon,
    .navbar-nav .nav-link.active .nav-icon {
        max-width: 25px;
        /* Adjust based on icon size */
        opacity: 1;
        margin-right: 8px;
    }
</style>