<!DOCTYPE html>
<html lang="en">
<head>
@include('recipient.css')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<title>Recipient Requests</title>
<style>
    /* Green theme for all icons */
    .btn i, .category-tile i, .modal-title i, .badge i {
        color: #28a745 !important; /* Green color */
    }

    /* Enhanced table styling */
    #requestsTable {
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }

    #requestsTable thead {
        background: linear-gradient(135deg, #196f38 0%, #28a745 100%);
    }

    #requestsTable thead th {
        color: white;
        font-weight: 600;
        padding: 15px 10px;
        border: none;
    }

    #requestsTable tbody tr {
        transition: all 0.3s ease;
    }

    #requestsTable tbody tr:hover {
        background-color: rgba(40, 167, 69, 0.05);
        transform: translateY(-1px);
    }

    #requestsTable tbody td {
        padding: 12px 10px;
        vertical-align: middle;
        border-color: #e9ecef;
    }

    .table-responsive {
        border-radius: 10px;
    }

    /* Badge styling */
    .badge {
        padding: 8px 12px;
        border-radius: 20px;
        font-weight: 500;
    }

    .bg-warning { background-color: #ffc107 !important; color: #000 !important; }
    .bg-success { background-color: #28a745 !important; }
    .bg-danger { background-color: #dc3545 !important; }
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

    /* New styles for recipient dashboard */
    .welcome-banner {
        background: linear-gradient(135deg, #196f38 0%, #28a745 100%);
        border-radius: 12px;
        padding: 25px;
        color: white;
        margin-bottom: 25px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }

    .support-section {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 25px;
    }

    .support-header {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    .support-header i {
        font-size: 2rem;
        margin-right: 15px;
        color: #28a745 !important;
    }

    .support-tips {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 15px;
    }

    .support-tip {
        background: white;
        border-radius: 10px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }

    .support-tip i {
        font-size: 2rem;
        color: #28a745 !important;
        margin-bottom: 15px;
    }

    .community-section {
        margin-bottom: 30px;
    }

    .community-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
        margin-bottom: 15px;
        border-left: 4px solid #28a745;
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

    @media (max-width: 768px) {
        .category-tiles {
            grid-template-columns: repeat(2, 1fr);
        }

        .quantity-unit-container {
            flex-direction: column;
        }
    }
</style>
</head>
<body>
@include('recipient.header')
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
                    <!-- Welcome Banner -->
                    <div class="welcome-banner">
                        <h2><i class="fas fa-hands-helping me-2"></i>Welcome, {{ Auth::user()->name }}!</h2>
                        <p class="mb-0">Our community is here to support you. You can request items you need through this platform.</p>
                    </div>

                    <!-- Motivation Quote -->
                    <div class="motivation-quote">
                        <p class="quote-text">"We rise by lifting others."</p>
                        <p class="quote-author">- Robert Ingersoll</p>
                    </div>

                    <!-- Support Section -->
                    <div class="support-section">
                        <div class="support-header">
                            <i class="fas fa-info-circle"></i>
                            <h4>Getting Support</h4>
                        </div>
                        <div class="support-tips">
                            <div class="support-tip">
                                <i class="fas fa-lightbulb"></i>
                                <h5>Be Specific</h5>
                                <p>Clearly describe what you need and why it's important for your situation</p>
                            </div>
                            <div class="support-tip">
                                <i class="fas fa-hand-holding-heart"></i>
                                <h5>Community Care</h5>
                                <p>Our community members are generous and want to help those in need</p>
                            </div>
                            <div class="support-tip">
                                <i class="fas fa-comments"></i>
                                <h5>Clear Communication</h5>
                                <p>Provide accurate contact information so donors can reach you</p>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3><i class="fas fa-list-alt me-2"></i>My Requests</h3>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRequestModal">
                            <i class="fas fa-plus"></i> Click here to Request
                        </button>
                    </div>

                    <!-- Create Request Modal with Tile Method -->
                    <div class="modal fade" id="createRequestModal" tabindex="-1" aria-labelledby="createRequestModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="createRequestModalLabel"><i class="fas fa-plus-circle me-2"></i>New Request</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>

                                <!-- Category Selection Screen -->
                                <div id="categorySelection" class="modal-body active-screen">
                                    <h5 class="text-center mb-4"><i class="fas fa-folder-open me-2"></i>Select Request Category</h5>
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

                                        <!-- New Categories (Matching Donor Categories) -->
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
                                <div id="requestFormContainer" class="modal-body form-screen">
                                    <div class="back-button" onclick="showScreen('subcategorySelection')">
                                        <i class="fas fa-arrow-left"></i> Back to Subcategories
                                    </div>
                                    <form id="requestForm" action="{{ route('requests.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="category" id="formCategory">
                                        <input type="hidden" name="subcategory" id="formSubcategory">

                                        <div class="row mb-3">
                                            <div class="col-md-4">
                                                <label class="form-label"><i class="fas fa-user me-1"></i> Full Name</label>
                                                <input type="text" class="form-control" name="full_name" value="{{ Auth::user()->name }}" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label"><i class="fas fa-phone me-1"></i> Contact Number</label>
                                                <input type="text" class="form-control" name="contact_number" value="{{ Auth::user()->contact }}" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label"><i class="fas fa-map-marker-alt me-1"></i> Address / Barangay</label>
                                                <input type="text" class="form-control" name="address" value="{{ Auth::user()->address }}" readonly>
                                            </div>
                                        </div>

                                        <div id="dynamicFormFields">
                                            <!-- Dynamic form fields will be loaded here based on category/subcategory -->
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label"><i class="fas fa-file-alt me-1"></i> Description / Reason for Request</label>
                                            <textarea class="form-control" name="description" rows="4" required placeholder="Please explain your need for this item"></textarea>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane me-1"></i> Submit Request</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Community Stories -->
                    <div class="community-section">
                        <h4 class="mb-3"><i class="fas fa-heart me-2"></i>Community Support Stories</h4>
                        <div class="community-card">
                            <p>"Thanks to the generous donors, my children had warm clothes for winter and supplies for school. This community support means more than you know."</p>
                            <p class="text-muted">- Maria, single mother of three</p>
                        </div>
                        <div class="community-card">
                            <p>"The medical supplies I received helped me manage my diabetes during a difficult financial time. Thank you for this life-changing support."</p>
                            <p class="text-muted">- James, retired veteran</p>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>

    <script>
        // Define categories and subcategories (matching donor categories)
        const categories = {
            wearable: {
                name: "Wearable",
                subcategories: [
                    { id: "shirt", name: "Shirt", icon: "fa-tshirt" },
                    { id: "pants", name: "Pants", icon: "fa-vest" },
                    { id: "jacket", name: "Jacket", icon: "fa-jacket" },
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
            // New Categories (Matching Donor Categories)
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

        // Define units for different categories (matching donor units)
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

        $(document).ready(function() {
            // Initialize DataTable with enhanced styling
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

            // Reset modal when closed
            $('#createRequestModal').on('hidden.bs.modal', function() {
                showScreen('categorySelection');
            });

            // Category tile click handler
            $('.category-tile').click(function() {
                currentCategory = $(this).data('category');
                showSubcategories(currentCategory);
            });

            // Edit button click handler
            $(document).on('click', '.edit-request', function() {
                const requestId = $(this).data('id');
                $.get(`/requests/${requestId}`, function(data) {
                    $('#editRequestForm').attr('action', `/requests/${requestId}`);

                    // Fill the form with existing data
                    $('#edit_full_name').val(data.full_name);
                    $('#edit_contact_number').val(data.contact_number);
                    $('#edit_address').val(data.address);
                    $('#edit_wearable_type').val(data.wearable_type);
                    $('#edit_quantity').val(data.quantity);
                    $('#edit_description').val(data.description);
                    $('#edit_preferred_date').val(data.preferred_date ? data.preferred_date.split(' ')[0] : '');

                    // Update size options based on wearable type
                    const sizeSelect = $('#edit_size');
                    updateSizeOptions(data.wearable_type, sizeSelect);
                    sizeSelect.val(data.size);

                    $('#editRequestModal').modal('show');
                }).fail(function(xhr, status, error) {
                    console.error("Error fetching request data:", error);
                });
            });

            // Delete button click handler
            $(document).on('click', '.delete-request', function() {
                const requestId = $(this).data('id');
                $('#deleteRequestForm').attr('action', `/requests/${requestId}`);
                $('#deleteRequestModal').modal('show');
            });
        });

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
                    <div class="category-tile" data-subcategory="${subcat.id}" onclick="showRequestForm('${category}', '${subcat.id}')">
                        <i class="fas ${subcat.icon}"></i>
                        <span>${subcat.name}</span>
                    </div>
                `);
            });

            showScreen('subcategorySelection');
        }

        function showRequestForm(category, subcategory) {
            currentSubcategory = subcategory;

            // Set the form subcategory
            $('#formSubcategory').val($(`.category-tile[data-subcategory="${subcategory}"] span`).text());

            // Load dynamic form fields based on category/subcategory
            const dynamicFields = $('#dynamicFormFields').empty();

            // Common fields with quantity and unit (matching donor form)
            dynamicFields.append(`
                <h5 class="mb-3"><i class="fas fa-info-circle me-2"></i>${categories[category].name} Details</h5>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label"><i class="fas fa-calculator me-1"></i> Quantity Needed</label>
                        <div class="quantity-unit-container">
                            <input type="number" class="form-control quantity-input" name="quantity" required min="1" placeholder="Enter quantity">
                            <select class="form-select unit-select" name="unit" required>
                                ${getUnitOptions(category)}
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label"><i class="fas fa-calendar-alt me-1"></i> Urgency</label>
                        <select class="form-select" name="urgency" required>
                            <option value="">Select urgency</option>
                            <option value="asap">ASAP (As Soon As Possible)</option>
                            <option value="within_week">Within 1 Week</option>
                            <option value="within_month">Within 1 Month</option>
                            <option value="flexible">Flexible/No Rush</option>
                        </select>
                    </div>
                </div>
            `);

            // Category-specific fields (matching donor form structure)
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
                            <label class="form-label"><i class="fas fa-ruler me-1"></i> Size Needed</label>
                            <select class="form-select" name="size" required>
                                ${getSizeOptions(subcategory)}
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label"><i class="fas fa-star me-1"></i> Acceptable Condition</label>
                            <select class="form-select" name="condition" required>
                                <option value="Gently Used">Gently Used</option>
                                <option value="New">New</option>
                                <option value="Any">Any Condition</option>
                            </select>
                        </div>
                    </div>
                `);
            } else if (category === 'food' || category === 'medical') {
                dynamicFields.append(`
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label"><i class="fas fa-list me-1"></i> Specific Items Needed</label>
                            <input type="text" class="form-control" name="specific_items" placeholder="e.g., Rice, Canned goods, Milk" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label"><i class="fas fa-calendar-times me-1"></i> Expiration Date Requirement</label>
                            <select class="form-select" name="expiration_preference">
                                <option value="any">Any expiration date</option>
                                <option value="3_months">At least 3 months remaining</option>
                                <option value="6_months">At least 6 months remaining</option>
                                <option value="1_year">At least 1 year remaining</option>
                            </select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label"><i class="fas fa-star me-1"></i> Acceptable Condition</label>
                            <select class="form-select" name="condition" required>
                                <option value="Fresh/New">Fresh/New</option>
                                <option value="Non-perishable">Non-perishable</option>
                                <option value="Any">Any Condition</option>
                            </select>
                        </div>
                    </div>
                `);
            } else if (category === 'household' || category === 'technology' || category === 'disaster' ||
                       category === 'toys' || category === 'senior') {
                // For the new categories (matching donor form)
                dynamicFields.append(`
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label"><i class="fas fa-list me-1"></i> Item Name / Description Needed</label>
                            <input type="text" class="form-control" name="item_description" placeholder="e.g., Rice cooker - working condition" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label"><i class="fas fa-star me-1"></i> Acceptable Condition</label>
                            <select class="form-select" name="condition" required>
                                ${getConditionOptions(category)}
                            </select>
                        </div>
                    </div>
                `);

                // Add category-specific fields for technology
                if (category === 'technology') {
                    dynamicFields.append(`
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-plug me-1"></i> Required Accessories</label>
                                <input type="text" class="form-control" name="accessories_included" placeholder="e.g., charger, cables">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label"><i class="fas fa-check-circle me-1"></i> Functionality Requirement</label>
                                <select class="form-select" name="functionality_requirement">
                                    <option value="fully_functional">Must be fully functional</option>
                                    <option value="minor_issues">Minor issues acceptable</option>
                                    <option value="any">Any condition acceptable</option>
                                </select>
                            </div>
                        </div>
                    `);
                }
            } else {
                // For other categories (hygiene, school)
                dynamicFields.append(`
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label"><i class="fas fa-list me-1"></i> Specific Items Needed</label>
                            <input type="text" class="form-control" name="specific_items" placeholder="List the specific items you need" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label"><i class="fas fa-star me-1"></i> Acceptable Condition</label>
                            <select class="form-select" name="condition" required>
                                <option value="New">New</option>
                                <option value="Used - Good">Used - Good</option>
                                <option value="Used - Fair">Used - Fair</option>
                                <option value="Any">Any Condition</option>
                            </select>
                        </div>
                    </div>
                `);
            }

            showScreen('requestFormContainer');
        }

        // Function to get unit options based on category (matching donor form)
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
                        <option value="Any">Any Condition</option>
                    `;
                    break;
                case 'technology':
                    options = `
                        <option value="Brand New">Brand New</option>
                        <option value="Gently Used (Fully Functional)">Gently Used (Fully Functional)</option>
                        <option value="Used (Minor Issues)">Used (Minor Issues)</option>
                        <option value="Needs Repair / Parts">Needs Repair / Parts</option>
                        <option value="Any">Any Condition</option>
                    `;
                    break;
                case 'disaster':
                    options = `
                        <option value="Brand New">Brand New</option>
                        <option value="Gently Used (Clean and Functional)">Gently Used (Clean and Functional)</option>
                        <option value="Any">Any Condition</option>
                    `;
                    break;
                case 'toys':
                    options = `
                        <option value="Brand New">Brand New</option>
                        <option value="Gently Used (Good Condition)">Gently Used (Good Condition)</option>
                        <option value="Used (Still Functional)">Used (Still Functional)</option>
                        <option value="Any">Any Condition</option>
                    `;
                    break;
                case 'senior':
                    options = `
                        <option value="Brand New">Brand New</option>
                        <option value="Gently Used">Gently Used</option>
                        <option value="Needs Minor Repair">Needs Minor Repair</option>
                        <option value="Any">Any Condition</option>
                    `;
                    break;
                default:
                    options = `
                        <option value="New">New</option>
                        <option value="Used - Good">Used - Good</option>
                        <option value="Used - Fair">Used - Fair</option>
                        <option value="Any">Any Condition</option>
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
