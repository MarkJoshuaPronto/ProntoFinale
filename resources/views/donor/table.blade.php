<div class="col-md-10 main-content">
    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: '{{ session('success') }}',
                    showConfirmButton: true,
                    timer: 3000
                });
            });
        </script>
    @endif
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: "{{ $errors->first() }}",
                    showConfirmButton: true,
                    timer: 3000
                });
            });
        </script>
    @endif
    <div class="container">
        <div class="table-responsive">
            <table class="table table-hover" id="donationsTable">
                <thead class="table-dark">
                    <tr>
                        <th><i class="fas fa-hashtag me-1"></i>ID</th>
                        <th><i class="fas fa-folder me-1"></i>Category</th>
                        <th><i class="fas fa-tag me-1"></i>Subcategory</th>
                        <th><i class="fas fa-info-circle me-1"></i>Details</th>
                        <th class="text-center"><i class="fas fa-image me-1"></i>Photo</th>
                        <th><i class="fas fa-status me-1"></i>Status</th>
                        <th><i class="fas fa-calendar-plus me-1"></i>Date Posted</th>
                        <th><i class="fas fa-calendar-check me-1"></i>Available Date</th>
                        <th><i class="fas fa-cogs me-1"></i>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($donations as $donation)
                    <tr>
                        <td><span class="badge bg-secondary">DON-{{ str_pad($donation->id, 5, '0', STR_PAD_LEFT) }}</span></td>
                        <td>{{ $donation->category ?? 'Wearable' }}</td>
                        <td>{{ $donation->category == 'Wearable' ? ($donation->wearable_type ?? 'N/A') : ($donation->subcategory ?? 'N/A') }}</td>
                        <td>
                            @if($donation->category)
                                {{ $donation->quantity }} {{ $donation->wearable_type }}
                                @if($donation->size) (Size: {{ $donation->size }}) @endif
                            @else
                                {{ $donation->quantity }} {{ $donation->wearable_type }}
                                @if($donation->size) (Size: {{ $donation->size }}) @endif
                            @endif
                        </td>
                        <td class="text-center">
                            @if($donation->donation_photo)
                                @php
                                    $photos = is_array($donation->donation_photo)
                                             ? $donation->donation_photo
                                             : json_decode($donation->donation_photo, true) ?? [$donation->donation_photo];
                                @endphp
                                <div class="d-flex justify-content-center">
                                    <a href="#" class="view-photo" data-photos='@json($photos)'>
                                        <img src="{{ asset('storage/' . $photos[0]) }}" class="img-thumbnail mx-auto" style="width: 80px; height: 80px; object-fit: cover;" alt="Donation Photo">
                                    </a>
                                </div>
                            @else
                                <span class="badge bg-secondary">No Photo</span>
                            @endif
                        </td>
                        <td>
                            @php
                                $statusClass = [
                                    'pending' => 'bg-warning',
                                    'approved' => 'bg-success',
                                    'claimed' => 'bg-info',
                                    'expired' => 'bg-secondary'
                                ][$donation->status] ?? 'bg-secondary';
                            @endphp
                            <span class="badge {{ $statusClass }}">
                                <i class="fas fa-circle me-1"></i>{{ ucfirst($donation->status) }}
                            </span>
                        </td>
                        <td>{{ $donation->created_at->format('M d, Y') }}</td>
                        <td>{{ $donation->available_date ? \Carbon\Carbon::parse($donation->available_date)->format('M d, Y') : 'N/A' }}</td>
                        <td>
                            <div class="d-flex gap-2 justify-content-center">
                                <button class="btn btn-info btn-sm view-donation" data-bs-toggle="modal" data-bs-target="#donationDetailsModal{{$donation->id}}">
                                    <i class="fas fa-eye"></i>
                                </button>
                                @if($donation->status === 'pending')
                                <button class="btn btn-warning btn-sm edit-donation" data-bs-toggle="modal" data-bs-target="#editDonationModal{{$donation->id}}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-danger btn-sm delete-donation" data-id="{{ $donation->id }}">
                                    <i class="fas fa-trash"></i>
                                </button>
                                @endif
                            </div>
                        </td>
                    </tr>

                    <div class="modal fade" id="donationDetailsModal{{$donation->id}}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title"><i class="fas fa-info-circle me-2"></i>Donation Details (DON-{{ str_pad($donation->id, 5, '0', STR_PAD_LEFT) }})</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    {{-- Photo Display Section --}}
                                    @if($donation->donation_photo)
                                    @php
                                        $photos = is_array($donation->donation_photo)
                                                 ? $donation->donation_photo
                                                 : json_decode($donation->donation_photo, true) ?? [$donation->donation_photo];
                                    @endphp
                                    <div class="mb-3 text-center">
                                        <h6><i class="fas fa-image me-1"></i> Donation Photos</h6>
                                        <div class="row justify-content-center">
                                            @foreach($photos as $index => $photo)
                                            <div class="col-md-4 mb-3 text-center">
                                                <a href="#" class="view-photo" data-photos='@json($photos)'>
                                                    <img src="{{ asset('storage/' . $photo) }}" class="img-fluid rounded mx-auto d-block" alt="Donation Image" style="max-height: 200px; object-fit: cover;">
                                                </a>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                    @else
                                    <div class="alert alert-info text-center">
                                        <i class="fas fa-exclamation-circle me-1"></i> No photo available for this donation.
                                    </div>
                                    @endif

                                    <div class="mb-3">
                                        <h6><i class="fas fa-user-circle me-1"></i> Donor Information</h6>
                                        <p><strong>Name:</strong> {{ $donation->user->name }}</p>
                                        <p><strong>Contact:</strong> {{ $donation->user->contact }}</p>
                                        <p><strong>Location:</strong> {{ $donation->location }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <h6><i class="fas fa-list-alt me-1"></i> Donation Details</h6>
                                        <p><strong>Category:</strong> {{ $donation->category ?? 'Wearable' }}</p>
                                        <p><strong>Subcategory:</strong> {{ $donation->subcategory ?? $donation->wearable_type }}</p>
                                        @if($donation->size)
                                        <p><strong>Size:</strong> {{ $donation->size }}</p>
                                        @endif
                                        <p><strong>Quantity:</strong> {{ $donation->quantity }}</p>
                                        @if($donation->condition)
                                        <p><strong>Condition:</strong> {{ $donation->condition }}</p>
                                        @endif
                                        <p><strong>Notes:</strong> {{ $donation->notes ?? 'None' }}</p>
                                        <p><strong>Available Date:</strong> {{ $donation->available_date ? \Carbon\Carbon::parse($donation->available_date)->format('M d, Y') : 'Not specified' }}</p>
                                    </div>
                                    <div class="mb-3">
                                        <h6><i class="fas fa-history me-1"></i> Status Information</h6>
                                        <p><strong>Status:</strong>
                                            <span class="badge {{ $statusClass }}">
                                                <i class="fas fa-circle me-1"></i>{{ ucfirst($donation->status) }}
                                            </span>
                                        </p>
                                        <p><strong>Date Posted:</strong> {{ $donation->created_at->format('M d, Y h:i A') }}</p>
                                        @if($donation->status != 'pending')
                                        <p><strong>Last Updated:</strong> {{ $donation->updated_at->format('M d, Y h:i A') }}</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="editDonationModal{{$donation->id}}" tabindex="-1" aria-labelledby="editDonationModalLabel{{$donation->id}}" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editDonationModalLabel{{$donation->id}}"><i class="fas fa-edit me-2"></i>Edit Donation (DON-{{ str_pad($donation->id, 5, '0', STR_PAD_LEFT) }})</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <form id="editForm{{$donation->id}}" action="{{ route('donations.update', $donation->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                        <div class="row g-3">
                                            @if($donation->category == 'Wearable')
                                            <div class="col-md-6">
                                                <label for="editWearableType{{$donation->id}}" class="form-label"><i class="fas fa-tshirt me-1"></i>Wearable Type</label>
                                                <select class="form-select" id="editWearableType{{$donation->id}}" name="wearable_type">
                                                    <option value="Shirt" @if($donation->wearable_type == 'Shirt') selected @endif>Shirt</option>
                                                    <option value="Pants" @if($donation->wearable_type == 'Pants') selected @endif>Pants</option>
                                                    <option value="Jacket" @if($donation->wearable_type == 'Jacket') selected @endif>Jacket</option>
                                                    <option value="Shoes" @if($donation->wearable_type == 'Shoes') selected @endif>Shoes</option>
                                                    <option value="Underwear" @if($donation->wearable_type == 'Underwear') selected @endif>Underwear</option>
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="editSize{{$donation->id}}" class="form-label"><i class="fas fa-ruler-combined me-1"></i>Size</label>
                                                <select class="form-select" id="editSize{{$donation->id}}" name="size">
                                                    {{-- Options will be populated by JS --}}
                                                </select>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="editQuantity{{$donation->id}}" class="form-label"><i class="fas fa-list-ol me-1"></i>Quantity</label>
                                                <input type="number" class="form-control" id="editQuantity{{$donation->id}}" name="quantity" value="{{ $donation->quantity }}">
                                            </div>
                                            @else
                                            <div class="col-md-6">
                                                <label for="editSubcategory{{$donation->id}}" class="form-label"><i class="fas fa-tag me-1"></i>Subcategory</label>
                                                <input type="text" class="form-control" id="editSubcategory{{$donation->id}}" name="subcategory" value="{{ $donation->subcategory }}" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label for="editQuantity{{$donation->id}}" class="form-label"><i class="fas fa-list-ol me-1"></i>Quantity</label>
                                                <input type="number" class="form-control" id="editQuantity{{$donation->id}}" name="quantity" value="{{ $donation->quantity }}">
                                            </div>
                                            <div class="col-12">
                                                <label for="editSpecificItems{{$donation->id}}" class="form-label"><i class="fas fa-list me-1"></i>Specific Items</label>
                                                <input type="text" class="form-control" id="editSpecificItems{{$donation->id}}" name="specific_items" value="{{ $donation->specific_items }}">
                                            </div>
                                            @endif

                                            <div class="col-md-6">
                                                <label for="editCondition{{$donation->id}}" class="form-label"><i class="fas fa-star me-1"></i>Condition</label>
                                                <select class="form-select" id="editCondition{{$donation->id}}" name="condition" required>
                                                    <option value="Gently Used" @if($donation->condition == 'Gently Used') selected @endif>Gently Used</option>
                                                    <option value="New" @if($donation->condition == 'New') selected @endif>New</option>
                                                    <option value="Needs minor repair" @if($donation->condition == 'Needs minor repair') selected @endif>Needs minor repair</option>
                                                </select>
                                            </div>

                                            @if($donation->category == 'Food' || $donation->category == 'Medical')
                                            <div class="col-md-6">
                                                <label for="editExpirationDate{{$donation->id}}" class="form-label"><i class="fas fa-calendar-times me-1"></i>Expiration Date</label>
                                                <input type="date" class="form-control" id="editExpirationDate{{$donation->id}}" name="expiration_date" value="{{ $donation->expiration_date }}">
                                            </div>
                                            @endif

                                            <div class="col-md-6">
                                                <label for="editLocation{{$donation->id}}" class="form-label"><i class="fas fa-map-marker-alt me-1"></i>Location</label>
                                                <input type="text" class="form-control" id="editLocation{{$donation->id}}" name="location" value="{{ $donation->location }}">
                                            </div>
                                            <div class="col-md-6">
                                                <label for="editAvailableDate{{$donation->id}}" class="form-label"><i class="fas fa-calendar-alt me-1"></i>Available Date</label>
                                                <input type="date" class="form-control" id="editAvailableDate{{$donation->id}}" name="available_date" value="{{ $donation->available_date }}">
                                            </div>
                                            <div class="col-12">
                                                <label for="editNotes{{$donation->id}}" class="form-label"><i class="fas fa-sticky-note me-1"></i>Notes</label>
                                                <textarea class="form-control" id="editNotes{{$donation->id}}" name="notes">{{ $donation->notes }}</textarea>
                                            </div>
                                            <div class="col-12">
                                                <label for="editPhotos{{$donation->id}}" class="form-label"><i class="fas fa-images me-1"></i>Update Photos</label>
                                                <input type="file" class="form-control" id="editPhotos{{$donation->id}}" name="donation_photos[]" multiple>
                                                <small class="text-muted">Select new photos to replace existing ones</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>


<!-- Total Donations Summary Section -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white py-2">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list-alt me-2"></i>Total Donations Summary
                </h5>
            </div>
            <div class="card-body p-3">
                <div class="row g-3">
                    <div class="col-md-3 col-6">
                        <div class="card bg-primary text-white text-center h-100">
                            <div class="card-body d-flex flex-column justify-content-center p-3">
                                <h4 class="card-title mb-2">{{ $donationscount }}</h4>
                                <small class="card-text">Total Donations</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="card bg-success text-white text-center h-100">
                            <div class="card-body d-flex flex-column justify-content-center p-3">
                                <h4 class="card-title mb-2">{{ $acceptedreq }}</h4>
                                <small class="card-text">Approved</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="card bg-danger text-white text-center h-100">
                            <div class="card-body d-flex flex-column justify-content-center p-3">
                                <h4 class="card-title mb-2">{{ $rejectedreq }}</h4>
                                <small class="card-text">Rejected</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="card bg-warning text-center h-100">
                            <div class="card-body d-flex flex-column justify-content-center p-3">
                                <h4 class="card-title mb-2 text-dark">{{ $pendingreq }}</h4>
                                <small class="card-text text-dark">Pending</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Additional Stats Row -->
                <div class="row g-3">
                    <div class="col-md-4 col-6">
                        <div class="card bg-info text-white text-center h-100">
                            <div class="card-body d-flex flex-column justify-content-center p-3">
                                <h5 class="card-title mb-2">{{ $matchedreq }}</h5>
                                <small class="card-text">Matched</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="card bg-success text-white text-center h-100">
                            <div class="card-body d-flex flex-column justify-content-center p-3">
                                <h5 class="card-title mb-2">{{ $totalMatchedDonations }}</h5>
                                <small class="card-text">Successful Matches</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="card bg-secondary text-white text-center h-100">
                            <div class="card-body d-flex flex-column justify-content-center p-3">
                                <h5 class="card-title mb-2">{{ $totalAllocatedQuantity }}</h5>
                                <small class="card-text">Items Given</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Analytics Charts Section -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-success text-white py-2">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-bar me-2"></i>Donation Analytics
                </h5>
            </div>
            <div class="card-body p-3">
                <div class="row">
                    <!-- Status Distribution Chart -->
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-header bg-info text-white py-2">
                                <h6 class="card-title mb-0">
                                    <i class="fas fa-chart-pie me-1"></i>Status Distribution
                                </h6>
                            </div>
                            <div class="card-body p-2">
                                <div class="chart-container" style="height: 180px;">
                                    <canvas id="statusDistributionChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Category Distribution Chart -->
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-header bg-warning text-dark py-2">
                                <h6 class="card-title mb-0">
                                    <i class="fas fa-chart-bar me-1"></i>Donations by Category
                                </h6>
                            </div>
                            <div class="card-body p-2">
                                <div class="chart-container" style="height: 180px;">
                                    <canvas id="categoryDistributionChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Monthly Trends Chart -->
                    <div class="col-md-4 mb-3">
                        <div class="card h-100">
                            <div class="card-header bg-primary text-white py-2">
                                <h6 class="card-title mb-0">
                                    <i class="fas fa-chart-line me-1"></i>Monthly Trends
                                </h6>
                            </div>
                            <div class="card-body p-2">
                                <div class="chart-container" style="height: 180px;">
                                    <canvas id="monthlyTrendsChart"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>



<!-- Single Photo Modal -->
<div class="modal fade" id="photoModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Donation Photos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="photoCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner" id="carousel-inner">
                        <!-- Photos will be inserted here dynamically -->
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#photoCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#photoCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- <!-- Load scripts at the bottom of the body -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> --}}
<script>
    // Store asset URL for use in JavaScript
    const assetUrl = '{{ asset("") }}';

    document.addEventListener('DOMContentLoaded', function() {
        try {
            // Initialize DataTable with enhanced styling
            const donationsTable = $('#donationsTable');
            if (donationsTable.length) {
                donationsTable.DataTable({
                    "order": [[5, "desc"]],
                    "pageLength": 10,
                    "responsive": true,
                    "language": {
                        "search": "<i class='fas fa-search'></i> Search:",
                        "lengthMenu": "Show _MENU_ entries",
                        "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                        "paginate": {
                            "previous": "<i class='fas fa-chevron-left'></i>",
                            "next": "<i class='fas fa-chevron-right'></i>"
                        }
                    },
                    "dom": '<"row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>rt<"row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>'
                });
            }

            // Photo modal handling
            $(document).on('click', '.view-photo', function(e) {
                e.preventDefault();
                const photos = JSON.parse($(this).attr('data-photos'));

                $('#carousel-inner').empty();
                photos.forEach((photo, index) => {
                    const activeClass = index === 0 ? 'active' : '';
                    $('#carousel-inner').append(`
                        <div class="carousel-item ${activeClass}">
                            <img src="${assetUrl}storage/${photo}" class="d-block w-100" alt="Donation Photo">
                        </div>
                    `);
                });

                // Show/hide navigation controls based on number of photos
                if (photos.length > 1) {
                    $('#photoCarousel').find('.carousel-control').show();
                } else {
                    $('#photoCarousel').find('.carousel-control').hide();
                }

                // Update modal title with photo count
                $('#photoModal .modal-title').text(`Donation Photos (${photos.length})`);

                // Initialize the modal
                const photoModal = new bootstrap.Modal(document.getElementById('photoModal'));
                photoModal.show();
            });

            // Function to update size options based on wearable type
            function updateSizeOptions(wearableType, selectElement) {
                if (!selectElement) return;

                selectElement.empty();
                selectElement.append('<option value="" disabled selected>Select size</option>');

                if (wearableType === 'Shoes') {
                    for (let i = 1; i <= 15; i++) {
                        selectElement.append(`<option value="${i}">${i}</option>`);
                    }
                } else {
                    const sizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'];
                    sizes.forEach(size => {
                        selectElement.append(`<option value="${size}">${size}</option>`);
                    });
                }
            }

            // Handle the edit modal opening
            $(document).on('show.bs.modal', '[id^=editDonationModal]', function(event) {
                const modal = $(this);
                const wearableTypeSelect = modal.find('select[name="wearable_type"]');
                const sizeSelect = modal.find('select[name="size"]');
                const donationId = modal.attr('id').replace('editDonationModal', '');
                const originalSize = modal.find('select[name="size"]').val() || modal.find('input[name="size"]').val();

                if (wearableTypeSelect.length > 0 && sizeSelect.length > 0) {
                    const currentWearableType = wearableTypeSelect.val();
                    updateSizeOptions(currentWearableType, sizeSelect);
                    sizeSelect.val(originalSize);

                    wearableTypeSelect.off('change').on('change', function() {
                        const newWearableType = $(this).val();
                        updateSizeOptions(newWearableType, sizeSelect);
                    });
                }
            });

            // Delete button click handler
            $(document).on('click', '.delete-donation', function() {
                const donationId = $(this).data('id');
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/donations/${donationId}`,
                            type: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                Swal.fire('Deleted!', response.success, 'success').then(() => {
                                    window.location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire('Error', xhr.responseJSON?.message || 'Failed to delete donation', 'error');
                            }
                        });
                    }
                });
            });

            // Edit form submission handler
            $(document).on('submit', '[id^=editForm]', function(e) {
                e.preventDefault();
                const form = $(this);
                const formData = new FormData(form[0]);

                if (!form.length) return;

                const url = form.attr('action');

                Swal.fire({
                    title: 'Saving...',
                    text: 'Please wait while we update the donation.',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    type: 'POST',
                    url: url,
                    data: formData,
                    processData: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Updated!',
                            text: response.success,
                            showConfirmButton: true
                        }).then(() => {
                            window.location.reload();
                        });
                    },
                    error: function(xhr) {
                        Swal.fire('Error', xhr.responseJSON?.message || 'Failed to update donation.', 'error');
                    }
                });
            });

        } catch (error) {
            console.error('Error in donation dashboard script:', error);
        }
    });
</script>

<script>
    // Initialize Donor Analytics Charts
function initializeDonorAnalyticsCharts() {
    // Status Distribution Chart (Doughnut Chart)
    const statusCtx = document.getElementById('statusDistributionChart').getContext('2d');
    const statusData = @json($statusAnalytics);

    // Filter out zero values for better visualization
    const filteredLabels = [];
    const filteredData = [];
    const filteredColors = [];

    const colors = ['#ffc107', '#28a745', '#dc3545', '#17a2b8']; // Yellow, Green, Red, Blue

    Object.keys(statusData).forEach((key, index) => {
        if (statusData[key] > 0) {
            const label = key.charAt(0).toUpperCase() + key.slice(1);
            filteredLabels.push(label);
            filteredData.push(statusData[key]);
            filteredColors.push(colors[index] || '#6c757d');
        }
    });

    if (filteredData.length > 0) {
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: filteredLabels,
                datasets: [{
                    data: filteredData,
                    backgroundColor: filteredColors,
                    borderWidth: 1,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 8,
                            boxWidth: 10,
                            font: {
                                size: 9
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `${label}: ${value} (${percentage}%)`;
                            }
                        }
                    }
                },
                cutout: '50%'
            }
        });
    } else {
        statusCtx.fillStyle = '#6c757d';
        statusCtx.font = '12px Arial';
        statusCtx.textAlign = 'center';
        statusCtx.fillText('No data available', statusCtx.canvas.width / 2, statusCtx.canvas.height / 2);
    }

    // Category Distribution Chart (Bar Chart)
    const categoryCtx = document.getElementById('categoryDistributionChart').getContext('2d');
    const categoryData = @json($categoryAnalytics);

    if (Object.keys(categoryData).length > 0) {
        new Chart(categoryCtx, {
            type: 'bar',
            data: {
                labels: Object.keys(categoryData),
                datasets: [{
                    label: 'Donations',
                    data: Object.values(categoryData),
                    backgroundColor: 'rgba(255, 193, 7, 0.7)',
                    borderColor: 'rgba(255, 193, 7, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: {
                                size: 9
                            }
                        },
                        title: {
                            display: true,
                            text: 'Number of Donations',
                            font: {
                                size: 10
                            }
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 9
                            }
                        }
                    }
                }
            }
        });
    } else {
        categoryCtx.fillStyle = '#6c757d';
        categoryCtx.font = '12px Arial';
        categoryCtx.textAlign = 'center';
        categoryCtx.fillText('No data available', categoryCtx.canvas.width / 2, categoryCtx.canvas.height / 2);
    }

    // Monthly Trends Chart (Line Chart)
    const monthlyCtx = document.getElementById('monthlyTrendsChart').getContext('2d');
    const monthlyLabels = @json($monthlyLabels);
    const monthlyData = @json($monthlyData);

    if (monthlyData.length > 0) {
        new Chart(monthlyCtx, {
            type: 'line',
            data: {
                labels: monthlyLabels,
                datasets: [{
                    label: 'Donations',
                    data: monthlyData,
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#007bff',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 1,
                    pointRadius: 3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            font: {
                                size: 9
                            }
                        },
                        title: {
                            display: true,
                            text: 'Number of Donations',
                            font: {
                                size: 10
                            }
                        }
                    },
                    x: {
                        ticks: {
                            font: {
                                size: 8
                            },
                            maxRotation: 45
                        }
                    }
                }
            }
        });
    } else {
        monthlyCtx.fillStyle = '#6c757d';
        monthlyCtx.font = '12px Arial';
        monthlyCtx.textAlign = 'center';
        monthlyCtx.fillText('No data available', monthlyCtx.canvas.width / 2, monthlyCtx.canvas.height / 2);
    }
}

// Initialize charts when document is ready
$(document).ready(function() {
    // Initialize donor analytics charts
    initializeDonorAnalyticsCharts();
});
</script>
