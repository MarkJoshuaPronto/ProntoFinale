<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset('faviconlogo.png') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <title>Gallery</title>
</head>
    <style>
        body {
            background-color: #f4f9f4;
            font-family: 'Arial', sans-serif;
            color: #34495e;
            /* --- Changes Start Here --- */
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Ensures body takes at least full viewport height */
            /* --- Changes End Here --- */
        }
        /* --- Add this new rule --- */
        section {
            flex: 1; /* Allows the section to grow and push the footer down */
        }
        .logo-text {
            font-size: 20px;
            margin-left: 10px;
        }
        .card {
            height: 100%;
            display: flex;
            flex-direction: column;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background-color: #ffffff;
            cursor: pointer; /* Add pointer cursor for clickable cards */
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
            max-height: 250px;
            object-fit: cover;
            width: 100%;
            margin-bottom: 20px;
            border-radius: 10px;
        }
        .fw-bold {
            font-weight: bold;
            color: #2c3e50;
        }
        .btn-primary {
            background-color: #196f38;
            border: none;
            border-radius: 30px;
            padding: 10px 20px;
            transition: background-color 0.3s ease;
            color: #ffffff;
        }
        .btn-primary:hover {
            background-color: #ffd000;
        }
        .gallery-description {
            font-size: 1rem;
            color: #555;
        }
        .gallery-location {
            font-size: 1rem;
            color: #777;
        }
        .gallery-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #196f38;
            margin-bottom: 30px;
            text-align: center;
            margin-top: 105px;
        }
        .navbar {
            background-color: #196f38;
            position: fixed;
            width: 100%;
            z-index: 1000;
            top: 0;
            opacity: 1;
            transition: top 0.3s ease, opacity 0.3s ease;
        }
        .navbar-text a {
            color: #ffffff;
        }
        .navbar-nav .nav-link {
            color: #ffffff;
        }
        .footer {
            background-color: #196f38;
            color: #fff;
            padding: 5px;
            text-align: center;
        }
        .footer p {
            margin-top: 20px;
        }
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
        /* Floating Card Styles */
        .floating-card {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80%;
            max-width: 600px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1001;
            display: none; /* Hidden by default */
        }
        .floating-card .swiper-container {
            width: 100%;
            height: 400px;
            border-radius: 10px;
        }
        .floating-card .swiper-slide {
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .floating-card .swiper-slide img {
            max-width: 100%;
            max-height: 100%;
            border-radius: 10px;
        }
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 1000;
            display: none; /* Hidden by default */
        }
        /* Responsive Styles */
        @media (max-width: 768px) {
            .gallery-title {
                font-size: 2rem;
                margin-top: 80px;
            }
            .navbar-collapse {
                position: absolute;
                top: 60px;
                left: 0;
                width: 100%;
                background-color: #196f38;
                z-index: 1001;
            }
            .navbar-nav {
                text-align: center;
            }
            .navbar-text {
                text-align: center;
                margin-top: 10px;
            }
            .col-md-3 {
                flex: 0 0 50%;
                max-width: 50%;
            }
            .fixed-img {
                max-height: 200px;
            }
            .card-body {
                padding: 15px;
            }
            .gallery-description, .gallery-location {
                font-size: 0.9rem;
            }
        }
        @media (max-width: 576px) {
            .gallery-title {
                font-size: 1.5rem;
                margin-top: 60px;
            }
            .col-md-3 {
                flex: 0 0 100%;
                max-width: 100%;
            }
            .fixed-img {
                max-height: 150px;
            }
            .card-body {
                padding: 10px;
            }
            .gallery-description, .gallery-location {
                font-size: 0.8rem;
            }
            .navbar-brand img {
                width: 120px;
                height: auto;
            }
            .navbar-toggler {
                padding: 0.25rem 0.5rem;
            }
        }
    </style>
