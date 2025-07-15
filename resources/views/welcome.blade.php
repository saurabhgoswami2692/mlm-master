@include('viw_header')
@include('viw_user_navbar')

<!-- Hero Section -->

<section class="hero-section py-5 bg-light text-center">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6 text-md-start">
                <h1 class="display-5 fw-bold">Build Your Network, Achieve Success</h1>
                <p class="lead">
                    Join our powerful <span class="fw-bold text-primary">The Fragrance Company</span> platform and unlock new opportunities by building your team.
                </p>
                @if(!session('user_id'))
                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg mt-3">Join the Network</a>
                @endif
            </div>
            <div class="col-md-6">
                <img src="{{ asset('public/images/hero-1.jpg') }}" alt="Network" class="img-fluid rounded shadow" style="max-height: 450px; width: auto;">
            </div>
        </div>
    </div>
</section>



<!-- About Section -->
<section class="py-5">
    <div class="container text-center">
        <h2 class="fw-bold mb-4">About <span class="fw-bold text-primary">The Fragrance Company</span> System</h2>
        <p class="text-muted fs-5">Our The Fragrance Company system helps you grow your network and earn commissions by referring new members. Start your journey to financial freedom today.</p>
    </div>
</section>

<!-- Mission & Vision -->
<section class="py-5 bg-light">
    <div class="container text-center">
        <div class="row">
            <div class="col-md-6 mb-4">
                <h3 class="fw-bold text-primary">Our Mission</h3>
                <p class="text-muted fs-5">To empower individuals by providing a simple and effective way to generate income and build a successful network through trust and transparency.</p>
            </div>
            <div class="col-md-6 mb-4">
                <h3 class="fw-bold text-success">Our Vision</h3>
                <p class="text-muted fs-5">To become the most trusted The Fragrance Company platform globally, offering life-changing financial opportunities to people from all walks of life.</p>
            </div>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="bg-white py-5">
    <div class="container text-center">
        <h2 class="fw-bold mb-5">How It Works</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="p-4 border rounded shadow-sm h-100 bg-light">
                    <i class="fa-solid fa-user fa-3x mb-3 text-primary"></i>
                    <h4>Register</h4>
                    <p>Sign up and become a member</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 border rounded shadow-sm h-100 bg-light">
                    <i class="fa-solid fa-users fa-3x mb-3 text-success"></i>
                    <h4>Refer</h4>
                    <p>Invite others to join the network</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 border rounded shadow-sm h-100 bg-light">
                    <i class="fa-solid fa-dollar-sign fa-3x mb-3 text-warning"></i>
                    <h4>Earn</h4>
                    <p>Receive commissions on referrals</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Animated Counters -->
<section class="py-5 bg-primary text-white text-center">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-3">
                <h2 class="fw-bold counter" data-count="5000">0</h2>
                <p>Active Users</p>
            </div>
            <div class="col-md-3">
                <h2 class="fw-bold counter" data-count="150000">0</h2>
                <p>Total Earnings</p>
            </div>
            <div class="col-md-3">
                <h2 class="fw-bold counter" data-count="1200">0</h2>
                <p>Boards Filled</p>
            </div>
            <div class="col-md-3">
                <h2 class="fw-bold counter" data-count="10">0</h2>
                <p>Years of Trust</p>
            </div>
        </div>
    </div>
</section>

<!-- Testimonials -->
<?php /*
<section class="py-5 bg-light text-center">
    <div class="container">
        <h2 class="fw-bold mb-5">What Our Members Say</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="p-4 bg-white shadow-sm rounded">
                    <p class="fst-italic">"MLM platform ne mujhe ek nayi income stream di. Ab main financially secure feel karta hoon!"</p>
                    <h6 class="mt-3 fw-semibold">— Rahul Sharma</h6>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-white shadow-sm rounded">
                    <p class="fst-italic">"I started with zero, and now I have a growing team. This platform truly works."</p>
                    <h6 class="mt-3 fw-semibold">— Anita Verma</h6>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 bg-white shadow-sm rounded">
                    <p class="fst-italic">"Simple, transparent, and powerful! Highly recommend for anyone looking to grow online."</p>
                    <h6 class="mt-3 fw-semibold">— Deepak Yadav</h6>
                </div>
            </div>
        </div>
    </div>
</section> */ ?>

@include('viw_footer')

<!-- Counter Script -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const counters = document.querySelectorAll('.counter');
        counters.forEach(counter => {
            const updateCount = () => {
                const target = +counter.getAttribute('data-count');
                const count = +counter.innerText;
                const speed = 100; // lower = faster
                const inc = target / speed;
                if (count < target) {
                    counter.innerText = Math.ceil(count + inc);
                    setTimeout(updateCount, 20);
                } else {
                    counter.innerText = target;
                }
            };
            updateCount();
        });
    });
</script>
