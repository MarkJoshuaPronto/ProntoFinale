<div class="col-md-10 main-content">
    {{-- Success and Error Alerts --}}
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

    <div class="container">
        <div class="table-responsive">
            <table class="table table-hover" id="requestsTable">
                <thead class="table-dark">
                    <tr>
                        <th><i class="fas fa-hashtag me-1"></i>Request ID</th>
                        <th><i class="fas fa-folder me-1"></i>Category</th>
                        <th><i class="fas fa-tag me-1"></i>Subcategory</th>
                        <th><i class="fas fa-info-circle me-1"></i>Details</th>
                        <th><i class="fas fa-tasks me-1"></i>Status</th>
                        <th><i class="fas fa-calendar-plus me-1"></i>Date Requested</th>
                        <th><i class="fas fa-calendar-check me-1"></i>Preferred Date</th>
                        <th><i class="fas fa-cogs me-1"></i>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($requests as $request)
                        <tr>
                            <td><span class="badge bg-secondary">REQ-{{ str_pad($request->id, 5, '0', STR_PAD_LEFT) }}</span></td>
                            <td>{{ $request->category ?? 'Wearable' }}</td>
                            <td>{{ $request->subcategory ?? $request->wearable_type }}</td>
                            <td>
                                @if($request->category)
                                    {{ $request->quantity }} {{ $request->subcategory }}
                                    @if($request->size) (Size: {{ $request->size }}) @endif
                                @else
                                    {{ $request->quantity }} {{ $request->wearable_type }}
                                    @if($request->size) (Size: {{ $request->size }}) @endif
                                @endif
                            </td>
                            <td>
                                @php
                                    $statusClass = [
                                        'pending' => 'bg-warning',
                                        'approved' => 'bg-success',
                                        'rejected' => 'bg-danger',
                                        'fulfilled' => 'bg-info'
                                    ][$request->status] ?? 'bg-secondary';
                                @endphp
                                <span class="badge {{ $statusClass }}">
                                    <i class="fas fa-circle me-1"></i>{{ ucfirst($request->status) }}
                                </span>
                            </td>
                            <td>{{ $request->created_at->format('M d, Y h:i A') }}</td>
                            <td>
                                @if($request->urgency === 'specific' && $request->specific_date)
                                    {{ \Carbon\Carbon::parse($request->specific_date)->format('M d, Y') }}
                                @else
                                    {{ ucfirst(str_replace('_', ' ', $request->urgency)) }}
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-2">
                                    <button class="btn btn-info btn-sm view-request" data-id="{{ $request->id }}" data-bs-toggle="modal" data-bs-target="#requestDetailsModal{{$request->id}}">
                                        <i class="fas fa-eye"></i> View
                                    </button>

                                    @if($request->status === 'pending')
                                    <button class="btn btn-warning btn-sm edit-request" data-bs-toggle="modal" data-bs-target="#editRequestModal{{$request->id}}">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>

                                    <button class="btn btn-danger btn-sm delete-request" data-id="{{ $request->id }}">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <div class="modal fade" id="requestDetailsModal{{$request->id}}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title"><i class="fas fa-info-circle me-2"></i>Request Details (REQ-{{ str_pad($request->id, 5, '0', STR_PAD_LEFT) }})</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <h6><i class="fas fa-user-circle me-1"></i> Requester Information</h6>
                                            <p><strong>Name:</strong> {{ $request->full_name }}</p>
                                            <p><strong>Contact:</strong> {{ $request->contact_number }}</p>
                                            <p><strong>Address:</strong> {{ $request->address }}</p>
                                        </div>

                                        <div class="mb-3">
                                            <h6><i class="fas fa-list-alt me-1"></i> Request Details</h6>
                                            <p><strong>Category:</strong> {{ $request->category ?? 'Wearable' }}</p>
                                            <p><strong>Subcategory:</strong> {{ $request->subcategory ?? $request->wearable_type }}</p>
                                            @if($request->size)
                                            <p><strong>Size:</strong> {{ $request->size }}</p>
                                            @endif
                                            <p><strong>Quantity:</strong> {{ $request->quantity }}</p>
                                            <p><strong>Description:</strong> {{ $request->description }}</p>
                                            <p><strong>Urgency:</strong>
                                                @if($request->urgency === 'specific' && $request->specific_date)
                                                    Specific Date: {{ \Carbon\Carbon::parse($request->specific_date)->format('M d, Y') }}
                                                @else
                                                    {{ ucfirst(str_replace('_', ' ', $request->urgency)) }}
                                                @endif
                                            </p>
                                        </div>

                                        <div class="mb-3">
                                            <h6><i class="fas fa-history me-1"></i> Status Information</h6>
                                            <p><strong>Status:</strong>
                                                <span class="badge {{ $statusClass }}">
                                                    <i class="fas fa-circle me-1"></i>{{ ucfirst($request->status) }}
                                                </span>
                                            </p>
                                            <p><strong>Date Requested:</strong> {{ $request->created_at->format('M d, Y h:i A') }}</p>
                                            @if($request->status != 'pending')
                                            <p><strong>Last Updated:</strong> {{ $request->updated_at->format('M d, Y h:i A') }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Edit Request Modal --}}
                        <div class="modal fade" id="editRequestModal{{$request->id}}" tabindex="-1" aria-labelledby="editRequestModalLabel{{$request->id}}" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editRequestModalLabel{{$request->id}}"><i class="fas fa-edit me-2"></i>Edit Request (REQ-{{ str_pad($request->id, 5, '0', STR_PAD_LEFT) }})</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <form id="editForm{{$request->id}}" action="{{ route('requests.update', $request->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="row g-3">
                                                <div class="col-md-6">
                                                    <label for="editFullName{{$request->id}}" class="form-label"><i class="fas fa-user me-1"></i>Full Name</label>
                                                    <input type="text" class="form-control" id="editFullName{{$request->id}}" name="full_name" value="{{ $request->full_name }}" readonly>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="editContactNumber{{$request->id}}" class="form-label"><i class="fas fa-phone me-1"></i>Contact Number</label>
                                                    <input type="text" class="form-control" id="editContactNumber{{$request->id}}" name="contact_number" value="{{ $request->contact_number }}" readonly>
                                                </div>
                                                <div class="col-12">
                                                    <label for="editAddress{{$request->id}}" class="form-label"><i class="fas fa-map-marker-alt me-1"></i>Address</label>
                                                    <textarea class="form-control" id="editAddress{{$request->id}}" name="address" rows="2" readonly>{{ $request->address }}</textarea>
                                                </div>

                                                @if($request->category == 'Wearable')
                                                <div class="col-md-6">
                                                    <label for="editWearableType{{$request->id}}" class="form-label"><i class="fas fa-tshirt me-1"></i>Wearable Type</label>
                                                    <select class="form-select" id="editWearableType{{$request->id}}" name="wearable_type">
                                                        <option value="t-shirt" @if($request->wearable_type == 't-shirt') selected @endif>T-shirt</option>
                                                        <option value="shorts" @if($request->wearable_type == 'shorts') selected @endif>Shorts</option>
                                                        <option value="pants" @if($request->wearable_type == 'pants') selected @endif>Pants</option>
                                                        <option value="jacket" @if($request->wearable_type == 'jacket') selected @endif>Jacket</option>
                                                        <option value="shoes" @if($request->wearable_type == 'shoes') selected @endif>Shoes</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="editSize{{$request->id}}" class="form-label"><i class="fas fa-ruler-combined me-1"></i>Size</label>
                                                    <select class="form-select" id="editSize{{$request->id}}" name="size">
                                                        <option value="small" @if($request->size == 'small') selected @endif>Small</option>
                                                        <option value="medium" @if($request->size == 'medium') selected @endif>Medium</option>
                                                        <option value="large" @if($request->size == 'large') selected @endif>Large</option>
                                                        <option value="xlarge" @if($request->size == 'xlarge') selected @endif>X-Large</option>
                                                    </select>
                                                </div>
                                                @else
                                                <div class="col-md-6">
                                                    <label for="editCategory{{$request->id}}" class="form-label"><i class="fas fa-list me-1"></i>Category</label>
                                                    <select class="form-select" id="editCategory{{$request->id}}" name="category" required>
                                                        <option value="Food" @if($request->category == 'Food') selected @endif>Food</option>
                                                        <option value="Medical Supplies" @if($request->category == 'Medical Supplies') selected @endif>Medical Supplies</option>
                                                        <option value="Clothing" @if($request->category == 'Clothing') selected @endif>Clothing</option>
                                                        <option value="Wearable" @if($request->category == 'Wearable') selected @endif>Wearable</option>
                                                        <option value="Other" @if($request->category == 'Other') selected @endif>Other</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="editSubcategory{{$request->id}}" class="form-label"><i class="fas fa-tag me-1"></i>Subcategory</label>
                                                    <input type="text" class="form-control" id="editSubcategory{{$request->id}}" name="subcategory" value="{{ $request->subcategory }}">
                                                </div>
                                                @endif

                                                <div class="col-md-6">
                                                    <label for="editQuantity{{$request->id}}" class="form-label"><i class="fas fa-list-ol me-1"></i>Quantity</label>
                                                    <input type="number" class="form-control" id="editQuantity{{$request->id}}" name="quantity" value="{{ $request->quantity }}" required>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="editUrgency{{$request->id}}" class="form-label"><i class="fas fa-clock me-1"></i>Urgency</label>
                                                    <select class="form-select" id="editUrgency{{$request->id}}" name="urgency" required>
                                                        <option value="asap" @if($request->urgency == 'asap') selected @endif>ASAP</option>
                                                        <option value="within_week" @if($request->urgency == 'within_week') selected @endif>Within 1 Week</option>
                                                        <option value="within_month" @if($request->urgency == 'within_month') selected @endif>Within 1 Month</option>
                                                        <option value="flexible" @if($request->urgency == 'flexible') selected @endif>Flexible</option>
                                                        <option value="specific" @if($request->urgency == 'specific') selected @endif>Specific Date</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-6" id="editSpecificDateField{{$request->id}}" style="display: {{ $request->urgency == 'specific' ? 'block' : 'none' }};">
                                                    <label for="editSpecificDate{{$request->id}}" class="form-label"><i class="fas fa-calendar-alt me-1"></i>Specific Date</label>
                                                    <input type="date" class="form-control" id="editSpecificDate{{$request->id}}" name="specific_date" value="{{ $request->specific_date }}">
                                                </div>

                                                <div class="col-12">
                                                    <label for="editDescription{{$request->id}}" class="form-label"><i class="fas fa-comment-alt me-1"></i>Description</label>
                                                    <textarea class="form-control" id="editDescription{{$request->id}}" name="description" rows="3" required>{{ $request->description }}</textarea>
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



<!-- Total Requests Summary Section -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-primary text-white py-2">
                <h5 class="card-title mb-0">
                    <i class="fas fa-list-alt me-2"></i>Total Requests Summary
                </h5>
            </div>
            <div class="card-body p-3">
                <div class="row g-3">
                    <div class="col-md-2 col-6">
                        <div class="card bg-primary text-white text-center h-100">
                            <div class="card-body d-flex flex-column justify-content-center p-3">
                                <h4 class="card-title mb-2">{{ $donationscount }}</h4>
                                <small class="card-text">Total Requests</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="card bg-success text-white text-center h-100">
                            <div class="card-body d-flex flex-column justify-content-center p-3">
                                <h4 class="card-title mb-2">{{ $acceptedreq }}</h4>
                                <small class="card-text">Approved</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="card bg-danger text-white text-center h-100">
                            <div class="card-body d-flex flex-column justify-content-center p-3">
                                <h4 class="card-title mb-2">{{ $rejectedreq }}</h4>
                                <small class="card-text">Rejected</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="card bg-warning text-dark text-center h-100">
                            <div class="card-body d-flex flex-column justify-content-center p-3">
                                <h4 class="card-title mb-2">{{ $pendingreq }}</h4>
                                <small class="card-text">Pending</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2 col-6">
                        <div class="card bg-info text-white text-center h-100">
                            <div class="card-body d-flex flex-column justify-content-center p-3">
                                <h4 class="card-title mb-2">{{ $matchedreq + $partiallymatched }}</h4>
                                <small class="card-text">Matched</small>
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
                    <i class="fas fa-chart-bar me-2"></i>Request Analytics
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
                                    <i class="fas fa-chart-bar me-1"></i>Requests by Category
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
</div>
    </div>

</div>


{{-- Create Request Modal --}}
<div class="modal fade" id="createRequestModal" tabindex="-1" aria-labelledby="createRequestModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createRequestModalLabel">New Request</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('requests.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="full_name" class="form-label"><i class="fas fa-user me-1"></i>Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="contact_number" class="form-label"><i class="fas fa-phone me-1"></i>Contact Number</label>
                        <input type="text" class="form-control" id="contact_number" name="contact_number" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label"><i class="fas fa-map-marker-alt me-1"></i>Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="category" class="form-label"><i class="fas fa-list me-1"></i>Category</label>
                        <select class="form-select" id="category" name="category" required>
                            <option value="">Select a category</option>
                            <option value="Food">Food</option>
                            <option value="Medical Supplies">Medical Supplies</option>
                            <option value="Clothing">Clothing</option>
                            <option value="Wearable">Wearable</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3" id="subcategory-field" style="display:none;">
                        <label for="subcategory" class="form-label"><i class="fas fa-list-alt me-1"></i>Subcategory</label>
                        <select class="form-select" id="subcategory" name="subcategory"></select>
                    </div>
                    <div class="mb-3" id="wearable-field" style="display:none;">
                        <label for="wearable_type" class="form-label"><i class="fas fa-tshirt me-1"></i>Wearable Type</label>
                        <select class="form-select" id="wearable_type" name="wearable_type">
                            <option value="t-shirt">T-shirt</option>
                            <option value="shorts">Shorts</option>
                            <option value="pants">Pants</option>
                            <option value="jacket">Jacket</option>
                            <option value="shoes">Shoes</option>
                        </select>
                    </div>
                    <div class="mb-3" id="size-field" style="display:none;">
                        <label for="size" class="form-label"><i class="fas fa-ruler me-1"></i>Size</label>
                        <select class="form-select" id="size" name="size">
                            <option value="small">Small</option>
                            <option value="medium">Medium</option>
                            <option value="large">Large</option>
                            <option value="xlarge">X-Large</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label"><i class="fas fa-sort-numeric-up me-1"></i>Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label"><i class="fas fa-comment-alt me-1"></i>Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="urgency" class="form-label"><i class="fas fa-clock me-1"></i>Urgency</label>
                        <select class="form-select" id="urgency" name="urgency" required>
                            <option value="asap">ASAP</option>
                            <option value="within_week">Within 1 Week</option>
                            <option value="within_month">Within 1 Month</option>
                            <option value="flexible">Flexible</option>
                            <option value="specific">Specific Date</option>
                        </select>
                    </div>
                    <div class="mb-3" id="specific-date-field" style="display: none;">
                        <label for="specific_date" class="form-label"><i class="fas fa-calendar-alt me-1"></i>Specific Date</label>
                        <input type="date" class="form-control" id="specific_date" name="specific_date">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Submit Request</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<meta name="csrf-token" content="{{ csrf_token() }}">

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#requestsTable').DataTable({
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

        // Handle New Request Form fields
        const createCategory = $('#category');
        const subcategoryField = $('#subcategory-field');
        const wearableField = $('#wearable-field');
        const sizeField = $('#size-field');
        const createSpecificDateField = $('#specific-date-field');

        createCategory.change(function() {
            const selectedCategory = $(this).val();
            // Reset fields
            subcategoryField.hide().find('select').attr('required', false);
            wearableField.hide().find('select').attr('required', false);
            sizeField.hide().find('select').attr('required', false);

            if (selectedCategory === 'Wearable') {
                wearableField.show().find('select').attr('required', true);
                sizeField.show().find('select').attr('required', true);
            } else {
                wearableField.hide().find('select').attr('required', false);
                sizeField.hide().find('select').attr('required', false);
            }
        });

        // Handle Urgency field for new request
        $('#urgency').change(function() {
            if ($(this).val() === 'specific') {
                createSpecificDateField.show();
            } else {
                createSpecificDateField.hide();
            }
        });

        // Handle urgency field for edit modals
        $('[id^=editUrgency]').change(function() {
            const id = this.id.replace('editUrgency', '');
            if ($(this).val() === 'specific') {
                $('#editSpecificDateField' + id).show();
            } else {
                $('#editSpecificDateField' + id).hide();
            }
        });

        // Handle the Delete button click
        $(document).on('click', '.delete-request', function(e) {
            e.preventDefault();
            const requestId = $(this).data('id');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Use the correct route for deletion
                    $.ajax({
                        url: `/requests/${requestId}`,
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'X-HTTP-Method-Override': 'DELETE'
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: 'Your request has been deleted.',
                                showConfirmButton: false,
                                timer: 1500
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Failed to delete the request.',
                            });
                        }
                    });
                }
            });
        });

        // New Edit form submission handler
        $('[id^=editForm]').submit(function(e) {
            e.preventDefault(); // Prevent the default form submission

            const form = $(this);
            const url = form.attr('action');
            const formData = form.serialize();

            Swal.fire({
                title: 'Saving...',
                text: 'Please wait while we update the request.',
                showConfirmButton: false,
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                type: 'PUT',
                url: url,
                data: formData,
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
                    Swal.fire('Error', xhr.responseJSON?.message || 'Failed to update request.', 'error');
                }
            });
        });
    });
