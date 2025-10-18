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
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Admin Dashboard - Analytics</title>
</head>
<style>
    /* Your existing CSS styles remain the same */
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
        background-color: #dc3545;
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
    .floating-card {
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
        width: 350px;
        text-align: center;
        animation: fadeIn 0.3s ease-in-out;
    }

    .floating-card img {
        width: 200x; /* Increased image size */
        height: 200px; /* Increased image size */
        border-radius: 50%;
        margin-bottom: 10px;
        border: 4px solid #196f38; /* Added border for elegance */
        object-fit: cover; /* Ensures the image fits well */
    }

    .floating-card h5 {
        font-size: 1.5rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
    }

    .floating-card p {
        font-size: 1rem;
        color: #555;
        margin-bottom: 8px;
        text-align: justify;
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

    /* Chart container styling */
    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
    }

    /* Analytics section styling */
    .analytics-section {
        margin-top: 30px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 10px;
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
    
    /* Export buttons styling */
    .export-buttons {
        margin: 20px 0;
        text-align: center;
    }
    
    .export-btn {
        margin: 0 10px;
        padding: 10px 20px;
        border-radius: 5px;
        font-weight: bold;
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
                    
                    <!-- Analytics Section -->
                    <div class="col-12 mt-5">
                        <div class="analytics-section">
                            <h3 class="text-center mb-4">Weekly Analytics Dashboard</h3>
                            
                            <!-- Export Buttons -->
                            <div class="export-buttons">
                                <a href="{{ route('csdl.export.analytics', ['type' => 'weekly']) }}" class="btn btn-success export-btn">
                                    <i class="fas fa-download me-2"></i>Export Weekly Analytics
                                </a>
                                <button class="btn btn-primary export-btn" onclick="showCustomDateModal()">
                                    <i class="fas fa-calendar-alt me-2"></i>Custom Date Range
                                </button>
                            </div>
                            
                            <div class="row">
                                <!-- Weekly Donations Chart -->
                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            <h5 class="card-title mb-0">
                                                <i class="fas fa-donate me-2"></i>Weekly Approved Donations (Including Matched)
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="chart-container">
                                                <canvas id="weeklyDonationsChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Weekly Requests Chart -->
                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-header bg-primary text-white">
                                            <h5 class="card-title mb-0">
                                                <i class="fas fa-hands-helping me-2"></i>Weekly Approved Requests (Including Matched & Fulfilled)
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="chart-container">
                                                <canvas id="weeklyRequestsChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Weekly Matches Chart -->
                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-header bg-warning text-dark">
                                            <h5 class="card-title mb-0">
                                                <i class="fas fa-exchange-alt me-2"></i>Weekly Matched Donations
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="chart-container">
                                                <canvas id="weeklyMatchesChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Approved Items Bar Chart -->
                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-header bg-info text-white">
                                            <h5 class="card-title mb-0">
                                                <i class="fas fa-chart-bar me-2"></i>Weekly Approved Items (Bar Graph)
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="chart-container">
                                                <canvas id="approvedItemsChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Most Donated Items -->
                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            <h5 class="card-title mb-0">
                                                <i class="fas fa-gift me-2"></i>Most Donated Items
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            @if($mostDonatedItems->count() > 0)
                                                <div class="table-responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Item</th>
                                                                <th>Donation Count</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($mostDonatedItems as $item)
                                                            <tr>
                                                                <td>{{ $item->subcategory }}</td>
                                                                <td>
                                                                    <span class="badge bg-success">{{ $item->count }}</span>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p class="text-muted text-center">No donation data available</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Most Requested Items -->
                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-header bg-primary text-white">
                                            <h5 class="card-title mb-0">
                                                <i class="fas fa-hand-holding-heart me-2"></i>Most Requested Items
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            @if($mostRequestedItems->count() > 0)
                                                <div class="table-responsive">
                                                    <table class="table table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th>Item</th>
                                                                <th>Request Count</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($mostRequestedItems as $item)
                                                            <tr>
                                                                <td>{{ $item->subcategory }}</td>
                                                                <td>
                                                                    <span class="badge bg-primary">{{ $item->count }}</span>
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            @else
                                                <p class="text-muted text-center">No request data available</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Custom Date Range Modal -->
    <div class="modal fade" id="customDateModal" tabindex="-1" aria-labelledby="customDateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customDateModalLabel">Custom Date Range Analytics</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="customDateForm">
                        <div class="mb-3">
                            <label for="startDate" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="startDate" name="start_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="endDate" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="endDate" name="end_date" required>
                        </div>
                    </form>
                    <div id="customAnalyticsResults" class="mt-3" style="display: none;">
                        <!-- Results will be displayed here -->
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="getCustomAnalytics()">Get Analytics</button>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz4fnFO9gyb3R2kW2vb5A/yq6pzZb5n3Qz9zDZvZgl6zdeGVJ5k/4fPjq2" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0oP4pL9p1yTL45o6uZ9VxAKp4a7lFvFscJ5FwY5UqBOfNfi6" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<script>
    $(document).ready(function() {
        $('#table').DataTable();
        
        // Initialize charts
        initializeAnalyticsCharts();
        
        // Set default dates for custom range
        const today = new Date().toISOString().split('T')[0];
        const oneMonthAgo = new Date();
        oneMonthAgo.setMonth(oneMonthAgo.getMonth() - 1);
        const oneMonthAgoStr = oneMonthAgo.toISOString().split('T')[0];
        
        $('#startDate').val(oneMonthAgoStr);
        $('#endDate').val(today);
    });

    function initializeAnalyticsCharts() {
        // Sample data - replace with actual data from your controller
        const weeklyData = @json($weeklyAnalytics);
        
        const weeks = weeklyData.weeks || ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
        const donations = weeklyData.donations || [12, 19, 15, 25];
        const requests = weeklyData.requests || [8, 12, 16, 20];
        const matches = weeklyData.matches || [6, 11, 14, 18];
        const approved = weeklyData.approved || [20, 31, 31, 45];

        // Weekly Donations Chart
        const donationsCtx = document.getElementById('weeklyDonationsChart').getContext('2d');
        new Chart(donationsCtx, {
            type: 'line',
            data: {
                labels: weeks,
                datasets: [{
                    label: 'Approved & Matched Donations',
                    data: donations,
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Donations'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Weeks'
                        }
                    }
                }
            }
        });

        // Weekly Requests Chart
        const requestsCtx = document.getElementById('weeklyRequestsChart').getContext('2d');
        new Chart(requestsCtx, {
            type: 'line',
            data: {
                labels: weeks,
                datasets: [{
                    label: 'Approved, Matched & Fulfilled Requests',
                    data: requests,
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Requests'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Weeks'
                        }
                    }
                }
            }
        });

        // Weekly Matches Chart
        const matchesCtx = document.getElementById('weeklyMatchesChart').getContext('2d');
        new Chart(matchesCtx, {
            type: 'line',
            data: {
                labels: weeks,
                datasets: [{
                    label: 'Matched Donations',
                    data: matches,
                    borderColor: '#ffc107',
                    backgroundColor: 'rgba(255, 193, 7, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Number of Matches'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Weeks'
                        }
                    }
                }
            }
        });

        // Approved Items Bar Chart
        const approvedCtx = document.getElementById('approvedItemsChart').getContext('2d');
        new Chart(approvedCtx, {
            type: 'bar',
            data: {
                labels: weeks,
                datasets: [{
                    label: 'Total Approved Items',
                    data: approved,
                    backgroundColor: 'rgba(23, 162, 184, 0.7)',
                    borderColor: 'rgba(23, 162, 184, 1)',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Total Approved Items'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Weeks'
                        }
                    }
                }
            }
        });
    }

    function showCustomDateModal() {
        $('#customDateModal').modal('show');
    }

    function getCustomAnalytics() {
        const startDate = $('#startDate').val();
        const endDate = $('#endDate').val();
        
        if (!startDate || !endDate) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Please select both start and end dates.',
                showConfirmButton: true
            });
            return;
        }
        
        // Show loading
        $('#customAnalyticsResults').html('<div class="text-center"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Loading analytics...</p></div>').show();
        
        // Make AJAX request to get custom analytics
        $.ajax({
            url: '{{ route("csdl.detailed.analytics") }}',
            type: 'GET',
            data: {
                start_date: startDate,
                end_date: endDate
            },
            success: function(response) {
                displayCustomAnalytics(response, startDate, endDate);
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to fetch analytics data.',
                    showConfirmButton: true
                });
                $('#customAnalyticsResults').hide();
            }
        });
    }

    function displayCustomAnalytics(data, startDate, endDate) {
        let html = `
            <h6>Analytics for ${startDate} to ${endDate}</h6>
            <div class="row">
                <div class="col-md-6">
                    <h6>Donations by Category</h6>
                    <ul class="list-group">
        `;
        
        if (data.donations_by_category && data.donations_by_category.length > 0) {
            data.donations_by_category.forEach(item => {
                html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                    ${item.category}
                    <span class="badge bg-success rounded-pill">${item.count}</span>
                </li>`;
            });
        } else {
            html += `<li class="list-group-item">No donation data available</li>`;
        }
        
        html += `
                    </ul>
                </div>
                <div class="col-md-6">
                    <h6>Requests by Category</h6>
                    <ul class="list-group">
        `;
        
        if (data.requests_by_category && data.requests_by_category.length > 0) {
            data.requests_by_category.forEach(item => {
                html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                    ${item.category}
                    <span class="badge bg-primary rounded-pill">${item.count}</span>
                </li>`;
            });
        } else {
            html += `<li class="list-group-item">No request data available</li>`;
        }
        
        html += `
                    </ul>
                </div>
            </div>
        `;
        
        $('#customAnalyticsResults').html(html).show();
    }

    // Your existing floating card functions
    document.getElementById('topDonorCard').addEventListener('click', function() {
        document.getElementById('overlay').style.display = 'block';
        document.getElementById('floatingCard').style.display = 'block';
    });

    function closeFloatingCard() {
        document.getElementById('overlay').style.display = 'none';
        document.getElementById('floatingCard').style.display = 'none';
    }

    document.getElementById('overlay').addEventListener('click', closeFloatingCard);
</script>
</html>