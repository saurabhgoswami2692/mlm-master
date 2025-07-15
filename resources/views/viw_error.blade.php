@include('viw_header')

<div class="container-fluid vh-100 d-flex align-items-center justify-content-center bg-light">
    <div class="row w-100">
        <!-- Left Side: Image -->
        <div class="col-md-6 d-none d-md-flex justify-content-center align-items-center">
            <img src="public/images/register.jpg" alt="Register Image" class="img-fluid" style="border-radius: 15px; max-height: 100%; object-fit: cover;">
        </div>

        <!-- Right Side: Register Form -->
        <div class="col-md-6 d-flex justify-content-center align-items-center">
            <div class="card shadow p-4" style="width: 90%; border-radius: 15px; background-color: #ffffff; box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.1);">
                <div class="text-center mb-4">
                    <h4 class="form-label" style="font-size: 1.5rem; font-weight: 600; color: red;">
                        The referral link you used is invalid.
                    </h4>
                    <a href="{{ route('register') }}" class="btn btn-primary mt-3">
                        Register Without Referral
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@include('viw_footer')

<script>
    var registerUrl = "{{ route('user_store') }}"; // Laravel route for AJAX
</script>

<script src="<?php echo env('APP_URL').'/resources/js/users.js'; ?>"></script>
