@include('viw_header')

<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center bg-light py-4">
    <div class="row w-100 mx-1">
        <!-- Image Section (Hidden on Mobile) -->
        <div class="col-md-6 d-none d-md-flex justify-content-center align-items-center">
            <img src="{{ asset('public/images/register.jpg') }}" alt="Register Image" class="img-fluid rounded shadow" style="max-height: 400px; object-fit: cover; width: 100%;">
        </div>

        <!-- Form Section (Full Width on Mobile) -->
        <div class="col-12 col-md-6 d-flex justify-content-center align-items-center">
            <div class="card shadow p-4 w-100" style="border-radius: 15px; max-width: 500px;">
                <h4 class="text-center mb-4" style="font-weight: 600; color: #2c3e50;">Join Our Network</h4>

                @if (session('message'))
                    <div class="alert {{ session('class') }} alert-dismissible fade show" role="alert">
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <form method="POST" action="{{ route('user_store') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Full Name & Mobile -->
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Full name" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Mobile</label>
                           <input type="text" class="form-control" name="mobile" value="{{ old('mobile') }}" maxlength="10" pattern="\d{10}" placeholder="Mobile" required>
                        </div>
                    </div>

                    <!-- Email & Gender -->
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label d-block">Gender</label>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="gender" value="male" class="form-check-input" checked>
                                <label class="form-check-label">Male</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input type="radio" name="gender" value="female" class="form-check-input">
                                <label class="form-check-label">Female</label>
                            </div>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="row mb-3 text-center align-items-center">
                        <div class="col-4">
                            <img src="{{ asset('storage/app/public/' . $product->product_image) }}" alt="Product Image" class="img-fluid rounded" style="max-width: 80px;">
                        </div>
                        <div class="col-8 text-start">
                            <h6 class="mb-0">{{ $product->product_name ?? '' }}</h6>
                            <p class="text-success fw-bold mb-0">₹ {{ $product->product_amount ?? '' }}</p>
                        </div>
                    </div>

                    <!-- Payment Method -->
                    <div class="row mb-3">
                        <label class="form-label">Payment Method</label>
                        <div class="col-6">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="payment_method" value="cash" checked>
                                <label class="form-check-label">Cash</label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-check">
                                <input type="radio" class="form-check-input" name="payment_method" value="online">
                                <label class="form-check-label">Online</label>
                            </div>
                        </div>
                    </div>

                    <!-- Password -->
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label class="form-label">Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" name="c_password" placeholder="Confirm password" required>
                        </div>
                    </div>

                    <!-- Hidden Inputs -->
                    <input type="hidden" name="joining_amount" value="">
                    <input type="hidden" name="product_id" value="{{ $product->product_id ?? '' }}">
                    <input type="hidden" name="amount" value="{{ $product->product_amount ?? '' }}">
                    <input type="hidden" name="refer_id" value="{{ $ref ?? '' }}">

                    <!-- Submit Button -->
                    <button type="submit" class="btn btn-danger w-100 mt-3">Join</button>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- @include('viw_footer') --}}
<script>
    var registerUrl = "{{ route('user_store') }}"; // Laravel route for AJAX
</script>

<script src="<?php echo env('APP_URL').'/resources/js/users.js'; ?>"></script>
