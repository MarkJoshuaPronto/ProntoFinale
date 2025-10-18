<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/png" href="{{ asset('faviconlogo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Cycle of Giving - About Us</title>
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

        .logo {
            max-width: 600px;
            margin-left: 80px;
            height: auto;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 30px;
            text-align: center;
        }

        .about-section {
            color: #ffffff;
            text-align: center;
        }

        .about-section,
        .mission-section,
        .goal-section,
        .process-section,
        .team-section,
        .values-section,
        .cta-section {
            padding: 80px 0;
        }

        .about-section {
            background-color: #196f38;
        }

        .mission-section {
            background-color: #f4f9f4;
        }

        .mission-section h2 {
            color: #196f38;
        }

        .mission-section p {
            font-size: 1.1rem;
            text-align: center;
            color: #000000;
        }

        .goal-section {
            background-color: #ffffff;
        }

        .section-title {
            color: #ffffff
        }

        .goal-section p {
            font-size: 1.1rem;
            color: #000000;
        }

        .goal-section li {
            color: #000000;
        }

        .process-section {
            background-color: #196f38;
            color: #ffffff;
        }

        .process-section h2 {
            color: #ffffff;
        }

        .process-step {
            text-align: center;
            margin-bottom: 40px;
        }

        .process-step img {
            max-width: 150px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .process-step h3 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 15px;
        }

        .process-step p {
            font-size: 1.1rem;
            color: #ffffff;
        }

        .team-section {
            background-color: #196f38;
        }

        .team-member {
            text-align: center;
            margin-bottom: 40px;
        }

        .team-member img {
            max-width: 150px;
            border-radius: 50%;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .team-member h3 {
            font-size: 1.5rem;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 10px;
        }

        .team-member p {
            font-size: 1.1rem;
            color: #ffffff;
        }

        .values-section {
            background-color: #ffffff;
            color: #000000;
        }

        .values-section h2 {
            color: #196f38;
        }

        .values-section p {
            font-size: 1.1rem;
            text-align: center;
            color: #000000;
        }

        .cta-section {
            position: relative;
            background: url("assets/donated.jpg") no-repeat center center/cover;
            overflow: hidden;
            text-align: center;
        }

        .cta-section::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(5px);
        }

        .cta-section .container {
            position: relative;
            z-index: 1;
            filter: none;
        }

        .cta-section p {
            font-size: 1.1rem;
            color: #ffffff;
        }

        .cta-section h2 {
            font-size: 2.5rem;
            font-weight: bold;
            color: #ffffff;
            margin-bottom: 20px;
        }

        .cta-section .btn-primary {
            background-color: #ffd000;
            color: #000000;
            border: none;
            padding: 12px 35px;
            font-size: 1.1rem;
            transition: background-color 0.3s ease;
        }

        .cta-section .btn-primary:hover {
            background-color: #196f38;
        }

        .role-specific {
            background-color: #196f38;
            padding: 40px 0;
        }

        .role-card {
            background-color: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            height: 100%;
        }

        .role-card h3 {
            color: #196f38;
            margin-bottom: 20px;
        }

        .role-card ul {
            text-align: left;
            padding-left: 20px;
        }

        .role-card li {
            margin-bottom: 10px;
        }




        .footer {
            background-color: #196f38;
            color: #fff;
            padding: 20px 0;
            text-align: center;
        }

        .footer p {
            margin: 0;
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

        /* Media Queries for Mobile Responsiveness */
        @media (max-width: 768px) {
            .hero-section {
                padding: 80px 0;
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

            .hero-section h1 {
                font-size: 2.5rem;
            }

            .hero-section p {
                font-size: 1rem;
            }

            .logo {
                max-width: 100%;
                margin-left: 0;
            }

            .section-title {
                font-size: 2rem;
            }

            .process-step img {
                max-width: 100px;
            }

            .process-step h3 {
                font-size: 1.2rem;
            }

            .process-step p {
                font-size: 1rem;
            }

            .team-member img {
                max-width: 100px;
            }

            .team-member h3 {
                font-size: 1.2rem;
            }

            .team-member p {
                font-size: 1rem;
            }

            .cta-section h2 {
                font-size: 2rem;
            }

            .cta-section p {
                font-size: 1rem;
            }

            .cta-section .btn-primary {
                padding: 10px 25px;
                font-size: 1rem;
            }
        }

        @media (max-width: 576px) {
            .hero-section {
                padding: 60px 0;
            }

            .hero-section h1 {
                font-size: 2rem;
            }

            .hero-section p {
                font-size: 0.9rem;
            }

            .section-title {
                font-size: 1.5rem;
            }

            .process-step img {
                max-width: 80px;
            }

            .process-step h3 {
                font-size: 1rem;
            }

            .process-step p {
                font-size: 0.9rem;
            }

            .team-member img {
                max-width: 80px;
            }

            .team-member h3 {
                font-size: 1rem;
            }

            .team-member p {
                font-size: 0.9rem;
            }

            .cta-section h2 {
                font-size: 1.5rem;
            }

            .cta-section p {
                font-size: 0.9rem;
            }

            .cta-section .btn-primary {
                padding: 8px 20px;
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
                    <a href="{{ route('landingpageuser') }}">
                        <img src="{{ asset('assets/navlogo.png') }}" alt="Cycle of Giving Logo" class="cyclelogo" style="width: 150px; height: 50px;">
                    </a>
                </span>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse align-items-center justify-content-center" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link text-white" aria-current="page" href="{{route('landingpageuser')}}">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{route('donationuser')}}">Donations</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{route('galleryuser')}}">Gallery</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="{{route('aboutususer')}}">About Us</a>
                        </li>
                    </ul>
                </div>
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
        </nav>
    </header>

    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1>About Us</h1>
                    <p>
                        At <strong>Cycle of Giving</strong>, we are dedicated to creating a world where generosity and sustainability go hand in hand. Our platform connects donors with those in need, ensuring that every item finds a new home where it’s truly valued. Through the power of giving, we not only reduce waste but also provide essential resources to individuals and families facing challenges. Whether it's clothing, food, school supplies, or household items, your contributions help create a ripple effect of kindness and hope. Together, we can support families, strengthen communities, and build a future where no one is left behind. Join us in making a lasting impact, give today!
                    </p>
                </div>
                <div class="col-md-6 text-center">
                    <img src="{{asset('assets/aboutus.jpg')}}" alt="About Us Image" class="logo">
                </div>
            </div>
        </div>
    </section>

    <section class="about-section">
        <div class="container">
            <h2 class="section-title">Who We Are</h2>
            <p>
                <strong>Cycle of Giving</strong> is a nonprofit organization with a mission to promote sustainability and social equity. We believe that every item has a second life and that every act of giving creates a ripple effect of positive change. Our team is made up of passionate individuals who are committed to making a difference in the world.
            </p>
            <p>
                Our journey began with a simple idea: to create a platform where people can easily donate items they no longer need and connect with those who do. Over time, we’ve grown into a global movement, with thousands of donors and recipients joining us in our mission to build a more sustainable and compassionate world.
            </p>
        </div>
    </section>

    <section class="mission-section">
        <div class="container">
            <h2 class="section-title">What We Do</h2>
            <p>
                We provide a platform where individuals and organizations can donate items they no longer need, such as clothing, furniture, electronics, and household goods. These items are then distributed to families and individuals who need them most. By facilitating this exchange, we reduce waste, support underserved communities, and promote a culture of generosity.
            </p>
            <p>
                Our platform is designed to be simple and accessible. Donors can easily list items they want to give away, and recipients can browse available items based on their needs. We also partner with local organizations to ensure that donations reach those who need them most, whether it’s a family in need, a shelter, or a community center.
            </p>
        </div>
    </section>

    <!-- New Role-Specific Section -->
    <section class="role-specific">
        <div class="container">
            <h2 class="text-center mb-5" style="color: #ffffff; font-weight: bold; font-size: 2.5rem;">How You Can Participate</h2>
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="role-card donor">
                        <h3>For Donors</h3>
                        <p>Your generosity powers our cycle of giving. As a donor, you can:</p>
                        <ul>
                            <li>Declutter your home while helping others in need</li>
                            <li>Reduce environmental impact by giving items a second life</li>
                            <li>Receive tax deductions for eligible donations</li>
                            <li>Choose where your items go or let us match them to needs</li>
                            <li>Track the impact of your donations through our platform</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div class="role-card recipient">
                        <h3>For Recipients</h3>
                        <p>We provide dignified access to resources you need. As a recipient, you can:</p>
                        <ul>
                            <li>Access quality items without financial burden</li>
                            <li>Request specific items needed by your family or organization</li>
                            <li>Receive notifications when needed items become available</li>
                            <li>Connect directly with donors in your community</li>
                            <li>Save money while reducing environmental waste</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="goal-section">
        <div class="container">
            <h2 class="section-title-goal">Our Goal</h2>
            <p>
                We strive to create a world where resources flow to where they're needed most, benefiting both donors and recipients. Our objectives include:
            </p>
            <ul>
                <li><strong>Creating seamless connections</strong> between donors and recipients</li>
                <li><strong>Ensuring dignity and choice</strong> for recipients receiving items</li>
                <li><strong>Providing satisfaction and transparency</strong> for donors</li>
                <li><strong>Expanding our reach</strong> to support more communities in need</li>
                <li><strong>Building stronger partnerships</strong> to amplify our impact</li>
                <li><strong>Promoting a culture of giving</strong> that benefits all participants</li>
            </ul>
            <p>
                Together, we can create a future where generosity and sustainability benefit everyone in our community.
            </p>
        </div>
    </section>

    <section class="process-section">
        <div class="container">
            <h2 class="section-title">How It Works</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="process-step">
                        <img src="{{asset('assets/donate-icon.jpg')}}" alt="Donate Icon">
                        <h3>1. Donate</h3>
                        <p>List items you no longer need and make them available for others. Your donations can range from clothing and furniture to electronics and household goods.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="process-step">
                        <img src="{{asset('assets/connect-icon.jpg')}}" alt="Connect Icon">
                        <h3>2. Connect</h3>
                        <p>Our platform matches your donations with individuals and families who need them most. We ensure that every item finds a new home where it’s truly valued.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="process-step">
                        <img src="{{asset('assets/impact-icon.jpg')}}" alt="Impact Icon">
                        <h3>3. Impact</h3>
                        <p>See the tangible impact of your generosity. Every donation helps reduce waste, supports families in need, and strengthens community connections.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="values-section">
        <div class="container">
            <h2 class="section-title">Our Values</h2>
            <p>
                At our core, we believe in <strong>dignity for all</strong>, whether giving or receiving. We value <strong>sustainability</strong> through reuse, <strong>generosity</strong> without expectation, and <strong>community</strong> connections that benefit everyone. We practice <strong>transparency</strong> in all operations, <strong>inclusivity</strong> in serving diverse needs, and <strong>environmental responsibility</strong> in reducing waste.
            </p>
        </div>
    </section>

    <section class="cta-section">
        <div class="container">
            <h2>Sharing is Caring</h2>
            <p>Start donating today and make a difference in the world! Your generosity can provide food, clean water, education, and medical aid to those in need. Every contribution, no matter how small, helps create a brighter future. Join us in making a positive impact, donate now and be a part of the change!</p>
            <a href="{{route('donationuser')}}" class="btn btn-primary">Donate Items</a>
        </div>
    </section>

    <footer class="footer">
        <div class="container">
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
</body>
</html>
