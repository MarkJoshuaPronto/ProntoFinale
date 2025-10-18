<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Forgot Password</title>
    <style>
        body {
            background-color: #f4f9f4; /* Match landing page background */
            font-family: 'Arial', sans-serif; /* Match font */
            color: #34495e; /* Match text color */
        }
        .card {
            min-width: 300px;
            border-radius: 15px; /* Match card style */
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); /* Add shadow */
            margin-top: 150px;
        }
        .logo-text {
            font-size: 20px;
            margin-left: 10px;
        }
        .btn-primary {
            background-color: #196f38; /* Match button color */
            border: none;
            padding: 12px 35px;
            font-size: 1.1rem;
            transition: background-color 0.3s ease;
        }
        .btn-primary:hover {
            background-color: #ffd000; /* Match hover color */
        }
        /* Navbar hover effect */
        .nav-link:hover {
            color: #ffd000 !important; /* Change color on hover */
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg" style="background-color: #196f38; position: fixed; width: 100%; z-index: 1000; top: 0; opacity: 1;">
            <div class="container-fluid">
                <span class="navbar-brand">
                    <a href="{{ route('landingpage') }}">
                        <img src="{{ asset('assets/navlogo.png') }}" alt="Cycle of Giving Logo" class="cyclelogo" style="width: 150px; height: 50px;">
                    </a>
                </span>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse align-items-center justify-content-center" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link text-white" aria-current="page" href="{{ route('landingpage') }}">Home</a>
                        </li>
                        {{-- <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('donation') }}">Donations</a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('gallery') }}">Gallery</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('aboutus') }}">About us</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="navbar-text p-2">
                <a class="nav-link text-white" href="{{ route('login') }}">Login</a>
            </div>
            <div class="navbar-text p-2">
                <a class="nav-link text-white" href="{{ route('register') }}">Register</a>
            </div>
        </nav>
    </header>

    <section>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-8">
                    <div class="card p-5">
                        <div class="card-body">
                            <h5 class="card-title text-center">Forgot Your Password?</h5>

                            @if (session('success'))
                                <script>
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success!',
                                        text: @json(session('success')),
                                        showConfirmButton: true,
                                        timer: 3000
                                    });
                                </script>
                            @endif

                            @if (session('error'))
                                <script>
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Error!',
                                        text: @json(session('error')),
                                        showConfirmButton: true,
                                        timer: 3000
                                    });
                                </script>
                            @endif

                            @if ($errors->any())
                            <script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: "{{ $errors->first() }}",
                                    showConfirmButton: true,
                                    timer: 3000
                                });
                            </script>
                            @endif

                            <form method="POST" action="{{ route('forgotpasswordpost') }}">
                                @csrf

                                <div class="d-flex justify-content-center align-items-center">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email Address</label>
                                            <input type="email" name="email" class="form-control border border-2 border-black" required placeholder="Enter your email">
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-center align-items-center mt-3">
                                    <button type="submit" class="btn btn-primary">Send Password Reset Link</button>
                                </div>
                            </form>

                            <div class="text-center mt-5">
                                <a href="{{ route('login') }}">Back to Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
