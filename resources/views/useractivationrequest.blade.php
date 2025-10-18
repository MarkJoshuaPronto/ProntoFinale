<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>User Activation Request</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f4f9f4;
            font-family: 'Arial', sans-serif;
            color: #34495e;
        }

        .navbar {
            background-color: #196f38;
        }

        .navbar .nav-link {
            color: white; /* Default link color */
        }

        .navbar .nav-link:hover {
            color: #ffd000 !important; /* Hover color */
        }

        .card {
            min-width: 300px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-top: 55px;
        }

        .btn-primary {
            background-color: #196f38;
            border: none;
            padding: 12px 35px;
            font-size: 1.1rem;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #ffd000;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #000000;
            margin-bottom: 30px;
            text-align: center;
        }
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg" style="position: fixed; width: 100%; z-index: 1000; top: 0; opacity: 1;">
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
                            <a class="nav-link" aria-current="page" href="{{route('landingpage')}}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('donation')}}">Donations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('gallery')}}">Gallery</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('aboutus')}}">About us</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="navbar-text p-2">
                <a class="nav-link" href="{{route('login')}}">Login</a>
            </div>
            <div class="navbar-text p-2">
                <a class="nav-link" href="{{route('register')}}">Register</a>
            </div>
        </nav>
    </header>

    <section class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-8">
                <div class="card p-5">
                    <div class="card-body">
                        <h5 class="card-title text-center section-title">Activation Request</h5>
                        @if (session('success'))
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: '{{ session('success') }}',
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

                        <form method="POST" action="{{ route('useractivationstore') }}">
                            @csrf
                            @method('POST')
                            <div class="d-flex justify-content-center align-items-center">
                                <div class="col-md-8">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text" class="form-control border border-2 border-black" id="name" name="name" placeholder="Enter your full name" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control border border-2 border-black" id="email" name="email" placeholder="Enter your email" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" class="form-control border border-2 border-black" id="address" name="address" placeholder="Enter your address" required>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center align-items-center mt-3">
                                <button type="submit" class="btn btn-primary">Submit Request</button>
                            </div>
                        </form>
                        <div class="text-center mt-5">
                            <a href="{{route('login')}}">Back</a>
                            <a href="{{route('forgotpassword')}}" style="margin-left: 20px;">Forgot Password?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
