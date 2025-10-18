<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register</title>
    <link rel="icon" type="image/png" href="{{ asset('faviconlogo.png') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<style>
    body {
        background-color: #f4f9f4;
        font-family: 'Arial', sans-serif;
        color: #34495e;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        margin: 0;
    }

    .card {
        background-color: #ffffff;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        padding: 20px;
        width: 100%;
        max-width: 800px;
        margin: auto;
        margin-top: 130px;
        margin-bottom: 50px;
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
        margin-top: .5rem;
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
    }

    .nav-link {
        color: #ffffff !important;
    }

    .nav-link:hover {
        color: #ffd000 !important;
    }

    .footer {
        background-color: #196f38;
        color: #fff;
        padding: 5px;
        text-align: center;
        margin-top: 5px;
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
            <a class="nav-link" href="{{route('login')}}">Login</a>
        </div>
        <div class="navbar-text p-2">
            <a class="nav-link active" href="{{route('register')}}">Register</a>
        </div>
    </nav>
</header>
<body>
    <section>
        <div class="container">
            <div class="form-container">
                <div class="card p-5">
                    <div class="card-body">
                        <h5 class="card-title">Register</h5>
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
                        <form method="POST" action="{{ route('registerpost') }}" onsubmit="return validateForm()">
                            @csrf
                            <div>
                                <div class="row justify-content-center">
                                    <div>
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="name" class="form-label">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="ex. John Joshua Doe" value="{{ old('name') }}" maxlength="40" oninput="validateName(this)">
                                                <small id="nameError" class="text-danger"></small>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="email" class="form-label">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="ex. johndoe@example.com" value="{{ old('email') }}">
                                                <small id="emailError" class="text-danger"></small>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <label for="address" class="form-label">Address</label>
                                                <input type="text" class="form-control" id="address" name="address" placeholder="ex. Binmaley, Pangasinan" value="{{ old('address') }}" maxlength="50" oninput="validateAddress(this)">
                                                <small id="addressError" class="text-danger"></small>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="age" class="form-label">Age</label>
                                                <input type="text" class="form-control" id="age" name="age" placeholder="ex. 25" required value="{{ old('age') }}" oninput="validateAge(this)">
                                                <small id="ageError" class="text-danger"></small>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <label for="gender" class="form-label">Gender</label>
                                                <select class="form-select" id="gender" name="gender" required>
                                                    <option value="" selected disabled>Select your gender</option>
                                                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                                    <option value="others" {{ old('gender') == 'others' ? 'selected' : '' }}>Other</option>
                                                </select>
                                                <small id="genderError" class="text-danger"></small>
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <label for="role" class="form-label">Register As</label>
                                                <select class="form-select" id="role" name="role" required>
                                                    <option value="" selected disabled>Select your role</option>
                                                    <option value="donor" {{ old('role') == 'donor' ? 'selected' : '' }}>Donor</option>
                                                    <option value="recipient" {{ old('role') == 'recipient' ? 'selected' : '' }}>Recipient</option>
                                                </select>
                                                <small id="roleError" class="text-danger"></small>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <label for="contact">Contact</label>
                                            <input type="text" class="form-control" id="contact" name="contact" placeholder="Enter your contact" value="{{ old('contact') }}" oninput="validateContact(this)">
                                            <small id="contactError" class="text-danger"></small>
                                        </div>

                                        <div class="mb-3 position-relative">
                                            <label for="id_password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="id_password" name="password" placeholder="Enter your password">
                                            <i class="far fa-eye eye-icon" id="togglePassword" style="top: 30%; right: 10px; cursor: pointer;"></i>
                                            <small id="passwordError" class="text-danger"></small>

                                            <label for="confirm_password" class="form-label">Confirm Password</label>
                                            <input type="password" class="form-control" id="confirm_password" name="password_confirmation" placeholder="Confirm your password" required>
                                            <i class="far fa-eye eye-icon" id="toggleConfirmPassword" style="top: 80%; right: 10px; cursor: pointer;"></i>
                                            <small id="confirmPasswordError" class="text-danger"></small>
                                        </div>

                                        <!-- Terms and Conditions Section -->
                                        <div class="row mb-3">
                                            <div class="col-md-12">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="termsCheckbox" required>
                                                    <label class="form-check-label" for="termsCheckbox">
                                                        I agree to the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">Terms and Conditions</a>.
                                                    </label>
                                                </div>
                                                <small id="termsError" class="text-danger"></small>
                                            </div>
                                        </div>

                                        <div class="d-flex justify-content-center align-items-center mt-3">
                                            <button type="submit" class="btn btn-primary">Register</button>
                                        </div>

                                        <!-- "Already have an account?" link -->
                                        <div class="d-flex justify-content-center align-items-center position-bottom mt-3">
                                            <p>Already have an account? <a href="{{ route('login') }}">Login here</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <script>
                            const togglePassword = document.querySelector('#togglePassword');
                            const password = document.querySelector('#id_password');

                            togglePassword.addEventListener('click', function (e) {
                                const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
                                password.setAttribute('type', type);
                                this.classList.toggle('fa-eye-slash');
                                this.classList.toggle('show', type === 'text'); // Show icon when password is visible
                            });

                            const toggleConfirmPassword = document.querySelector('#toggleConfirmPassword');
                            const confirmPassword = document.querySelector('#confirm_password');

                            toggleConfirmPassword.addEventListener('click', function (e) {
                                const type = confirmPassword.getAttribute('type') === 'password' ? 'text' : 'password';
                                confirmPassword.setAttribute('type', type);
                                this.classList.toggle('fa-eye-slash');
                                this.classList.toggle('show', type === 'text'); // Show icon when password is visible
                            });

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
                                    input.value = age.replace(/[^0-9]/g, ''); // Remove any non-numeric characters
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

                                // Validate Terms and Conditions
                                const termsCheckbox = document.getElementById('termsCheckbox');
                                if (!termsCheckbox.checked) {
                                    document.getElementById('termsError').textContent = 'You must agree to the Terms and Conditions.';
                                    isValid = false;
                                } else {
                                    document.getElementById('termsError').textContent = '';
                                }

                                return isValid;
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Terms and Conditions Modal -->
    <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>
                        By registering on this website, you agree to the following Terms and Conditions in compliance with applicable Philippine laws:
                    </p>

                    <h6>1. User Responsibilities</h6>
                    <p>
                        a. You agree to provide accurate, current, and complete information during registration and update such information to keep it accurate and complete.<br>
                        b. You are responsible for maintaining the confidentiality of your account and password and for all activities that occur under your account.
                    </p>

                    <h6>2. Lawful Use</h6>
                    <p>
                        a. You shall not use this platform for any unlawful purpose, including but not limited to fraud, identity theft, and dissemination of malicious content.<br>
                        b. Any fraudulent or malicious activity shall be subject to prosecution under <strong>Republic Act No. 10175 (Cybercrime Prevention Act of 2012)</strong>.
                    </p>

                    <h6>3. Data Privacy</h6>
                    <p>
                        a. Your personal information will be collected and processed in accordance with <strong>Republic Act No. 10173 (Data Privacy Act of 2012)</strong>.<br>
                        b. We are committed to ensuring the confidentiality, integrity, and availability of your personal data and will not disclose it without your consent unless required by law.
                    </p>

                    <h6>4. Donations and Transactions</h6>
                    <p>
                        a. All donations made through this platform are voluntary and non-refundable.<br>
                        b. Any misuse of funds or misrepresentation of donations will be subject to penalties under <strong>Republic Act No. 10963 (Tax Reform for Acceleration and Inclusion Act)</strong> and other applicable financial regulations.
                    </p>

                    <h6>5. Account Termination</h6>
                    <p>
                        a. We reserve the right to suspend or terminate your account if you violate these terms.<br>
                        b. Violations related to cybercrimes, financial fraud, or data privacy breaches will be reported to the appropriate authorities, including the National Bureau of Investigation (NBI) Cybercrime Division.
                    </p>

                    <h6>6. Amendments</h6>
                    <p>
                        a. These Terms and Conditions may be updated from time to time, and continued use of the platform signifies your acceptance of any changes.<br>
                        b. We will notify users of significant updates through email or website announcements.
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="conatain">
            <p>&copy; 2023 Cycle of Giving. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.querySelector('form').addEventListener('submit', function (e) {
            const termsCheckbox = document.querySelector('#termsCheckbox');
            if (!termsCheckbox.checked) {
                e.preventDefault(); // Prevent form submission
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'You must agree to the Terms and Conditions to proceed.',
                    showConfirmButton: true,
                });
            }
        });

        // Navbar scroll behavior
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
</body>
</html>
