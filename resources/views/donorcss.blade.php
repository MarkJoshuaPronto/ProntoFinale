  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="icon" type="image/png" href="{{ asset('faviconlogo.png') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Cycle of Giving - Donation</title>
    <style>
        body {
            background-color: #f4f9f4;
            font-family: 'Arial', sans-serif;
            color: #34495e;
        }

        .navbar {
            transition: top 0.3s ease, opacity 0.3s ease;
            position: fixed; /* Ensure the navbar is fixed */
            width: 100%;
            z-index: 1000;
            top: 0;
            opacity: 1;
        }

        .logo-text {
            font-size: 20px;
            margin-left: 10px;
        }

        .btn-primary {
            background-color: #196f38;
            border: none;
            padding: 12px 35px;
            font-size: 1.1rem;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #2c7a5b;
        }

        .sidebar {
            background-color: #000000;
            padding-top: 20px;
            margin-top: 70px;
        }

        .sidebar a {
            padding: 10px 20px;
            text-decoration: none;
            color: #FEFBF6;
            display: block;
        }

        .sidebar a:hover {
            background-color: #2c7a5b;
            color: white;
        }

        .main-content {
            background-color: #ffffff;
            padding: 20px;
            min-height: 100vh;
            margin-top: 70px;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
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

        .img {
            width: 100px;
            height: 100px;
        }

        div.dataTables_filter input {
            margin-bottom: 1rem;
        }

        .gallery {
            width: 250px;
        }

        .nav-link:hover {
            color: #ffd000 !important;
        }

        .dropdown-menu {
            background-color: rgb(255, 255, 255);
        }

        .dropdown-item {
            color: rgb(0, 0, 0);
        }

        .badge {
            font-size: 0.9rem;
        }

        .bg-warning {
            background-color: #ffc107 !important;
        }

        .bg-danger {
            background-color: #dc3545 !important;
        }

        .bg-success {
            background-color: #28a745 !important;
        }

        .bg-primary {
            background-color: #007bff !important;
        }

        .bg-secondary {
            background-color: #6c757d !important;
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

    </style>
