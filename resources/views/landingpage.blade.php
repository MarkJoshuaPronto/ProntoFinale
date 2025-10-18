<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset('faviconlogo.png') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Cycle of Giving - Home</title>
    <style>
        body {
            background-color: #f4f9f4;
            font-family: 'Arial', sans-serif;
            color: #34495e;
        }

        .hero-section {
            background-color: #ffffff;
            padding: 150px 0;
            border-radius: 15px;
        }

        .hero-section h1 {
            font-size: 3.5rem;
            font-weight: bold;
            color: #2c3e50;
        }

        .hero-section p {
            font-size: 1.2rem;
            color: #34495e;
            line-height: 1.8;
            text-align: justify;
        }

        .btn-primary {
            background-color: #196f38;
            border: none;
            padding: 12px 35px;
            font-size: 1.1rem;
            transition: background-color 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #ffd000;
        }

        .btn-secondary {
            background-color: #ffd000;
            color: #2c3e50;
            border: none;
            padding: 12px 35px;
            font-size: 1.1rem;
            transition: background-color 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #196f38;
            color: white;
        }

        .logo {
            max-width: 500px;
            height: auto;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-left: 100px;
        }

        /* Section Titles */
        .section-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #000000;
            margin-bottom: 30px;
            text-align: center;
        }

        .mission-section,
        .impact-section,
        .how-it-works,
        .testimonials-section,
        .partners-section,
        .cta-section {
            padding: 80px 0;
        }

        /* Mission Section */
        .mission-section {
            position: relative;
            background-color: #196f38;
            overflow: hidden;
        }

        /* .mission-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(5px);
        } */

        .mission-section .container {
            position: relative;
            z-index: 1;
            filter: none;
        }

        .mission-section h2 {
            color: #ffffff;
        }

        .mission-section p {
            color: #fff;
            text-align: center;
            font-size: 1.1rem;
            line-height: center;
        }

        /* How It Works Section */
        .how-it-works {
            background-color: #ffffff;
        }

        .how-it-works h2 {
            color: #196f38;
        }

        .how-it-works .step {
            text-align: center;
            padding: 30px;
            border-radius: 15px;
            background-color: #196f38;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .how-it-works .step:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .how-it-works .step h3 {
            font-size: 1.75rem;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 20px;
        }

        .how-it-works p {
            color: #ffffff;
            font-size: 1.1rem;
            line-height: 1.6;
        }

        /* Role Cards */
        .role-cards {
            display: flex;
            justify-content: center;
            gap: 30px;
            margin-top: 40px;
        }

        .role-card {
            background-color: #196f38;
            border-radius: 15px;
            padding: 30px;
            width: 45%;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .role-card:hover {
            transform: translateY(-10px);
        }

        .role-card h3 {
            color: #ffffff;
            font-size: 1.75rem;
            margin-bottom: 20px;
            text-align: center;
        }

        .role-card p {
            color: #ffffff;
            font-size: 1.1rem;
            line-height: 1.6;
            text-align: justify;
        }

        /* Testimonials Section */
        .testimonials-section {
            background-color: #ffffff;
        }

        .testimonials-section h2 {
            color: #196f38;
        }

        .testimonial-card {
            background-color: #196f38;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .testimonial-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
        }

        .testimonial-card p {
            font-style: italic;
            color: #ffffff;
        }

        .testimonial-card h4 {
            font-size: 1.2rem;
            font-weight: bold;
            color: #ffffff;
            margin-top: 15px;
        }

        .partners-section {
            background: #196f38;
        }

        .partners-section h2 {
            color: #ffffff;
        }

        .partners-section img {
            max-width: 190px;
            margin: 20px;
            transition: filter 0.3s ease;
            display: block; /* Ensure images behave as blocks */
        }

        .partners-section img:hover {
            filter: grayscale(0%);
        }

        .partner-link {
            display: inline-block; /* Allow links to be inline blocks */
        }

        /* Call To Action Section */
        /* remove any background-image from .cta-section */
        .cta-section {
        position: relative;
        background-color: #fdfdfd; /* fallback color */
        color: #000;
        padding: 60px 0;
        text-align: center;
        overflow: hidden;
        }

        /* blurred background image */
        .cta-section::before {
        content: "";
        position: absolute;
        inset: 0;                      /* top:0; right:0; bottom:0; left:0 */
        background-color: #ffffff;
        background-size: cover;
        background-position: center;
        filter: blur(8px);            /* blur strength */
        transform: scale(1.05);       /* prevent edge cut-off */
        z-index: 0;                   /* keep it behind content */
        pointer-events: none;
        }

        /* make sure content is above the pseudo-element */
        .cta-section > * {
        position: relative;
        z-index: 1;
        }

        .cta-section h2 {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            color: #196f38;
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

        /* Mobile adjustments */
        @media (max-width: 768px) {
            .hero-section {
                padding: 80px 20px;
            }

            .hero-section h1 {
                font-size: 2.5rem;
            }

            .logo {
                max-width: 100%;
                margin-left: 0;
            }

            .section-title {
                font-size: 2rem;
            }

            .how-it-works .step {
                padding: 20px;
            }

            .how-it-works .step h3 {
                font-size: 1.5rem;
            }

            .role-cards {
                flex-direction: column;
                align-items: center;
            }

            .role-card {
                width: 100%;
                margin-bottom: 20px;
            }

            .partners-section img {
                max-width: 150px;
                margin: 10px;
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
                text-align: center;
            }

            .navbar-text {
                text-align: center;
                margin-top: 10px;
            }

            .hero-section .row {
                flex-direction: column;
            }

            .hero-section .col-md-6 {
                width: 100%;
                text-align: center;
            }

            .hero-section .btn-primary, .hero-section .btn-secondary {
                width: 100%;
                margin-bottom: 20px;
            }

            .mission-section p {
                font-size: 1rem;
            }

            .testimonial-card {
                margin-bottom: 20px;
            }

            .cta-section h2 {
                font-size: 2rem;
            }

            .cta-section p {
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .hero-section h1 {
                font-size: 2rem;
            }

            .hero-section p {
                font-size: 1rem;
            }

            .section-title {
                font-size: 1.75rem;
            }

            .how-it-works .step h3 {
                font-size: 1.25rem;
            }

            .how-it-works p {
                font-size: 1rem;
            }

            .role-card h3 {
                font-size: 1.5rem;
            }

            .role-card p {
                font-size: 1rem;
            }

            .testimonial-card p {
                font-size: 0.9rem;
            }

            .testimonial-card h4 {
                font-size: 1rem;
            }

            .cta-section h2 {
                font-size: 1.75rem;
            }

            .cta-section p {
                font-size: 0.9rem;
            }

            .footer p {
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
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
                        {{-- <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('donation') }}">Donations</a>
                        </li> --}}
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('gallery') }}">Gallery</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{ route('aboutus') }}">About Us</a>
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

    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1>Cycle of Giving</h1>
                    <p>
                        Welcome to <strong>Cycle of Giving</strong>, a platform where generosity meets sustainability. We believe that every item has a second life, and every act of giving creates a ripple effect of positive change. Whether you're decluttering your home or searching for something you need, you're contributing to a movement that reduces waste, supports families, and strengthens communities.
                    </p>
                    <p>
                        By joining us, you're not just donating or receiving items, you're becoming part of a global effort to promote environmental sustainability and social equity. Together, we can create a world where resources are shared, not wasted, and where every act of kindness makes a difference.
                    </p>
                    <div class="text-left mt-4">
                        <a href="{{ route('register') }}" class="btn btn-primary me-3">I Want to Donate</a>
                        <a href="{{ route('register') }}" class="btn btn-secondary">I Need Items</a>
                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <img src="{{ asset('assets/upang.png') }}" alt="Cycle of Giving Logo" class="logo">
                </div>
            </div>
        </div>
    </section>

    <section class="mission-section">
        <div class="container">
            <h2 class="section-title">Our Mission</h2>
            <p>
                At Cycle of Giving, our mission is to create a sustainable ecosystem where resources are shared, not wasted. We aim to bridge the gap between those who have and those who need, fostering a culture of generosity and environmental responsibility. By connecting donors with recipients, we reduce waste, support underserved communities, and promote a greener future for all.
            </p>
        </div>
    </section>

    <section class="how-it-works">
        <div class="container">
            <h2 class="section-title">How It Works</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="step">
                        <h3>1. Donate</h3>
                        <p>List items you no longer need and make them available for others. Your donations can range from clothing and furniture to electronics and household goods.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step">
                        <h3>2. Connect</h3>
                        <p>Our platform matches your donations with individuals and families who need them most. We ensure that every item finds a new home where it's truly valued.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step">
                        <h3>3. Impact</h3>
                        <p>See the tangible impact of your generosity. Every donation helps reduce waste, supports families in need, and strengthens community connections.</p>
                    </div>
                </div>
            </div>

            <div class="role-cards">
                <div class="role-card">
                    <h3>For Donors</h3>
                    <p>As a donor, you can easily list items you no longer need. Simply create an account, upload photos and descriptions of your items, and specify pickup or drop-off preferences. Your donations will be matched with recipients who truly need them, and you can track the impact of your generosity through our platform.</p>
                </div>
                <div class="role-card">
                    <h3>For Recipients</h3>
                    <p>As a recipient, you can browse available items that meet your needs. Create an account to request items, communicate with donors, and arrange for pickup or delivery. Our platform ensures that items go to those who need them most, helping you access essential goods while reducing environmental waste.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- <section class="testimonials-section">
        <div class="container">
            <h2 class="section-title">What People Are Saying</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <p>"Cycle of Giving helped me declutter my home while supporting families in need."</p>
                        <h4>- Nathaniel Z. (Donor)</h4>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <p>"I received a much-needed stroller for my baby. This platform is a lifesaver!"</p>
                        <h4>- Joyce E. (Recipient)</h4>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="testimonial-card">
                        <p>"A simple way to make a big impact. I love being part of this community!"</p>
                        <h4>- Jethro I. (Donor)</h4>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <section class="partners-section">
        <div class="container">
            <h2 class="section-title">Our Partners</h2>
            <div class="d-flex justify-content-center flex-wrap">
                <a href="https://www.facebook.com/up.csdl" target="_blank" class="partner-link">
                    <img src="{{asset('assets/csdl.png')}}" alt="Partner 1">
                </a>
                <a href="https://www.facebook.com/phinma.up.citesc" target="_blank" class="partner-link">
                    <img src="{{asset('assets/cite.jpg')}}" alt="Partner 2">
                </a>
                 <a href="https://www.facebook.com/share/p/12FznZUeGkd/" target="_blank" class="partner-link">
                    <img src="{{asset('assets/helpinghands.jpg')}}" alt="Partner 3">
                </a>
                {{-- <a href="#" class="partner-link">
                    <img src="{{asset('assets/cycleofgiving.jpg')}}" alt="Partner 4">
                </a> --}}
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="container">
            <h2>Join Our Community Today</h2>
            <p>Whether you have items to give or are in need of essential goods, your participation makes a difference.</p>
            <div class="mt-4">
                <a href="{{ route('register') }}" class="btn btn-primary me-3">Become a Donor</a>
                <a href="{{ route('register') }}" class="btn btn-secondary">Become a Recipient</a>
            </div>
        </div>
    </section>

    <footer class="footer">
        <div class="conatain">
            <p>&copy; 2023 Cycle of Giving. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

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

    <script>
        //This section is only needed if you want to add an alert to the third image as it does not have a link.
        document.addEventListener('DOMContentLoaded', function() {
            var partnerLinks = document.querySelectorAll('.partner-link');

            partnerLinks.forEach(function(link, index) {
                if (index === 2 && link.getAttribute('href') === 'javascript:void(0);') { // Check if it's the third link and has no proper link
                    link.addEventListener('click', function(event) {
                        event.preventDefault(); // Prevent default action (navigation)
                        alert('No link provided for this partner.');
                    });
                }
            });
        });
    </script>
</body>
</html>
