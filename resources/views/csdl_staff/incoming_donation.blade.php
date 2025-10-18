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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Admin Donations</title>
</head>
<style>
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
    /* Floating Card Styles */
     #floatingCard {
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
        width: 500px; /* Increased width for better content display */
        max-width: 90%;
        max-height: 80vh;
        overflow-y: auto;
        text-align: left; /* Changed to left alignment for better readability */
        animation: fadeIn 0.3s ease-in-out;
    }

    #floatingCard h3 {
        font-size: 1.5rem;
        font-weight: bold;
        color: #196f38;
        margin-bottom: 20px;
        text-align: center;
        border-bottom: 2px solid #eee;
        padding-bottom: 10px;
    }

    #floatingCard p {
        font-size: 1rem;
        color: #555;
        margin-bottom: 10px;
        text-align: left;
    }

    #floatingCard .close-card {
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 5px;
        cursor: pointer;
        margin-top: 20px;
        display: block;
        margin-left: auto;
        transition: background-color 0.3s ease;
    }

    #floatingCard .close-card:hover {
        background-color: #c82333;
    }

    #floatingCardOverlay {
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

    /* Remove the conflicting .floating-card and .overlay styles */
    .floating-card:not(#floatingCard),
    .overlay:not(#floatingCardOverlay) {
        display: none !important;
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
  .status-badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-weight: bold;
    }
    .status-pending {
        background-color: #ffc107;
        color: #000;
    }
    .status-approved {
        background-color: #28a745;
        color: #fff;
    }
    .status-rejected {
        background-color: #dc3545;
        color: #fff;
    }
    .status-claimed {
        background-color: #17a2b8;
        color: #fff;
    }
    .status-matched {
        background-color: #6f42c1;
        color: #fff;
    }
    .action-buttons {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }

    /* New styles for the enhanced table */
    .status-filter {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
        flex-wrap: wrap;
    }

    .status-btn {
        padding: 8px 20px;
        border-radius: 50px;
        font-weight: 500;
        transition: all 0.3s ease;
        border: 2px solid transparent;
    }

    .status-btn.active {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .btn-approved {
        background-color: #28a745;
        color: white;
    }

    .btn-pending {
        background-color: #ffc107;
        color: #000;
    }

    .btn-rejected {
        background-color: #dc3545;
        color: white;
    }

    .btn-claimed {
        background-color: #17a2b8;
        color: white;
    }

    .btn-matched {
        background-color: #6f42c1;
        color: white;
    }

    .btn-all {
        background-color: #6c757d;
        color: white;
    }

    .table-container {
        background-color: white;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
        padding: 20px;
        margin-bottom: 20px;
    }

    .table thead th {
        background-color: #196f38;
        color: white;
        font-weight: 600;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(25, 111, 56, 0.05);
    }

    .action-buttons {
        display: flex;
        gap: 5px;
        justify-content: center;
    }

    .btn-table {
        padding: 5px 10px;
        font-size: 0.875rem;
    }

    .view-details-btn {
        background-color: #17a2b8;
        border-color: #17a2b8;
        color: white;
    }

    .view-details-btn:hover {
        background-color: #138496;
        border-color: #117a8b;
        color: white;
    }
</style>
<body>
    <section>
        <div class="container-fluid">
            <div class="row">
                @include('csdl_staff.sidebar')
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

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3>Donation Management</h3>
                    </div>

                    <!-- Status Filter Buttons -->
                    <div class="status-filter">
                        <button class="status-btn btn-all active" data-status="all">All Donations</button>
                        <button class="status-btn btn-approved" data-status="approved">Approved</button>
                        <button class="status-btn btn-matched" data-status="matched">Matched</button>
                        <button class="status-btn btn-pending" data-status="pending">Pending</button>
                        <button class="status-btn btn-rejected" data-status="rejected">Rejected</button>
                        <button class="status-btn btn-claimed" data-status="claimed">Claimed</button>
                    </div>

                    <div class="table-container">
                        <div class="table-responsive mt-2">
                            <table class="table table-bordered table-hover" id="donationsTable">
                                <thead>
                                    <tr>
                                        <th>Donor</th>
                                        <th>Contact</th>
                                        <th>Category</th>
                                        <th>Type</th>
                                        <th>Quantity</th>
                                        <th>Available Date</th>
                                        <th>Donation Photo</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($donations as $donation)
                                    <tr data-status="{{ $donation->status }}">
                                        <td>{{ $donation->full_name }}</td>
                                        <td>{{ $donation->contact_number }}</td>
                                        <td>{{ ucfirst($donation->category) }}</td>
                                        <td>{{ $donation->wearable_type ?? 'N/A' }}</td>
                                        <td>{{ $donation->quantity }}</td>
                                        <td>{{ $donation->available_date ? \Carbon\Carbon::parse($donation->available_date)->format('M d, Y') : 'Flexible' }}</td>
                                        <td>
                                            @if($donation->donation_photo)
                                                @foreach(json_decode($donation->donation_photo) as $photo)
                                                    <img src="{{ asset('storage/' . $photo) }}" width="100" class="img-thumbnail">
                                                @endforeach
                                            @else
                                                No photo available
                                            @endif
                                        </td>
                                        <td>
                                            <span class="status-badge status-{{ strtolower($donation->status) }}">
                                                {{ ucfirst($donation->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <!-- View Details Button -->
                                                <button class="btn btn-table view-details-btn view-details"
                                                    data-full-name="{{ $donation->full_name }}"
                                                    data-contact="{{ $donation->contact_number }}"
                                                    data-location="{{ $donation->location }}"
                                                    data-category="{{ $donation->category }}"
                                                    data-subcategory="{{ $donation->subcategory }}"
                                                    data-wearable-type="{{ $donation->wearable_type ?? 'N/A' }}"
                                                    data-size="{{ $donation->size ?? 'N/A' }}"
                                                    data-quantity="{{ $donation->quantity }}"
                                                    data-condition="{{ $donation->condition }}"
                                                    data-notes="{{ $donation->notes ?? 'N/A' }}"
                                                    data-date="{{ $donation->available_date ? \Carbon\Carbon::parse($donation->available_date)->format('F j, Y') : 'Flexible' }}"
                                                    data-status="{{ $donation->status }}"
                                                    data-photo="{{ $donation->donation_photo }}"
                                                >
                                                    <i class="fas fa-eye"></i> View
                                                </button>

                                                <!-- Action Buttons -->
                                                @if($donation->status == 'pending')
                                                <div class="action-buttons">
                                                    <form action="{{ route('donations.update-status', $donation->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="approved">
                                                        <button type="submit" class="btn btn-success btn-table">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('donations.update-status', $donation->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="rejected">
                                                        <button type="submit" class="btn btn-danger btn-table">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                                @elseif(in_array($donation->status, ['approved', 'matched']))
                                                <div class="action-buttons">
                                                    <form action="{{ route('donations.update-status', $donation->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="status" value="claimed">
                                                        <button type="submit" class="btn btn-info btn-table">
                                                            <i class="fas fa-check-circle"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                                @endif
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

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gyb3R2kW2vb5A/yq6pzZb5n3Qz9zDZvZgl6zdeGVJ5k/4fPjq2" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0oP4pL9p1yTL45o6uZ9VxAKp4a7lFvFscJ5FwY5UqBOfNfi6" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
$(document).ready(function() {
    // Initialize DataTable
    var table = $('#donationsTable').DataTable({
        "pageLength": 5,
        "order": [[5, "desc"]], // Sort by available date by default
        "language": {
            "search": "Search donations:",
            "lengthMenu": "Show _MENU_ entries",
            "info": "Showing _START_ to _END_ of _TOTAL_ entries",
            "paginate": {
                "previous": "<i class='fas fa-chevron-left'></i>",
                "next": "<i class='fas fa-chevron-right'></i>"
            }
        }
    });

    // Status filter functionality - Corrected version
    $('.status-btn').on('click', function() {
        var status = $(this).data('status');

        // Update active button
        $('.status-btn').removeClass('active');
        $(this).addClass('active');

        if (status === 'all') {
            table.columns().search('').draw();
        } else {
            // Column 7 is the status column (zero-indexed)
            table.column(7).search(status, true, false).draw();
        }
    });


    // View Details Functionality
    $(document).on('click', '.view-details', function() {
        const fullName = $(this).data('full-name');
        const contact = $(this).data('contact');
        const location = $(this).data('location');
        const category = $(this).data('category');
        const subcategory = $(this).data('subcategory');
        const wearableType = $(this).data('wearable-type');
        const size = $(this).data('size');
        const quantity = $(this).data('quantity');
        const condition = $(this).data('condition');
        const notes = $(this).data('notes');
        const date = $(this).data('date');
        const status = $(this).data('status');
        const photo = $(this).data('photo');

        // Process photos
        let photoHtml = '';
        if (photo && photo !== 'N/A') {
            try {
                const photos = Array.isArray(photo) ? photo : JSON.parse(photo);
                photoHtml = photos.map(p =>
                    `<img src="/storage/${p}" class="img-fluid img-thumbnail m-2" style="max-height: 300px;">`
                ).join('');
            } catch (e) {
                console.error("Photo processing error:", e);
                photoHtml = '<p>Error loading photos</p>';
            }
        } else {
            photoHtml = '<p>No photo available</p>';
        }

        const cardContent = `
            <h3 class="text-center mb-4">Donation Details</h3>
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Donor Name:</strong> ${fullName}</p>
                    <p><strong>Contact Number:</strong> ${contact}</p>
                    <p><strong>Location:</strong> ${location}</p>
                    <p><strong>Status:</strong>
                        <span class="status-badge status-${status.toLowerCase()}">
                            ${status.charAt(0).toUpperCase() + status.slice(1)}
                        </span>
                    </p>
                </div>
                <div class="col-md-6">
                    <p><strong>Category:</strong> ${category.charAt(0).toUpperCase() + category.slice(1)}</p>
                    <p><strong>Subcategory:</strong> ${subcategory.charAt(0).toUpperCase() + subcategory.slice(1)}</p>
                    <p><strong>Type:</strong> ${wearableType}</p>
                    <p><strong>Size:</strong> ${size}</p>
                    <p><strong>Quantity:</strong> ${quantity}</p>
                    <p><strong>Condition:</strong> ${condition.charAt(0).toUpperCase() + condition.slice(1)}</p>
                    <p><strong>Available Date:</strong> ${date}</p>
                </div>
            </div>
            <hr>
            <h4 class="mb-3">Donation Photos</h4>
            <div class="d-flex flex-wrap justify-content-center">${photoHtml}</div>
            <hr>
            <h4 class="mb-3">Additional Notes</h4>
            <p>${notes}</p>
        `;

        $('#cardContent').html(cardContent);
        $('#floatingCard').show();
        $('#floatingCardOverlay').show();
    });

    // Close modal functionality
    $('#floatingCardOverlay, #floatingCard .close-card').on('click', function() {
        $('#floatingCard').hide();
        $('#floatingCardOverlay').hide();
    });

    // Prevent event propagation when clicking inside the modal
    $('#floatingCard').on('click', function(e) {
        e.stopPropagation();
    });

    // Status Update Confirmation
    $('form[action*="update-status"]').on('submit', function(e) {
        e.preventDefault();
        const status = $(this).find('input[name="status"]').val();
        let actionText = '';
        let confirmText = '';

        if (status === 'approved') {
            actionText = 'approve';
            confirmText = 'Approve this donation?';
        } else if (status === 'rejected') {
            actionText = 'reject';
            confirmText = 'Reject this donation?';
        } else if (status === 'claimed') {
            actionText = 'mark as claimed';
            confirmText = 'Mark this donation as claimed?';
        }

        Swal.fire({
            title: 'Confirm Donation Update',
            text: `Are you sure you want to ${actionText} this donation?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: `Yes, ${actionText} it!`
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
});
</script>
</body>
</html>
