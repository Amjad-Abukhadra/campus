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
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('listings*') ? 'active' : '' }}"
                            href="{{ url('/listings') }}">Listings</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('about') ? 'active' : '' }}"
                            href="{{ url('/about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('contact') ? 'active' : '' }}"
                            href="{{ url('/contact') }}">Contact</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-info text-dark fw-semibold ms-2" href="{{ route('login') }}">Login</a>
                    </li>
                @endguest


                {{-- Authenticated users --}}
                @auth
                    {{-- 🔹 LANDLORD LINKS --}}
                    @if (auth()->user()->hasRole('landlord'))
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                                href="{{ route('dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('applications') ? 'active' : '' }}"
                                href="{{ route('applications') }}">Applications</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('posts.create') ? 'active' : '' }}"
                                href="{{ route('posts.create') }}">Posts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}"
                                href="{{ route('profile') }}">Profile</a>
                        </li>
                    @endif

                    {{-- 🔹 ADMIN LINKS --}}
                    @if (auth()->user()->hasRole('admin'))
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('admin/dashboard*') ? 'active' : '' }}"
                                href="{{ url('/admin/dashboard') }}">Admin Dashboard</a>
                        </li>
                    @endif

                    {{-- 🔹 STUDENT LINKS --}}
                    @if (auth()->user()->hasRole('student'))
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('student/profile*') ? 'active' : '' }}"
                                href="{{ url('/student/profile') }}">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('student/apartments*') ? 'active' : '' }}"
                                href="{{ url('/student/apartments') }}">Apartments</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link {{ request()->is('student/roommates*') ? 'active' : '' }}"
                                href="{{ route('student.roommate.posts') }}">Roommates</a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('student/applications*') ? 'active' : '' }}"
                                href="{{ url('/student/applications') }}">Application</a>
                        </li>
                    @endif


                    {{-- Logout --}}
                    <li class="nav-item">
                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-info text-dark fw-semibold ms-2">Logout</button>
                        </form>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