<body>
    <header>
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <span class="navbar-brand">
                    <a href="{{ route('landingpageuser') }}">
                        <img src="{{ asset('assets/navlogo.png') }}" alt="Cycle of Giving Logo" class="cyclelogo" style="width: 150px; height: 50px;">
                    </a>
                </span>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse align-items-center justify-content-center" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item"><a class="nav-link text-white" href="{{ route('landingpageuser') }}">Home</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="{{ route('donationuser') }}">Donations</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="{{ route('galleryuser') }}">Gallery</a></li>
                        <li class="nav-item"><a class="nav-link text-white" href="{{ route('aboutususer') }}">About Us</a></li>
                    </ul>
                </div>
                <div class="d-flex align-items-center">
                                        <div class="dropdown">
    @if (Auth::check() && $auth->image)
        <img src="{{ asset('storage/' . $auth->image) }}" alt="Authenticated Logo"
             style="width: 40px; height: 40px; border-radius: 50%; margin-left: 15px; cursor: pointer;"
             id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
    @else
        <img src="{{ asset('assets/logo.jpg') }}" alt="Authenticated Logo"
             style="width: 40px; height: 40px; border-radius: 50%; margin-left: 15px; cursor: pointer;"
             id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
    @endif
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
        <li>
            @if(Auth::user()->role == 'donor')
                <a class="dropdown-item" href="{{ route('donordashboard') }}">Donor Dashboard</a>
            @elseif(Auth::user()->role == 'recipient')
                <a class="dropdown-item" href="{{ route('recipientdashboard') }}">Recipient Dashboard</a>
            @else
                <a class="dropdown-item" href="{{ route('donordashboard') }}">Dashboard</a>
            @endif
        </li>
        <li>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="dropdown-item" style="background-color: red; color: white; width: 100%; text-align: left; border: none;">
                    Logout
                </button>
            </form>
        </li>
    </ul>
</div>
                </div>
            </div>
        </nav>
    </header>

    <section>
        <div class="container mt-5">
            <h4 class="gallery-title">Gallery</h4>
            <div class="row justify-content-start mt-5">
                @foreach ($gallery as $index => $items)
                    <div class="col-md-3 mb-5 gallery-card">
                        <div class="card p-3" onclick="openGallery({{ $index }})" data-images="{{ json_encode($items->images) }}">
                            <div class="card-body">
                                <img src="{{ asset('storage/' . $items->images[0]) }}" class="img-fluid fixed-img" alt="Image">
                                <p class="fw-bold mt-3">{{ $items->description }}</p>
                                <p class="gallery-description"><strong>Location:</strong> {{ $items->location }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <div class="overlay" onclick="closeGallery()"></div>
    <div class="floating-card">
        <div class="swiper-container">
            <div class="swiper-wrapper"></div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2023 Cycle of Giving. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        let swiper;

        // Function to initialize Swiper
        function initializeSwiper() {
            swiper = new Swiper('.swiper-container', {
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                keyboard: { enabled: true },
                touch: {
                    enabled: true,
                    dragSize: 20
                },
                mousewheel: {
                    enabled: true
                }
            });
        }

        // Open the floating card with the selected gallery
        function openGallery(index) {
            // Get the gallery card element
            const galleryCard = document.querySelectorAll('.gallery-card')[index];

            // Get all images from the selected gallery card
            const images = JSON.parse(galleryCard.querySelector('.card').getAttribute('data-images'));

            // Create slides for Swiper
            const imagesHTML = images.map(img => `
                <div class="swiper-slide">
                    <img src="{{ asset('storage/') }}/${img}" alt="Gallery Image">
                </div>
            `).join('');

            // Update Swiper container
            const swiperWrapper = document.querySelector('.swiper-wrapper');
            swiperWrapper.innerHTML = imagesHTML;

            // Destroy existing Swiper instance if it exists
            if (swiper) {
                swiper.destroy(true, true);
            }

            // Reinitialize Swiper
            initializeSwiper();

            // Show floating card
            document.querySelector('.floating-card').style.display = 'block';
            document.querySelector('.overlay').style.display = 'block';
        }

        // Close the floating card
        function closeGallery() {
            document.querySelector('.floating-card').style.display = 'none';
            document.querySelector('.overlay').style.display = 'none';
        }

        // Close the floating card when clicking outside
        document.querySelector('.overlay').addEventListener('click', closeGallery);

        // Add keyboard controls
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeGallery();
            }
        });
    </script>
    <script>
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
</script>
</body>
</html>
