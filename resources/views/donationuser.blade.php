<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('recipient.css')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Donation Dashboard</title>
    <style>
        /* Your existing CSS styles remain the same */
        html, body {
            height: 100%;
        }

        body {
            display: flex;
            flex-direction: column;
        }

        .footer {
            margin-top: auto;
        }

        /* Green theme for all icons */
        .btn i, .category-tile i, .modal-title i, .badge i, .form-label i {
            color: #28a745 !important; /* Green color */
        }

        /* Enhanced table styling */
        #donationsTable {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            margin-top: 20px;
        }

        #donationsTable thead {
            background: linear-gradient(135deg, #196f38 0%, #28a745 100%);
        }

        #donationsTable thead th {
            color: white;
            font-weight: 600;
            padding: 15px 10px;
            border: none;
            text-align: center;
        }

        #donationsTable tbody tr {
            transition: all 0.3s ease;
        }

        #donationsTable tbody tr:hover {
            background-color: rgba(40, 167, 69, 0.05);
            transform: translateY(-1px);
        }

        #donationsTable tbody td {
            padding: 12px 10px;
            vertical-align: middle;
            border-color: #e9ecef;
            text-align: center;
        }

        .table-responsive {
            border-radius: 10px;
            background: white;
        }

        /* Badge styling */
        .badge {
            padding: 8px 12px;
            border-radius: 20px;
            font-weight: 500;
        }

        .bg-warning { background-color: #ffc107 !important; color: #000 !important; }
        .bg-success { background-color: #28a745 !important; }
        .bg-info { background-color: #17a2b8 !important; }
        .bg-secondary { background-color: #6c757d !important; }

        /* Button styling */
        .btn-sm {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.875rem;
        }

        /* Category tiles styling */
        .category-tiles {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            padding: 15px;
        }

        .category-tile {
            border: 2px solid #e9ecef;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            height: 120px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background: white;
        }

        .category-tile:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(40, 167, 69, 0.2);
            border-color: #28a745;
        }

        .category-tile i {
            font-size: 2rem;
            margin-bottom: 10px;
            color: #28a745 !important;
        }

        .back-button {
            margin-bottom: 15px;
            cursor: pointer;
            color: #28a745;
            font-weight: 500;
        }

        .back-button i {
            margin-right: 5px;
            color: #28a745 !important;
        }

        .form-screen {
            display: none;
        }

        .active-screen {
            display: block;
        }

        /* Form styling */
        .form-label {
            font-weight: 500;
            color: #495057;
            margin-bottom: 8px;
        }

        .form-control, .form-select {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            padding: 10px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }

        /* Modal header styling */
        .modal-header {
            background: linear-gradient(135deg, #196f38 0%, #28a745 100%);
            color: white;
            border-radius: 10px 10px 0 0;
        }

        .modal-title {
            font-weight: 600;
        }

        .btn-close {
            filter: invert(1);
        }

        /* Donation limit indicator */
        .donation-limit {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 15px;
            margin-bottom: 20px;
            border-left: 4px solid #28a745;
        }

        .donation-progress {
            height: 8px;
            background: #e9ecef;
            border-radius: 4px;
            overflow: hidden;
            margin: 10px 0;
        }

        .donation-progress-bar {
            height: 100%;
            background: linear-gradient(135deg, #196f38 0%, #28a745 100%);
            border-radius: 4px;
            transition: width 0.3s ease;
        }

        /* Remove "Other" category styling */
        .category-tile[data-category="other"] {
            display: none !important;
        }

        /* New styles for enhanced content */
        .welcome-banner {
            background: linear-gradient(135deg, #196f38 0%, #28a745 100%);
            border-radius: 12px;
            padding: 25px;
            color: white;
            margin-bottom: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-card i {
            font-size: 2rem;
            margin-bottom: 10px;
            color: #28a745 !important;
        }

        .stat-card h3 {
            margin: 0;
            font-size: 2rem;
            font-weight: 700;
        }

        .stat-card p {
            margin: 5px 0 0;
            color: #6c757d;
        }

        .impact-section {
            background: #f8f9fa;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 25px;
        }

        .impact-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .impact-header i {
            font-size: 2rem;
            margin-right: 15px;
            color: #28a745 !important;
        }

        .impact-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
        }

        .impact-stat {
            text-align: center;
            padding: 15px;
        }

        .impact-stat i {
            font-size: 1.5rem;
            color: #28a745 !important;
            margin-bottom: 10px;
        }

        .impact-stat h4 {
            margin: 0;
            font-size: 1.5rem;
        }

        .impact-stat p {
            margin: 5px 0 0;
            color: #6c757d;
        }

        .testimonial-section {
            margin-bottom: 30px;
        }

        .testimonial-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
            margin-bottom: 15px;
            border-left: 4px solid #28a745;
        }

        .testimonial-text {
            font-style: italic;
            margin-bottom: 10px;
        }

        .testimonial-author {
            font-weight: 600;
            color: #28a745;
        }

        .motivation-quote {
            background: linear-gradient(135deg, #196f38 0%, #28a745 100%);
            color: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            margin-bottom: 25px;
        }

        .quote-text {
            font-size: 1.2rem;
            font-style: italic;
            margin-bottom: 10px;
        }

        .quote-author {
            font-weight: 600;
        }

        .donation-tips {
            background: #e8f5e9;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .donation-tips h4 {
            color: #196f38;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .donation-tips h4 i {
            margin-right: 10px;
        }

        .tip-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .tip-item i {
            color: #28a745 !important;
            margin-right: 10px;
            margin-top: 5px;
        }

        .recent-activity {
            margin-bottom: 25px;
        }

        .activity-item {
            display: flex;
            align-items: center;
            padding: 10px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-icon {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(40, 167, 69, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
        }

        .activity-icon i {
            color: #28a745 !important;
        }

        .activity-content {
            flex: 1;
        }

        .activity-content h6 {
            margin: 0;
            font-weight: 600;
        }

        .activity-content p {
            margin: 0;
            color: #6c757d;
            font-size: 0.9rem;
        }

        .social-share {
            background: white;
            border-radius: 10px;
            padding: 20px;
            text-align: center;
            margin-bottom: 25px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        }

        .social-share h5 {
            margin-bottom: 15px;
            color: #196f38;
        }

        .social-buttons {
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .social-btn {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            transition: transform 0.3s ease;
        }

        .social-btn:hover {
            transform: scale(1.1);
        }

        /* Footer */
        .footer {
            background-color: #196f38;
            color: #fff;
            padding: 5px;
            text-align: center;
        }

        .footer p {
            margin-top: 20px;
        }

        .fb-btn { background: #3b5998; }
        .twitter-btn { background: #1da1f2; }
        .whatsapp-btn { background: #25d366; }

        /* Anonymous checkbox styling */
        .anonymous-checkbox {
            margin-top: 10px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 3px solid #28a745;
        }

        .form-check-input:checked {
            background-color: #28a745;
            border-color: #28a745;
        }

        /* Quantity and Unit styling */
        .quantity-unit-container {
            display: flex;
            gap: 10px;
        }

        .quantity-input {
            flex: 2;
        }

        .unit-select {
            flex: 1;
        }

        /* Date validation styling */
        .date-error {
            color: #dc3545;
            font-size: 0.875rem;
            margin-top: 5px;
            display: none;
        }

        .date-error.show {
            display: block;
        }

        .date-input.invalid {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }

        @media (max-width: 768px) {
            .category-tiles {
                grid-template-columns: repeat(2, 1fr);
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .quantity-unit-container {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    @include('donor.header')
    <section>
        <div class="container-fluid">
            <div class="row">
                <div class="main-content">
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
                        <!-- Your existing content remains the same -->
                        <!-- Welcome Banner -->
                        <div class="welcome-banner">
                            <h2><i class="fas fa-hands-helping me-2"></i>Welcome, {{ Auth::user()->name }}!</h2>
                            <p class="mb-0">Your generosity is making a real difference in our community. Thank you for being a part of our mission.</p>
                        </div>

                        <!-- Stats Overview - Removed statistics -->
                        <div class="stats-grid">
                            <div class="stat-card">
                                <i class="fas fa-hand-holding-heart"></i>
                                <h3>Your Donations</h3>
                                <p>Making an impact</p>
                            </div>
                            <div class="stat-card">
                                <i class="fas fa-users"></i>
                                <h3>Community</h3>
                                <p>People helped together</p>
                            </div>
                            <div class="stat-card">
                                <i class="fas fa-trophy"></i>
                                <h3>Achievements</h3>
                                <p>Your contributions matter</p>
                            </div>
                            <div class="stat-card">
                                <i class="fas fa-calendar-check"></i>
                                <h3>Consistency</h3>
                                <p>Regular giving changes lives</p>
                            </div>
                        </div>

                        <!-- Motivation Quote -->
                        <div class="motivation-quote">
                            <p class="quote-text">"No one has ever become poor by giving."</p>
                            <p class="quote-author">- Anne Frank</p>
                        </div>

                        <!-- Impact Section - Removed statistics -->
                        <div class="impact-section">
                            <div class="impact-header">
                                <i class="fas fa-globe"></i>
                                <h4>Your Generosity Creates Impact</h4>
                            </div>
                            <div class="impact-stats">
                                <div class="impact-stat">
                                    <i class="fas fa-tshirt"></i>
                                    <h4>Warmth</h4>
                                    <p>Providing clothing</p>
                                </div>
                                <div class="impact-stat">
                                    <i class="fas fa-utensils"></i>
                                    <h4>Nourishment</h4>
                                    <p>Sharing meals</p>
                                </div>
                                <div class="impact-stat">
                                    <i class="fas fa-book"></i>
                                    <h4>Education</h4>
                                    <p>Supporting learning</p>
                                </div>
                                <div class="impact-stat">
                                    <i class="fas fa-heart"></i>
                                    <h4>Care</h4>
                                    <p>Touching lives</p>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3><i class="fas fa-hand-holding-heart me-2"></i>My Donations</h3>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createDonationModal">
                                <i class="fas fa-plus"></i> Click here to Donate
                            </button>
                        </div>

                        <!-- Donation Limit Indicator -->
                        @php
                            $donationCount = $donations->count();
                            $maxDonations = 10;
                            $minDonations = 5;
                            $progressPercentage = min(100, ($donationCount / $maxDonations) * 100);
                        @endphp

                        <div class="donation-limit">
                            <h6><i class="fas fa-chart-line me-2"></i>Donation Progress</h6>
                            <p class="mb-2">You have made <strong>{{ $donationCount }}</strong> out of <strong>{{ $maxDonations }}</strong> allowed donations this period.</p>
                            <div class="donation-progress">
                                <div class="donation-progress-bar" style="width: {{ $progressPercentage }}%"></div>
                            </div>
                            <small class="text-muted">
                                @if($donationCount >= $maxDonations)
                                    <i class="fas fa-info-circle me-1"></i>You've reached the maximum donation limit.
                                @elseif($donationCount >= $minDonations)
                                    <i class="fas fa-info-circle me-1"></i>You can make {{ $maxDonations - $donationCount }} more donations.
                                @else
                                    <i class="fas fa-info-circle me-1"></i>Keep going! You can make {{ $maxDonations - $donationCount }} more donations.
                                @endif
                            </small>
                        </div>

                        <!-- Donation Tips -->
                        <div class="donation-tips">
                            <h4><i class="fas fa-lightbulb"></i> Donation Tips</h4>
                            <div class="tip-item">
                                <i class="fas fa-check-circle"></i>
                                <div>Ensure all clothing items are clean and in good condition</div>
                            </div>
                            <div class="tip-item">
                                <i class="fas fa-check-circle"></i>
                                <div>Check expiration dates on food and medical items</div>
                            </div>
                            <div class="tip-item">
                                <i class="fas fa-check-circle"></i>
                                <div>Package fragile items carefully to prevent damage</div>
                            </div>
                            <div class="tip-item">
                                <i class="fas fa-check-circle"></i>
                                <div>Include a note of encouragement with your donation</div>
                            </div>
                        </div>

                        <!-- Recent Activity - Static examples -->
                        <div class="recent-activity">
                            <h4 class="mb-3"><i class="fas fa-history me-2"></i>Donation Opportunities</h4>
                            <div class="activity-item">
                                <div class="activity-icon">
                                    <i class="fas fa-tshirt"></i>
                                </div>
                                <div class="activity-content">
                                    <h6>Winter Clothing Drive</h6>
                                    <p>Help keep our community warm this winter</p>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon">
                                    <i class="fas fa-utensils"></i>
                                </div>
                                <div class="activity-content">
                                    <h6>Food Collection</h6>
                                    <p>Non-perishable items needed for local families</p>
                                </div>
                            </div>
                            <div class="activity-item">
                                <div class="activity-icon">
                                    <i class="fas fa-book"></i>
                                </div>
                                <div class="activity-content">
                                    <h6>Back to School Initiative</h6>
                                    <p>Support students with school supplies</p>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonials -->
                        <div class="testimonial-section">
                            <h4 class="mb-3"><i class="fas fa-comments me-2"></i>Stories of Impact</h4>
                            <div class="testimonial-card">
                                <p class="testimonial-text">"Thanks to donors like you, my children have warm clothes for winter and supplies for school. Your generosity means more than you know."</p>
                                <p class="testimonial-author">- Maria, single mother of three</p>
                            </div>
                            <div class="testimonial-card">
                                <p class="testimonial-text">"The medical supplies I received helped me manage my diabetes during a difficult financial time. Thank you for saving lives."</p>
                                <p class="testimonial-author">- James, retired veteran</p>
                            </div>
                        </div>

                        <!-- Create Donation Modal with Tile Method -->
                        <div class="modal fade" id="createDonationModal" tabindex="-1" aria-labelledby="createDonationModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="createDonationModalLabel"><i class="fas fa-plus-circle me-2"></i>New Donation</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <!-- Category Selection Screen -->
                                    <div id="categorySelection" class="modal-body active-screen">
                                        <h5 class="text-center mb-4"><i class="fas fa-folder-open me-2"></i>Select Donation Category</h5>
                                        <div class="category-tiles">
                                            <!-- Existing Categories -->
                                            <div class="category-tile" data-category="wearable">
                                                <i class="fas fa-tshirt"></i>
                                                <span>Wearable</span>
                                            </div>
                                            <div class="category-tile" data-category="food">
                                                <i class="fas fa-utensils"></i>
                                                <span>Food</span>
                                            </div>
                                            <div class="category-tile" data-category="hygiene">
                                                <i class="fas fa-pump-soap"></i>
                                                <span>Hygiene</span>
                                            </div>
                                            <div class="category-tile" data-category="school">
                                                <i class="fas fa-book"></i>
                                                <span>School Supplies</span>
                                            </div>
                                            <div class="category-tile" data-category="medical">
                                                <i class="fas fa-briefcase-medical"></i>
                                                <span>Medical</span>
                                            </div>

                                            <!-- New Categories -->
                                            <div class="category-tile" data-category="household">
                                                <i class="fas fa-home"></i>
                                                <span>Household Essentials</span>
                                            </div>
                                            <div class="category-tile" data-category="technology">
                                                <i class="fas fa-laptop"></i>
                                                <span>Technology & Electronics</span>
                                            </div>
                                            <div class="category-tile" data-category="disaster">
                                                <i class="fas fa-first-aid"></i>
                                                <span>Disaster Relief</span>
                                            </div>
                                            <div class="category-tile" data-category="toys">
                                                <i class="fas fa-gamepad"></i>
                                                <span>Toys & Recreation</span>
                                            </div>
                                            <div class="category-tile" data-category="senior">
                                                <i class="fas fa-wheelchair"></i>
                                                <span>Senior & Disability Support</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Subcategory Selection Screen -->
                                    <div id="subcategorySelection" class="modal-body form-screen">
                                        <div class="back-button" onclick="showScreen('categorySelection')">
                                            <i class="fas fa-arrow-left"></i> Back to Categories
                                        </div>
                                        <h5 class="text-center mb-4"><i class="fas fa-tags me-2"></i>Select Subcategory</h5>
                                        <div class="category-tiles" id="subcategoryTiles">
                                            <!-- Subcategories will be loaded here dynamically -->
                                        </div>
                                    </div>

                                    <!-- Form Screen -->
                                    <div id="donationFormContainer" class="modal-body form-screen">
                                        <div class="back-button" onclick="showScreen('subcategorySelection')">
                                            <i class="fas fa-arrow-left"></i> Back to Subcategories
                                        </div>
                                        <form id="donationForm" action="{{ route('donations.store') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="category" id="formCategory">
                                            <input type="hidden" name="subcategory" id="formSubcategory">
                                            <input type="hidden" name="is_anonymous" id="isAnonymous" value="0">

                                            <div class="row mb-3">
                                                <div class="col-md-4">
                                                    <label class="form-label"><i class="fas fa-user me-1"></i> Full Name</label>
                                                    <input type="text" class="form-control" name="full_name" id="fullNameInput" value="{{ Auth::user()->name }}" readonly>

                                                    <!-- Anonymous Checkbox -->
                                                    <div class="anonymous-checkbox mt-2">
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox" id="anonymousCheckbox">
                                                            <label class="form-check-label" for="anonymousCheckbox">
                                                                <i class="fas fa-user-secret me-1"></i> Be Anonymous
                                                            </label>
                                                        </div>
                                                        <small class="text-muted">Your name will appear as asterisks (e.g., J*** C****)</small>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label"><i class="fas fa-phone me-1"></i> Contact Number</label>
                                                    <input type="text" class="form-control" name="contact_number" value="{{ Auth::user()->contact }}" readonly>
                                                </div>
                                                <div class="col-md-4">
                                                    <label class="form-label"><i class="fas fa-map-marker-alt me-1"></i> Location</label>
                                                    <input type="text" class="form-control" name="location" value="{{ Auth::user()->address }}" readonly>
                                                </div>
                                            </div>

                                            <div id="dynamicFormFields">
                                                <!-- Dynamic form fields will be loaded here based on category/subcategory -->
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label"><i class="fas fa-sticky-note me-1"></i> Additional Notes (Optional)</label>
                                                <textarea class="form-control" name="notes" rows="4" placeholder="Any additional information about your donation"></textarea>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label"><i class="fas fa-camera me-1"></i> Upload Photos (Optional)</label>
                                                <input type="file" class="form-control" name="photos[]" multiple accept="image/*">
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane me-1"></i> Submit Donation</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        // Define categories and subcategories (including new categories)
        const categories = {
            wearable: {
                name: "Wearable",
                subcategories: [
                    { id: "shirt", name: "Shirt", icon: "fa-tshirt" },
                    { id: "pants", name: "Pants", icon: "fa-vest" },
                    { id: "jacket", name: "Jacket", icon: "fa-vest-patches" },
                    { id: "shoes", name: "Shoes", icon: "fa-shoe-prints" },
                    { id: "underwear", name: "Underwear", icon: "fa-socks" }
                ]
            },
            food: {
                name: "Food",
                subcategories: [
                    { id: "groceries", name: "Groceries", icon: "fa-shopping-basket" },
                    { id: "meals", name: "Prepared Meals", icon: "fa-utensils" },
                    { id: "babyfood", name: "Baby Food", icon: "fa-baby" }
                ]
            },
            hygiene: {
                name: "Hygiene",
                subcategories: [
                    { id: "soap", name: "Soap/Shampoo", icon: "fa-soap" },
                    { id: "toothpaste", name: "Toothpaste/Brush", icon: "fa-tooth" },
                    { id: "sanitary", name: "Sanitary Products", icon: "fa-pump-medical" }
                ]
            },
            school: {
                name: "School Supplies",
                subcategories: [
                    { id: "notebooks", name: "Notebooks", icon: "fa-book" },
                    { id: "pens", name: "Pens/Pencils", icon: "fa-pen" },
                    { id: "bag", name: "School Bag", icon: "fa-briefcase" }
                ]
            },
            medical: {
                name: "Medical",
                subcategories: [
                    { id: "medicine", name: "Medicine", icon: "fa-pills" },
                    { id: "first_aid", name: "First Aid", icon: "fa-first-aid" },
                    { id: "equipment", name: "Medical Equipment", icon: "fa-wheelchair" }
                ]
            },
            // New Categories
            household: {
                name: "Household Essentials",
                subcategories: [
                    { id: "kitchen_tools", name: "Kitchen Tools", icon: "fa-utensils" },
                    { id: "beds_linens", name: "Beds & Linens", icon: "fa-bed" },
                    { id: "furniture", name: "Furniture", icon: "fa-couch" },
                    { id: "lighting_appliances", name: "Lighting & Appliances", icon: "fa-lightbulb" },
                    { id: "cleaning_supplies", name: "Cleaning Supplies", icon: "fa-broom" },
                    // { id: "household_others", name: "Others", icon: "fa-ellipsis-h" }
                ]
            },
            technology: {
                name: "Technology and Electronics",
                subcategories: [
                    { id: "mobile_phones", name: "Mobile Phones", icon: "fa-mobile-alt" },
                    { id: "tablets_laptops", name: "Tablets / Laptops", icon: "fa-laptop" },
                    { id: "computers", name: "Computers", icon: "fa-desktop" },
                    { id: "computer_accessories", name: "Computer Accessories", icon: "fa-keyboard" },
                    { id: "printers_scanners", name: "Printers / Scanners", icon: "fa-print" },
                    { id: "chargers_power_banks", name: "Chargers / Power Banks", icon: "fa-battery-full" },
                    { id: "audio_devices", name: "Audio Devices", icon: "fa-headphones" },
                    { id: "cables_adapters", name: "Cables / Adapters", icon: "fa-plug" },
                    { id: "small_appliances", name: "Small Appliances", icon: "fa-plug" },
                    // { id: "technology_others", name: "Others", icon: "fa-ellipsis-h" }
                ]
            },
            disaster: {
                name: "Disaster Relief and Emergency",
                subcategories: [
                    { id: "first_aid_kits", name: "First Aid Kits & Medical Supplies", icon: "fa-first-aid" },
                    { id: "emergency_food_packs", name: "Emergency Food Packs", icon: "fa-utensils" },
                    { id: "bottled_water", name: "Bottled Water & Drinks", icon: "fa-wine-bottle" },
                    { id: "blankets_sleeping_mats", name: "Blankets & Sleeping Mats", icon: "fa-bed" },
                    { id: "clothing_evacuees", name: "Clothing (for evacuees)", icon: "fa-tshirt" },
                    { id: "hygiene_kits", name: "Hygiene Kits", icon: "fa-soap" },
                    { id: "flashlights_batteries", name: "Flashlights / Batteries / Power Banks", icon: "fa-lightbulb" },
                    { id: "tents_tarpaulins", name: "Tents / Tarpaulins", icon: "fa-campground" },
                    { id: "rescue_equipment", name: "Rescue Equipment", icon: "fa-life-ring" },
                    // { id: "disaster_others", name: "Others", icon: "fa-ellipsis-h" }
                ]
            },
            toys: {
                name: "Toys and Recreational Items",
                subcategories: [
                    { id: "stuffed_toys", name: "Stuffed Toys", icon: "fa-stuffed-toys" },
                    { id: "educational_toys", name: "Educational Toys", icon: "fa-puzzle-piece" },
                    { id: "board_card_games", name: "Board & Card Games", icon: "fa-dice" },
                    { id: "outdoor_sports", name: "Outdoor/Sports Equipment", icon: "fa-baseball-ball" },
                    { id: "musical_instruments", name: "Musical Instruments", icon: "fa-guitar" },
                    { id: "art_craft", name: "Art & Craft Materials", icon: "fa-palette" },
                    // { id: "toys_others", name: "Others", icon: "fa-ellipsis-h" }
                ]
            },
            senior: {
                name: "Senior and Disability Support",
                subcategories: [
                    { id: "walking_canes", name: "Walking Canes", icon: "fa-walking-cane" },
                    { id: "wheelchairs", name: "Wheelchairs", icon: "fa-wheelchair" },
                    { id: "crutches", name: "Crutches", icon: "fa-crutches" },
                    { id: "adult_diapers", name: "Adult Diapers", icon: "fa-baby" },
                    { id: "hearing_aids", name: "Hearing Aids", icon: "fa-deaf" },
                    { id: "medical_alert_devices", name: "Medical Alert Devices", icon: "fa-bell" },
                    // { id: "senior_others", name: "Others", icon: "fa-ellipsis-h" }
                ]
            }
        };

        // Define units for different categories
        const categoryUnits = {
            wearable: ["pieces", "pairs", "sets"],
            food: ["kg", "grams", "liters", "pieces", "packets", "boxes"],
            hygiene: ["pieces", "packs", "bottles", "tubes", "boxes"],
            school: ["pieces", "packs", "sets", "boxes"],
            medical: ["pieces", "packs", "bottles", "boxes", "strips"],
            household: ["pieces", "sets", "pairs", "units"],
            technology: ["pieces", "units", "sets"],
            disaster: ["pieces", "packs", "kits", "bottles", "boxes"],
            toys: ["pieces", "sets", "pairs"],
            senior: ["pieces", "pairs", "units", "packs"]
        };

        let currentCategory = null;
        let currentSubcategory = null;

        // Date validation functions
        function setMinDateForInputs() {
            const today = new Date();
            const todayString = today.toISOString().split('T')[0];

            // Set min attribute for all date inputs
            $('input[type="date"]').each(function() {
                $(this).attr('min', todayString);
            });
        }

        function validateDateInput(input) {
            const selectedDate = new Date(input.value);
            const today = new Date();
            today.setHours(0, 0, 0, 0); // Reset time to compare dates only

            if (selectedDate < today) {
                // Show error
                $(input).addClass('invalid');
                $(input).siblings('.date-error').addClass('show');
                return false;
            } else {
                // Remove error
                $(input).removeClass('invalid');
                $(input).siblings('.date-error').removeClass('show');
                return true;
            }
        }

        function validateFormDates() {
            let isValid = true;

            $('input[type="date"]').each(function() {
                if (this.value && !validateDateInput(this)) {
                    isValid = false;
                }
            });

            return isValid;
        }

        $(document).ready(function() {
            // Initialize DataTable with enhanced styling
            $('#donationsTable').DataTable({
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

            // Set min date for all date inputs when page loads
            setMinDateForInputs();

            // Reset modal when closed
            $('#createDonationModal').on('hidden.bs.modal', function() {
                showScreen('categorySelection');
                resetAnonymousCheckbox();
            });

            // Anonymous checkbox handler
            $('#anonymousCheckbox').change(function() {
                const isChecked = $(this).is(':checked');
                const fullNameInput = $('#fullNameInput');
                const originalName = "{{ Auth::user()->name }}";

                if (isChecked) {
                    // Convert name to asterisk format
                    const anonymousName = convertToAnonymous(originalName);
                    fullNameInput.val(anonymousName);
                    $('#isAnonymous').val('1');
                } else {
                    // Restore original name
                    fullNameInput.val(originalName);
                    $('#isAnonymous').val('0');
                }
            });

            // Category tile click handler
            $('.category-tile').click(function() {
                currentCategory = $(this).data('category');
                showSubcategories(currentCategory);
            });

            // Donate Again button handler
            $(document).on('click', '.donate-again-btn', function() {
                const category = $(this).data('category');
                const subcategory = $(this).data('subcategory');

                Swal.fire({
                    title: 'Donate Again?',
                    text: "Would you like to donate this item again?",
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, donate again!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Close current modal
                        $('.modal').modal('hide');

                        // Open create donation modal
                        $('#createDonationModal').modal('show');

                        // Automatically select the category and subcategory
                        setTimeout(() => {
                            $(`.category-tile[data-category="${category}"]`).click();
                            setTimeout(() => {
                                $(`.category-tile[data-subcategory="${subcategory}"]`).click();
                            }, 500);
                        }, 500);
                    }
                });
            });

            // Edit button click handler
            $(document).on('click', '.edit-donation', function() {
                const donationId = $(this).data('id');
                const $button = $(this);

                // Show loading state
                $button.html('<i class="fas fa-spinner fa-spin"></i>');

                $.get(`/donations/${donationId}/edit`, function(data) {
                    $('#editDonationForm').attr('action', `/donations/${donationId}`);

                    // Fill form with data
                    $('#edit_full_name').val(data.full_name);
                    $('#edit_contact_number').val(data.contact_number);
                    $('#edit_location').val(data.location);
                    $('#edit_wearable_type').val(data.wearable_type);
                    $('#edit_quantity').val(data.quantity);
                    $('#edit_condition').val(data.condition);
                    $('#edit_notes').val(data.notes);
                    $('#edit_available_date').val(data.available_date ? data.available_date.split(' ')[0] : '');

                    // Update size dropdown
                    const sizeSelect = $('#edit_size');
                    updateSizeOptions(data.wearable_type, sizeSelect);
                    sizeSelect.val(data.size);

                    // Set min date for edit form
                    setMinDateForInputs();

                    $('#editDonationModal').modal('show');
                })
                .fail(function(xhr) {
                    Swal.fire('Error', xhr.responseJSON?.message || 'Failed to load donation data', 'error');
                })
                .always(() => {
                    $button.html('<i class="fas fa-edit"></i>');
                });
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

            // Form submission validation
            $('#donationForm').on('submit', function(e) {
                if (!validateFormDates()) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Invalid Date',
                        text: 'Please select a date that is today or in the future.',
                        confirmButtonColor: '#28a745'
                    });
                }
            });

            // Real-time date validation
            $(document).on('change', 'input[type="date"]', function() {
                validateDateInput(this);
            });
        });

        // Function to convert name to anonymous format
        function convertToAnonymous(fullName) {
            return fullName.split(' ').map(word => {
                if (word.length <= 1) return word;
                return word.charAt(0) + '*'.repeat(word.length - 1);
            }).join(' ');
        }

        // Function to reset anonymous checkbox
        function resetAnonymousCheckbox() {
            $('#anonymousCheckbox').prop('checked', false);
            $('#fullNameInput').val("{{ Auth::user()->name }}");
            $('#isAnonymous').val('0');
        }

        function showScreen(screenId) {
            $('.modal-body').removeClass('active-screen').addClass('form-screen');
            $('#' + screenId).removeClass('form-screen').addClass('active-screen');
        }

        function showSubcategories(category) {
            $('#subcategoryTiles').empty();
            const categoryData = categories[category];

            // Set the form category
            $('#formCategory').val(categoryData.name);

            // Add subcategory tiles
            categoryData.subcategories.forEach(subcat => {
                $('#subcategoryTiles').append(`
                    <div class="category-tile" data-subcategory="${subcat.id}" onclick="showDonationForm('${category}', '${subcat.id}')">
                        <i class="fas ${subcat.icon}"></i>
                        <span>${subcat.name}</span>
                    </div>
                `);
            });

            showScreen('subcategorySelection');
        }

        function showDonationForm(category, subcategory) {
            currentSubcategory = subcategory;

            // Set the form subcategory
            $('#formSubcategory').val($(`.category-tile[data-subcategory="${subcategory}"] span`).text());

            // Load dynamic form fields based on category/subcategory
            const dynamicFields = $('#dynamicFormFields').empty();

            // Common fields with quantity and unit
            dynamicFields.append(`
                <h5 class="mb-3"><i class="fas fa-info-circle me-2"></i>${categories[category].name} Details</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label"><i class="fas fa-calculator me-1"></i> Quantity Available</label>
                        <div class="quantity-unit-container">
                            <input type="number" class="form-control quantity-input" name="quantity" required min="1" placeholder="Enter quantity">
                            <select class="form-select unit-select" name="unit" required>
                                ${getUnitOptions(category)}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><i class="fas fa-calendar-day me-1"></i> Available Date for Drop-Off/Pickup</label>
                        <input type="date" class="form-control date-input" name="available_date" required>
                        <div class="date-error">Please select a date that is today or in the future.</div>
                    </div>
                </div>
            `);

            // Category-specific fields
            if (category === 'wearable') {
                const subcategoryName = $(`.category-tile[data-subcategory="${subcategory}"] span`).text();
                dynamicFields.append(`
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-tshirt me-1"></i> Type of Wearable</label>
                            <input type="text" class="form-control" name="wearable_type" value="${subcategoryName}" readonly>
                            <input type="hidden" name="wearable_type" value="${subcategoryName}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label"><i class="fas fa-ruler me-1"></i> Size(s) Available</label>
                            <select class="form-select" name="size" required>
                                ${getSizeOptions(subcategory)}
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label"><i class="fas fa-star me-1"></i> Condition</label>
                            <select class="form-select" name="condition" required>
                                <option value="Gently Used">Gently Used</option>
                                <option value="New">New</option>
                            </select>
                        </div>
                    </div>
                `);
            } else if (category === 'food' || category === 'medical') {
                dynamicFields.append(`
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label"><i class="fas fa-list me-1"></i> Specific Items</label>
                            <input type="text" class="form-control" name="specific_items" placeholder="e.g., Rice, Canned goods, Milk" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label"><i class="fas fa-calendar-times me-1"></i> Expiration Date (if applicable)</label>
                            <input type="date" class="form-control date-input" name="expiration_date">
                            <div class="date-error">Please select a date that is today or in the future.</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label"><i class="fas fa-star me-1"></i> Condition</label>
                            <select class="form-select" name="condition" required>
                                <option value="Fresh/New">Fresh/New</option>
                                <option value="Non-perishable">Non-perishable</option>
                            </select>
                        </div>
                    </div>
                `);
            } else if (category === 'household' || category === 'technology' || category === 'disaster' ||
                       category === 'toys' || category === 'senior') {
                // For the new categories
                dynamicFields.append(`
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label"><i class="fas fa-list me-1"></i> Item Name / Description</label>
                            <input type="text" class="form-control" name="item_description" placeholder="e.g., Rice cooker - working condition" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label"><i class="fas fa-star me-1"></i> Condition</label>
                            <select class="form-select" name="condition" required>
                                ${getConditionOptions(category)}
                            </select>
                        </div>
                    </div>
                `);

                // Add category-specific fields
                if (category === 'technology') {
                    dynamicFields.append(`
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-plug me-1"></i> Accessories Included</label>
                                <input type="text" class="form-control" name="accessories_included" placeholder="e.g., charger, cables, box">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-check-circle me-1"></i> Tested for Functionality</label>
                                <select class="form-select" name="tested_functionality">
                                    <option value="Yes">Yes</option>
                                    <option value="No">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="data_privacy_agreement" id="dataPrivacyAgreement">
                                <label class="form-check-label" for="dataPrivacyAgreement">
                                    <i class="fas fa-shield-alt me-1"></i> I confirm that all personal data or files have been deleted from the device before donation.
                                </label>
                            </div>
                        </div>
                    `);
                }
            } else {
                // For other categories (hygiene, school)
                dynamicFields.append(`
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label"><i class="fas fa-list me-1"></i> Specific Items</label>
                            <input type="text" class="form-control" name="specific_items" placeholder="List the specific items you're donating" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label"><i class="fas fa-star me-1"></i> Condition</label>
                            <select class="form-select" name="condition" required>
                                <option value="New">New</option>
                                <option value="Used - Good">Used - Good</option>
                                <option value="Used - Fair">Used - Fair</option>
                            </select>
                        </div>
                    </div>
                `);
            }

            // Set min date for newly created date inputs
            setMinDateForInputs();

            showScreen('donationFormContainer');
        }

        // Function to get unit options based on category
        function getUnitOptions(category) {
            const units = categoryUnits[category] || ["pieces"];
            let options = '<option value="" selected disabled>Select unit</option>';

            units.forEach(unit => {
                options += `<option value="${unit}">${unit}</option>`;
            });

            return options;
        }

        function getConditionOptions(category) {
            let options = '';

            switch(category) {
                case 'household':
                    options = `
                        <option value="Brand New">Brand New</option>
                        <option value="Gently Used (Good Condition)">Gently Used (Good Condition)</option>
                        <option value="Used (Needs minor repair)">Used (Needs minor repair)</option>
                    `;
                    break;
                case 'technology':
                    options = `
                        <option value="Brand New">Brand New</option>
                        <option value="Gently Used (Fully Functional)">Gently Used (Fully Functional)</option>
                        <option value="Used (Minor Issues)">Used (Minor Issues)</option>
                        <option value="Needs Repair / Parts">Needs Repair / Parts</option>
                    `;
                    break;
                case 'disaster':
                    options = `
                        <option value="Brand New">Brand New</option>
                        <option value="Gently Used (Clean and Functional)">Gently Used (Clean and Functional)</option>
                    `;
                    break;
                case 'toys':
                    options = `
                        <option value="Brand New">Brand New</option>
                        <option value="Gently Used (Good Condition)">Gently Used (Good Condition)</option>
                        <option value="Used (Still Functional)">Used (Still Functional)</option>
                    `;
                    break;
                case 'senior':
                    options = `
                        <option value="Brand New">Brand New</option>
                        <option value="Gently Used">Gently Used</option>
                        <option value="Needs Minor Repair">Needs Minor Repair</option>
                    `;
                    break;
                default:
                    options = `
                        <option value="New">New</option>
                        <option value="Used - Good">Used - Good</option>
                        <option value="Used - Fair">Used - Fair</option>
                    `;
            }

            return options;
        }

        function getSizeOptions(subcategory) {
            let options = '<option value="" selected disabled>Select size</option>';

            if (subcategory === 'shoes') {
                // Shoe sizes
                const shoeSizes = ['3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];
                shoeSizes.forEach(size => {
                    options += `<option value="${size}">Size ${size}</option>`;
                });
            } else if (subcategory === 'other') {
                options = '<option value="N/A">Not applicable</option>';
            } else {
                // Age-based sizes for clothing
                options += '<optgroup label="Children">';
                const childSizes = ['2T', '3T', '4T', '5T', '6X', '7-8', '10-12'];
                childSizes.forEach(size => {
                    options += `<option value="${size}">${size}</option>`;
                });

                options += '<optgroup label="Teen/Adult">';
                const teenAdultSizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'];
                teenAdultSizes.forEach(size => {
                    options += `<option value="${size}">${size}</option>`;
                });
            }

            return options;
        }

        function updateSizeOptions(type, selectElement) {
            selectElement.empty();
            selectElement.append('<option value="" selected disabled>Select size</option>');

            if (type === 'Shoes') {
                // Add shoe sizes
                const shoeSizes = ['3', '4', '5', '6', '7', '8', '9', '10', '11', '12'];
                shoeSizes.forEach(size => {
                    selectElement.append(`<option value="${size}">Size ${size}</option>`);
                });
            } else if (type === 'Others') {
                selectElement.append('<option value="N/A">N/A</option>');
            } else {
                // Add clothing sizes
                selectElement.append('<optgroup label="Children">');
                const childSizes = ['2T', '3T', '4T', '5T', '6X', '7-8', '10-12'];
                childSizes.forEach(size => {
                    selectElement.append(`<option value="${size}">${size}</option>`);
                });

                selectElement.append('<optgroup label="Teen/Adult">');
                const teenAdultSizes = ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL'];
                teenAdultSizes.forEach(size => {
                    selectElement.append(`<option value="${size}">${size}</option>`);
                });
            }
        }
    </script>
</body>
</html>
