<footer class="bg-light border-top mt-5 pt-5">
    <div class="container">
        <div class="row text-center text-md-start">
            <!-- Logo & About -->
            <div class="col-md-4 mb-4">
                <h5 class="fw-bold text-primary">The Fragrance Company Network</h5>
                <p class="text-muted">Grow your network, earn commissions, and unlock financial opportunities with our structured The Fragrance Company system.</p>
            </div>

            <!-- Useful Links -->
            <div class="col-md-4 mb-4">
                <h6 class="fw-semibold text-dark">Quick Links</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ route('product') }}" class="text-muted text-decoration-none">Product</a></li>
                    <li><a href="#" class="text-muted text-decoration-none">Contact</a></li>
                    @if(session('user_id'))
                        <li><a href="{{ route('user_logout') }}" class="text-muted text-decoration-none">Logout</a></li>
                    @else
                        <li><a href="{{ route('login') }}" class="text-muted text-decoration-none">Login</a></li>
                        <li><a href="{{ route('register') }}" class="text-muted text-decoration-none">Register</a></li>
                    @endif
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="col-md-4 mb-4">
                <h6 class="fw-semibold text-dark">Contact Us</h6>
                <p class="text-muted mb-1"><i class="fa-solid fa-envelope me-2 text-primary"></i> support@thefragrancecompany.com</p>
                <p class="text-muted mb-1"><i class="fa-solid fa-phone me-2 text-success"></i> +91 9785552945</p>
                <p class="text-muted"><i class="fa-solid fa-location-dot me-2 text-danger"></i> Jaipur, Rajasthan</p>
            </div>
        </div>

        <hr class="my-4">

        <div class="text-center pb-3">
            <small class="text-muted">&copy; {{ date('Y') }} The Fragrance Company. All rights reserved.</small>
        </div>
    </div>
</footer>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="<?php echo env('APP_URL').'/resources/js/custom_v1.js'; ?>"></script>
</body>
</html>