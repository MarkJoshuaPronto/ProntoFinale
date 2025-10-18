<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit Profile</title>
    <link rel="icon" type="image/png" href="{{ asset('faviconlogo.png') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<style>
    body {
        background-color: #f4f9f4;
        font-family: 'Arial', sans-serif;
        color: #34495e;
    }

    .logo-text {
        font-size: 20px;
        margin-left: 10px;
    }

    .btn-primary {
        background-color: #196f38;
        border: none;
        padding: 12px 35px;
        font-size: 1.1rem;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #2c7a5b;
    }

    .sidebar {
        background-color: #000000;
        padding-top: 20px;
        margin-top: 70px;
        height: 100vh;
        position: fixed;
        width: 16.666667%; /* col-md-2 equivalent */
    }

    .sidebar a {
        padding: 10px 20px;
        text-decoration: none;
        color: #FEFBF6;
        display: block;
    }

    .sidebar a:hover {
        background-color: #2c7a5b;
        color: white;
    }

    .main-content {
        background-color: #ffffff;
        padding: 20px;
        min-height: 100vh;
        margin-left: 16.666667%; /* col-md-2 equivalent */
        margin-top: 50px;
    }

    .card {
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        display: flex;
        align-items: center;
        justify-content: center;
        height: 100%;
    }

    .table td, .table th {
        vertical-align: middle;
        text-align: center;
    }

    .img {
        width: 100px;
        height: 100px;
    }

    div.dataTables_filter input {
        margin-bottom: 1rem;
    }

    .gallery {
        width: 250px;
    }

    .navbar {
        transition: top 0.3s ease, opacity 0.3s ease;
        position: fixed;
        width: 100%;
        z-index: 1000;
        top: 0;
        opacity: 1;
        background-color: #196f38;
    }
    .nav-link {
        color: #ffffff !important;
    }
    .nav-link:hover {
        color: #ffd000 !important;
    }

    .dropdown-menu {
        background-color: rgb(255, 255, 255);
    }

    .dropdown-item {
        color: rgb(0, 0, 0);
    }

    .badge {
        font-size: 0.9rem;
    }

    .bg-warning {
        background-color: #ffc107 !important;
    }

    .bg-danger {
        background-color: #dc3545 !important;
    }

    .bg-success {
        background-color: #28a745 !important;
    }

    .bg-primary {
        background-color: #007bff !important;
    }

    .bg-secondary {
        background-color: #6c757d !important;
    }

    .form {
        margin-top: 8%;
    }

    .password-container {
        position: relative;
        width: 100%; /* Ensure the container takes full width */
    }

    .eye-icon {
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        z-index: 2; /* Ensure the icon is above the input */
    }

    .form-control {
        position: relative;
    }

    .form-label {
        margin-bottom: 0.5rem;
    }

    .text-danger {
        color: #dc3545;
    }

    .img-thumbnail {
        width: 100px;
        height: 100px;
    }

    .rounded-circle {
        border-radius: 50%;
    }

    .text-center {
        text-align: center;
    }

    .mt-5 {
        margin-top: 3rem;
    }

    .mb-4 {
        margin-bottom: 1.5rem;
    }

    .mb-2 {
        margin-bottom: 0.5rem;
    }

    .mt-3 {
        margin-top: 1rem;
    }

    .justify-content-center {
        justify-content: center;
    }

    .align-items-center {
        align-items: center;
    }

    .d-flex {
        display: flex;
    }

    .dropdown-menu-end {
        right: 0;
        left: auto;
    }

    .container-fluid {
        padding-left: 0;
        padding-right: 0;
    }

    .row {
        margin-left: 0;
        margin-right: 0;
    }

    .col-md-2 {
        padding-left: 0;
        padding-right: 0;
    }

    .col-md-10 {
        padding-left: 0;
        padding-right: 0;
    }
