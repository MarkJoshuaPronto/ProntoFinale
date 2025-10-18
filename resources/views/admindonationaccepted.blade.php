@php use Illuminate\Support\Str; @endphp


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
    <title>Admin Accepted Donation</title>
</head>
<style>
   .circular-logo {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        overflow: hidden;
        border: 2px solid #ccc;
    }

    .circular-logo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .logo-text {
            font-size: 20px;
            margin-left: 10px;
    }
    .sidebar {
        background-color: #000000;
        padding-top: 20px;
        display: flex;
        flex-direction: column;
        height: 100vh;
    }
    .sidebar a {
        padding: 10px 20px;
        text-decoration: none;
        color: #FEFBF6;
        display: block;
    }
    .sidebar a:hover {
        background-color: #196f38;
        color: white;
    }
    .main-content {
        padding: 20px;
        min-height: 100vh;
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
    .img{
        width: 100px;
        height: 100px;
    }
    div.dataTables_filter input {
        margin-bottom: 1rem;
    }
    .gallery{
        width: 250px;
    }
    .logout-container {
        padding: 10px 20px;
        text-align: center;
        margin-bottom: 20px;
    }

    .logout-button {
        margin-top: 10px;
        width: 170px;
        margin: 5%;
        display: block;
        padding: 10px 20px;
        background-color: #ff0000;
        color: white;
        border-radius: 5px;
        text-align: center;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }
    .logout-button:hover {
        background-color: #ffd000;
        color: rgb(0, 0, 0);
    }
    .floating-card {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background-color: #ffffff;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        z-index: 1000;
        max-width: 600px;
        width: 90%;
        display: none;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        line-height: 1.6;
        color: #333;
        overflow-y: auto; /* Add vertical scrollbar if content overflows */
        max-height: 80vh; /* Set a maximum height for the card */
    }

    .floating-card h3 {
        font-size: 1.5em;
        margin-bottom: 20px;
        color: #007bff;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }

    .floating-card p {
        margin-bottom: 15px;
    }

    .floating-card img {
        max-width: 90%;
        height: auto;
        border-radius: 8px;
        margin: 20px auto;
        display: block;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    .floating-card .close-card {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 20px;
        float: right;
        transition: background-color 0.3s ease;
    }

    .floating-card .close-card:hover {
        background-color: #c82333;
    }

    .floating-card-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        z-index: 999;
        display: none;
        backdrop-filter: blur(5px);
    }

    .floating-card.show, .floating-card-overlay.show {
        display: block;
    }

    .floating-card #cardContent {
        padding-right: 15px; /* Add padding to prevent content from touching the scrollbar */
    }    .badge-new {
        background-color: #28a745;
    }
    .badge-used {
        background-color: #ffc107;
        color: #212529;
    }
    .badge-fair {
        background-color: #dc3545;
    }
    .status-select {
        width: 150px;
        margin-right: 5px;
    }
</style>
<body>
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-2 sidebar">
                    <div class="text-center mt-5">
                        @if($auth->image)
                        <img
                            src="{{ asset('storage/' . $auth->image) }}"
                            alt="User Image"
                            width="80"
                            height="80"
                            class="rounded-circle mb-2"
                            id="profile-image-{{ $auth->id }}"
                            style="cursor: pointer;"
                            data-bs-toggle="modal"
                            data-bs-target="#editUserModal-{{ $auth->id }}">
                    @else
                        <img
                            src="{{ asset('assets/logo.jpg') }}"
                            alt="User Image"
                            width="80"
                            height="80"
                            class="rounded-circle mb-2"
                            id="profile-image-{{ $auth->id }}"
                            style="cursor: pointer;"
                            data-bs-toggle="modal"
                            data-bs-target="#editUserModal-{{ $auth->id }}">
                    @endif

                    </div>
                    <div class="modal fade" id="editUserModal-{{ $auth->id }}" tabindex="-1" aria-labelledby="editauthModalLabel-{{ $auth->id }}" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editauthModalLabel-{{ $auth->id }}">Edit {{$auth->name}}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('updateuser', $auth->id) }}" method="POST" enctype="multipart/form-data" id="form">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-2">
                                        <label for="image-{{ $auth->id }}" class="form-label">Image</label>
                                        <input type="file" class="form-control" id="image-{{ $auth->id }}" name="image">
                                        @if ($auth->image)
                                            <img src="{{ asset('storage/' . $auth->image) }}" alt="auth Image" class="img-thumbnail mt-2" style="width: 100px; height: 100px;">
                                        @endif
                                    </div>
                                    <div class="mb-2">
                                        <label for="name-{{ $auth->id }}" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="name-{{ $auth->id }}" name="name" value="{{ $auth->name }}" required>
                                    </div>


                                    <div class="mb-2">
                                        <label for="email-{{ $auth->id }}" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email-{{ $auth->id }}" name="email" value="{{ $auth->email }}" required>
                                    </div>

                                    <div class="mb-2">
                                        <label for="address-{{ $auth->id }}" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="address-{{ $auth->id }}" name="address" value="{{ $auth->address }}" required>
                                    </div>


                                    <div class="mb-2">
                                        <label for="age-{{ $auth->id }}" class="form-label">Age</label>
                                        <input type="number" class="form-control" id="age-{{ $auth->id }}" name="age" value="{{ $auth->age }}" required>
                                    </div>


                                    <div class="mb-2">
                                        <label for="gender-{{ $auth->id }}" class="form-label">Gender</label>
                                        <select class="form-select" id="gender-{{ $auth->id }}" name="gender" required>
                                            <option value="male" {{ $auth->gender == 'male' ? 'selected' : '' }}>Male</option>
                                            <option value="female" {{ $auth->gender == 'female' ? 'selected' : '' }}>Female</option>
                                            <option value="others" {{ $auth->gender == 'others' ? 'selected' : '' }}>Others</option>
                                        </select>
                                    </div>

                                    <div class="mb-2">
                                        <label for="password-{{ $auth->id }}" class="form-label">New Password (optional)</label>
                                        <input type="password" class="form-control" id="password-{{ $auth->id }}" name="password">
                                    </div>
                                    <div class="mb-2">
                                        <label for="password_confirmation-{{ $auth->id }}" class="form-label">Confirm New Password</label>
                                        <input type="password" class="form-control" id="password_confirmation-{{ $auth->id }}" name="password_confirmation">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Update User</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    </div>

                    <h4 class="text-center text-white mb-4">Admin {{ ucwords(Auth::user()->name) }}</h4>
                    <a href="{{ route('admindashboard') }}">
                        Dashboard
                    </a>
                    <a href="{{route('userlist')}}">Donors
                        @if ($newrecord > 0)
                            <span class="badge badge-pill bg-danger">{{ $newrecord }}</span>
                        @endif
                    </a>
                    <a href="{{route('recipientlist')}}">Recipients
                        @if ($newrecord > 0)
                            <span class="badge badge-pill bg-danger">{{ $newrecord }}</span>
                        @endif
                    <a href="{{route('admindonation')}}">
                        Incoming Donations
                        @if ($newdonation > 0)
                        <span class="badge badge-pill bg-danger">{{ $newdonation }}</span>
                    @endif
                    {{-- <a href="{{route('inneeds')}}">Outgoing Donation</a> --}}
                    <a href="{{route('admingallery')}}">Gallery</a>
                    <a href="{{route('activationrequest')}}">
                        Activation Request
                        @if ($newservice > 0)
                            <span class="badge badge-pill bg-danger">{{ $newservice }}</span>
                        @endif
                    </a>
                    <div class="logout-container">
                        <button href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="logout-button">Logout</button>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
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
                                text: "{{ $errors->first() }}",
                                showConfirmButton: true,
                                timer: 3000
                            });
                        </script>
                    @endif

                    <div class="containers">
                        <div class="d-flex gap-2 mb-3">
                            <a href="{{route('admindonation')}}" class="btn btn-warning">Pending</a>
                            <a href="{{route('admindonationaccepted')}}" class="btn btn-success">Accepted</a>
                            <a href="{{route('admindonationrejected')}}" class="btn btn-danger">Rejected</a>
                        </div>

                        <div class="table-responsive mt-2">
                            <table class="table table-bordered" id="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Donor</th>
                                        <th>Item Image</th>
                                        <th>Item Name</th>
                                        <th>Description</th>
                                        <th>Item Status</th>
                                        <th>Drop-off Location</th>
                                        <th>Date Accepted</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($alldonators as $donation)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($donation->user->image)
                                                    <img src="{{ asset('storage/' . $donation->user->image) }}" alt="Donor Image" class="rounded-circle me-2" style="width: 40px; height: 40px;">
                                                @else
                                                    <img src="{{ asset('assets/logo.jpg') }}" alt="Donor Image" class="rounded-circle me-2" style="width: 40px; height: 40px;">
                                                @endif
                                                <div>
                                                    <strong>{{ $donation->user->name }}</strong><br>
                                                    <small>{{ $donation->user->contact ?? 'No contact' }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <img src="{{ asset('storage/' . $donation->image) }}" alt="Item Image" style="width: 60px; height: 60px; object-fit: cover;" class="rounded">
                                        </td>
                                        <td>{{ $donation->name }}</td>
                                        <td>{{ Str::limit($donation->description, 50) }}</td>
                                        <td>
                                            <span class="badge rounded-pill
                                                @if($donation->item_status == 'new') badge-new
                                                @elseif($donation->item_status == 'used') badge-used
                                                @elseif($donation->item_status == 'fair') badge-fair
                                                @endif">
                                                {{ ucfirst($donation->item_status) }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $donation->dropofflocation == 'Dagupan' ? 'Dagupan Campus' : 'Urdaneta Campus' }}
                                        </td>
                                        <td>{{ $donation->updated_at->format('M d, Y h:i A') }}</td>
                                        <td>
                                            <div class="d-flex flex-column gap-2">
                                                <!-- View Details Button -->
                                                <button class="btn btn-info btn-sm view-details"
                                                    data-name="{{ $donation->name }}"
                                                    data-image="{{ asset('storage/' . $donation->image) }}"
                                                    data-description="{{ $donation->description }}"
                                                    data-item-status="{{ $donation->item_status }}"
                                                    data-dropoff-location="{{ $donation->dropofflocation == 'Dagupan' ? 'Dagupan Campus' : 'Urdaneta Campus' }}"
                                                    data-donor-name="{{ $donation->user->name }}"
                                                    data-donor-address="{{ $donation->user->address }}"
                                                    data-donor-contact="{{ $donation->user->contact ?? 'No contact yet' }}"
                                                    data-accepted-date="{{ $donation->updated_at->format('M d, Y h:i A') }}"
                                                >
                                                    View Details
                                                </button>

                                                <!-- Status Update Form -->
                                                <form action="{{ route('updatestatus', $donation->id) }}" method="POST" class="status-form">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="input-group">
                                                        <select name="status" class="form-select form-select-sm status-select" required>
                                                            <option value="accepted" selected>Accepted</option>
                                                            <option value="rejected">Reject</option>
                                                            <option value="pending">Set to Pending</option>
                                                        </select>
                                                        <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Floating Card for Details -->
                    <div id="floatingCard" class="floating-card">
                        <div id="cardContent"></div>
                        <button class="btn btn-sm btn-danger close-card">Close</button>
                    </div>
                    <div id="floatingCardOverlay" class="floating-card-overlay"></div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gyb3R2kW2vb5A/yq6pzZb5n3Qz9zDZvZgl6zdeGVJ5k/4fPjq2" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0oP4pL9p1yTL45o6uZ9VxAKp4a7lFvFscJ5FwY5UqBOfNfi6" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                "pageLength": 10,
                "order": [[6, "desc"]] // Sort by date accepted descending
            });

            // View Details Functionality
            document.addEventListener('DOMContentLoaded', function() {
                const viewButtons = document.querySelectorAll('.view-details');
                const floatingCard = document.getElementById('floatingCard');
                const overlay = document.getElementById('floatingCardOverlay');
                const cardContent = document.getElementById('cardContent');

                viewButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const itemName = this.getAttribute('data-name');
                        const itemImage = this.getAttribute('data-image');
                        const description = this.getAttribute('data-description');
                        const itemStatus = this.getAttribute('data-item-status');
                        const dropoffLocation = this.getAttribute('data-dropoff-location');
                        const donorName = this.getAttribute('data-donor-name');
                        const donorAddress = this.getAttribute('data-donor-address');
                        const donorContact = this.getAttribute('data-donor-contact');
                        const acceptedDate = this.getAttribute('data-accepted-date');

                        cardContent.innerHTML = `
                            <h3 class="text-center mb-4">Donation Details</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Item Name:</strong> ${itemName}</p>
                                    <p><strong>Item Status:</strong>
                                        <span class="badge rounded-pill
                                            ${itemStatus === 'new' ? 'bg-success' :
                                              itemStatus === 'used' ? 'bg-warning' : 'bg-danger'}">
                                            ${itemStatus.charAt(0).toUpperCase() + itemStatus.slice(1)}
                                        </span>
                                    </p>
                                    <p><strong>Description:</strong> ${description}</p>
                                    <p><strong>Drop-off Location:</strong> ${dropoffLocation}</p>
                                    <p><strong>Date Accepted:</strong> ${acceptedDate}</p>
                                </div>
                                <div class="col-md-6">
                                    <img src="${itemImage}" alt="Item Image" class="img-fluid rounded mb-3">
                                </div>
                            </div>
                            <hr>
                            <h4 class="text-center mb-3">Donor Information</h4>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong>Donor Name:</strong> ${donorName}</p>
                                    <p><strong>Address:</strong> ${donorAddress}</p>
                                    <p><strong>Contact:</strong> ${donorContact}</p>
                                </div>
                                <div class="col-md-6 text-center">
                                    <img src="{{ asset('storage/' . $donation->user->image) }}" alt="Donor Image" style="width: 100px; height: 100px; border-radius: 50%; object-fit: cover;">
                                </div>
                            </div>
                        `;
                        floatingCard.classList.add('show');
                        overlay.classList.add('show');
                    });
                });

                overlay.addEventListener('click', function() {
                    floatingCard.classList.remove('show');
                    overlay.classList.remove('show');
                });

                floatingCard.addEventListener('click', function(event) {
                    if (event.target.classList.contains('close-card')) {
                        floatingCard.classList.remove('show');
                        overlay.classList.remove('show');
                    }
                });
            });

            // Status Update Confirmation
            document.querySelectorAll('.status-form').forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const status = this.querySelector('.status-select').value;
                    const action = status === 'accepted' ? 'keep as accepted' :
                                 status === 'rejected' ? 'reject' : 'set to pending';

                    Swal.fire({
                        title: 'Confirm Status Update',
                        text: `Are you sure you want to ${action} this donation?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, update it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>
