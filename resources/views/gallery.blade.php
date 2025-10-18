<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset('faviconlogo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
    <title>Gallery</title>
    <style>
        /* NEW: Flexbox for full-height layout */
        html, body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }

        body {
            background-color: #f4f9f4;
            font-family: 'Arial', sans-serif;
            color: #34495e;
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
            cursor: pointer;
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

        .navbar-text a,
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
            display: none;
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
            display: none;
        }

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

            .navbar-nav,
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
</head>
<body>
<header>
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <span class="navbar-brand">
                <a href="{{ route('landingpage') }}">
                    <img src="{{ asset('assets/navlogo.png') }}" alt="Cycle of Giving Logo" class="cyclelogo" style="width: 150px; height: 50px;">
                </a>
            </span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse align-items-center justify-content-center" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link text-white" href="{{ route('landingpage') }}">Home</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="{{ route('gallery') }}">Gallery</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="{{ route('aboutus') }}">About Us</a></li>
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

<!-- 🌟 MAIN CONTENT WRAPPER -->
<main>
    <section>
        <div class="container mt-5">
            <h4 class="gallery-title">Gallery</h4>
            <div class="row justify-content-start mt-5">
                @foreach ($gallery as $index => $items)
                    @php
                        $images = [];
                        if (is_string($items->images)) {
                            $images = json_decode($items->images, true);
                            if (json_last_error() !== JSON_ERROR_NONE) {
                                $cleanImage = str_replace(['"', '[', ']', '\\'], '', $items->images);
                                $images = [$cleanImage];
                            }
                        } elseif (is_array($items->images)) {
                            $images = $items->images;
                        }
                        $firstImage = !empty($images) ? $images[0] : null;
                        $imageUrl = $firstImage ? asset('storage/' . trim($firstImage, '[]"\'')) : null;
                    @endphp

                    <div class="col-md-3 mb-5 gallery-card">
                        <div class="card p-3" onclick="openGallery({{ $index }})"
                             data-images="{{ htmlspecialchars(json_encode($images), ENT_QUOTES, 'UTF-8') }}">
                            <div class="card-body">
                                @if($imageUrl)
                                    <img src="{{ $imageUrl }}" class="img-fluid fixed-img" alt="Gallery Image"
                                         onerror="this.src='{{ asset('assets/placeholder.jpg') }}'">
                                @else
                                    <img src="{{ asset('assets/placeholder.jpg') }}" class="img-fluid fixed-img" alt="No Image Available">
                                @endif
                                <p class="fw-bold mt-3">{{ $items->description }}</p>
                                <p class="gallery-description"><strong>Location:</strong> {{ $items->location }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
</main>

<!-- Floating Gallery -->
<div class="overlay" onclick="closeGallery()"></div>
<div class="floating-card">
    <div class="swiper-container">
        <div class="swiper-wrapper"></div>
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
</div>

<!-- ✅ FOOTER STAYS AT BOTTOM -->
<footer class="footer">
    <div class="container">
        <p>&copy; 2023 Cycle of Giving. All rights reserved.</p>
    </div>
</footer>

<!-- Scripts -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    let swiper;
    function initializeSwiper() {
        swiper = new Swiper('.swiper-container', {
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            keyboard: { enabled: true },
            mousewheel: { enabled: true },
            loop: true
        });
    }

    function openGallery(index) {
        const galleryCards = document.querySelectorAll('.gallery-card');
        const galleryCard = galleryCards[index];
        const imagesData = galleryCard.querySelector('.card').getAttribute('data-images');
        const images = JSON.parse(imagesData);
        const imagesHTML = images.map(img => {
            const cleanImg = img.replace(/^\["(.*)"\]$/, '$1').replace(/\\/g, '');
            return `
                <div class="swiper-slide">
                    <img src="{{ asset('storage/') }}/${cleanImg}"
                         alt="Gallery Image"
                         onerror="this.src='{{ asset('assets/placeholder.jpg') }}'">
                </div>
            `;
        }).join('');
        const swiperWrapper = document.querySelector('.swiper-wrapper');
        swiperWrapper.innerHTML = imagesHTML;
        if (swiper) swiper.destroy(true, true);
        initializeSwiper();
        document.querySelector('.floating-card').style.display = 'block';
        document.querySelector('.overlay').style.display = 'block';
    }

    function closeGallery() {
        document.querySelector('.floating-card').style.display = 'none';
        document.querySelector('.overlay').style.display = 'none';
    }

    document.querySelector('.overlay').addEventListener('click', closeGallery);
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') closeGallery();
    });

    window.addEventListener('scroll', function () {
        const navbar = document.querySelector('.navbar');
        let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        if (scrollTop > this.lastScrollTop) {
            navbar.style.top = "-80px";
            navbar.style.opacity = "0";
        } else {
            navbar.style.top = "0";
            navbar.style.opacity = "1";
        }
        this.lastScrollTop = scrollTop;
    });
</script>
</body>
</html>
