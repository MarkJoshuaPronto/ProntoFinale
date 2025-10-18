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
        .cta-section {
            background-color: #fdfdfd;
            color: #000000;
            padding: 60px 0;
            text-align: center;
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
