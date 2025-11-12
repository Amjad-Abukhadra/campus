<!-- Footer -->
<footer class="bg-dark text-white pt-5 pb-3 mt-5">
    <div class="container">
        <div class="row g-4">
            <!-- About Section -->
            <div class="col-lg-3 col-md-6">
                <h5 class="text-info mb-3">About Campus Mate</h5>
                <p class="text-light">Your trusted platform for finding safe and affordable student housing.
                    Connecting students with their perfect campus home.</p>
                <div class="d-flex gap-2 mt-3">
                    <a href="#" class="btn btn-outline-info btn-sm rounded-circle" aria-label="Facebook">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" class="btn btn-outline-info btn-sm rounded-circle" aria-label="Twitter">
                        <i class="bi bi-twitter"></i>
                    </a>
                    <a href="#" class="btn btn-outline-info btn-sm rounded-circle" aria-label="Instagram">
                        <i class="bi bi-instagram"></i>
                    </a>
                    <a href="#" class="btn btn-outline-info btn-sm rounded-circle" aria-label="LinkedIn">
                        <i class="bi bi-linkedin"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-3 col-md-6">
                <h5 class="text-info mb-3">Quick Links</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ url('/') }}" class="text-light text-decoration-none">Home</a>
                    </li>
                    <li class="mb-2"><a href="{{ url('/listings') }}" class="text-light text-decoration-none">Browse
                            Listings</a></li>
                    <li class="mb-2"><a href="{{ url('/about') }}" class="text-light text-decoration-none">About
                            Us</a></li>
                    <li class="mb-2"><a href="{{ url('/faq') }}" class="text-light text-decoration-none">FAQ</a>
                    </li>
                    <li class="mb-2"><a href="{{ url('/contact') }}"
                            class="text-light text-decoration-none">Contact</a></li>
                </ul>
            </div>

            <!-- For Landlords -->
            <div class="col-lg-3 col-md-6">
                <h5 class="text-info mb-3">For Landlords</h5>
                <ul class="list-unstyled">
                    <li class="mb-2"><a href="{{ url('/list-property') }}"
                            class="text-light text-decoration-none">List Your Property</a></li>
                    <li class="mb-2"><a href="{{ url('/landlord-resources') }}"
                            class="text-light text-decoration-none">Resources</a></li>
                    <li class="mb-2"><a href="{{ url('/pricing') }}"
                            class="text-light text-decoration-none">Pricing</a></li>
                    <li class="mb-2"><a href="{{ url('/terms') }}" class="text-light text-decoration-none">Terms &
                            Conditions</a></li>
                    <li class="mb-2"><a href="{{ url('/privacy') }}" class="text-light text-decoration-none">Privacy
                            Policy</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-3 col-md-6">
                <h5 class="text-info mb-3">Contact Us</h5>
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="bi bi-envelope me-2"></i>
                        <a href="mailto:support@campusmate.com"
                            class="text-light text-decoration-none">support@campusmate.com</a>
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-phone me-2"></i>
                        <span class="text-light">+962 6 XXX XXXX</span>
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-geo-alt me-2"></i>
                        <span class="text-light">Amman, Jordan</span>
                    </li>
                </ul>
            </div>
        </div>

        <hr class="border-secondary my-4">

        <div class="row">
            <div class="col-12 text-center">
                <p class="mb-0 text-light">&copy; {{ date('Y') }} Campus Mate. All rights reserved.</p>
            </div>
        </div>
    </div>
</footer>
