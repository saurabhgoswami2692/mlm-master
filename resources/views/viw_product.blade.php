@include('viw_header')
@include('viw_user_navbar')

<div class="container py-5">
    <div class="row align-items-center bg-light shadow rounded p-4">
        <!-- Product Image -->
        <div class="col-md-6 mb-4 mb-md-0">
            <img src="{{ asset('public/images/product.jpg') }}" alt="The Fragrance Company Product" class="img-fluid rounded shadow-sm">
        </div>

        <!-- Product Details -->
        <div class="col-md-6">
            <h2 class="mb-3 fw-bold text-primary">The Fragrance Company</h2>
            <h4 class="mb-3">Premium Wellness Product</h4>

            <p class="mb-4 text-muted">
                Experience the essence of luxury with our exclusive product, crafted by <span class="fw-semibold text-dark">The Fragrance Company</span>. Designed to boost your health, elevate your mood, and energize your lifestyle — all with the power of natural ingredients backed by science.
            </p>

            <h4 class="text-success mb-3">Only ₹1,299</h4>

            <a href="#" class="btn btn-danger btn-lg px-4">Buy Now</a>
        </div>
    </div>
</div>

@include('viw_footer')

