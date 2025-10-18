<!DOCTYPE html>
<html lang="en">
<head>
    @include('recipient.aboutuspage.aboutuspagecss')
</head>
<body>
    @include('recipient.aboutuspage.aboutuspageheader')

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
                <strong>Cycle of Giving</strong> is a nonprofit organization creating a sustainable bridge between those who have resources to share and those who need them. We believe every item deserves a second life, and every person deserves dignity and support. Our platform serves both <strong>donors</strong> looking to make a meaningful impact and <strong>recipients</strong> seeking essential resources.
            </p>
            <p>
                Our community includes individuals, families, nonprofits, and businesses, all united by the common goal of reducing waste while helping others. Whether you're here to give or to receive, you're an essential part of our mission to create a more equitable and sustainable world.
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
                        <h3 style="color: #ffffff;">1. Give or Request</h3>
                        <p><strong>Donors</strong> list items they want to give away. <strong>Recipients</strong> browse or request items they need. Our platform makes both processes simple and dignified.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="process-step">
                        <img src="{{asset('assets/connect-icon.jpg')}}" alt="Connect Icon">
                        <h3 style="color: #ffffff;">2. Connect</h3>
                        <p>We match donations with those who need them most. Donors and recipients can communicate directly or through our partner organizations to arrange transfers.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="process-step">
                        <img src="{{asset('assets/impact-icon.jpg')}}" alt="Impact Icon">
                        <h3 style="color: #ffffff;">3. Impact</h3>
                        <p>Every exchange creates a double benefit: donors declutter meaningfully while recipients access needed resources. Together, we reduce waste and strengthen communities.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="values-section">
        <div class="container">
            <h2 class="section-title">Our Values</h2>
            <p>
                At the core of our organization are the values of <strong>sustainability</strong>, <strong>generosity</strong>, and <strong>community</strong>. We believe that every act of giving, no matter how small, contributes to a larger movement of positive change. We are committed to transparency, inclusivity, and environmental responsibility in everything we do.
            </p>
        </div>
    </section>

    <section class="cta-section">
        <div class="container">
            <h2>Sharing is Caring</h2>
            <p>Start donating today and make a difference in the world! Your generosity can provide food, clean water, education, and medical aid to those in need. Every contribution, no matter how small, helps create a brighter future. Join us in making a positive impact, donate now and be a part of the change!</p>
            <a href="{{route('show_request')}}" class="btn btn-primary">Request Items</a>
        </div>
    </section>

    @include('recipient.aboutuspage.aboutuspagefooter')
</body>
    @include('recipient.aboutuspage.aboutuspagejs')
</html>
