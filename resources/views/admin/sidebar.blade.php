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
        cursor: pointer;
    }
    .dropdown-toggle::after {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
    }

    /* Fix dropdown positioning inside sidebar */
    .sidebar .dropdown {
        position: relative;
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
    .floating-card {
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

    .floating-card h3 {
        font-size: 1.5em;
        margin-bottom: 20px;
        color: #007bff;
        border-bottom: 1px solid #eee;
        padding-bottom: 10px;
    }

    .floating-card p {
        margin-bottom: 15px;
    }

    .floating-card img {
        max-width: 90%;
        height: auto;
        border-radius: 8px;
        margin: 20px auto;
        display: block;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    .floating-card .close-card {
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
    .status-accepted {
        background-color: #28a745;
        color: #fff;
    }
    .status-rejected {
        background-color: #dc3545;
        color: #fff;
    }
    .status-fulfilled {
        background-color: #17a2b8;
        color: #fff;
    }
    .match-btn {
        margin-top: 10px;
    }
    .donation-item {
        border: 1px solid #ddd;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 10px;
        background-color: #f9f9f9;
    }
    .donation-item:hover {
        background-color: #f0f0f0;
    }
    .donation-item.selected {
        background-color: #d4edda;
        border-color: #c3e6cb;
    }
    .donation-details {
        margin-left: 10px;
    }
</style>

<div class="col-md-2 sidebar">
    <div class="user-profile">
        <div class="text-center mt-3">
            @if($auth->image)
                <img
                    src="{{ asset('storage/' . $auth->image) }}"
                    alt="User Image"
                    width="80"
                    height="80"
                    class="rounded-circle mb-2"
                    id="profile-image-{{ $auth->id }}"
                    style="cursor: pointer;"
                    data-bs-toggle="modal"
                    data-bs-target="#editUserModal">
            @else
                <img
                    src="{{ asset('assets/logo.jpg') }}"
                    alt="User Image"
                    width="80"
                    height="80"
                    class="rounded-circle mb-2"
                    id="profile-image-{{ $auth->id }}"
                    style="cursor: pointer;"
                    data-bs-toggle="modal"
                    data-bs-target="#editUserModal">
            @endif
        </div>
        <h4 class="text-center text-white mb-2">Admin {{ ucwords(Auth::user()->name) }}</h4>
    </div>

    <a href="{{ route('admindashboard') }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a>

    <!-- User Dropdown -->
    <div class="dropdown">
        <a class="dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-users"></i> User
        </a>
        <ul class="dropdown-menu" aria-labelledby="userDropdown">
            <li><a class="dropdown-item" href="{{route('userlist')}}">
                <i class="fas fa-user-friends"></i> Donors
                @if ($newrecord > 0)
                    <span class="badge badge-pill bg-danger">{{ $newrecord }}</span>
                @endif
            </a></li>
            <li><a class="dropdown-item" href="{{route('recipientlist')}}">
                <i class="fas fa-user-friends"></i> Recipients
                @if ($newrecord > 0)
                    <span class="badge badge-pill bg-danger">{{ $newrecord }}</span>
                @endif
            </a></li>
            <li><a class="dropdown-item" href="{{route('activationrequest')}}">
                <i class="fas fa-user-check"></i> Activation Request
                @if ($newservice > 0)
                    <span class="badge badge-pill bg-danger">{{ $newservice }}</span>
                @endif
            </a></li>
        </ul>
    </div>

    <a href="{{ route('show-recipient-request') }}"><i class="fas fa-hand-holding-heart"></i> Recipient Request</a>

    <!-- Donation Dropdown -->
    <div class="dropdown">
        <a class="dropdown-toggle" href="#" role="button" id="donationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fas fa-donate"></i> Donation
        </a>
        <ul class="dropdown-menu" aria-labelledby="donationDropdown">
            <li><a class="dropdown-item" href="{{route('admindonation')}}">
                <i class="fas fa-inbox"></i> Incoming Donations
                @if ($newdonation > 0)
                    <span class="badge badge-pill bg-danger">{{ $newdonation }}</span>
                @endif
            </a></li>
@php
$category = request()->input('category');
$subcategory = request()->input('subcategory');

// Count matching donations
$matchingDonationCount = \App\Models\Donation::where('status', 'approved')
    ->where(function($query) use ($category, $subcategory) {
        if ($category && $subcategory) {
            $query->whereRaw('LOWER(category) = ?', [strtolower($category)])
                  ->whereRaw('LOWER(subcategory) = ?', [strtolower($subcategory)]);
        }
    })
    ->count();
@endphp

<li>
    <a class="dropdown-item" href="{{ route('show-match') }}">
        <i class="fas fa-exchange-alt"></i> Match Request & Donations
        @if ($matchingDonationCount > 0)
            <span class="badge badge-pill bg-danger">{{ $matchingDonationCount }}</span>
        @endif
    </a>
</li>

            {{-- <li><a class="dropdown-item" href="{{route('inneeds')}}">
                <i class="fas fa-box-open"></i> Outgoing Donation
            </a></li> --}}
        </ul>
    </div>
        <a href="{{ route('admin_inventory') }}"><i class="fas fa-boxes"></i> Inventory</a>


    <a href="{{route('admingallery')}}"><i class="fas fa-images"></i> Gallery</a>
<!-- In your sidebar.blade.php -->
<a href="{{ route('staff-management') }}">
    <i class="fas fa-users-cog"></i> Staff Management
</a>

    <div class="logout-container">
        <button href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="logout-button">
            <i class="fas fa-sign-out-alt"></i> Logout
        </button>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>

    <!-- Modal for user editing -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit {{$auth->name}}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('updateuser', $auth->id) }}" method="POST" enctype="multipart/form-data" id="profileForm">
                    @csrf
                    @method('PUT')
                    <div class="mb-2">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                        @if ($auth->image)
                            <img src="{{ asset('storage/' . $auth->image) }}" alt="auth Image" class="img-thumbnail mt-2" style="width: 100px; height: 100px;">
                        @endif
                    </div>
                    <div class="mb-2">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $auth->name }}" required>
                    </div>
                    <div class="mb-2">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $auth->email }}" required>
                    </div>
                    <div class="mb-2">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="{{ $auth->address }}" required>
                    </div>
                    <div class="mb-2">
                        <label for="age" class="form-label">Age</label>
                        <input type="number" class="form-control" id="age" name="age" value="{{ $auth->age }}" required>
                    </div>
                    <div class="mb-2">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select" id="gender" name="gender" required>
                            <option value="male" {{ $auth->gender == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ $auth->gender == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="others" {{ $auth->gender == 'others' ? 'selected' : '' }}>Others</option>
                        </select>
                    </div>
                    <div class="mb-2">
                        <label for="contact" class="form-label">Contact</label>
                        <input type="tel" class="form-control" id="contact" name="contact" value="{{ $auth->contact }}">
                    </div>
                    <div class="mb-2">
                        <label for="password" class="form-label">New Password (optional)</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="mb-2">
                        <label for="password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>
                    <button type="submit" class="btn btn-primary">Update User</button>
                </form>
            </div>
        </div>
    </div>
    </div>
</div>

<script>
// Initialize Bootstrap dropdowns
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all dropdowns
    var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'))
    var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
        return new bootstrap.Dropdown(dropdownToggleEl)
    });

    // Handle form submission
    document.getElementById('profileForm').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const passwordConfirmation = document.getElementById('password_confirmation').value;

        if (password && password !== passwordConfirmation) {
            e.preventDefault();
            alert('Passwords do not match!');
        }
    });
});
</script>
