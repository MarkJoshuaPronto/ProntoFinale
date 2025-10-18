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
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Admin Accepted Activation Request</title>
</head>
<style>
    /* Green sidebar styling */
    .sidebar {
        background: linear-gradient(to bottom, #1a4720, #2e8b57);
        padding-top: 20px;
        display: flex;
        flex-direction: column;
        height: auto;
        box-shadow: 3px 0 10px rgba(0, 0, 0, 0.2);
    }
    .sidebar a {
        padding: 12px 20px;
        text-decoration: none;
        color: #ffffff;
        display: block;
        transition: all 0.3s ease;
        border-left: 4px solid transparent;
        margin: 5px 10px;
        border-radius: 5px;
    }
    .sidebar a:hover {
        background-color: rgba(255, 255, 255, 0.15);
        color: white;
        border-left: 4px solid #ffd000;
        transform: translateX(5px);
    }
    .sidebar a i {
        margin-right: 10px;
        width: 20px;
        text-align: center;
    }

    /* Badge styling for sidebar */
    .sidebar .badge {
        float: right;
        font-size: 0.7rem;
        padding: 3px 6px;
    }

    /* Dropdown styling */
    .dropdown-menu {
        border: none;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        border-radius: 8px;
        overflow: hidden;
        background-color: #2e8b57;
    }
    .dropdown-item {
        padding: 10px 15px;
        transition: all 0.2s ease;
        color: white;
    }
    .dropdown-item:hover {
        background-color: rgba(255, 255, 255, 0.15);
        color: white;
    }
    .dropdown-divider {
        border-top: 1px solid rgba(255, 255, 255, 0.2);
    }

    /* Dropdown toggle styling */
    .dropdown-toggle {
        position: relative;
    }
    .dropdown-toggle::after {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
    }

    /* User profile section in sidebar */
    .user-profile {
        background-color: rgba(0, 0, 0, 0.2);
        border-radius: 10px;
        margin: 10px;
        padding: 15px;
        text-align: center;
        color: white;
    }

    /* Rest of your existing styles */
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
    .proj{
        margin-top: 5%;
    }
    .card{
        border: 2px solid black;
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
        background-color: #dc3545;
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
    /* Floating Card Styles */
    .floating-card {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1050;
        display: none;
        background-color: white;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        width: 350px;
        text-align: center;
        animation: fadeIn 0.3s ease-in-out;
    }

    .floating-card img {
        width: 200x; /* Increased image size */
        height: 200px; /* Increased image size */
        border-radius: 50%;
        margin-bottom: 10px;
        border: 4px solid #196f38; /* Added border for elegance */
        object-fit: cover; /* Ensures the image fits well */
    }

    .floating-card h5 {
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
    }

    .floating-card p {
        font-size: 1rem;
        color: #555;
        margin-bottom: 8px;
        text-align: justify;
    }

    .floating-card button {
        background-color: #196f38;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 1rem;
        transition: background-color 0.3s ease;
    }

    .floating-card button:hover {
        background-color: #145a2e; /* Darker shade on hover */
    }

    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6); /* Darker overlay for better contrast */
        z-index: 1040;
        display: none;
        animation: fadeIn 0.3s ease-in-out;
    }
    /* Elegant Top Donor Badge Styles */
    .top-donor-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background-color: #f5f0e1; /* Soft, Creamy Gold */
        color: #4a4a4a; /* Dark Gray for text/icon */
        border-radius: 15px; /* Pill-shaped for softer look */
        padding: 2px 8px; /* Reduced padding for smaller badge */
        font-size: 0.75rem;
        margin-left: 8px; /* Slightly increased spacing */
        /* subtle border instead of shadow */
        border: 1px solid #d4d0c5;
    }

    .top-donor-badge i {
        font-style: normal;
        font-weight: normal; /* Regular weight for elegance */
        margin-right: 4px; /* Space between icon and text */
        font-size: 0.8rem; /* Slightly larger icon */
    }

    /* Fade-in animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    /* Additional styles for gallery page */
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
</style>
<body>
    <section>
        <div class="container-fluid">
            <div class="row">
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
                                text: "Password doesn't match!",
                                showConfirmButton: true,
                                timer: 3000
                            });
                        </script>
                    @endif
                    <div class="containers">
                        <div class="modal fade" id="addRequestModal" tabindex="-1" aria-labelledby="addRequestModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h5 class="modal-title" id="addRequestModalLabel">Add New Request for Help</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                <form action="{{route('addinneed')}}" method="POST" enctype="multipart/form-data">
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
                                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
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
                        <div class="d-flex gap-2 mb-3">
                            <a href="{{route('activationrequest')}}" class="btn btn-warning">Pending</a>
                            <a href="{{route('activationrequestcompleted')}}" class="btn btn-success">Completed</a>
                        </div>
                        <div class="table-responsive mt-2">
                            <table class="table table-bordered" id="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($activationrequest as $request)
                                    <tr class="bg-dark">
                                        <td class="bg-dark text-white">{{$request->name}}</td>
                                        <td class="bg-dark text-white">{{$request->email}}</td>
                                        <td class="bg-dark text-white">{{$request->address}}</td>
                                        <td class="bg-dark text-white">
                                            @if($request->status == 'pending')
                                                <span class="badge badge-pill bg-warning">Pending</span>
                                            @else
                                            <span class="badge badge-pill bg-success">Completed</span>
                                            @endif
                                        </td>
                                        <td class="bg-dark text-white">
                                            <form action="{{ route('deletesupport', $request->id) }}" method="POST" id="deleteForm-{{ $request->id }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-danger deleteButton" data-id="{{ $request->id }}">Delete</button>
                                            </form>
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
                   "pageLength": 9
               });
           });
    </script>
    <script>
        // Delete button functionality
        document.querySelectorAll('.deleteButton').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const requestId = this.getAttribute('data-id');

                Swal.fire({
                    title: 'Are you sure?',
                    text: "This action cannot be undone!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Submit the form
                        document.getElementById('deleteForm-' + requestId).submit();
                    }
                });
            });
        });
    </script>
</body>
</html>
