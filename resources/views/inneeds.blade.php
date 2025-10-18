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
    <title>Admin Outgoing Donation</title>
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
        height: auto;
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
    /* Custom Button Style */
    .custom-btn {
    background-color: #196f38;
    color: #ffffff
    }

    .custom-btn:hover {
        background-color: #ffd000;
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
                    </a>
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
                        <button href="#" class="btn mt-2 custom-btn" data-bs-toggle="modal" data-bs-target="#addRequestModal">Add New Request for Help</button>
                        <div class="modal fade" id="addRequestModal" tabindex="-1" aria-labelledby="addRequestModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="addRequestModalLabel">Add New Request for Help</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="addRequestForm" action="{{route('addinneed')}}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="image" class="form-label">Image</label>
                                                <input type="file" class="form-control" id="image" name="image" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="title" class="form-label">Title</label>
                                                <input type="text" class="form-control" id="title" name="title" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description</label>
                                                <textarea class="form-control" id="description" name="description" rows="3" required maxlength="500"></textarea>
                                                <small id="charCount" class="form-text text-muted">500 characters remaining</small>
                                                <small id="descriptionError" class="text-danger" style="display: none;">Description must be less than 500 characters.</small>
                                            </div>
                                            <div class="mb-3">
                                                <label for="location" class="form-label">Location</label>
                                                <input type="text" class="form-control" id="location" name="location" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="category" class="form-label">Category</label>
                                                <select class="form-select" id="category" name="category" required>
                                                    <option value="food">Food and Nutrition</option>
                                                    <option value="clothing">Clothing and Wearables</option>
                                                    <option value="education">Educational and School Supplies</option>
                                                    <option value="hygiene">Hygiene and Sanitation</option>
                                                    <option value="shelter">Shelter and Home Essentials</option>
                                                    <option value="medical">Medical and First Aid</option>
                                                    <option value="emergency">Emergency and Disaster Relief</option>
                                                </select>
                                            </div>
                                            <div class="mb-3 text-center">
                                                <button type="submit" class="btn btn-primary">Submit Request</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive mt-2">
                            <table class="table table-bordered" id="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Image</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Location</th>
                                        <th>Category</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($inneeds as $inneed)
                                    <tr class="bg-dark">
                                        <td class="bg-dark"><img src="{{ asset('storage/' . $inneed->image) }}" alt="Image" style="width: 50px; height: 50px;"></td>
                                        <td class="bg-dark text-white">{{$inneed->title}}</td>
                                        <td class="bg-dark text-white">{{$inneed->description}}</td>
                                        <td class="bg-dark text-white">{{$inneed->location}}</td>
                                        <td class="bg-dark text-white">{{$inneed->category}}</td>
                                        <td class="bg-dark mt-2 d-flex align-items-center justify-content-center gap-2">
                                            <!-- Edit Button and Modal -->
                                            <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal-{{ $inneed->id }}">Edit</button>

                                            <div class="modal fade" id="editModal-{{ $inneed->id }}" tabindex="-1" aria-labelledby="editModalLabel-{{ $inneed->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="editModalLabel-{{ $inneed->id }}">Edit</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form id="editForm-{{ $inneed->id }}" action="{{route('updateinneed',$inneed->id)}}" enctype="multipart/form-data" method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <input type="hidden" id="inneedId" name="id" value="{{ $inneed->id }}">
                                                                <div class="text-start mb-3">
                                                                    <label for="image-{{ $inneed->id }}" class="form-label">Image</label>
                                                                    <input type="file" class="form-control" id="image-{{ $inneed->id }}" name="image">
                                                                    @if ($inneed->image)
                                                                        <img src="{{ asset('storage/' . $inneed->image) }}" alt="InNeed Image" class="img-thumbnail mt-2" style="width: 100px; height: 100px;">
                                                                    @endif
                                                                </div>
                                                                <div class="text-start mb-3">
                                                                    <label for="title" class="form-label">Title</label>
                                                                    <input type="text" class="form-control" id="title-{{ $inneed->id }}" name="title" value="{{ $inneed->title }}" required>
                                                                </div>
                                                                <div class="text-start mb-3">
                                                                    <label for="description" class="form-label">Description</label>
                                                                    <textarea class="form-control" id="description-{{ $inneed->id }}" name="description" rows="3" required>{{ $inneed->description }}</textarea>
                                                                </div>
                                                                <div class="text-start mb-3">
                                                                    <label for="location" class="form-label">Location</label>
                                                                    <input type="text" class="form-control" id="location-{{ $inneed->id }}" name="location" value="{{ $inneed->location }}" required>
                                                                </div>
                                                                <div class="text-start mb-3">
                                                                    <label for="category-{{ $inneed->id }}" class="form-label">Category</label>
                                                                    <select class="form-select" id="category-{{ $inneed->id }}" name="category" required>
                                                                        <option value="food" {{ $inneed->category == 'food' ? 'selected' : '' }}>Food and Nutrition</option>
                                                                        <option value="clothing" {{ $inneed->category == 'clothing' ? 'selected' : '' }}>Clothing and Wearables</option>
                                                                        <option value="education" {{ $inneed->category == 'education' ? 'selected' : '' }}>Educational and School Supplies</option>
                                                                        <option value="hygiene" {{ $inneed->category == 'hygiene' ? 'selected' : '' }}>Hygiene and Sanitation</option>
                                                                        <option value="shelter" {{ $inneed->category == 'shelter' ? 'selected' : '' }}>Shelter and Home Essentials</option>
                                                                        <option value="medical" {{ $inneed->category == 'medical' ? 'selected' : '' }}>Medical and First Aid</option>
                                                                        <option value="emergency" {{ $inneed->category == 'emergency' ? 'selected' : '' }}>Emergency and Disaster Relief</option>
                                                                    </select>
                                                                </div>
                                                            </form>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="submit" class="btn btn-primary" form="editForm-{{ $inneed->id }}">Update</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Delete Form -->
                                            <form id="deleteForm-{{ $inneed->id }}" action="{{ route('destroy', $inneed->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $inneed->id }})">Delete</button>
                                            </form>

                                            <!-- SweetAlert Script -->
                                            <script>
                                                function confirmDelete(inneedId) {
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
                                                            document.getElementById('deleteForm-' + inneedId).submit();
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
            </div>
        </div>
    </section>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gyb3R2kW2vb5A/yq6pzZb5n3Qz9zDZvZgl6zdeGVJ5k/4fPjq2" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0oP4pL9p1yTL45o6uZ9VxAKp4a7lFvFscJ5FwY5UqBOfNfi6" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                "pageLength": 7
            });

            // Character count and validation for the description field
            $('#description').on('input', function() {
                const maxLength = 500;
                const currentLength = $(this).val().length;
                const remaining = maxLength - currentLength;
                $('#charCount').text(remaining + ' characters remaining');

                if (currentLength > maxLength) {
                    $('#descriptionError').show();
                } else {
                    $('#descriptionError').hide();
                }
            });

            $('#addRequestForm').on('submit', function(e) {
                const description = $('#description').val();
                if (description.length > 500) {
                    e.preventDefault();
                    $('#descriptionError').show();
                } else {
                    $('#descriptionError').hide();
                }
            });
        });
    </script>
</body>
</html>
