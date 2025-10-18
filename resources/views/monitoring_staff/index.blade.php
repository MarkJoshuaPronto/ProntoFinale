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
    <title>Monitoring Staff - Donation Analytics</title>
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

    /* Status badges */
    .status-badge {
        font-size: 0.8rem;
        padding: 4px 8px;
        border-radius: 12px;
    }
</style>
<body>
    <section>
        <div class="container-fluid">
            <div class="row">
                @include('monitoring_staff.sidebar')
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
                    
                    <!-- Donation Analytics Section -->
                    <div class="col-12 mt-5">
                        <div class="analytics-section">
                            <h3 class="text-center mb-4">Donation Analytics Dashboard</h3>
                            
                            <!-- Export Buttons -->
                            <div class="export-buttons">
                                <a href="{{ route('monitoring.export.donation-analytics', ['type' => 'weekly']) }}" class="btn btn-success export-btn">
                                    <i class="fas fa-download me-2"></i>Export Donation Analytics
                                </a>
                                <button class="btn btn-primary export-btn" onclick="showCustomDateModal()">
                                    <i class="fas fa-calendar-alt me-2"></i>Custom Date Range
                                </button>
                            </div>
                            
                            <div class="row">
                                <!-- Weekly Donations Overview Chart -->
                                <div class="col-md-8 mb-4">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            <h5 class="card-title mb-0">
                                                <i class="fas fa-chart-line me-2"></i>Weekly Donation Trends
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="chart-container">
                                                <canvas id="weeklyDonationsChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Donation Status Distribution -->
                                <div class="col-md-4 mb-4">
                                    <div class="card">
                                        <div class="card-header bg-info text-white">
                                            <h5 class="card-title mb-0">
                                                <i class="fas fa-chart-pie me-2"></i>Donation Status Distribution
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="chart-container">
                                                <canvas id="donationStatusChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Donations by Category -->
                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-header bg-warning text-dark">
                                            <h5 class="card-title mb-0">
                                                <i class="fas fa-tags me-2"></i>Donations by Category
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="chart-container">
                                                <canvas id="donationsByCategoryChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Most Donated Items -->
                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-header bg-primary text-white">
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
                                                                <th>Percentage</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php
                                                                $totalDonations = $mostDonatedItems->sum('count');
                                                            @endphp
                                                            @foreach($mostDonatedItems as $item)
                                                            <tr>
                                                                <td>{{ $item->subcategory }}</td>
                                                                <td>
                                                                    <span class="badge bg-success">{{ $item->count }}</span>
                                                                </td>
                                                                <td>
                                                                    <span class="badge bg-info">
                                                                        {{ number_format(($item->count / $totalDonations) * 100, 1) }}%
                                                                    </span>
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

                                <!-- Quick Stats -->
                                <div class="col-12 mb-4">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="card text-white bg-success">
                                                <div class="card-body text-center">
                                                    <h4>{{ $totaldonation }}</h4>
                                                    <p>Total Approved Donations</p>
                                                    <i class="fas fa-check-circle fa-2x"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card text-white bg-warning">
                                                <div class="card-body text-center">
                                                    <h4>{{ $totalpending }}</h4>
                                                    <p>Pending Donations</p>
                                                    <i class="fas fa-clock fa-2x"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card text-white bg-danger">
                                                <div class="card-body text-center">
                                                    <h4>{{ $totalrejected }}</h4>
                                                    <p>Rejected Donations</p>
                                                    <i class="fas fa-times-circle fa-2x"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card text-white bg-info">
                                                <div class="card-body text-center">
                                                    <h4>{{ $newdonation }}</h4>
                                                    <p>New Donations Today</p>
                                                    <i class="fas fa-plus-circle fa-2x"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Top Donor Information -->
                                @if($topdonator)
                                <div class="col-12 mb-4">
                                    <div class="card">
                                        <div class="card-header bg-success text-white">
                                            <h5 class="card-title mb-0">
                                                <i class="fas fa-trophy me-2"></i>Top Donor Recognition
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row align-items-center">
                                                <div class="col-md-8">
                                                    <h6>{{ $topdonator->user->name ?? 'Anonymous Donor' }}</h6>
                                                    <p class="mb-1"><strong>Total Donations:</strong> {{ $topdonator->donation_count }}</p>
                                                    <p class="mb-0"><strong>Email:</strong> {{ $topdonator->user->email ?? 'N/A' }}</p>
                                                </div>
                                                <div class="col-md-4 text-center">
                                                    <div class="bg-warning text-dark p-3 rounded">
                                                        <i class="fas fa-crown fa-3x mb-2"></i>
                                                        <h5>Top Donor</h5>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif
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
                    <h5 class="modal-title" id="customDateModalLabel">Custom Date Range - Donation Analytics</h5>
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
                    <button type="button" class="btn btn-primary" onclick="getCustomDonationAnalytics()">Get Donation Analytics</button>
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
        initializeDonationCharts();
        
        // Set default dates for custom range
        const today = new Date().toISOString().split('T')[0];
        const oneMonthAgo = new Date();
        oneMonthAgo.setMonth(oneMonthAgo.getMonth() - 1);
        const oneMonthAgoStr = oneMonthAgo.toISOString().split('T')[0];
        
        $('#startDate').val(oneMonthAgoStr);
        $('#endDate').val(today);
    });

    function initializeDonationCharts() {
        const donationData = @json($weeklyDonationAnalytics);
        const statusData = @json($donationStatusDistribution);
        const categoryData = @json($donationsByCategory);
        
        const weeks = donationData.weeks || ['Week 1', 'Week 2', 'Week 3', 'Week 4'];
        const approved = donationData.approved_donations || [12, 19, 15, 25];
        const pending = donationData.pending_donations || [5, 8, 12, 7];
        const matched = donationData.matched_donations || [6, 11, 14, 18];
        const total = donationData.total_donations || [23, 38, 41, 50];

        // Weekly Donations Chart
        const donationsCtx = document.getElementById('weeklyDonationsChart').getContext('2d');
        new Chart(donationsCtx, {
            type: 'line',
            data: {
                labels: weeks,
                datasets: [
                    {
                        label: 'Approved Donations',
                        data: approved,
                        borderColor: '#28a745',
                        backgroundColor: 'rgba(40, 167, 69, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Pending Donations',
                        data: pending,
                        borderColor: '#ffc107',
                        backgroundColor: 'rgba(255, 193, 7, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Matched Donations',
                        data: matched,
                        borderColor: '#17a2b8',
                        backgroundColor: 'rgba(23, 162, 184, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    },
                    {
                        label: 'Total Donations',
                        data: total,
                        borderColor: '#6c757d',
                        backgroundColor: 'rgba(108, 117, 125, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4,
                        borderDash: [5, 5]
                    }
                ]
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

        // Donation Status Distribution Chart
        const statusCtx = document.getElementById('donationStatusChart').getContext('2d');
        const statusLabels = statusData.map(item => {
            // Convert status to readable format
            const statusMap = {
                'pending': 'Pending',
                'approved': 'Approved',
                'rejected': 'Rejected',
                'matched': 'Matched',
                'claimed': 'Claimed',
                'distributed': 'Distributed'
            };
            return statusMap[item.status] || item.status;
        });
        const statusCounts = statusData.map(item => item.count);
        const statusColors = ['#ffc107', '#28a745', '#dc3545', '#17a2b8', '#6f42c1', '#20c997'];

        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: statusLabels,
                datasets: [{
                    data: statusCounts,
                    backgroundColor: statusColors,
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
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
                }
            }
        });

        // Donations by Category Chart
        const categoryCtx = document.getElementById('donationsByCategoryChart').getContext('2d');
        const categoryLabels = categoryData.map(item => item.category);
        const categoryCounts = categoryData.map(item => item.count);
        const categoryColors = ['#28a745', '#17a2b8', '#ffc107', '#dc3545', '#6f42c1', '#e83e8c'];

        new Chart(categoryCtx, {
            type: 'bar',
            data: {
                labels: categoryLabels,
                datasets: [{
                    label: 'Donations by Category',
                    data: categoryCounts,
                    backgroundColor: categoryColors,
                    borderColor: categoryColors.map(color => color.replace('0.7', '1')),
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
                        title: {
                            display: true,
                            text: 'Number of Donations'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Categories'
                        }
                    }
                }
            }
        });
    }

    function showCustomDateModal() {
        $('#customDateModal').modal('show');
    }

    function getCustomDonationAnalytics() {
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
        $('#customAnalyticsResults').html('<div class="text-center"><div class="spinner-border text-primary" role="status"></div><p class="mt-2">Loading donation analytics...</p></div>').show();
        
        // Make AJAX request to get custom donation analytics
        $.ajax({
            url: '{{ route("monitoring.detailed.donation-analytics") }}',
            type: 'GET',
            data: {
                start_date: startDate,
                end_date: endDate
            },
            success: function(response) {
                displayCustomDonationAnalytics(response, startDate, endDate);
            },
            error: function(xhr) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to fetch donation analytics data.',
                    showConfirmButton: true
                });
                $('#customAnalyticsResults').hide();
            }
        });
    }

    function displayCustomDonationAnalytics(data, startDate, endDate) {
        let html = `
            <h6>Donation Analytics for ${startDate} to ${endDate}</h6>
            <div class="row">
        `;
        
        // Donations by Category
        if (data.donations_by_category && data.donations_by_category.length > 0) {
            html += `
                <div class="col-md-6">
                    <h6>Donations by Category</h6>
                    <ul class="list-group">
            `;
            data.donations_by_category.forEach(item => {
                html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                    ${item.category}
                    <span class="badge bg-success rounded-pill">${item.count}</span>
                </li>`;
            });
            html += `</ul></div>`;
        }

        // Donations by Status
        if (data.donations_by_status && data.donations_by_status.length > 0) {
            html += `
                <div class="col-md-6">
                    <h6>Donations by Status</h6>
                    <ul class="list-group">
            `;
            data.donations_by_status.forEach(item => {
                const statusColors = {
                    'pending': 'warning',
                    'approved': 'success',
                    'rejected': 'danger',
                    'matched': 'info',
                    'claimed': 'primary',
                    'distributed': 'dark'
                };
                const statusMap = {
                    'pending': 'Pending',
                    'approved': 'Approved',
                    'rejected': 'Rejected',
                    'matched': 'Matched',
                    'claimed': 'Claimed',
                    'distributed': 'Distributed'
                };
                html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                    ${statusMap[item.status] || item.status}
                    <span class="badge bg-${statusColors[item.status] || 'secondary'} rounded-pill">${item.count}</span>
                </li>`;
            });
            html += `</ul></div>`;
        }

        // Top Donors
        if (data.top_donors && data.top_donors.length > 0) {
            html += `
                <div class="col-12 mt-3">
                    <h6>Top Donors</h6>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Donor Name</th>
                                    <th>Donation Count</th>
                                </tr>
                            </thead>
                            <tbody>
            `;
            data.top_donors.forEach(donor => {
                html += `<tr>
                    <td>${donor.user ? donor.user.name : 'Anonymous'}</td>
                    <td><span class="badge bg-success">${donor.donation_count}</span></td>
                </tr>`;
            });
            html += `</tbody></table></div></div>`;
        }

        html += `</div>`;
        
        $('#customAnalyticsResults').html(html).show();
    }
</script>
</html>