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
    <title>Staff Management</title>
</head>
<style>
    .main-content {
        padding: 20px;
        min-height: 100vh;
    }

    /* Green table styling */
    #staffTable {
        border: 1px solid #2e7d32;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 6px rgba(46, 125, 50, 0.1);
    }

    #staffTable thead th {
        background-color: #2e7d32;
        color: white;
        font-weight: 600;
        border: none;
        padding: 12px 15px;
    }

    #staffTable tbody tr {
        transition: background-color 0.2s ease;
    }

    #staffTable tbody tr:nth-child(even) {
        background-color: #e8f5e9;
    }

    #staffTable tbody tr:nth-child(odd) {
        background-color: #f1f8e9;
    }

    #staffTable tbody tr:hover {
        background-color: #c8e6c9;
    }

    #staffTable tbody td {
        border-color: #a5d6a7;
        padding: 10px 15px;
        color: #1b5e20;
        vertical-align: middle;
    }

    /* Status badges */
    .badge.bg-danger {
        background-color: #e53935 !important;
    }

    .badge.bg-success {
        background-color: #43a047 !important;
    }

    .badge.bg-warning {
        background-color: #ff9800 !important;
    }

    .badge.bg-info {
        background-color: #2196f3 !important;
    }

    .badge.bg-secondary {
        background-color: #6c757d !important;
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

    .action-buttons {
        display: flex;
        gap: 5px;
        flex-wrap: wrap;
    }

    .btn-sm {
        padding: 4px 8px;
        font-size: 0.875rem;
    }

    .role-badge {
        font-size: 0.75rem;
        padding: 4px 8px;
        border-radius: 12px;
    }

    .user-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #2e7d32;
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

                    <!-- Page Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2 class="text-success">
                            <i class="fas fa-users-cog me-2"></i>Staff Management
                        </h2>
                        <button class="btn custom-btn" data-bs-toggle="modal" data-bs-target="#addStaffModal">
                            <i class="fas fa-plus me-2"></i>Add New Staff
                        </button>
                    </div>

                    <!-- Add Staff Modal -->
                    <div class="modal fade" id="addStaffModal" tabindex="-1" aria-labelledby="addStaffModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-success text-white">
                                    <h5 class="modal-title" id="addStaffModalLabel">
                                        <i class="fas fa-user-plus me-2"></i>Add New Staff Member
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('add-staff') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="image" class="form-label">Profile Image</label>
                                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                                <div class="form-text">Optional: Upload staff profile picture</div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="role" class="form-label">Staff Role *</label>
                                                <select class="form-select" id="role" name="role" required>
                                                    <option value="">Select Staff Role</option>
                                                    <option value="csdl_staff">CSDL Staff</option>
                                                    <option value="it_staff">IT Staff</option>
                                                    <option value="monitoring_staff">Monitoring Staff</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="name" class="form-label">Full Name *</label>
                                                <input type="text" class="form-control" id="name" name="name" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="email" class="form-label">Email Address *</label>
                                                <input type="email" class="form-control" id="email" name="email" required>
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="address" class="form-label">Address *</label>
                                            <input type="text" class="form-control" id="address" name="address" required>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4 mb-3">
                                                <label for="age" class="form-label">Age *</label>
                                                <input type="number" class="form-control" id="age" name="age" min="18" required>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="gender" class="form-label">Gender *</label>
                                                <select class="form-select" id="gender" name="gender" required>
                                                    <option value="">Select Gender</option>
                                                    <option value="male">Male</option>
                                                    <option value="female">Female</option>
                                                    <option value="others">Others</option>
                                                </select>
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label for="contact" class="form-label">Contact Number *</label>
                                                <input type="tel" class="form-control" id="contact" name="contact" required>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="password" class="form-label">Password *</label>
                                                <input type="password" class="form-control" id="password" name="password" required minlength="8">
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="password_confirmation" class="form-label">Confirm Password *</label>
                                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                            </div>
                                        </div>

                                        <div class="d-grid">
                                            <button type="submit" class="btn btn-success">
                                                <i class="fas fa-save me-2"></i>Add Staff Member
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Staff Table -->
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered" id="staffTable">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Profile</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Contact</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($staffUsers as $staff)
                                    <tr>
                                        <td class="text-center">
                                            @if($staff->image)
                                                <img src="{{ asset('storage/' . $staff->image) }}" alt="Staff Image" class="user-avatar">
                                            @else
                                                <img src="{{ asset('assets/logo.jpg') }}" alt="Default Image" class="user-avatar">
                                            @endif
                                        </td>
                                        <td>
                                            <strong>{{ $staff->name }}</strong>
                                            <br>
                                            <small class="text-muted">Age: {{ $staff->age }}, {{ ucfirst($staff->gender) }}</small>
                                        </td>
                                        <td>{{ $staff->email }}</td>
                                        <td>
                                            @php
                                                $roleBadges = [
                                                    'csdl_staff' => ['bg-primary', 'CSDL Staff'],
                                                    'it_staff' => ['bg-info', 'IT Staff'],
                                                    'monitoring_staff' => ['bg-warning', 'Monitoring Staff']
                                                ];
                                                $badge = $roleBadges[$staff->role] ?? ['bg-secondary', 'Staff'];
                                            @endphp
                                            <span class="badge role-badge {{ $badge[0] }}">{{ $badge[1] }}</span>
                                        </td>
                                        <td>
                                            @if (!$staff->contact)
                                                <span class="text-muted">Not provided</span>
                                            @else
                                                <span>{{ $staff->contact }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($staff->account_status === 'inactive')
                                                <span class="badge badge-pill bg-danger">Inactive</span>
                                            @else
                                                <span class="badge badge-pill bg-success">Active</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <!-- Activate/Deactivate Buttons -->
                                                @if ($staff->account_status === 'inactive')
                                                    <form action="{{ route('update-staff-status', $staff->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="account_status" value="active">
                                                        <button type="button" class="btn btn-success btn-sm activate-btn" 
                                                                data-staff-name="{{ $staff->name }}">
                                                            <i class="fas fa-check"></i> Activate
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('update-staff-status', $staff->id) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="account_status" value="inactive">
                                                        <button type="button" class="btn btn-warning btn-sm deactivate-btn" 
                                                                data-staff-name="{{ $staff->name }}">
                                                            <i class="fas fa-pause"></i> Deactivate
                                                        </button>
                                                    </form>
                                                @endif

                                                <!-- Delete Button -->
                                                <form action="{{ route('delete-staff', $staff->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-danger btn-sm delete-btn" 
                                                            data-staff-name="{{ $staff->name }}">
                                                        <i class="fas fa-trash"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted py-4">
                                            <i class="fas fa-users fa-3x mb-3"></i>
                                            <h5>No Staff Members Found</h5>
                                            <p>Click "Add New Staff" to create your first staff account.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize DataTable
            $('#staffTable').DataTable({
                "pageLength": 10,
                "ordering": true,
                "searching": true,
                "responsive": true
            });

            // Activate button confirmation
            $('.activate-btn').on('click', function(e) {
                e.preventDefault();
                const staffName = $(this).data('staff-name');
                const form = $(this).closest('form');
                
                Swal.fire({
                    icon: 'question',
                    title: 'Activate Staff Account',
                    text: `Are you sure you want to activate ${staffName}'s account?`,
                    showCancelButton: true,
                    confirmButtonText: 'Yes, activate it!',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#28a745'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // Deactivate button confirmation
            $('.deactivate-btn').on('click', function(e) {
                e.preventDefault();
                const staffName = $(this).data('staff-name');
                const form = $(this).closest('form');
                
                Swal.fire({
                    icon: 'warning',
                    title: 'Deactivate Staff Account',
                    text: `Are you sure you want to deactivate ${staffName}'s account?`,
                    showCancelButton: true,
                    confirmButtonText: 'Yes, deactivate it!',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#ffc107'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // Delete button confirmation
            $('.delete-btn').on('click', function(e) {
                e.preventDefault();
                const staffName = $(this).data('staff-name');
                const form = $(this).closest('form');
                
                Swal.fire({
                    icon: 'error',
                    title: 'Delete Staff Member',
                    html: `
                        <p>Are you sure you want to delete <strong>${staffName}</strong>?</p>
                        <p class="text-danger"><small>This action cannot be undone!</small></p>
                    `,
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#dc3545',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });

            // Form validation for password match
            $('#password_confirmation').on('keyup', function() {
                const password = $('#password').val();
                const confirmPassword = $(this).val();
                
                if (password !== confirmPassword) {
                    $(this).addClass('is-invalid');
                    $(this).removeClass('is-valid');
                } else {
                    $(this).removeClass('is-invalid');
                    $(this).addClass('is-valid');
                }
            });
        });
    </script>
</body>
</html>