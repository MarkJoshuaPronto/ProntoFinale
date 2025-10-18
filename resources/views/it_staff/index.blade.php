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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>IT Staff - Real Data Analytics</title>
</head>
<style>
    .main-content {
        padding: 20px;
        min-height: 100vh;
        background: #f8f9fa;
    }

    .analytics-section {
        background: white;
        border-radius: 15px;
        padding: 25px;
        margin-top: 20px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        border: 1px solid #e9ecef;
    }

    .real-data-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        border: 1px solid #e9ecef;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .real-data-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .data-value {
        font-size: 2rem;
        font-weight: bold;
        color: #2c3e50;
    }

    .data-label {
        font-size: 0.9rem;
        color: #6c757d;
        text-transform: uppercase;
        font-weight: 600;
    }

    .growth-positive {
        color: #28a745;
        font-weight: bold;
    }

    .growth-negative {
        color: #dc3545;
        font-weight: bold;
    }

    .growth-neutral {
        color: #6c757d;
        font-weight: bold;
    }

    .chart-container {
        position: relative;
        height: 300px;
        width: 100%;
        background: white;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid #e9ecef;
    }

    .health-indicator {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
    }

    .health-excellent { background-color: #28a745; }
    .health-good { background-color: #17a2b8; }
    .health-fair { background-color: #ffc107; }
    .health-poor { background-color: #dc3545; }

    .prediction-badge {
        font-size: 0.8rem;
        padding: 4px 8px;
        border-radius: 12px;
        font-weight: 600;
    }

    .trend-up { background-color: #d4edda; color: #155724; }
    .trend-down { background-color: #f8d7da; color: #721c24; }
    .trend-stable { background-color: #e2e3e5; color: #383d41; }
</style>
<body>
    <section>
        <div class="container-fluid">
            <div class="row">
                @include('it_staff.sidebar')
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
                    
                    <!-- Real Data Analytics Section -->
                    <div class="col-12 mt-4">
                        <div class="analytics-section">
                            <h3 class="text-center mb-4 text-primary">
                                <i class="fas fa-database me-2"></i>Real Data Analytics Dashboard
                            </h3>
                            
                            <!-- Quick Stats with Real Data -->
                            <div class="row mb-4">
                                <div class="col-md-2">
                                    <div class="real-data-card text-center">
                                        <div class="data-value">{{ $totaldonation }}</div>
                                        <div class="data-label">Approved Donations</div>
                                        <small class="text-muted">Total: {{ $totaldonation + $totalpending + $totalrejected }}</small>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="real-data-card text-center">
                                        <div class="data-value">{{ $totalpending }}</div>
                                        <div class="data-label">Pending Donations</div>
                                        <small class="text-warning"><i class="fas fa-clock"></i> Awaiting Review</small>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="real-data-card text-center">
                                        <div class="data-value">{{ $usercount }}</div>
                                        <div class="data-label">Active Users</div>
                                        <small class="text-muted">Total: {{ $activeuser + $inactiveuser }}</small>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="real-data-card text-center">
                                        <div class="data-value">{{ $systemPerformance['total_matches'] }}</div>
                                        <div class="data-label">Successful Matches</div>
                                        <small class="text-success">{{ $systemPerformance['match_efficiency'] }}% Efficiency</small>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="real-data-card text-center">
                                        <div class="data-value">{{ $newdonation }}</div>
                                        <div class="data-label">New Today</div>
                                        <small class="text-info"><i class="fas fa-sync"></i> Daily Influx</small>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="real-data-card text-center">
                                        <div class="data-value">{{ $systemPerformance['total_support_tickets'] }}</div>
                                        <div class="data-label">Support Tickets</div>
                                        <small class="text-muted">System Support</small>
                                    </div>
                                </div>
                            </div>

                            <!-- System Performance with Real Data -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="real-data-card">
                                        <h5><i class="fas fa-tachometer-alt me-2"></i>System Performance</h5>
                                        <div class="row mt-3">
                                            <div class="col-6">
                                                <small class="data-label">User Growth Rate</small>
                                                <div class="d-flex align-items-center">
                                                    <span class="data-value {{ $systemPerformance['user_growth_rate'] >= 0 ? 'growth-positive' : 'growth-negative' }}">
                                                        {{ $systemPerformance['user_growth_rate'] }}%
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <small class="data-label">Donation Growth</small>
                                                <div class="d-flex align-items-center">
                                                    <span class="data-value {{ $systemPerformance['donation_growth_rate'] >= 0 ? 'growth-positive' : 'growth-negative' }}">
                                                        {{ $systemPerformance['donation_growth_rate'] }}%
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-6">
                                                <small class="data-label">Avg Processing Time</small>
                                                <div class="data-value">{{ $systemPerformance['avg_processing_time'] }}h</div>
                                            </div>
                                            <div class="col-6">
                                                <small class="data-label">Match Efficiency</small>
                                                <div class="data-value">{{ $systemPerformance['match_efficiency'] }}%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="real-data-card">
                                        <h5><i class="fas fa-chart-line me-2"></i>Predictive Analytics</h5>
                                        <div class="row mt-3">
                                            <div class="col-4 text-center">
                                                <small class="data-label">Next Month Donations</small>
                                                <div class="data-value text-primary">{{ $predictiveAnalytics['predicted_next_month_donations'] }}</div>
                                                <small>vs {{ $predictiveAnalytics['current_month_donations'] }} current</small>
                                            </div>
                                            <div class="col-4 text-center">
                                                <small class="data-label">Next Month Users</small>
                                                <div class="data-value text-info">{{ $predictiveAnalytics['predicted_next_month_users'] }}</div>
                                                <small>Confidence: {{ $predictiveAnalytics['prediction_confidence'] }}%</small>
                                            </div>
                                            <div class="col-4 text-center">
                                                <small class="data-label">Recommendation</small>
                                                <div>
                                                    <span class="prediction-badge 
                                                        {{ $predictiveAnalytics['recommended_action']['severity'] == 'high' ? 'trend-up' : 
                                                           ($predictiveAnalytics['recommended_action']['severity'] == 'medium' ? 'trend-stable' : 'trend-down') }}">
                                                        {{ ucfirst($predictiveAnalytics['recommended_action']['action']) }}
                                                    </span>
                                                </div>
                                                <small class="text-muted">{{ $predictiveAnalytics['recommended_action']['message'] }}</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Real Data Charts -->
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="real-data-card">
                                        <h5><i class="fas fa-chart-bar me-2"></i>Weekly Donation Trends (Real Data)</h5>
                                        <div class="chart-container">
                                            <canvas id="realWeeklyDonationsChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="real-data-card">
                                        <h5><i class="fas fa-chart-pie me-2"></i>Donation Status Distribution</h5>
                                        <div class="chart-container">
                                            <canvas id="realDonationStatusChart"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Category Trends with Real Data -->
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <div class="real-data-card">
                                        <h5><i class="fas fa-tags me-2"></i>Category Trends</h5>
                                        <div class="table-responsive">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Category</th>
                                                        <th>Current</th>
                                                        <th>Last Month</th>
                                                        <th>Growth</th>
                                                        <th>Trend</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($predictiveAnalytics['category_trends'] as $category => $data)
                                                    <tr>
                                                        <td>{{ $category }}</td>
                                                        <td>{{ $data['current'] }}</td>
                                                        <td>{{ $data['last_month'] }}</td>
                                                        <td>
                                                            <span class="{{ $data['growth'] > 0 ? 'growth-positive' : ($data['growth'] < 0 ? 'growth-negative' : 'growth-neutral') }}">
                                                                {{ $data['growth'] }}%
                                                            </span>
                                                        </td>
                                                        <td>
                                                            <span class="prediction-badge 
                                                                {{ $data['trend'] == 'up' ? 'trend-up' : 
                                                                   ($data['trend'] == 'down' ? 'trend-down' : 'trend-stable') }}">
                                                                {{ ucfirst($data['trend']) }}
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="real-data-card">
                                        <h5><i class="fas fa-heartbeat me-2"></i>System Health</h5>
                                        <div class="row mt-3">
                                            <div class="col-6">
                                                <small class="data-label">Overall Health Score</small>
                                                <div class="data-value">
                                                    @php
                                                        $healthScore = $systemHealthMetrics['overall_health_score'];
                                                        $healthClass = $healthScore >= 90 ? 'health-excellent' : 
                                                                      ($healthScore >= 80 ? 'health-good' : 
                                                                      ($healthScore >= 70 ? 'health-fair' : 'health-poor'));
                                                    @endphp
                                                    <span class="health-indicator {{ $healthClass }}"></span>
                                                    {{ $healthScore }}%
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <small class="data-label">Pending Items</small>
                                                <div class="data-value text-warning">
                                                    {{ $systemHealthMetrics['pending_donations'] + $systemHealthMetrics['pending_requests'] }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row mt-3">
                                            <div class="col-4 text-center">
                                                <small class="data-label">Donation Health</small>
                                                <div class="data-value">{{ $systemHealthMetrics['donation_processing_health'] }}%</div>
                                            </div>
                                            <div class="col-4 text-center">
                                                <small class="data-label">Request Health</small>
                                                <div class="data-value">{{ $systemHealthMetrics['request_processing_health'] }}%</div>
                                            </div>
                                            <div class="col-4 text-center">
                                                <small class="data-label">System Load</small>
                                                <div class="data-value">{{ $systemHealthMetrics['system_load_health'] }}%</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Most Donated Items with Real Data -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="real-data-card">
                                        <h5><i class="fas fa-gift me-2"></i>Most Donated Items (Real Data)</h5>
                                        @if($mostDonatedItems->count() > 0)
                                            <div class="table-responsive">
                                                <table class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>Item</th>
                                                            <th>Donation Count</th>
                                                            <th>Percentage</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @php
                                                            $totalDonationsCount = $mostDonatedItems->sum('count');
                                                        @endphp
                                                        @foreach($mostDonatedItems as $item)
                                                        <tr>
                                                            <td>{{ $item->subcategory }}</td>
                                                            <td>
                                                                <span class="badge bg-success">{{ $item->count }}</span>
                                                            </td>
                                                            <td>
                                                                <span class="badge bg-info">
                                                                    {{ number_format(($item->count / $totalDonationsCount) * 100, 1) }}%
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="badge bg-primary">Active</span>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        @else
                                            <p class="text-muted text-center">No donation data available in the system</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
    
    <script>
        $(document).ready(function() {
            initializeRealDataCharts();
        });

        function initializeRealDataCharts() {
            // Real Weekly Donations Chart
            const weeklyData = @json($weeklyDonationAnalytics);
            const statusData = @json($donationStatusDistribution);
            
            const weeks = weeklyData.weeks || [];
            const approved = weeklyData.approved_donations || [];
            const pending = weeklyData.pending_donations || [];
            const matched = weeklyData.matched_donations || [];
            const rejected = weeklyData.rejected_donations || [];

            // Weekly Donations Chart with Real Data
            const weeklyCtx = document.getElementById('realWeeklyDonationsChart').getContext('2d');
            new Chart(weeklyCtx, {
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
                            label: 'Rejected Donations',
                            data: rejected,
                            borderColor: '#dc3545',
                            backgroundColor: 'rgba(220, 53, 69, 0.1)',
                            borderWidth: 3,
                            fill: true,
                            tension: 0.4
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
                        title: {
                            display: true,
                            text: 'Real Donation Data - Last 8 Weeks'
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

            // Donation Status Distribution with Real Data
            const statusCtx = document.getElementById('realDonationStatusChart').getContext('2d');
            const statusLabels = statusData.map(item => {
                const statusMap = {
                    'pending': 'Pending Review',
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
        }
    </script>
</body>
</html>