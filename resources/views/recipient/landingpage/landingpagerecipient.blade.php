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
@include('recipient.landingpage.landingpagecss')
</head>
<body>
    @include('recipient.landingpage.landingpageheader')

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
                    {{-- <div class="text-left mt-4">
                        <a href="{{ route('register') }}" class="btn btn-primary me-3">I Want to Donate</a>
                        <a href="{{ route('register') }}" class="btn btn-secondary">I Need Items</a>
                    </div> --}}
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
                {{-- <a href="{{ route('register') }}" class="btn btn-primary me-3">Become a Donor</a> --}}
                <a href="{{ route('show_request') }}" class="btn btn-primary me-3">Request Items</a>
            </div>
        </div>
    </section>

@include('recipient.landingpage.landingpagefooter')
@include('recipient.landingpage.landingpagejs')
</body>
</html>