</script>

<script>
    // Initialize Analytics Charts
function initializeAnalyticsCharts() {
    // Status Distribution Chart (Doughnut Chart - more compact)
    const statusCtx = document.getElementById('statusDistributionChart').getContext('2d');
    const statusData = @json($statusAnalytics);

    // Filter out zero values for better visualization
    const filteredLabels = [];
    const filteredData = [];
    const filteredColors = [];

    const colors = ['#28a745', '#dc3545', '#ffc107', '#6c757d']; // Green, Red, Yellow, Gray

    Object.keys(statusData).forEach((key, index) => {
        if (statusData[key] > 0) {
            filteredLabels.push(key.charAt(0).toUpperCase() + key.slice(1));
            filteredData.push(statusData[key]);
            filteredColors.push(colors[index] || '#6c757d');
        }
    });

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
                        padding: 10,
                        boxWidth: 12,
                        font: {
                            size: 10
                        }
                    }
                }
            },
            cutout: '60%'
        }
    });

    // Category Distribution Chart (Horizontal Bar - more compact)
    const categoryCtx = document.getElementById('categoryDistributionChart').getContext('2d');
    const categoryData = @json($categoryAnalytics);

    new Chart(categoryCtx, {
        type: 'bar',
        data: {
            labels: Object.keys(categoryData),
            datasets: [{
                label: 'Requests',
                data: Object.values(categoryData),
                backgroundColor: 'rgba(40, 167, 69, 0.7)',
                borderColor: 'rgba(40, 167, 69, 1)',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y', // Horizontal bars
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        font: {
                            size: 10
                        }
                    }
                },
                y: {
                    ticks: {
                        font: {
                            size: 10
                        }
                    }
                }
            }
        }
    });

    // Monthly Trends Chart (Line Chart - compact)
    const monthlyCtx = document.getElementById('monthlyTrendsChart').getContext('2d');
    const monthlyLabels = @json($monthlyLabels);
    const monthlyData = @json($monthlyData);

    new Chart(monthlyCtx, {
        type: 'line',
        data: {
            labels: monthlyLabels,
            datasets: [{
                label: 'Requests',
                data: monthlyData,
                borderColor: '#ffc107',
                backgroundColor: 'rgba(255, 193, 7, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
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
                            size: 10
                        }
                    }
                },
                x: {
                    ticks: {
                        font: {
                            size: 9
                        },
                        maxRotation: 45
                    }
                }
            }
        }
    });
}

// Initialize charts when document is ready
$(document).ready(function() {
    // Initialize analytics charts
    initializeAnalyticsCharts();
});
</script>
