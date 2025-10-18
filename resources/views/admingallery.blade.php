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
    <title>Admin Gallery</title>
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
        width: 200px;
        height: 200px;
        border-radius: 50%;
        margin-bottom: 10px;
        border: 4px solid #196f38;
        object-fit: cover;
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
        background-color: #145a2e;
    }

    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.6);
        z-index: 1040;
        display: none;
        animation: fadeIn 0.3s ease-in-out;
    }
    /* Elegant Top Donor Badge Styles */
    .top-donor-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background-color: #f5f0e1;
        color: #4a4a4a;
        border-radius: 15px;
        padding: 2px 8px;
        font-size: 0.75rem;
        margin-left: 8px;
        border: 1px solid #d4d0c5;
    }

    .top-donor-badge i {
        font-style: normal;
        font-weight: normal;
        margin-right: 4px;
        font-size: 0.8rem;
    }

    /* Fade-in animation */
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
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
                            let errorMessages = '';
                            @foreach ($errors->all() as $error)
                                errorMessages += `{{ $error }}\n`;
                            @endforeach

                            Swal.fire({
                                icon: 'error',
                                title: 'Oops... Something went wrong!',
                                text: errorMessages,
                                showConfirmButton: true
                            });
                        </script>
                    @endif

                    <div class="modal fade" id="addGalleryModal" tabindex="-1" aria-labelledby="addGalleryModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addGalleryModalLabel">Add New Gallery</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('gallerypost') }}" method="POST" enctype="multipart/form-data" id="addGalleryForm">
                                        @csrf
                                        <div class="mb-2">
                                            <label for="images" class="form-label">Images</label>
                                            {{-- ✅ ADDED 'required' ATTRIBUTE --}}
                                            <input type="file" class="form-control" id="images" name="images[]" multiple required>
                                        </div>
                                        <div class="mb-2">
                                            <label for="description" class="form-label">Description</label>
                                            <textarea class="form-control" id="description" name="description" rows="3" required maxlength="200"></textarea>
                                            <small id="charCount" class="form-text text-muted">200 characters remaining</small>
                                            <small id="descriptionError" class="text-danger" style="display: none;">Description must be less than 200 characters.</small>
                                        </div>
                                        <div class="mb-2">
                                            <label for="location" class="form-label">Location</label>
                                            <input type="text" class="form-control" id="location" name="location" required>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Add Gallery</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="containers">
                        <button class="btn mt-2 custom-btn" data-bs-toggle="modal" data-bs-target="#addGalleryModal">Add Gallery</button>
                        <div class="table-responsive mt-2">
                            <table class="table table-bordered" id="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Image</th>
                                        <th>Description</th>
                                        <th>Location</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($gallery as $item)
                                    <tr>
                                        <td class="bg-dark">
                                            @if (!empty($item->images) && is_array($item->images))
                                                <img src="{{ asset('storage/' . $item->images[0]) }}" alt="Gallery thumbnail" class="card-img-top" style="width: 50px; height: 50px; object-fit: cover;">
                                            @else
                                                <i class="fas fa-image text-white"></i>
                                            @endif
                                        </td>
                                        <td class="bg-dark text-white">{{ $item->description }}</td>
                                        <td class="bg-dark text-white">{{ $item->location }}</td>
                                        <td class="bg-dark text-white">
                                            <div class="d-flex justify-content-center align-items-center gap-2">
                                                <button class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editGalleryModal-{{ $item->id }}">Edit</button>
                                                <div class="modal fade" id="editGalleryModal-{{ $item->id }}" tabindex="-1" aria-labelledby="editGalleryModalLabel-{{ $item->id }}" aria-hidden="true">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="editGalleryModalLabel-{{ $item->id }}" style="color: #000000">Edit Gallery</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <form action="{{ route('galleryupdate', $item->id) }}" method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="text-start mb-2">
                                                                        <label for="images-{{$item->id}}" class="form-label" style="color: #000000">Images</label>
                                                                        <input type="file" class="form-control" id="images-{{$item->id}}" name="images[]" multiple>
                                                                        @if ($item->images)
                                                                            @foreach ($item->images as $image)
                                                                                <img src="{{ asset('storage/' . $image) }}" alt="Gallery Image" class="img-fluid mt-2" style="max-width: 150px;">
                                                                            @endforeach
                                                                        @endif
                                                                    </div>
                                                                    <div class="mb-2">
                                                                    <label for="description-{{ $item->id }}" class="form-label" style="color: #000000;">Description</label>
                                                                        <textarea class="form-control" id="description-{{ $item->id }}" name="description" rows="3" required>{{ $item->description }}</textarea>
                                                                        <div style="text-align: left;">
                                                                            <small id="charCount-{{ $item->id }}" class="form-text text-muted">200 characters remaining</small>
                                                                            <small id="descriptionError-{{ $item->id }}" class="text-danger" style="display: none;">Description must be less than 200 characters.</small>
                                                                        </div>
                                                                    </div>
                                                                    <div class="text-start mb-2">
                                                                        <label for="location-{{$item->id}}" class="form-label" style="color: #000000;">Location</label>
                                                                        <input type="text" class="form-control" id="location-{{$item->id}}" name="location" required value="{{ old('location', $item->location) }}">
                                                                    </div>
                                                                    <button type="submit" class="btn btn-primary">Update Gallery</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <form id="deleteForm-{{ $item->id }}" action="{{ route('deletegallery', $item->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger" onclick="confirmDelete({{ $item->id }})">Delete</button>
                                                </form>
                                                <script>
                                                    function confirmDelete(itemId) {
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
                                                                document.getElementById('deleteForm-' + itemId).submit();
                                                            }
                                                        });
                                                    }
                                                </script>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5">No data available in table</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
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
        });
    </script>
    <script>
        $(document).ready(function() {
            const maxLength = 200;

            function updateCounter(elementId) {
                const currentLength = $(elementId).val().length;
                const remaining = maxLength - currentLength;
                $(elementId.replace('description', 'charCount')).text(remaining + ' characters remaining');
                $(elementId.replace('description', 'descriptionError')).toggle(currentLength > maxLength);
            }

            function initCounter(elementId) {
                $(elementId)
                    .on('input', function() {
                        updateCounter(elementId);
                    })
                    .on('paste', function() {
                        setTimeout(function() {
                            updateCounter(elementId);
                        }, 0);
                    });
                updateCounter(elementId);
            }

            initCounter('#description');

            $('[id^="editGalleryModal-"]').on('shown.bs.modal', function() {
                const itemId = $(this).attr('id').replace('editGalleryModal-', '');
                initCounter(`#description-${itemId}`);
            });

            // ✅ MODIFIED FORM SUBMISSION HANDLING
            $('#addGalleryForm').on('submit', function(e) {
                // Check for description length
                const description = $('#description').val();
                if (description.length > maxLength) {
                    e.preventDefault(); // Stop submission
                    $('#descriptionError').show();
                    return false;
                }
                $('#descriptionError').hide();

                // Check if files are selected
                const images = $('#images').get(0).files.length;
                if (images === 0) {
                    e.preventDefault(); // Stop submission
                    Swal.fire({
                        icon: 'error',
                        title: 'No Images Selected',
                        text: 'Please select at least one image file to upload.',
                    });
                    return false;
                }

                return true; // Allow submission
            });

            $('form[action*="galleryupdate"]').on('submit', function(e) {
                const formId = $(this).closest('.modal').attr('id');
                const itemId = formId.replace('editGalleryModal-', '');
                const description = $(`#description-${itemId}`).val();
                if (description.length > maxLength) {
                    e.preventDefault();
                    $(`#descriptionError-${itemId}`).show();
                    return false;
                }
                $(`#descriptionError-${itemId}`).hide();
                return true;
            });
        });
    </script>
</body>
</html>
