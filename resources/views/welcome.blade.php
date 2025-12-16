<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Mate - Find Your Perfect Campus Home</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="icon" type="image/png" href="{{ asset('images/campus.png') }}">
</head>

<body class="min-vh-100 d-flex align-items-center"
    style="background-image: url('{{ asset('images/bg.jpeg') }}'); 
             background-size: cover; 
             background-position: center; 
             background-repeat: no-repeat; 
             background-attachment: fixed;">

    <div class="bg-dark bg-opacity-75 w-100 min-vh-100 d-flex align-items-center py-5">
        <div class="container">
            <div class="text-center text-white py-5">
                <h1 class="display-1 fw-bold mb-4">
                    <i class="bi bi-house-heart"></i> Campus Mate
                </h1>
                <p class="lead fs-3 mb-5 opacity-75">
                    Your Gateway to Finding the Perfect Campus Home
                </p>

                <div class="d-flex flex-wrap justify-content-center gap-3 mb-5">
                    <a href="{{ route('login') }}" class="btn btn-outline-light btn-lg px-5 py-3 rounded-pill">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Login
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-5 py-3 rounded-pill">
                        <i class="bi bi-person-plus me-2"></i>Register
                    </a>
                </div>

                <div class="bg-white bg-opacity-95 rounded-4 p-4 p-md-5 mt-5 shadow-lg">
                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="text-center p-4">
                                <div class="display-4 text-primary mb-3">
                                    <i class="bi bi-search"></i>
                                </div>
                                <h3 class="h4 fw-semibold mb-3 text-dark">Find Apartments</h3>
                                <p class="text-muted">
                                    Browse through verified listings and find your ideal campus accommodation
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center p-4">
                                <div class="display-4 text-primary mb-3">
                                    <i class="bi bi-people"></i>
                                </div>
                                <h3 class="h4 fw-semibold mb-3 text-dark">Find Roommates</h3>
                                <p class="text-muted">
                                    Connect with fellow students and find the perfect roommate match
                                </p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center p-4">
                                <div class="display-4 text-primary mb-3">
                                    <i class="bi bi-shield-check"></i>
                                </div>
                                <h3 class="h4 fw-semibold mb-3 text-dark">Safe & Secure</h3>
                                <p class="text-muted">
                                    Verified landlords and secure platform for all your housing needs
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
