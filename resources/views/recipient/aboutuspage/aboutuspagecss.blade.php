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
        /* Your existing CSS styles remain unchanged */
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

        .about-section {
            font-size: 1.1rem;
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

        .dual-cta {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        .dual-cta .btn {
            min-width: 180px;
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

        .section-title-goal {
            color: #196f38;
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 30px;
            text-align: center;
        }

        /* .role-card.donor {
            border-top: 5px solid #196f38;
        }

        .role-card.recipient {
            border-top: 5px solid #ffd000;
        } */

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