</style>
<body>
    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <span class="navbar-brand">
                    <a href="{{ route('landingpageuser') }}">
                        <img src="{{ asset('assets/navlogo.png') }}" alt="Logo" class="cyclelogo" style="width: 150px; height: 50px;">
                    </a>
                </span>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse align-items-center justify-content-center" id="navbarNav">
                    <ul class="navbar-nav text-center">
                        <li class="nav-item">
                            <a class="nav-link text-white" aria-current="page" href="{{route('landingpageuser')}}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{route('donationuser')}}">Donations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{route('galleryuser')}}">Gallery</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{route('aboutususer')}}">About us</a>
                        </li>
                    </ul>
                </div>
                <div class="d-flex align-items-center">
                    <div class="dropdown">
                        @if (Auth::check() && $auth->image)
                            <img src="{{ asset('storage/' . $auth->image) }}" alt="Profile" style="width: 40px; height: 40px; border-radius: 50%; margin-left: 15px; cursor: pointer;" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        @else
                            <img src="{{ asset('assets/logo.jpg') }}" alt="Profile" style="width: 40px; height: 40px; border-radius: 50%; margin-left: 15px; cursor: pointer;" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        @endif
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="{{ route('donordashboard') }}">Dashboard</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="dropdown-item" style="background-color: red; color: white;">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>

    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2 sidebar">
                    <div class="text-center mt-5">
                        @if(Auth::check() && $auth->image)
                            <img src="{{ asset('storage/' . $auth->image) }}" alt="User Image" width="80" height="80" class="rounded-circle mb-2">
                        @else
                            <img src="{{ asset('assets/logo.jpg') }}" alt="User Image" width="80" height="80" class="rounded-circle mb-2">
                        @endif
                    </div>
                    <h4 class="text-center text-white mb-4">{{ ucwords(Auth::user()->name) }}</h4>
                    <a href="{{route('donordashboard')}}">Dashboard</a>
                    <a href="{{ route('edituser', Auth::user()->id) }}">Edit Profile</a>
                    <a href="#" onclick="confirmDeactivate()">Deactivate Account</a>
                    <a href="#" onclick="confirmDelete()">Delete Account</a>
                </div>
                <div class="col-md-10 main-content">
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
                                text: '{{ $errors->first() }}',
                                showConfirmButton: true,
                                timer: 3000
                            });
                        </script>
                    @endif

                    <div class="container form mt-5">
                        <form action="{{ route('updateuser', $user->id) }}" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="image" class="form-label">Image</label>
                                    <input type="file" class="form-control" id="image" name="image">
                                    @if ($user->image)
                                        <img src="{{ asset('storage/' . $user->image) }}" alt="User Image" class="img-thumbnail mt-2" style="width: 100px; height: 100px;">
                                    @endif
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" maxlength="40" oninput="validateName(this)">
                                    <small id="nameError" class="text-danger"></small>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                                    <small id="emailError" class="text-danger"></small>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="address" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" value="{{ $user->address }}" maxlength="50" oninput="validateAddress(this)">
                                    <small id="addressError" class="text-danger"></small>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="age" class="form-label">Age</label>
                                    <input type="text" class="form-control" id="age" name="age" value="{{ $user->age }}" oninput="validateAge(this)">
                                    <small id="ageError" class="text-danger"></small>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select class="form-select" id="gender" name="gender" required>
                                        <option value="male" {{ $user->gender == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ $user->gender == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="others" {{ $user->gender == 'others' ? 'selected' : '' }}>Others</option>
                                    </select>
                                    <small id="genderError" class="text-danger"></small>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <label for="password" class="form-label">New Password (optional)</label>
                                    <div class="password-container">
                                        <input type="password" class="form-control" id="password" name="password" placeholder="*****">
                                        <i class="far fa-eye eye-icon" id="togglePassword"></i>
                                    </div>
                                    <small id="passwordError" class="text-danger"></small>
                                </div>
                                <div class="col-md-6 mb-2">
                                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                    <div class="password-container">
                                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="*****">
                                        <i class="far fa-eye eye-icon" id="toggleConfirmPassword"></i>
                                    </div>
                                    <small id="confirmPasswordError" class="text-danger"></small>
                                </div>
                            </div>

                            <div class="row justify-content-center">
                                <div class="col-md-6">
                                    <label for="contact" class="form-label">Contact</label>
                                    <input type="tel" class="form-control" id="contact" name="contact" value="{{ $user->contact }}" oninput="validateContact(this)">
                                    <small id="contactError" class="text-danger"></small>
                                </div>
                            </div>

                            <div class="text-center">
                                <button type="submit" class="btn btn-primary mt-3">Update Profile</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        // Function to validate the Name field
        function validateName(input) {
            const nameError = document.getElementById('nameError');
            const regex = /^[A-Za-z\s]+$/;
            if (!regex.test(input.value)) {
                nameError.textContent = 'Name should only contain letters and spaces.';
                input.value = input.value.replace(/[^A-Za-z\s]/g, '');
            } else {
                nameError.textContent = '';
            }
        }

        // Function to validate the Address field
        function validateAddress(input) {
            const addressError = document.getElementById('addressError');
            const regex = /^[A-Za-z0-9\s,]+$/;
            if (!regex.test(input.value)) {
                addressError.textContent = 'Address should only contain letters, numbers, spaces, and commas.';
                input.value = input.value.replace(/[^A-Za-z0-9\s,]/g, '');
            } else {
                addressError.textContent = '';
            }
        }

        // Function to validate the Contact field
        function validateContact(input) {
            const contactError = document.getElementById('contactError');
            const contactValue = input.value;

            // Check if the input contains any non-numeric characters
            if (!/^\d*$/.test(contactValue)) {
                contactError.textContent = 'Contact should only contain numbers.';
                input.value = contactValue.replace(/\D/g, ''); // Remove non-numeric characters
            } else if (contactValue.length > 11) {
                // Check if the length exceeds 11 digits
                contactError.textContent = 'Contact number cannot exceed 11 digits.';
                input.value = contactValue.slice(0, 11); // Trim to 11 digits
            } else {
                contactError.textContent = ''; // Clear the error message if valid
            }
        }

        // Function to validate the Age field
        function validateAge(input) {
            const ageError = document.getElementById('ageError');
            let age = input.value.trim(); // Get the raw input value

            // Check if the input contains any non-numeric characters
            if (/[^0-9]/.test(age)) {
                ageError.textContent = 'Age must be a number. Special characters and letters are not allowed.';
                input.value = age.replace(/[^0-9]/g, '');
                return;
            }

            // Check if the input is empty
            if (age === '') {
                ageError.textContent = ''; // Clear the error message if the input is empty
                return;
            }

            // Convert the input to a number
            const ageNumber = parseInt(age, 10);

            // Check if the age is within the allowed range
            if (ageNumber < 1 || ageNumber > 99) {
                ageError.textContent = 'Age must be between 1 and 99.';
                input.value = Math.max(1, Math.min(99, ageNumber)); // Clamp the value to the allowed range
            } else {
                ageError.textContent = ''; // Clear the error message if valid
            }
        }

        // Function to validate the entire form
        function validateForm() {
            let isValid = true;

            // Validate Name
            const nameInput = document.getElementById('name');
            validateName(nameInput);
            if (document.getElementById('nameError').textContent !== '') {
                isValid = false;
            }

            // Validate Address
            const addressInput = document.getElementById('address');
            validateAddress(addressInput);
            if (document.getElementById('addressError').textContent !== '') {
                isValid = false;
            }

            // Validate Contact
            const contactInput = document.getElementById('contact');
            validateContact(contactInput);
            if (document.getElementById('contactError').textContent !== '') {
                isValid = false;
            }

            // Validate Age
            const ageInput = document.getElementById('age');
            validateAge(ageInput);
            if (document.getElementById('ageError').textContent !== '') {
                isValid = false;
            }

            // Validate Password (if provided)
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('password_confirmation');
            if (passwordInput.value !== '' || confirmPasswordInput.value !== '') {
                if (passwordInput.value.length < 8) {
                    document.getElementById('passwordError').textContent = 'Password must be at least 8 characters long.';
                    isValid = false;
                } else if (passwordInput.value !== confirmPasswordInput.value) {
                    document.getElementById('confirmPasswordError').textContent = 'Passwords do not match.';
                    isValid = false;
                } else {
                    document.getElementById('passwordError').textContent = '';
                    document.getElementById('confirmPasswordError').textContent = '';
                }
            }

            return isValid;
        }

        // Toggle password visibility
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function (e) {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });

        // Toggle confirm password visibility
        const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
        const confirmPassword = document.querySelector('#password_confirmation');

        toggleConfirmPassword.addEventListener('click', function (e) {
            const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
            confirmPassword.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>
