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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
    <title>Admin Dashboard</title>
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
</style>
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
                            text: "{{ $errors->first() }}",
                            showConfirmButton: true,
                            timer: 3000
                        });
                    </script>
                    @endif

                    <div class="col-12 mt-5">
                        <div class="analytics-section">
                            <h3 class="text-center mb-4">Platform Analytics Dashboard</h3>

                            <div class="row">
                                <div class="col-md-6 mb-4">
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

                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-header bg-primary text-white">
                                            <h5 class="card-title mb-0">
                                                <i class="fas fa-chart-bar me-2"></i>Weekly Donations vs. Requests
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="chart-container">
                                                <canvas id="donationsVsRequestsChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-header bg-warning text-dark">
                                            <h5 class="card-title mb-0">
                                                <i class="fas fa-chart-pie me-2"></i>Overall Activity Breakdown
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="chart-container">
                                                <canvas id="activityDoughnutChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-4">
                                    <div class="card">
                                        <div class="card-header bg-info text-white">
                                            <h5 class="card-title mb-0">
                                                <i class="fas fa-gift me-2"></i>Top 5 Donated Item Categories
                                            </h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="chart-container">
                                                <canvas id="topItemsPieChart"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                </div>

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

                            <div class="row mt-4">
                                <div class="col-12 text-center">
                                    <button class="btn btn-info" onclick="exportAnalyticsData()">
                                        <i class="fas fa-file-export me-1"></i>Export Analytics Data
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
    });

    function initializeAnalyticsCharts() {
        // --- DATA PREPARATION ---
        const weeklyData = @json($weeklyAnalytics);
        const mostDonatedItems = @json($mostDonatedItems);

        const weeks = weeklyData.weeks || [];
        const donations = weeklyData.donations || [];
        const requests = weeklyData.requests || [];
        const matches = weeklyData.matches || [];

        const chartColors = {
            red: 'rgb(255, 99, 132)',
            orange: 'rgb(255, 159, 64)',
            yellow: 'rgb(255, 205, 86)',
            green: 'rgb(75, 192, 192)',
            blue: 'rgb(54, 162, 235)',
            purple: 'rgb(153, 102, 255)',
            grey: 'rgb(201, 203, 207)'
        };

        // --- CHART 1: WEEKLY DONATIONS (LINE CHART) ---
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
                scales: {
                    y: { beginAtZero: true, title: { display: true, text: 'Number of Donations' }},
                    x: { title: { display: true, text: 'Weeks' }}
                }
            }
        });

        // --- CHART 2: DONATIONS VS REQUESTS (GROUPED BAR CHART) ---
        const requestsCtx = document.getElementById('donationsVsRequestsChart').getContext('2d');
        new Chart(requestsCtx, {
            type: 'bar',
            data: {
                labels: weeks,
                datasets: [
                    {
                        label: 'Donations',
                        data: donations,
                        backgroundColor: 'rgba(40, 167, 69, 0.7)',
                        borderColor: 'rgba(40, 167, 69, 1)',
                        borderWidth: 1
                    },
                    {
                        label: 'Requests',
                        data: requests,
                        backgroundColor: 'rgba(0, 123, 255, 0.7)',
                        borderColor: 'rgba(0, 123, 255, 1)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true, title: { display: true, text: 'Count' }},
                    x: { title: { display: true, text: 'Weeks' }}
                }
            }
        });

        // --- CHART 3: OVERALL ACTIVITY (DOUGHNUT CHART) ---
        const totalDonations = donations.reduce((a, b) => a + b, 0);
        const totalRequests = requests.reduce((a, b) => a + b, 0);
        const totalMatches = matches.reduce((a, b) => a + b, 0);

        const doughnutCtx = document.getElementById('activityDoughnutChart').getContext('2d');
        new Chart(doughnutCtx, {
            type: 'doughnut',
            data: {
                labels: ['Donations', 'Requests', 'Matches'],
                datasets: [{
                    label: 'Total Activity',
                    data: [totalDonations, totalRequests, totalMatches],
                    backgroundColor: [
                        'rgba(40, 167, 69, 0.8)',
                        'rgba(0, 123, 255, 0.8)',
                        'rgba(255, 193, 7, 0.8)'
                    ],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                }
            }
        });

        // --- CHART 4: TOP DONATED ITEMS (PIE CHART) ---
        // Prepare data for the pie chart (Top 5 items)
        const topItems = mostDonatedItems.slice(0, 5);
        const pieLabels = topItems.map(item => item.subcategory);
        const pieData = topItems.map(item => item.count);

        const pieCtx = document.getElementById('topItemsPieChart').getContext('2d');
        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: pieLabels,
                datasets: [{
                    label: 'Donation Count',
                    data: pieData,
                    backgroundColor: [
                        chartColors.blue,
                        chartColors.green,
                        chartColors.yellow,
                        chartColors.orange,
                        chartColors.purple
                    ],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'right',
                    }
                }
            }
        });
    }

    function exportAnalyticsData() {
        // Show loading state
        Swal.fire({
            title: 'Exporting Analytics Data',
            text: 'Please wait while we prepare your data...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Get chart data
        const weeklyData = @json($weeklyAnalytics);
        const mostDonatedItems = @json($mostDonatedItems);
        const mostRequestedItems = @json($mostRequestedItems);

        try {
            // Create workbook
            const wb = XLSX.utils.book_new();

            // Weekly Analytics Sheet
            const weeklySheetData = [
                ['Week', 'Donations', 'Requests', 'Matches'],
                ...weeklyData.weeks.map((week, index) => [
                    week,
                    weeklyData.donations?.[index] || 0,
                    weeklyData.requests?.[index] || 0,
                    weeklyData.matches?.[index] || 0,
                ])
            ];
            const weeklySheet = XLSX.utils.aoa_to_sheet(weeklySheetData);
            XLSX.utils.book_append_sheet(wb, weeklySheet, 'Weekly Analytics');

            // Most Donated Items Sheet
            const donatedItemsData = [
                ['Item Name', 'Donation Count'],
                ...mostDonatedItems.map(item => [item.subcategory, item.count])
            ];
            const donatedSheet = XLSX.utils.aoa_to_sheet(donatedItemsData);
            XLSX.utils.book_append_sheet(wb, donatedSheet, 'Most Donated Items');

            // Most Requested Items Sheet
            const requestedItemsData = [
                ['Item Name', 'Request Count'],
                ...mostRequestedItems.map(item => [item.subcategory, item.count])
            ];
            const requestedSheet = XLSX.utils.aoa_to_sheet(requestedItemsData);
            XLSX.utils.book_append_sheet(wb, requestedSheet, 'Most Requested Items');

            // Summary Sheet
            const summaryData = [
                ['Metric', 'Value'],
                ['Total Donors', {{$usercount}}],
                ['Total Donations', {{$totaldonation}}],
                ['Top Donor', @json($topdonator && $topdonator->user ? $topdonator->user->name : 'No top donor')],
                ['Export Date', new Date().toLocaleDateString()]
            ];
            const summarySheet = XLSX.utils.aoa_to_sheet(summaryData);
            XLSX.utils.book_append_sheet(wb, summarySheet, 'Summary');

            // Generate file and download
            const fileName = `analytics_export_${new Date().toISOString().split('T')[0]}.xlsx`;
            XLSX.writeFile(wb, fileName);

            Swal.close();

            Swal.fire({
                icon: 'success',
                title: 'Export Successful!',
                text: `Analytics data has been exported to ${fileName}`,
                showConfirmButton: true,
                timer: 3000
            });

        } catch (error) {
            console.error('Export error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Export Failed',
                text: 'There was an error exporting the analytics data. Please try again.',
                showConfirmButton: true
            });
        }
    }

    // Your existing floating card functions (if any)
    // Example:
    // document.getElementById('topDonorCard').addEventListener('click', function() {
    //     document.getElementById('overlay').style.display = 'block';
    //     document.getElementById('floatingCard').style.display = 'block';
    // });

    function closeFloatingCard() {
        document.getElementById('overlay').style.display = 'none';
        document.getElementById('floatingCard').style.display = 'none';
    }

    // if (document.getElementById('overlay')) {
    //    document.getElementById('overlay').addEventListener('click', closeFloatingCard);
    // }
</script>
</html>
