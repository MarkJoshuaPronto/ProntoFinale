<!DOCTYPE html>
<html lang="en">
    @include('admin.header')
<head>
    <style>
        /* Improved table styling */
        .table th {
            background-color: #2e8b57;
            color: white;
            font-weight: 600;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(46, 139, 87, 0.1);
        }

        /* Status badges */
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 0.85rem;
        }
        .status-pending {
            background-color: #ffc107;
            color: #000;
        }
        .status-approved {
            background-color: #17a2b8;
            color: #fff;
        }
        .status-rejected {
            background-color: #dc3545;
            color: #fff;
        }
        .status-matched {
            background-color: #28a745;
            color: #fff;
        }
        .status-partially_matched {
            background-color: #fd7e14;
            color: #fff;
        }
        .status-fulfilled {
            background-color: #6f42c1;
            color: #fff;
        }

        /* Action buttons */
        .btn-action {
            padding: 0.25rem 0.5rem;
            font-size: 0.75rem;
            margin: 2px;
        }

        /* Match badges */
        .match-badge {
            background-color: #17a2b8;
            color: white;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 0.75rem;
            margin-left: 5px;
        }

        /* Compact table */
        .compact-table td, .compact-table th {
            padding: 0.5rem;
        }

        /* Progress bar for fulfillment */
        .progress {
            height: 8px;
            margin-bottom: 5px;
        }

        /* Truncate text */
        .text-truncate {
            max-width: 150px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Hover tooltip for truncated text */
        .text-truncate:hover {
            white-space: normal;
            overflow: visible;
            position: absolute;
            background: white;
            border: 1px solid #ddd;
            padding: 5px;
            z-index: 100;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            max-width: 300px;
        }
    </style>
</head>
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

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3><i class="fas fa-handshake"></i> Donations and Requests Fulfillment</h3>
                        <button class="btn btn-outline-primary" id="runAutoMatch">
                            <i class="fas fa-robot"></i> Run Auto-Matching
                        </button>
                    </div>

                    <div class="table-responsive mt-2">
                        <table class="table table-bordered table-hover compact-table" id="requestsTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Requester</th>
                                    <th>Contact</th>
                                    <th>Category</th>
                                    <th>Subcategory</th>
                                    <th>Size</th>
                                    <th>Quantity</th>
                                    <th>Progress</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($requests as $request)
                                @php
                                    $fulfilledQuantity = $request->quantity - ($request->remaining_quantity ?? $request->quantity);
                                    $progressPercentage = $request->quantity > 0 ? ($fulfilledQuantity / $request->quantity) * 100 : 0;
                                    $matches = $request->matches;
                                @endphp
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <strong>{{ $request->full_name }}</strong>
                                                <br>
                                                <!-- FIXED: Using PHP's native string functions instead of Str class -->
                                                <small class="text-muted">{{ strlen($request->address) > 25 ? substr($request->address, 0, 25) . '...' : $request->address }}</small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $request->contact_number }}</td>
                                    <td>{{ ucfirst($request->category) }}</td>
                                    <td>{{ ucfirst($request->subcategory) }}</td>
                                    <td>{{ $request->size ?? 'N/A' }}</td>
                                    <td>
                                        <strong>{{ $fulfilledQuantity }}/{{ $request->quantity }}</strong>
                                    </td>
                                    <td>
                                        <div class="progress">
                                            <div class="progress-bar
                                                @if($progressPercentage == 100) bg-success
                                                @elseif($progressPercentage > 0) bg-warning
                                                @else bg-secondary
                                                @endif"
                                                role="progressbar"
                                                style="width: {{ $progressPercentage }}%"
                                                aria-valuenow="{{ $progressPercentage }}"
                                                aria-valuemin="0"
                                                aria-valuemax="100">
                                            </div>
                                        </div>
                                        <small>{{ number_format($progressPercentage, 0) }}% fulfilled</small>
                                    </td>
                                    <td>
                                        <span class="status-badge status-{{ $request->status }}">
                                            {{ ucfirst($request->status) }}
                                        </span>
                                        @if($matches && $matches->count() > 0)
                                            <span class="match-badge" title="{{ $matches->count() }} matches">
                                                <i class="fas fa-link"></i> {{ $matches->count() }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex flex-wrap">
                                            <!-- View Details Button -->
                                            <button class="btn btn-info btn-action view-details"
                                                data-full-name="{{ $request->full_name }}"
                                                data-contact="{{ $request->contact_number }}"
                                                data-address="{{ $request->address }}"
                                                data-category="{{ $request->category }}"
                                                data-subcategory="{{ $request->subcategory }}"
                                                data-specific-items="{{ $request->specific_items ?? 'N/A' }}"
                                                data-specific-needs="{{ $request->specific_needs ?? 'N/A' }}"
                                                data-size="{{ $request->size ?? 'N/A' }}"
                                                data-quantity="{{ $request->quantity }}"
                                                data-fulfilled="{{ $fulfilledQuantity }}"
                                                data-condition="{{ $request->condition ?? 'N/A' }}"
                                                data-description="{{ $request->description }}"
                                                data-date="{{ $request->preferred_date ? \Carbon\Carbon::parse($request->preferred_date)->format('F j, Y') : 'Flexible' }}"
                                                data-status="{{ $request->status }}"
                                                data-id="{{ $request->id }}"
                                                data-matches="{{ $matches ? $matches->toJson() : '[]' }}"
                                                title="View Details"
                                            >
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            <!-- Action Buttons -->
                                            <!-- Action Buttons -->
@if($request->status == 'pending')
    <form action="{{ route('update-request-status', $request->id) }}" method="POST" class="d-inline">
        @csrf
        @method('PUT')
        <input type="hidden" name="status" value="approved">
        <button type="submit" class="btn btn-success btn-action" title="Approve">
            <i class="fas fa-check"></i>
        </button>
    </form>
    <form action="{{ route('update-request-status', $request->id) }}" method="POST" class="d-inline">
        @csrf
        @method('PUT')
        <input type="hidden" name="status" value="rejected">
        <button type="submit" class="btn btn-danger btn-action" title="Reject">
            <i class="fas fa-times"></i>
        </button>
    </form>
@endif

@if(in_array($request->status, ['approved', 'partially_matched']))
    @php
        $remainingQty = $request->quantity - $fulfilledQuantity;
        $canMatch = $remainingQty > 0;
    @endphp
    <button class="btn btn-primary btn-action match-donation {{ !$canMatch ? 'disabled' : '' }}"
        data-request-id="{{ $request->id }}"
        data-category="{{ $request->category }}"
        data-subcategory="{{ $request->subcategory }}"
        data-quantity="{{ $remainingQty }}"
        {{ !$canMatch ? 'disabled' : '' }}
        title="{{ $canMatch ? 'Match with Donation' : 'No quantity needed' }}">
        <i class="fas fa-link"></i>
    </button>
@endif

@if($request->status == 'partially_matched' || $request->status == 'matched')
    <button class="btn btn-info btn-action view-matches"
        data-request-id="{{ $request->id }}"
        title="View Matches">
        <i class="fas fa-list"></i>
    </button>
@endif
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- View Details Floating Card -->
                    <div id="floatingCard" class="floating-card">
                        <div id="cardContent"></div>
                        <button class="btn btn-sm btn-danger close-card">Close</button>
                    </div>
                    <div id="floatingCardOverlay" class="floating-card-overlay"></div>

                    <!-- Donation Matching Modal -->
                    <div class="modal fade" id="donationMatchModal" tabindex="-1" aria-labelledby="donationMatchModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="donationMatchModalLabel">Match Request with Donations</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h6>Request Details:</h6>
                                    <div id="requestDetails"></div>
                                    <hr>
                                    <h6>Available Donations:</h6>
                                    <div id="donationList"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="confirmMatch">Confirm Match</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- View Matches Modal -->
                    <div class="modal fade" id="viewMatchesModal" tabindex="-1" aria-labelledby="viewMatchesModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="viewMatchesModalLabel">Donation Matches</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <h6>Request Details:</h6>
                                    <div id="requestMatchesDetails"></div>
                                    <hr>
                                    <h6>Matched Donations:</h6>
                                    <div id="matchedDonationsList"></div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
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

    <script>
    $(document).ready(function() {
        // Initialize DataTable with better options
        $('#requestsTable').DataTable({
            "pageLength": 10,
            "order": [[0, "asc"]],
            "responsive": true,
            "autoWidth": false,
            "language": {
                "search": "Filter:",
                "lengthMenu": "Show _MENU_ entries",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "paginate": {
                    "previous": "←",
                    "next": "→"
                }
            },
            "columnDefs": [
                { "orderable": false, "targets": [8] }, // Disable sorting on actions column
                { "width": "15%", "targets": [0, 8] }, // Set width for specific columns
                { "width": "10%", "targets": [1, 2, 3, 4, 5, 6, 7] }
            ]
        });


        // Run auto-matching for all approved requests
// Update the runAutoMatching function in your Blade template
        $('#runAutoMatch').click(function() {
            Swal.fire({
                title: 'Run Auto-Matching?',
                text: 'This will attempt to match all approved requests with available donations',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, run it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Matching requests with donations',
                        allowOutsideClick: false,
                        didOpen: () => { Swal.showLoading(); }
                    });

                    // Use the correct route
                    $.ajax({
                        url: '{{ route("run-auto-matching") }}',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.close();
                            if (response.success) {
                                Swal.fire({
                                    title: 'Success',
                                    text: response.message,
                                    icon: 'success',
                                    showCancelButton: false,
                                    confirmButtonText: 'Refresh Page'
                                }).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire('Info', response.message, 'info');
                            }
                        },
                        error: function(xhr) {
                            Swal.close();
                            let errorMessage = 'An error occurred during auto-matching';

                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            }

                            Swal.fire('Error', errorMessage, 'error');
                        }
                    });
                }
            });
        });

        // View Details Functionality
        const viewButtons = document.querySelectorAll('.view-details');
        const floatingCard = document.getElementById('floatingCard');
        const overlay = document.getElementById('floatingCardOverlay');
        const cardContent = document.getElementById('cardContent');

        viewButtons.forEach(button => {
            button.addEventListener('click', function() {
                const fullName = this.getAttribute('data-full-name');
                const contact = this.getAttribute('data-contact');
                const address = this.getAttribute('data-address');
                const category = this.getAttribute('data-category');
                const subcategory = this.getAttribute('data-subcategory');
                const specificItems = this.getAttribute('data-specific-items');
                const specificNeeds = this.getAttribute('data-specific-needs');
                const size = this.getAttribute('data-size');
                const quantity = this.getAttribute('data-quantity');
                const fulfilled = this.getAttribute('data-fulfilled');
                const condition = this.getAttribute('data-condition');
                const description = this.getAttribute('data-description');
                const date = this.getAttribute('data-date');
                const status = this.getAttribute('data-status');
                const requestId = this.getAttribute('data-id');
                const matchesJson = this.getAttribute('data-matches');
                const matches = matchesJson ? JSON.parse(matchesJson) : [];
                console.log(matches); // Inspect the matches data in the console

                // Build the details content
                let specificDetails = '';
                if (category === 'food') {
                    specificDetails = `<p><strong>Specific Items:</strong> ${specificItems}</p>`;
                } else if (category === 'medical') {
                    specificDetails = `<p><strong>Specific Needs:</strong> ${specificNeeds}</p>`;
                } else if (category === 'wearable') {
                    specificDetails = `<p><strong>Condition Preference:</strong> ${condition}</p>`;
                }

                // Build matches section if any
                let matchesHtml = '';
                if (matches.length > 0) {
                    matchesHtml = `<hr><h5>Matched Donations:</h5><div class="list-group mt-3">`;
                    matches.forEach(match => {
                        // Check if match.donation exists before trying to access its properties
                        if (match.donation) {
                            matchesHtml += `
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <strong>${match.donation.full_name}</strong>
                                            <p class="mb-1">Allocated: ${match.allocated_quantity} items</p>
                                            <small>Contact: ${match.donation.contact_number}</small>
                                        </div>
                                        <span class="badge bg-success" style="height: fit-content;">${match.status}</span>
                                    </div>
                                </div>
                            `;
                        } else {
                            // Handle the case where match.donation is undefined
                            matchesHtml += `
                                <div class="list-group-item">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <strong>Unknown Donor</strong>
                                            <p class="mb-1">Allocated: ${match.allocated_quantity} items</p>
                                            <small>No contact information available</small>
                                        </div>
                                        <span class="badge bg-success" style="height: fit-content;">${match.status}</span>
                                    </div>
                                </div>
                            `;
                        }
                    });
                    matchesHtml += `</div>`;
                }


                cardContent.innerHTML = `
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
                            <p><strong>Size:</strong> ${size}</p>
                            <p><strong>Quantity:</strong> ${fulfilled} of ${quantity} fulfilled</p>
                            <p><strong>Preferred Date:</strong> ${date}</p>
                        </div>
                    </div>
                    <hr>
                    <h5>Description</h5>
                    <p>${description}</p>
                    ${matchesHtml}
                `;
                floatingCard.classList.add('show');
                overlay.classList.add('show');
            });
        });

        overlay.addEventListener('click', function() {
            floatingCard.classList.remove('show');
            overlay.classList.remove('show');
        });

        document.querySelector('.close-card').addEventListener('click', function() {
            floatingCard.classList.remove('show');
            overlay.classList.remove('show');
        });

        // View matches functionality
        $(document).on('click', '.view-matches', function() {
            const requestId = $(this).data('request-id');

            // Use the correct route for getting matches
            $.get(`/admin/recipient-requests/${requestId}/matches`, function(data) {
                $('#requestMatchesDetails').html(`
                    <p><strong>Requester:</strong> ${data.request.full_name}</p>
                    <p><strong>Contact:</strong> ${data.request.contact_number}</p>
                    <p><strong>Total Quantity:</strong> ${data.request.quantity}</p>
                    <p><strong>Fulfilled Quantity:</strong> ${data.request.quantity - (data.request.remaining_quantity || 0)}</p>
                    <p><strong>Remaining Quantity:</strong> ${data.request.remaining_quantity || 0}</p>
                `);

                if (data.matches.length > 0) {
                    let matchesHtml = '<div class="list-group">';
                    data.matches.forEach(match => {
                        matchesHtml += `
                            <div class="list-group-item">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <h6 class="mb-1">${match.donation.full_name}</h6>
                                        <p class="mb-1"><strong>Allocated Quantity:</strong> ${match.allocated_quantity}</p>
                                        <p class="mb-1"><strong>Contact:</strong> ${match.donation.contact_number}</p>
                                        <p class="mb-1"><strong>Location:</strong> ${match.donation.location}</p>
                                        <small class="text-muted">Matched on: ${new Date(match.created_at).toLocaleDateString()}</small>
                                    </div>
                                    <span class="badge bg-${match.status === 'approved' ? 'success' : 'warning'}">${match.status}</span>
                                </div>
                            </div>
                        `;
                    });
                    matchesHtml += '</div>';
                    $('#matchedDonationsList').html(matchesHtml);
                } else {
                    $('#matchedDonationsList').html('<p class="text-center">No matches found for this request.</p>');
                }

                $('#viewMatchesModal').modal('show');
            });
        });

        // Update match donation modal to handle partial fulfillment
        $(document).on('click', '.match-donation', function() {
            const requestId = $(this).data('request-id');
            const category = $(this).data('category');
            const subcategory = $(this).data('subcategory');
            const neededQuantity = $(this).data('quantity');

            // Check if there's actually quantity needed
            if (neededQuantity <= 0) {
                Swal.fire('Info', 'This request has no remaining quantity to match.', 'info');
                return;
            }
            // Load request details
            $.get(`/admin/recipient-requests/${requestId}`, function(request) {
                $('#requestDetails').html(`
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Requester:</strong> ${request.full_name}</p>
                            <p><strong>Contact:</strong> ${request.contact_number}</p>
                            <p><strong>Address:</strong> ${request.address}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Category:</strong> ${request.category}</p>
                            <p><strong>Subcategory:</strong> ${request.subcategory}</p>
                            <p><strong>Quantity Needed:</strong> ${neededQuantity} (of ${request.quantity} total)</p>
                            <p><strong>Size:</strong> ${request.size || 'N/A'}</p>
                        </div>
                    </div>
                    <input type="hidden" id="requestId" value="${request.id}">
                    <input type="hidden" id="neededQuantity" value="${neededQuantity}">
                `);

                // Load matching donations
                $.get(`/admin/donations/matching?category=${category}&subcategory=${subcategory}&request_id=${requestId}`, function(donations) {
                    if (donations.length > 0) {
                        let donationListHtml = '<div class="list-group">';
                        donations.forEach(donation => {
                            donationListHtml += `
                                <div class="donation-item list-group-item" data-donation-id="${donation.id}" data-available-quantity="${donation.available_quantity}">
                                    <div class="form-check">
                                        <input class="form-check-input donation-checkbox" type="radio" name="selectedDonation"
                                            id="donation-${donation.id}" value="${donation.id}">
                                        <label class="form-check-label" for="donation-${donation.id}">
                                            <strong>${donation.full_name}</strong>
                                            (${donation.available_quantity} available)
                                        </label>
                                    </div>
                                    <div class="donation-details ms-3 mt-2">
                                        <p class="mb-1"><strong>Contact:</strong> ${donation.contact_number}</p>
                                        <p class="mb-1"><strong>Location:</strong> ${donation.location}</p>
                                        <p class="mb-1"><strong>Available Date:</strong> ${new Date(donation.available_date).toLocaleDateString()}</p>
                                        ${donation.notes ? `<p class="mb-1"><strong>Notes:</strong> ${donation.notes}</p>` : ''}
                                    </div>
                                </div>
                            `;
                        });
                        donationListHtml += '</div>';
                        $('#donationList').html(donationListHtml);
                        $('#confirmMatch').prop('disabled', false);
                    } else {
                        $('#donationList').html('<p class="text-center text-muted">No matching donations found for this request.</p>');
                        $('#confirmMatch').prop('disabled', true);
                    }
                });

                $('#donationMatchModal').modal('show');
            });
        });

        // Update confirm match to handle quantity allocation
        $('#confirmMatch').click(function() {
            const requestId = $('#requestId').val();
            const neededQuantity = parseInt($('#neededQuantity').val());
            const donationId = $('input[name="selectedDonation"]:checked').val();
            const donationElement = $(`[data-donation-id="${donationId}"]`);
            const availableQuantity = parseInt(donationElement.data('available-quantity'));

            if (!donationId) {
                Swal.fire('Error', 'Please select a donation to match with this request', 'error');
                return;
            }

            // Determine how much to allocate
            const allocateQuantity = Math.min(neededQuantity, availableQuantity);

            Swal.fire({
                title: 'Confirm Quantity Allocation',
                html: `This donation has ${availableQuantity} items available.<br>
                      The request needs ${neededQuantity} more items.<br><br>
                      How many items would you like to allocate?`,
                input: 'number',
                inputValue: allocateQuantity,
                inputAttributes: {
                    min: 1,
                    max: Math.min(availableQuantity, neededQuantity),
                    step: 1
                },
                showCancelButton: true,
                confirmButtonText: 'Allocate',
                preConfirm: (quantity) => {
                    if (!quantity || quantity <= 0) {
                        Swal.showValidationMessage('Please enter a valid quantity');
                    } else if (quantity > availableQuantity) {
                        Swal.showValidationMessage(`Cannot allocate more than available (${availableQuantity})`);
                    } else if (quantity > neededQuantity) {
                        Swal.showValidationMessage(`Request only needs ${neededQuantity} more items`);
                    }
                    return quantity;
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const allocatedQuantity = result.value;

                    // Show loading indicator
                    Swal.fire({
                        title: 'Processing...',
                        text: 'Matching request with donation',
                        allowOutsideClick: false,
                        didOpen: () => { Swal.showLoading(); }
                    });

                    // Use the correct route for matching
                    $.ajax({
                        url: '/admin/match-request',
                        method: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            request_id: requestId,
                            donation_id: donationId,
                            allocated_quantity: allocatedQuantity
                        },
                        success: function(response) {
                            Swal.close();
                            Swal.fire('Success', 'Request successfully matched with donation', 'success')
                                .then(() => { location.reload(); });
                        },
                        error: function(xhr) {
                            Swal.close();
                            let errorMessage = 'An error occurred while processing your request';

                            if (xhr.responseJSON && xhr.responseJSON.message) {
                                errorMessage = xhr.responseJSON.message;
                            } else if (xhr.status === 500) {
                                errorMessage = 'Internal server error. Please try again later.';
                            }

                            Swal.fire('Error', errorMessage, 'error');
                        }
                    });
                }
            });
        });

        // Highlight selected donation
        $(document).on('change', '.donation-checkbox', function() {
            $('.donation-item').removeClass('selected');
            $(this).closest('.donation-item').addClass('selected');
        });
    });
    </script>

    <script>
        $(document).ready(function() {
    // Check auto-matching availability on page load
    checkAutoMatchingAvailability();

    // Function to check if auto-matching is available
    function checkAutoMatchingAvailability() {
        $.get('/admin/check-auto-matching-availability', function(response) {
            if (response.available) {
                $('#runAutoMatch').prop('disabled', false);
                $('#runAutoMatch').attr('title', response.message);
            } else {
                $('#runAutoMatch').prop('disabled', true);
                $('#runAutoMatch').attr('title', response.message + ' - Auto-matching unavailable');
                $('#runAutoMatch').addClass('btn-outline-secondary').removeClass('btn-outline-primary');
            }
        }).fail(function() {
            $('#runAutoMatch').prop('disabled', false);
            $('#runAutoMatch').attr('title', 'Unable to check availability - proceed with caution');
        });
    }

    // Run auto-matching for all approved requests
    $('#runAutoMatch').click(function() {
        if ($(this).prop('disabled')) {
            Swal.fire({
                title: 'Auto-Matching Unavailable',
                text: $(this).attr('title'),
                icon: 'warning',
                confirmButtonText: 'OK'
            });
            return;
        }

        Swal.fire({
            title: 'Run Auto-Matching?',
            html: 'This will attempt to match all approved requests with available donations.<br><br>' +
                  '<strong>Note:</strong> Matching depends on:<br>' +
                  '• Category/Subcategory compatibility<br>' +
                  '• Condition requirements<br>' +
                  '• Available quantities<br>' +
                  '• Size compatibility (for wearables)',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Yes, run it!',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#2e8b57'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Processing Auto-Matching...',
                    html: 'Matching requests with available donations<br><br>' +
                          '<small>This may take a few moments</small>',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                // Use the correct route
                $.ajax({
                    url: '{{ route("run-auto-matching") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        Swal.close();

                        if (response.success) {
                            if (response.matched) {
                                Swal.fire({
                                    title: 'Auto-Matching Complete!',
                                    html: response.message,
                                    icon: 'success',
                                    showCancelButton: true,
                                    confirmButtonText: 'Refresh Page',
                                    cancelButtonText: 'View Details',
                                    confirmButtonColor: '#2e8b57'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    } else {
                                        // Show detailed results
                                        showDetailedResults(response.details);
                                    }
                                });
                            } else {
                                Swal.fire({
                                    title: 'No Matches Found',
                                    html: response.message,
                                    icon: 'info',
                                    confirmButtonText: 'OK',
                                    confirmButtonColor: '#17a2b8'
                                });
                            }
                        } else {
                            Swal.fire('Error', response.message, 'error');
                        }

                        // Re-check availability after matching
                        checkAutoMatchingAvailability();
                    },
                    error: function(xhr) {
                        Swal.close();
                        let errorMessage = 'An error occurred during auto-matching';

                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }

                        Swal.fire('Error', errorMessage, 'error');
                    }
                });
            }
        });
    });

    // Function to show detailed matching results
    function showDetailedResults(details) {
        let resultsHtml = `
            <div class="text-start">
                <h6>Matching Summary:</h6>
                <p><strong>Total Requests:</strong> ${details.total_requests}</p>
                <p><strong>Matched Requests:</strong> ${details.matched_requests}</p>
                <p><strong>Total Matches:</strong> ${details.total_matches}</p>

                <h6 class="mt-3">Request Details:</h6>
                <div style="max-height: 300px; overflow-y: auto;">
        `;

        details.results.forEach(result => {
            const statusIcon = result.matches_found > 0 ? '✅' : '❌';
            resultsHtml += `
                <div class="border-bottom py-2">
                    <strong>${statusIcon} Request #${result.request_id}</strong><br>
                    <small>${result.category} / ${result.subcategory}</small><br>
                    <small>Matches: ${result.matches_found} | Remaining: ${result.remaining_quantity}</small><br>
                    <small class="text-muted">${result.status}</small>
                </div>
            `;
        });

        resultsHtml += `
                </div>
            </div>
        `;

        Swal.fire({
            title: 'Detailed Results',
            html: resultsHtml,
            width: 600,
            confirmButtonText: 'Refresh Page',
            confirmButtonColor: '#2e8b57'
        }).then(() => {
            location.reload();
        });
    }
});
    </script>
</body>
</html>
