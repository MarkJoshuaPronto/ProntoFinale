<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Prevent Caching -->
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, proxy-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

    <title>Login</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="icon" type="image/png" href="{{ asset('faviconlogo.png') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #f4f9f4;
            font-family: 'Arial', sans-serif;
            color: #34495e;
        }

        .card {
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: auto;
            margin-top: 80px;
            margin-bottom: 60px;
        }

        .card-title {
            font-size: 2rem;
            font-weight: bold;
            color: #2c3e50;
            text-align: center;
        }

        .form-label {
            font-weight: bold;
            color: #34495e;
        }

        .form-control {
            border: 2px solid #196f38;
            border-radius: 10px;
            padding: 10px;
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

        .navbar {
            background-color: #196f38;
            transition: top 0.3s ease, opacity 0.3s ease;
            position: fixed;
            width: 100%;
            z-index: 1000;
            top: 0;
            opacity: 1;
        }

        .nav-link {
            color: #ffffff !important;
        }

        .nav-link:hover {
            color: #ffd000 !important;
        }

        /* Footer */
        .footer {
            background-color: #196f38;
            color: #fff;
            padding: 5px;
            text-align: center;
            margin-top: 40px;
        }

        .footer p {
            margin-top: 20px;
        }

        /* Eye Icon Styles */
        .eye-icon {
            display: none; /* Initially hide the eye icon */
        }

        .eye-icon.show {
            display: block; /* Show the eye icon when the password is visible */
        }
    </style>
</head>
<header>
    <nav class="navbar navbar-expand-lg">
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
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{route('donation')}}">Donations</a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('gallery')}}">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('aboutus')}}">About Us</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="navbar-text p-2">
            <a class="nav-link active" href="{{route('login')}}">Login</a>
        </div>
        <div class="navbar-text p-2">
            <a class="nav-link" href="{{route('register')}}">Register</a>
        </div>
    </nav>
</header>
<body>
    <section>
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="card p-5 mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Login</h5>

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
                            @if (session('error'))
                            <script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error!',
                                    text: '{{ session('error') }}',
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

                            <form method="POST" action="{{ route('loginpost') }}">
                                @csrf
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email address</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
                                </div>
                                <div class="mb-3 position-relative">
                                    <label for="id_password" class="form-label">Password</label>
                                    <input type="password" class="form-control" id="id_password" name="password" placeholder="Enter your password">
                                    <i class="far fa-eye eye-icon" id="togglePassword" style="top: 60%; right: 10px; cursor: pointer;"></i>
                                </div>

                                <script>
                                    const togglePassword = document.querySelector('#togglePassword');
                                    const password = document.querySelector('#id_password');

                                    togglePassword.addEventListener('click', function () {
                                        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                                        password.setAttribute('type', type);

                                        // Toggle the eye icon visibility
                                        this.classList.toggle('fa-eye-slash');
                                        this.classList.toggle('show', type === 'text'); // Show icon when password is visible
                                    });
                                </script>

                                <div class="d-flex justify-content-center align-items-center mt-3">
                                    <button type="submit" class="btn btn-primary">Login</button>
                                </div>

                                <div class="d-flex justify-content-center align-items-center mt-3">
                                    <p>Don't have an account? <a href="{{ route('register') }}">Register here</a></p>
                                </div>
                            </form>

<!-- In your login page -->
<div class="text-center mt-5">
    <a href="{{route('useractivationrequest')}}">Request For Account Activation</a>
    <a href="{{route('forgotpassword')}}" style="margin-left: 20px;">Forgot Password?</a>
</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="conatain">
            <p>&copy; 2023 Cycle of Giving. All rights reserved.</p>
        </div>
    </footer>

    <script>
        var isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};

        function preventBackAfterLogout() {
            if (!isLoggedIn) {
                // Clear session history and prevent going back
                history.pushState(null, "", location.href);
                history.pushState(null, "", location.href);

                window.addEventListener("popstate", function () {
                    // Push forward again so back button does nothing
                    history.go(1);
                });

                // Optional: Force redirect to login if back is pressed multiple times
                setTimeout(() => {
                    history.pushState(null, "", location.href);
                }, 100);
            }
        }

        // Execute when page loads
        window.onload = preventBackAfterLogout;

        let lastScrollTop = 0;
        const navbar = document.querySelector('.navbar');

        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            if (scrollTop > lastScrollTop) {
                // Scroll Down
                navbar.style.top = "-80px"; // Adjust based on navbar height
                navbar.style.opacity = "0"; // Fade out
            } else {
                // Scroll Up
                navbar.style.top = "0";
                navbar.style.opacity = "1"; // Fade in
            }
            lastScrollTop = scrollTop;
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
