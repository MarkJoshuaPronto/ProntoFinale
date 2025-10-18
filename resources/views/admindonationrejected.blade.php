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
    <title>Admin Rejected Donation</title>
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
                                text: "Password doesn't match!",
                                showConfirmButton: true,
                                timer: 3000
                            });
                        </script>
                    @endif
                    <div class="containers">
                        <a href="{{route('admindonation')}}" class="btn btn-warning">Pending</a>
                        <a href="{{route('admindonationaccepted')}}" class="btn btn-success">Accepted</a>
                        <a href="{{route('admindonationrejected')}}" class="btn btn-danger">Rejected</a>
                        <div class="table-responsive mt-2">
    <table class="table table-bordered" id="table">
        <thead class="thead-dark">
            <tr>
                <th>Donor's Image</th>
                <th>Donor's Name</th>
                <th>Donor's Address</th>
                <th>Gender</th>
                <th>Contact</th>
                <th>Item Status</th>
                <th>Status</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($alldonators as $donators)
            <tr>
                <td class="bg-dark">
                    @if($donators->user->image)
                        <img src="{{ asset('storage/' . $donators->user->image) }}" alt="Image" style="width: 50px; height: 50px;">
                    @else
                        <img src="{{ asset('assets/logo.jpg') }}" alt="Image" style="width: 50px; height: 50px;">
                    @endif
                </td>
                <td class="bg-dark text-white">{{ $donators->user->name }}</td>
                <td class="bg-dark text-white">{{$donators->user->address}}</td>
                <td class="bg-dark text-white">
                    <span class="bg-dark text-white
                        @if ($donators->user->gender == 'male')
                        @elseif($donators->user->gender == 'female')
                        @elseif($donators->user->gender == 'others')
                        @endif">
                        {{ ucfirst($donators->user->gender) }}
                    </span>
                </td>
                <td class="bg-dark text-white">
                    @if (!$donators->user->contact)
                        <span class="badge badge-pill bg-danger">No contact yet</span>
                    @else
                        <span class="bg-dark text-white">{{ $donators->user->contact }}</span>
                    @endif
                </td>
                <td class="bg-dark text-white">
                    <span class="bg-dark text-white
                        @if ($donators->item_status == 'new')
                        @elseif($donators->item_status == 'used')
                        @elseif($donators->item_status == 'fair')
                        @endif text-white">
                        {{ ucfirst($donators->item_status) }}
                    </span>
                </td>
                <td class="bg-dark text-white">
                    <span class="badge rounded-pill
                        @if ($donators->status == 'pending')
                            bg-warning
                        @elseif($donators->status == 'rejected')
                            bg-danger
                        @elseif($donators->status == 'accepted')
                            bg-success
                        @endif text-white">
                        {{ ucfirst($donators->status) }}
                    </span>
                </td>
                <td class="bg-dark text-white">
                    <button class="btn view-details" style="margin-bottom: 15px; color: #ffffff; hover: #ffd000; background-color: #198754;"
                        data-inneed-title="{{ $donators->inneed->title }}"
                        data-item-image="{{ asset('storage/' . $donators->image) }}"
                        data-description="{{ $donators->description }}"
                        data-inneed-location="{{ $donators->inneed->location }}"
                        data-dropoff-location="{{ $donators->dropofflocation == 'Dagupan' ? 'Dagupan Campus' : 'Urdaneta Campus' }}"
                    >View</button>
                    <form action="{{ route('updatestatus', $donators->id) }}" method="POST" id="statusForm_{{ $donators->id }}">
                        @csrf
                        @method('PUT')
                        <label for="status" class="form-label" style="display: none"></label>
                        <select name="status" id="status" onchange="document.getElementById('statusForm_{{ $donators->id }}').submit();">
                            <option selected disabled>Update Status</option>
                            <option value="accepted" {{ $donators->status == 'accepted' ? 'selected' : '' }}>Accept</option>
                            <option value="rejected" {{ $donators->status == 'rejected' ? 'selected' : '' }}>Reject</option>
                        </select>
                    </form>
                </td>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div id="floatingCard" class="floating-card">
    <div id="cardContent"></div>
    <button class="btn btn-sm btn-danger close-card">Close</button>
</div>
<div id="floatingCardOverlay" class="floating-card-overlay"></div>

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gyb3R2kW2vb5A/yq6pzZb5n3Qz9zDZvZgl6zdeGVJ5k/4fPjq2" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0oP4pL9p1yTL45o6uZ9VxAKp4a7lFvFscJ5FwY5UqBOfNfi6" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script>
    $(document).ready(function() {
            $('#table').DataTable({
                "pageLength": 5
            });
        });
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const viewButtons = document.querySelectorAll('.view-details');
    const floatingCard = document.getElementById('floatingCard');
    const overlay = document.getElementById('floatingCardOverlay');
    const cardContent = document.getElementById('cardContent');

    viewButtons.forEach(button => {
        button.addEventListener('click', function() {
            const donorDonated = this.getAttribute('data-inneed-title');
            const itemImage = this.getAttribute('data-item-image');
            const description = this.getAttribute('data-description');
            const inneedLocation = this.getAttribute('data-inneed-location');
            const dropoffLocation = this.getAttribute('data-dropoff-location');

            cardContent.innerHTML = `
                <p><strong>Where The Donor Donated:</strong> ${donorDonated}</p>
                <p><strong>Item Image:</strong> <img src="${itemImage}" alt="Item Image""></p>
                <p><strong>Item Description:</strong> ${description}</p>
                <p><strong>Beneficiary Location:</strong> ${inneedLocation}</p>
                <p><strong>Drop-off Location:</strong> ${dropoffLocation}</p>
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
</script>
</body>
</html>
