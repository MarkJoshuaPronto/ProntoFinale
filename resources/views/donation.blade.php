<?php
use Illuminate\Support\Str;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset('faviconlogo.png') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Donations</title>
    <style>
        /* Existing CSS remains unchanged */
        body {
            background-color: #f4f9f4;
            font-family: 'Arial', sans-serif;
            color: #34495e;
            margin-top: 100px;
        }

        .section-heading {
            font-size: 2.5rem;
            font-weight: bold;
            color: #196f38;
            margin-bottom: 30px;
            text-align: center;
        }

        .logo-text {
            font-size: 20px;
            margin-left: 10px;
        }

        .card {
            height: 500px;
            width: 300px;
            display: flex;
            flex-direction: column;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
            margin-bottom: 40px;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card-body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
            text-align: center;
            height: 100%;
        }

        .fixed-img {
            height: 150px;
            width: 100%;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .fw-bold {
            font-weight: bold;
        }

        .btn-primary {
            background-color: #196f38;
            border: none;
            border-radius: 30px;
            padding: 10px 20px;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #2c7a5b;
        }

        .donation-title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .doanationfirst-title {
            font-size: 2.25rem;
            font-weight: bold;
        }

        .donation-description {
            margin-top: 10px;
            font-size: 1rem;
            color: #555;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            position: relative;
        }

        .donation-description.expanded {
            -webkit-line-clamp: unset;
        }

        .donation-location {
            font-size: 1rem;
            color: #777;
        }

        .donation-card-footer {
            text-align: center;
            margin-top: auto;
        }

        .see-more {
            color: #196f38;
            cursor: pointer;
            font-weight: bold;
            margin-top: 5px;
            display: block;
        }

        .floating-card {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 90%;
            max-width: 1000px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            display: none;
            padding: 20px;
        }

        .floating-card img {
            height: 300px;
            width: 400px;
            object-fit: cover;
            border-radius: 10px;
            margin-right: 20px;
        }

        .floating-card-content {
            display: flex;
            align-items: center;
        }

        .floating-card-description {
            flex: 1;
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 999;
            display: none;
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

        /* Custom CSS for Navbar Links */
        .nav-link:hover {
            color: #ffd000 !important;
        }

        .text-center a {
            color: #196f38;
            text-decoration: none;
        }

        .text-center a:hover {
            color: #ffd000;
        }

        /* Navbar transition */
        .navbar {
            transition: top 0.3s ease, opacity 0.3s ease;
        }

        .search-container {
            display: flex;
            justify-content: flex-start;
            margin-bottom: 20px;
            align-items: center;
        }

        .search-label {
            margin-right: 10px;
            font-weight: bold;
        }

        .search-bar {
            width: 250px;
        }

        /* Mobile adjustments */
        @media (max-width: 768px) {
            .section-heading {
                font-size: 2rem;
            }

            .card {
                width: 100%;
                height: auto;
            }

            .floating-card img {
                width: 100%;
                height: auto;
                margin-right: 0;
                margin-bottom: 10px;
            }

            .floating-card-content {
                flex-direction: column;
                align-items: flex-start;
            }

            .navbar-collapse {
                position: absolute;
                top: 60px; /* Adjust based on navbar height */
                left: 0;
                width: 100%;
                background-color: #196f38;
                z-index: 1001;
            }

            .navbar-nav {
                flex-direction: column;
                align-items: center;
            }

            .nav-item {
                width: 100%;
                text-align: center;
            }

            .nav-link {
                padding: 10px 0;
            }

            .search-container {
                flex-direction: column;
                align-items: flex-start;
            }

            .search-bar {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .section-heading {
                font-size: 1.5rem;
            }

            .floating-card {
                width: 95%;
                padding: 10px;
            }

            .floating-card img {
                height: 200px;
            }

            .floating-card-description h3 {
                font-size: 1.5rem;
            }

            .floating-card-description p {
                font-size: 0.9rem;
            }

            .btn-primary {
                padding: 8px 16px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <!-- Rest of the HTML remains unchanged -->
    <header>
        <nav class="navbar navbar-expand-lg" style="background-color: #196f38; position: fixed; width: 100%; z-index: 1000; top: 0; opacity: 1;">
            <div class="container-fluid">
                <span class="navbar-brand">
                    <a href="{{ route('landingpage') }}">
                        <img src="{{ asset('assets/navlogo.png') }}" alt="Cycle of Giving Logo" class="cyclelogo" style="width: 150px; height: 50px;">
                    </a>
                </span>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse align-items-center justify-content-center" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link text-white" aria-current="page" href="{{ route('landingpage') }}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('donation') }}">Donations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('gallery') }}">Gallery</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('aboutus') }}">About us</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="navbar-text p-2">
                <a class="nav-link text-white" href="{{ route('login') }}">Login</a>
            </div>
            <div class="navbar-text p-2">
                <a class="nav-link text-white" href="{{ route('register') }}">Register</a>
            </div>
        </nav>
    </header>

    <section>
        <div class="container mt-5">
            <div class="text-center text-white">
                <h4 class="section-heading">Your generosity could provide them with the support they need to improve their lives.</h4>
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
            </div>

            <div class="search-container">
                <label for="searchInput" class="search-label">Search:</label>
                <input type="text" id="searchInput" class="form-control search-bar" placeholder="Search by Title...">
            </div>
            <!-- Add this below the search bar -->
            <div id="noResultsWarning" class="alert alert-warning mt-3" style="display: none;">
                No donations match your search.
            </div>

            <div class="row justify-content-start mt-5" id="cardContainer">
                @foreach ($inneeds as $inneed)
                    <div class="col-md-3 mb-4 card-item" data-title="{{ $inneed->title }}">
                        <div class="card p-3" onclick="showFloatingCard('{{ $inneed->id }}')">
                            <div class="card-body">
                                <img src="{{ asset('storage/' . $inneed->image) }}" class="fixed-img" alt="Image">
                                <h5 class="donation-title">{{ $inneed->title }}</h5>
                                <p class="donation-description">
                                    <strong>Description:</strong> {{ Str::limit($inneed->description, 100) }}
                                    @if (strlen($inneed->description) > 100)
                                        <span class="see-more" onclick="event.stopPropagation(); showFloatingCard('{{ $inneed->id }}')">See More</span>
                                    @endif
                                </p>
                                <p class="donation-location"><strong>Location:</strong> {{ $inneed->location }}</p>
                            </div>
                            <a href="{{ route('login') }}" class="btn btn-primary">Donate Now</a>
                        </div>
                    </div>

                    <!-- Floating Card -->
                    <div class="floating-card" id="floatingCard{{ $inneed->id }}">
                        <div class="floating-card-content">
                            <img src="{{ asset('storage/' . $inneed->image) }}" alt="Image">
                            <div class="floating-card-description">
                                <h3 class="doanationfirst-title">{{ $inneed->title }}</h3>
                                <p><strong>Description:</strong> {{ $inneed->description }}</p>
                                <p><strong>Location:</strong> {{ $inneed->location }}</p>
                                <a href="{{ route('login') }}" class="btn btn-primary">Donate Now</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

        <!-- Overlay -->
        <div class="overlay" id="overlay" onclick="hideFloatingCard()"></div>
    </section>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2023 Cycle of Giving. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        function showFloatingCard(id) {
            document.getElementById('floatingCard' + id).style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        }

        function hideFloatingCard() {
            document.querySelectorAll('.floating-card').forEach(card => {
                card.style.display = 'none';
            });
            document.getElementById('overlay').style.display = 'none';
        }

        // Scroll effect script
        let lastScrollTop = 0;
        const navbar = document.querySelector('.navbar');

        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            if (scrollTop > lastScrollTop) {
                // Scroll Down
                navbar.style.top = "-80px"; // Adjust based on navbar height
                navbar.style.opacity = "0"; // Fade out
            } else {
                // Scroll Up
                navbar.style.top = "0";
                navbar.style.opacity = "1"; // Fade in
            }
            lastScrollTop = scrollTop;
        });

            $(document).ready(function(){
            $("#searchInput").on("keyup", function() {
                var value = $(this).val().toLowerCase();
                var visibleCards = 0;

                // Filter cards and count visible ones
                $("#cardContainer .card-item").each(function() {
                    var title = $(this).data('title').toLowerCase();
                    if (title.indexOf(value) > -1) {
                        $(this).show();
                        visibleCards++;
                    } else {
                        $(this).hide();
                    }
                });

                // Show or hide the warning message
                if (visibleCards === 0) {
                    $("#noResultsWarning").show();
                } else {
                    $("#noResultsWarning").hide();
                }
            });
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
