@include('viw_header')
@include('viw_user_navbar')

<section class="py-5 bg-light">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold text-primary">About Us</h2>
            <p class="lead text-muted">Get to know more about <span class="text-dark fw-semibold">The Fragrance Company</span> and our mission</p>
        </div>

        <div class="row align-items-center">
            <div class="col-md-6 mb-4 mb-md-0">
                <img src="{{ asset('public/images/product.jpg') }}" alt="About The Fragrance Company" class="img-fluid rounded shadow">
            </div>

            <div class="col-md-6">
                <h3 class="fw-bold text-dark">We Are More Than Just a Company</h3>
                <p class="text-muted">
                    <strong>The Fragrance Company</strong> was founded with a simple idea – to provide high-quality, aromatic products that promote confidence, freshness, and well-being while creating income opportunities for individuals across the country.
                </p>
                <p class="text-muted">
                    Our unique MLM system allows everyday people to become entrepreneurs by promoting our premium products and building their own network. We believe in ethical marketing, transparency, and empowering people with the tools they need to succeed.
                </p>
            </div>
        </div>

        <div class="mt-5 text-center">
            <h4 class="fw-semibold text-success">Our Mission</h4>
            <p class="text-muted">To combine the power of premium fragrances with the strength of a supportive community-driven business model.</p>
        </div>

        <div class="mt-4 text-center">
            <h4 class="fw-semibold text-info">Our Vision</h4>
            <p class="text-muted">To become India’s leading fragrance-based MLM platform, recognized for innovation, integrity, and inspiration.</p>
        </div>
    </div>
</section>

@include('viw_footer')
