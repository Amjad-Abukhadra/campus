<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Mate - Register</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="icon" type="image/png" href="{{ asset('images/campus.png') }}">
</head>

<body class="d-flex align-items-center justify-content-center min-vh-100"
    style="background-image: url('{{ asset('images/bg.jpeg') }}'); 
           background-size: cover; 
           background-position: center; 
           background-repeat: no-repeat; ">

    <div class="container">
        <div class="row g-0 shadow-lg rounded overflow-hidden mx-auto"
            style="max-width: 700px; background-color: rgba(255,255,255,0.9);">

            <!-- Left Side -->
            <div
                class="col-md-5 d-none d-md-flex flex-column justify-content-center align-items-center text-white bg-dark p-7">
                <h2 class="fw-bold">Create Account</h2>
                <p class="mt-2 text-center">Join Campus Mate to manage your profile and stay connected.</p>
            </div>

            <!-- Right Side (Form) -->
            <div class="col-md-7 p-4">
                <div class="text-center mb-4">
                    <img src="{{ asset('images/campus.png') }}" alt="Campus Mate Logo" height="60" class="mb-2">
                    <h3 class="fw-bold">Welcome!</h3>
                </div>

                <form method="POST" action="#">
                    @csrf
                    <!-- Name -->
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control" id="name" name="name" required
                                placeholder="Enter your full name">
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control" id="email" name="email" required
                                placeholder="Enter your email">
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" required
                                placeholder="Enter your password">
                        </div>
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="bi bi-lock-fill"></i></span>
                            <input type="password" class="form-control" id="password_confirmation"
                                name="password_confirmation" required placeholder="Confirm your password">
                        </div>
                    </div>

                    <!-- Submit -->
                    <div class="d-grid gap-2 mb-3">
                        <button type="submit" class="btn btn-dark btn-lg fw-semibold text-light">
                            <i class="bi bi-person-plus me-2"></i>Register
                        </button>
                    </div>

                    <div class="text-center mt-3">
                        <p class="mb-0">Already have an account?
                            <a href="#" class="text-dark fw-semibold text-decoration-none">Login</a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
