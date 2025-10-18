<style>
    body {
        background-color: #f4f9f4;
        font-family: 'Arial', sans-serif;
        color: #34495e;
        /* --- Changes Start Here --- */
        display: flex;
        flex-direction: column;
        min-height: 100vh; /* Ensures the body is at least the full height of the viewport */
        /* --- Changes End Here --- */
    }

    /* --- Add this new rule --- */
    section {
        flex: 1; /* This makes the section grow to fill available space, pushing the footer down */
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
