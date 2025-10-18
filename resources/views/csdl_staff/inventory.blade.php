<!DOCTYPE html>
<html lang="en">
@include('admin.header')
<head>
    <style>
        .table th {
            background-color: #2e8b57;
            color: white;
            font-weight: 600;
        }
        
        .table-hover tbody tr:hover {
            background-color: rgba(46, 139, 87, 0.1);
        }
        
        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 0.85rem;
        }
        
        .status-approved {
            background-color: #28a745;
            color: #fff;
        }
        
        .quantity-low {
            color: #dc3545;
            font-weight: bold;
        }
        
        .quantity-good {
            color: #28a745;
            font-weight: bold;
        }
    </style>
</head>
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

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3><i class="fas fa-boxes"></i> Inventory Management</h3>
                        <div class="badge bg-primary p-2">
                            Total Items: {{ $donations->sum('available_quantity') }}
                        </div>
                    </div>

                    <div class="table-responsive mt-2">
                        <table class="table table-bordered table-hover" id="inventoryTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Donor Name</th>
                                    <th>Contact</th>
                                    <th>Category</th>
                                    <th>Subcategory</th>
                                    <th>Size</th>
                                    <th>Available Qty</th>
                                    <th>Condition</th>
                                    <th>Location</th>
                                    <th>Available Date</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($donations as $donation)
                                <tr>
                                    <td>
                                        <strong>{{ $donation->full_name }}</strong>
                                        @if($donation->donation_photo)
                                        <br>
                                        <small>
                                            <a href="#" class="view-photo" data-photo="{{ asset('storage/' . $donation->donation_photo) }}">
                                                View Photo
                                            </a>
                                        </small>
                                        @endif
                                    </td>
                                    <td>{{ $donation->contact_number }}</td>
                                    <td>{{ ucfirst($donation->category) }}</td>
                                    <td>{{ ucfirst($donation->subcategory) }}</td>
                                    <td>{{ $donation->size ?? 'N/A' }}</td>
                                    <td class="{{ $donation->available_quantity <= 5 ? 'quantity-low' : 'quantity-good' }}">
                                        {{ $donation->available_quantity }}
                                    </td>
                                    <td>{{ $donation->condition ?? 'N/A' }}</td>
                                    <td>{{ $donation->location }}</td>
                                    <td>{{ \Carbon\Carbon::parse($donation->available_date)->format('M j, Y') }}</td>
                                    <td>
                                        <span class="status-badge status-{{ $donation->status }}">
                                            {{ ucfirst($donation->status) }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Photo View Modal -->
                    <div class="modal fade" id="photoModal" tabindex="-1" aria-labelledby="photoModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="photoModalLabel">Donation Photo</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body text-center">
                                    <img id="donationPhoto" src="" alt="Donation Photo" class="img-fluid" style="max-height: 70vh;">
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#inventoryTable').DataTable({
            "pageLength": 10,
            "order": [[5, "desc"]], // Sort by available quantity descending
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
            }
        });

        // View photo functionality
        $('.view-photo').click(function(e) {
            e.preventDefault();
            const photoUrl = $(this).data('photo');
            $('#donationPhoto').attr('src', photoUrl);
            $('#photoModal').modal('show');
        });

        // Add some analytics
        const totalItems = {{ $donations->sum('available_quantity') }};
        const totalDonations = {{ $donations->count() }};
        const lowStock = {{ $donations->where('available_quantity', '<=', 5)->count() }};
        
        console.log(`Inventory Summary:
        - Total Donations: ${totalDonations}
        - Total Items Available: ${totalItems}
        - Low Stock Items (≤5): ${lowStock}
        `);
    });
    </script>
</body>
</html>