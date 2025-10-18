<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" type="image/png" href="{{ asset('faviconlogo.png') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>User Dashboard</title>
    <style>
        body {
            background-color: #f4f9f4;
            font-family: 'Arial', sans-serif;
            color: #34495e;
        }

        .navbar {
            transition: top 0.3s ease, opacity 0.3s ease;
            position: fixed; /* Ensure the navbar is fixed */
            width: 100%;
            z-index: 1000;
            top: 0;
            opacity: 1;
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
            margin-top: 70px;
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
    </style>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg" style="background-color: #196f38;">
            <div class="container-fluid">
                <span class="navbar-brand">
                    <a href="{{ route('landingpageuser') }}">
                        <img src="{{ asset('assets/navlogo.png') }}" alt="Cycle of Giving Logo" class="cyclelogo" style="width: 150px; height: 50px;">
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
                            <img src="{{ asset('storage/' . $auth->image) }}" alt="Authenticated Logo"
                                 style="width: 40px; height: 40px; border-radius: 50%; margin-left: 15px; cursor: pointer;"
                                 id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        @else
                            <img src="{{ asset('assets/logo.jpg') }}" alt="Authenticated Logo"
                                 style="width: 40px; height: 40px; border-radius: 50%; margin-left: 15px; cursor: pointer;"
                                 id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        @endif
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="{{ route('donordashboard') }}">Dashboard</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="dropdown-item" style="background-color: red;,color: #fffff;color: white;">Logout</button>
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
                            <img
                                src="{{ asset('storage/' . $auth->image) }}"
                                alt="User  Image"
                                width="80"
                                height="80"
                                class="rounded-circle mb-2"
                                id="profile-image-{{ $auth->id }}"
                                style="cursor: pointer;"
                                data-bs-toggle="modal"
                                data-bs-target="#editUser Modal-{{ $auth->id }}">
                        @else
                            <img
                                src="{{ asset('assets/logo.jpg') }}"
                                alt="User  Image"
                                width="80"
                                height="80"
                                class="rounded-circle mb-2"
                                id="profile-image-{{ $auth->id }}"
                                style="cursor: pointer;"
                                data-bs-toggle="modal"
                                data-bs-target="#editUser Modal-{{ $auth->id }}">
                        @endif
                    </div>
                    <h4 class="text-center text-white mb-4">{{ ucwords(Auth::user()->name) }}</h4>
                    <a href="{{route('donordashboard')}}">Dashboard</a>
                    <a href="{{ route('edituser', Auth::user()->id) }}">Edit Profile</a>
                    <a href="#" onclick="confirmDeactivate()">Deactivate Account</a>
                    <form id="deactivateForm" action="{{ route('userdeactivateaccount', $auth->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('PUT')
                    </form>
                    <script>
                        function confirmDeactivate() {
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "You won't be able to undo this action!",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Yes, deactivate it!',
                                cancelButtonText: 'Cancel',
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    document.getElementById('deactivateForm').submit();
                                }
                            });
                        }
                    </script>
                    <a href="#" onclick="confirmDelete()">Delete Account</a>
                    <form id="deleteForm" action="{{ route('deleteaccount', $auth->id) }}" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                    <script>
                        function confirmDelete() {
                            Swal.fire({
                                title: 'Are you sure?',
                                text: "Do you really want to permanently delete this account?",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonText: 'Yes, delete it!',
                                cancelButtonText: 'Cancel',
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    document.getElementById('deleteForm').submit();
                                }
                            });
                        }
                    </script>
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
                                text: "{{ $errors->first() }}",  // Display the first error message
                                showConfirmButton: true,
                                timer: 3000
                            });
                        </script>
                    @endif
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-3">
                                <div class="card p-1">
                                    <div class="card-body">
                                        <img src="{{ asset('assets/donation.png') }}" class="img">
                                    </div>
                                    <h5 class="text-center fw-bold">Donations: {{$donationscount}}</h5>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card p-1">
                                    <div class="card-body">
                                        <img src="{{ asset('assets/pending.png') }}" class="img">
                                    </div>
                                    <h5 class="text-center fw-bold">Pending Requests: {{$pendingreq}}</h5>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card p-1">
                                    <div class="card-body">
                                        <img src="{{ asset('assets/accept.png') }}" class="img">
                                    </div>
                                    <h5 class="text-center fw-bold">Accepted Requests: {{$acceptedreq}}</h5>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card p-1">
                                    <div class="card-body">
                                        <img src="{{ asset('assets/decline.png') }}" class="img">
                                    </div>
                                    <h5 class="text-center fw-bold">Rejected Requests: {{$rejectedreq}}</h5>
                                </div>
                            </div>
                        </div>
                        <br>
                        <table class="table table-bordered" id="table">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Item Description</th>
                                    <th>Status</th>
                                    <th>Item Status</th>
                                    <th>Drop-off Location</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($donations as $donation)
                                <tr class="bg-dark">
                                    <td class="bg-dark">
                                        <img src="{{ asset('storage/' . $donation->image) }}" alt="Image" style="width: 50px; height: 50px;">
                                    </td>
                                    <td class="bg-dark text-white">{{$donation->name}}</td>
                                    <td class="bg-dark text-white">{{$donation->description}}</td>
                                    <td class="bg-dark text-white">
                                        <span class="badge rounded-pill
                                            @if ($donation->status == 'pending')
                                                bg-warning
                                            @elseif($donation->status == 'rejected')
                                                bg-danger
                                            @elseif($donation->status == 'accepted')
                                                bg-success
                                            @endif text-white">
                                            {{ ucfirst($donation->status) }}
                                        </span>
                                    </td>
                                    <td class="bg-dark text-white">
                                        <span class="badge rounded-pill
                                            @if ($donation->item_status == 'new')
                                                bg-success
                                            @elseif($donation->item_status == 'used')
                                                bg-warning
                                            @elseif($donation->item_status == 'fair')
                                                bg-danger
                                            @endif text-white">
                                            {{ ucfirst($donation->item_status) }}
                                        </span>
                                    </td>
                                    <td class="bg-dark text-white">
                                        <span class="badge rounded-pill
                                            @if ($donation->dropofflocation == 'Dagupan')
                                            @elseif($donation->dropofflocation == 'Urdaneta')
                                            @endif text-white">
                                            {{ ucfirst($donation->dropofflocation) }}
                                        </span>
                                    </td>
                                    <td class="bg-dark mt-1 d-flex align-items-center justify-content-center gap-2">
                                        @if ($donation->status == 'accepted')
                                        <button class="btn btn-warning" disabled>Edit</button>
                                        @else
                                        <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editDonationModal{{$donation->id}}">Edit</button>
                                        @endif
                                        <div class="modal fade" id="editDonationModal{{$donation->id}}" tabindex="-1" aria-labelledby="editDonationModalLabel{{$donation->id}}" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editDonationModalLabel{{$donation->id}}">Edit Donation</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form id="editDonationForm{{$donation->id}}" action="{{ route('updatedonation',$donation->id) }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="donation_id" value="{{ $donation->id }}">

                                                            <div class="text-start mb-3">
                                                                <label for="image{{$donation->id}}" class="form-label">Donation Image</label>
                                                                <input type="file" class="form-control" id="image{{$donation->id}}" name="image">
                                                                @if ($donation->image)
                                                                <img src="{{ asset('storage/' . $donation->image) }}" alt="InNeed Image" class="img-thumbnail mt-2" style="width: 100px; height: 100px;">
                                                                @endif
                                                            </div>
                                                            <div class="text-start mb-3">
                                                                <label for="name{{$donation->id}}" class="form-label">Donation Name</label>
                                                                <input type="text" class="form-control" id="name{{$donation->id}}" name="name" value="{{ $donation->name }}" required>
                                                            </div>

                                                            <div class="text-start mb-3">
                                                                <label for="description{{$donation->id}}" class="form-label">Description</label>
                                                                <textarea class="form-control" id="description{{$donation->id}}" name="description" rows="3" maxlength="500" required>{{ $donation->description }}</textarea>
                                                                <small id="charCount{{$donation->id}}" class="form-text text-muted">500 characters remaining</small>
                                                                <small id="errorMsg{{$donation->id}}" class="form-text text-danger" style="display: none;">Description exceeds the maximum character limit.</small>
                                                            </div>

                                                            <div class="text-start mb-3" style="display: none;">
                                                                <label for="status{{$donation->id}}" class="form-label">Status</label>
                                                                <input type="text" class="form-control" id="status{{$donation->id}}" name="status" value="{{ $donation->status }}" required>
                                                            </div>

                                                            <div class="text-start mb-3">
                                                                <label for="item_status{{$donation->id}}" class="form-label">Item Status</label>
                                                                <select class="form-select" id="item_status{{$donation->id}}" name="item_status" required>
                                                                    <option value="new" {{ $donation->item_status == 'new' ? 'selected' : '' }}>New</option>
                                                                    <option value="used" {{ $donation->item_status == 'used' ? 'selected' : '' }}>Used</option>
                                                                    <option value="fair" {{ $donation->item_status == 'fair' ? 'selected' : '' }}>Fair</option>
                                                                </select>
                                                            </div>

                                                            <div class="text-start mb-3">
                                                                <label for="dropofflocation{{$donation->id}}" class="form-label">Drop-off Location</label>
                                                                <select class="form-select" id="dropofflocation{{$donation->id}}" name="dropofflocation" required>
                                                                    <option value="Dagupan" {{ $donation->dropofflocation == 'Dagupan' ? 'selected' : '' }}>Dagupan Campus</option>
                                                                    <option value="Urdaneta" {{ $donation->dropofflocation == 'Urdaneta' ? 'selected' : '' }}>Urdaneta Campus</option>
                                                                </select>
                                                            </div>

                                                            <div class="mb-3 text-center">
                                                                <button type="submit" class="btn btn-primary">Update Donation</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <form id="deleteForm-{{ $donation->id }}" action="{{ route('destroyuserdonation', $donation->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            @if ($donation->status == 'accepted')
                                                <button type="button" class="btn btn-danger" disabled>Delete</button>
                                            @else
                                                <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $donation->id }})">Delete</button>
                                            @endif
                                        </form>
                                        <script>
                                            function confirmDelete(donationId) {
                                                Swal.fire({
                                                    title: 'Are you sure?',
                                                    text: "You won't be able to undo this!",
                                                    icon: 'warning',
                                                    showCancelButton: true,
                                                    confirmButtonText: 'Yes, delete it!',
                                                    cancelButtonText: 'Cancel',
                                                    confirmButtonColor: '#d33',
                                                    cancelButtonColor: '#3085d6',
                                                }).then((result) => {
                                                    if (result.isConfirmed) {
                                                        document.getElementById('deleteForm-' + donationId).submit();
                                                    }
                                                });
                                            }
                                        </script>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                "pageLength": 5
            });
        });

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

        // Add event listeners for character count and validation
        @foreach ($donations as $donation)
        document.getElementById('description{{$donation->id}}').addEventListener('input', function() {
            const maxLength = 500;
            const currentLength = this.value.length;
            const remaining = maxLength - currentLength;
            document.getElementById('charCount{{$donation->id}}').textContent = remaining + ' characters remaining';

            if (currentLength > maxLength) {
                document.getElementById('errorMsg{{$donation->id}}').style.display = 'block';
            } else {
                document.getElementById('errorMsg{{$donation->id}}').style.display = 'none';
            }
        });

        // Initial character count on page load
        const initialDescription{{$donation->id}} = document.getElementById('description{{$donation->id}}').value;
        const initialRemaining{{$donation->id}} = 500 - initialDescription{{$donation->id}}.length;
        document.getElementById('charCount{{$donation->id}}').textContent = initialRemaining{{$donation->id}} + ' characters remaining';

        document.getElementById('editDonationForm{{$donation->id}}').addEventListener('submit', function(event) {
            const description = document.getElementById('description{{$donation->id}}').value;
            if (description.length > 500) {
                event.preventDefault();
                document.getElementById('errorMsg{{$donation->id}}').style.display = 'block';
            }
        });
        @endforeach
    </script>
</body>
</html>
