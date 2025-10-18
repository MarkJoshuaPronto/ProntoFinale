<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" type="image/png" href="{{ asset('faviconlogo.png') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Recipient Requests</title>
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
       #floatingCard {
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
        overflow-y: auto;
        max-height: 80vh;
    }

    #floatingCard h3 {
        font-size: 1.5em;
        margin-bottom: 20px;
        color: #007bff;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }

    #floatingCard p {
        margin-bottom: 15px;
    }

    #floatingCard .close-card {
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
        z-index: 999;
        display: none;
        backdrop-filter: blur(5px);
    }

    /* Remove the class-based styles that might conflict */
    .floating-card:not(#floatingCard),
    .floating-card-overlay:not(#floatingCardOverlay) {
        display: none !important;
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
        padding-right: 15px;
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
    .status-matched {
        background-color: #6f42c1;
        color: #fff;
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
                                text: "Password doesn't match!",
                                showConfirmButton: true,
                                timer: 3000
                            });
                        </script>
                    @endif

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3>Recipient Requests</h3>
                    </div>

                    <!-- Status Filter Buttons -->
                    <div class="status-filter">
                        <button class="status-btn btn-all active" data-status="all">All Requests</button>
                        <button class="status-btn btn-approved" data-status="approved">Approved</button>
                        <button class="status-btn btn-matched" data-status="matched">Matched</button>
                        <button class="status-btn btn-pending" data-status="pending">Pending</button>
                        <button class="status-btn btn-rejected" data-status="rejected">Rejected</button>
                    </div>

                    <div class="table-container">
                        <div class="table-responsive mt-2">
                            <table class="table table-bordered table-hover" id="requestsTable">
                                <thead>
                                    <tr>
                                        <th>Requester</th>
                                        <th>Contact</th>
                                        <th>Category</th>
                                        <th>Quantity</th>
                                        <th>Preferred Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($requests as $request)
                                    <tr data-status="{{ $request->status }}">
                                        <td>{{ $request->full_name }}</td>
                                        <td>{{ $request->contact_number }}</td>
                                        <td>{{ ucfirst($request->category) }}</td>
                                        <td>{{ $request->quantity }}</td>
                                        <td>{{ $request->preferred_date ? \Carbon\Carbon::parse($request->preferred_date)->format('M d, Y') : 'Flexible' }}</td>
                                        <td>
                                            <span class="status-badge status-{{ $request->status }}">
                                                {{ ucfirst($request->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <!-- View Details Button -->
                                                <button class="btn btn-table view-details-btn view-details"
                                                    data-full-name="{{ $request->full_name }}"
                                                    data-contact="{{ $request->contact_number }}"
                                                    data-address="{{ $request->address }}"
                                                    data-category="{{ $request->category }}"
                                                    data-subcategory="{{ $request->subcategory }}"
                                                    data-specific-items="{{ $request->specific_items ?? 'N/A' }}"
                                                    data-specific-needs="{{ $request->specific_needs ?? 'N/A' }}"
                                                    data-size="{{ $request->size ?? 'N/A' }}"
                                                    data-quantity="{{ $request->quantity }}"
                                                    data-condition="{{ $request->condition ?? 'N/A' }}"
                                                    data-description="{{ $request->description }}"
                                                    data-date="{{ $request->preferred_date ? \Carbon\Carbon::parse($request->preferred_date)->format('F j, Y') : 'Flexible' }}"
                                                    data-status="{{ $request->status }}"
                                                >
                                                    <i class="fas fa-eye"></i> View
                                                </button>

                                                <!-- Action Buttons -->
                                                @if($request->status == 'pending')
                                                <form action="{{ route('update-request-status', $request->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="approved">
                                                    <button type="submit" class="btn btn-success btn-table">
                                                        <i class="fas fa-check"></i>
                                                    </button>
                                                </form>
                                                <form action="{{ route('update-request-status', $request->id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" name="status" value="rejected">
                                                    <button type="submit" class="btn btn-danger btn-table">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

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


    <script>
    $(document).ready(function() {
        // Initialize DataTable
        var table = $('#requestsTable').DataTable({
            "pageLength": 5,
            "order": [[4, "desc"]], // Changed from 5 to 4 since we removed a column
            "language": {
                "search": "Search requests:",
                "lengthMenu": "Show _MENU_ entries",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "paginate": {
                    "previous": "<i class='fas fa-chevron-left'></i>",
                    "next": "<i class='fas fa-chevron-right'></i>"
                }
            }
        });


        // Status filter functionality
        $('.status-btn').on('click', function() {
            var status = $(this).data('status');

            // Update active button
            $('.status-btn').removeClass('active');
            $(this).addClass('active');

            if (status === 'all') {
                table.search('').columns().search('').draw();
            } else {
                // Clear any previous search
                table.search('');

                // Filter the status column (column index 5 now) for the status value
                table.column(5).search(status, true, false).draw();
            }
        });

        // View Details Functionality - Fixed using jQuery
        $(document).on('click', '.view-details', function() {
            console.log('View details button clicked'); // Debug

            const fullName = $(this).data('full-name');
            const contact = $(this).data('contact');
            const address = $(this).data('address');
            const category = $(this).data('category');
            const subcategory = $(this).data('subcategory');
            const specificItems = $(this).data('specific-items');
            const specificNeeds = $(this).data('specific-needs');
            const size = $(this).data('size');
            const quantity = $(this).data('quantity');
            const condition = $(this).data('condition');
            const description = $(this).data('description');
            const date = $(this).data('date');
            const status = $(this).data('status');

            console.log('Data extracted:', fullName); // Debug

            // Build the details content based on category
            let specificDetails = '';
            if (category === 'food') {
                specificDetails = `<p><strong>Specific Items:</strong> ${specificItems}</p>`;
            } else if (category === 'medical') {
                specificDetails = `<p><strong>Specific Needs:</strong> ${specificNeeds}</p>`;
            } else if (category === 'wearable') {
                specificDetails = `<p><strong>Condition Preference:</strong> ${condition}</p><p><strong>Size:</strong> ${size}</p>`;
            }

            const cardContent = `
                <h3 class="text-center mb-4">Request Details</h3>
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>Requester Name:</strong> ${fullName}</p>
                        <p><strong>Contact Number:</strong> ${contact}</p>
                        <p><strong>Address:</strong> ${address}</p>
                        <p><strong>Status:</strong>
                            <span class="status-badge status-${status}">
                                ${status.charAt(0).toUpperCase() + status.slice(1)}
                            </span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Category:</strong> ${category.charAt(0).toUpperCase() + category.slice(1)}</p>
                        <p><strong>Subcategory:</strong> ${subcategory.charAt(0).toUpperCase() + subcategory.slice(1)}</p>
                        ${specificDetails}
                        <p><strong>Quantity:</strong> ${quantity}</p>
                        <p><strong>Preferred Date:</strong> ${date}</p>
                    </div>
                </div>
                <hr>
                <h4 class="mb-3">Description</h4>
                <p>${description}</p>
            `;

            $('#cardContent').html(cardContent);
            $('#floatingCard').show();
            $('#floatingCardOverlay').show();

            console.log('Modal should be visible now'); // Debug
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
        $('form[action*="update-request-status"]').on('submit', function(e) {
            e.preventDefault();
            const status = $(this).find('input[name="status"]').val();
            const action = status === 'approved' ? 'approve' : 'reject';

            Swal.fire({
                title: 'Confirm Request Update',
                text: `Are you sure you want to ${action} this request?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: `Yes, ${action} it!`
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
