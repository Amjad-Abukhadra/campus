{{-- Page Loading Screen Overlay --}}
<div id="page-loader"
    class="position-fixed top-0 start-0 w-100 h-100 d-flex justify-content-center align-items-center opacity-0 invisible"
    style="z-index: 9999; background: rgba(0, 0, 0, 0.5); backdrop-filter: blur(20px); transition: opacity 0.3s ease, visibility 0.3s ease;">

    <div class="card shadow-lg border border-2 border-primary"
        style="background: rgba(255, 255, 255, 0.95); min-width: 320px; max-width: 400px;">
        <div class="card-body text-center p-4">
            {{-- Campus Logo Card --}}
            <div class="mb-4 d-flex justify-content-center">
                <div class="card border-2 shadow-sm bg-white p-3 rounded-3">
                    <img src="{{ asset('images/campus.png') }}" alt="Campus Logo" class="img-fluid"
                        style="max-width: 90px; height: auto;">
                </div>
            </div>

            {{-- Hopping Dots --}}
            <div class="mb-3 d-flex justify-content-center align-items-center gap-2" style="height: 3rem;">
                <span class="dot bg-primary rounded-circle"
                    style="width: 12px; height: 12px; animation: hop 1.4s infinite ease-in-out;"></span>
                <span class="dot bg-primary rounded-circle"
                    style="width: 12px; height: 12px; animation: hop 1.4s infinite ease-in-out 0.2s;"></span>
                <span class="dot bg-primary rounded-circle"
                    style="width: 12px; height: 12px; animation: hop 1.4s infinite ease-in-out 0.4s;"></span>
            </div>

            {{-- Loading Text --}}
            <h6 class="text-primary fw-semibold mb-1">Loading</h6>
            <p class="text-muted small mb-0">Please wait...</p>
        </div>
    </div>
</div>

<style>
    @keyframes hop {

        0%,
        80%,
        100% {
            transform: translateY(0);
        }

        40% {
            transform: translateY(-20px);
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const loader = document.getElementById('page-loader');

        // Function to show loader
        function showLoader() {
            loader.classList.remove('opacity-0', 'invisible');
            loader.classList.add('opacity-100', 'visible');
        }

        // Function to hide loader
        function hideLoader() {
            loader.classList.remove('opacity-100', 'visible');
            loader.classList.add('opacity-0', 'invisible');
        }

        // Hide loader when page is fully loaded
        window.addEventListener('load', hideLoader);

        // Show loader on link clicks (except external links and anchors)
        document.addEventListener('click', function (e) {
            const link = e.target.closest('a');
            if (link &&
                !link.hasAttribute('target') &&
                !link.getAttribute('href')?.startsWith('#') &&
                !link.getAttribute('href')?.startsWith('javascript:') &&
                link.hostname === window.location.hostname) {
                showLoader();
            }
        });

        // Show loader on form submissions
        document.addEventListener('submit', function (e) {
            const form = e.target;
            // Don't show loader for forms with data-no-loader attribute
            if (!form.hasAttribute('data-no-loader')) {
                showLoader();
            }
        });

        // Handle browser back/forward buttons
        window.addEventListener('pageshow', function (event) {
            if (event.persisted) {
                hideLoader();
            }
        });

        // Fallback: Hide loader after 10 seconds to prevent infinite loading
        setTimeout(hideLoader, 50000);
    });
</script>