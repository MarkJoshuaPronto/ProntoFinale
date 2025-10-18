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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Admin Donors</title>
</head>
<style>
    .main-content {
        padding: 20px;
        min-height: 100vh;
    }

    /* Green table styling */
    #table {
        border: 1px solid #2e7d32;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(46, 125, 50, 0.1);
    }

    #table thead th {
        background-color: #2e7d32;
        color: white;
        font-weight: 600;
        border: none;
        padding: 12px 15px;
    }

    #table tbody tr {
        transition: background-color 0.2s ease;
    }

    #table tbody tr:nth-child(even) {
        background-color: #e8f5e9;
    }

    #table tbody tr:nth-child(odd) {
        background-color: #f1f8e9;
    }

    #table tbody tr:hover {
        background-color: #c8e6c9;
    }

    #table tbody td {
        border-color: #a5d6a7;
        padding: 10px 15px;
        color: #1b5e20;
    }

    #table tbody td:first-child {
        border-left: none;
    }

    #table tbody td:last-child {
        border-right: none;
    }

    /* Status badges */
    .badge.bg-danger {
        background-color: #e53935 !important;
    }

    .badge.bg-success {
        background-color: #43a047 !important;
    }

    .custom-btn {
        background-color: #2e8b57;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 5px;
        transition: all 0.3s ease;
    }

    .custom-btn:hover {
        background-color: #1a4720;
        color: white;
    }
</style>
<body>
    <section>
        <div class="container-fluid">
            <div class="row">
                <!-- Include the sidebar component -->
                @include('admin.sidebar')

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

                    <button class="btn mt-2 custom-btn" data-bs-toggle="modal" data-bs-target="#addUserModal">Add New Recipient</button>

                    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addUserModalLabel">Add New Recipient</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('addrecipient') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="mb-2">
                                            <label for="image" class="form-label">Image</label>
                                            <input type="file" class="form-control" id="image" name="image">
                                        </div>
                                        <div class="mb-2">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" class="form-control" id="name" name="name" required>
                                        </div>
                                        <div class="mb-2">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                        </div>
                                        <div class="mb-2">
                                            <label for="address" class="form-label">Address</label>
                                            <input type="text" class="form-control" id="address" name="address" required>
                                        </div>
                                        <div>
                                            <label for="role" class="form-label">Role</label>
                                            <input type="text" class="form-control" id="role" name="role" value="recipient" readonly>
                                        </div>
                                        <div class="mb-2">
                                            <label for="age" class="form-label">Age</label>
                                            <input type="number" class="form-control" id="age" name="age" fixed>
                                        </div>
                                        <div class="mb-2">
                                            <label for="gender" class="form-label">Gender</label>
                                            <select class="form-select" id="gender" name="gender" required>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                                <option value="others">Others</option>
                                            </select>
                                        </div>
                                        <div class="mb-2">
                                            <label for="contact" class="form-label">Contact</label>
                                            <input type="tel" class="form-control" id="contact" name="contact" required>
                                        </div>
                                        <div class="mb-2">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" required>
                                        </div>
                                        <div class="mb-2">
                                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Add Recipient</button>
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
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Address</th>
                                    <th>Age</th>
                                    <th>Gender</th>
                                    <th>Contact</th>
                                    <th>Account_Status</th>
                                    <th>Update_Account_Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>
                                            @if($user->image)
                                                <img src="{{ asset('storage/' . $user->image) }}" alt="User Image" class="card-img-top" style="width: 50px; height: 50px;">
                                            @else
                                                <img src="{{ asset('assets/logo.jpg') }}" alt="Default Image" class="card-img-top" style="width: 50px; height: 50px;">
                                            @endif
                                        </td>
                                        <td>{{$user->name}}</td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->address}}</td>
                                        <td>{{$user->age}}</td>
                                        <td>{{$user->gender}}</td>
                                        <td>
                                            @if (!$user->contact)
                                                <span>No contact yet</span>
                                            @else
                                                <span>{{ $user->contact }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($user->account_status === 'inactive')
                                                <span class="badge badge-pill bg-danger">Inactive</span>
                                            @else
                                                <span class="badge badge-pill bg-success">Active</span>
                                            @endif
                                        </td>
                                        <td>
                                        <div class="text-center d-flex gap-2 justify-content-center align-items-center">
                                            <form id="activateForm" action="{{ route('activateaccount', $user->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="button" class="btn btn-success activateButton">Activate</button>
                                            </form>

                                            <script>
                                                document.querySelectorAll('.activateButton').forEach(button => {
                                                    button.addEventListener('click', function (e) {
                                                        e.preventDefault();
                                                        const form = this.closest('form');
                                                        Swal.fire({
                                                            icon: 'warning',
                                                            title: 'Are you sure?',
                                                            text: "Do you really want to activate this account?",
                                                            showCancelButton: true,
                                                            confirmButtonText: 'Yes, activate it!',
                                                            cancelButtonText: 'No, cancel',
                                                            reverseButtons: true
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                form.submit();
                                                            }
                                                        });
                                                    });
                                                });
                                            </script>

                                            <form id="deactivateForm" action="{{ route('deactivateaccount', $user->id) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="button" class="btn btn-danger deactivateButton">Deactivate</button>
                                            </form>

                                            <script>
                                                document.querySelectorAll('.deactivateButton').forEach(button => {
                                                    button.addEventListener('click', function (e) {
                                                        e.preventDefault();
                                                        Swal.fire({
                                                            icon: 'warning',
                                                            title: 'Are you sure?',
                                                            text: "Do you really want to deactivate this account?",
                                                            showCancelButton: true,
                                                            confirmButtonText: 'Yes, deactivate it!',
                                                            cancelButtonText: 'No, cancel',
                                                            reverseButtons: true
                                                        }).then((result) => {
                                                            if (result.isConfirmed) {
                                                                const form = this.closest('form');
                                                                form.submit();
                                                            }
                                                        });
                                                    });
                                                });
                                            </script>
                                        </div>
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
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gyb3R2kW2vb5A/yq6pzZb5n3Qz9zDZvZgl6zdeGVJ5k/4fPjq2" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0oP4pL9p1yTL45o6uZ9VxAKp4a7lFvFscJ5FwY5UqBOfNfi6" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function() {
            $('#table').DataTable({
                "pageLength": 7
            });
        });
    </script>
</body>
</html>
