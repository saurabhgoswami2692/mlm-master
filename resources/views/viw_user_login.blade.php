@include('viw_header')

<div class="container-fluid vh-100 d-flex align-items-center justify-content-center bg-light">
    <div class="row w-100">
        <!-- Left Side: Image -->
        <div class="col-md-6 d-none d-md-flex justify-content-center align-items-center">
            <img src="public/images/login.jpg" alt="Login Image" class="img-fluid" style="border-radius: 15px; max-height: 100%; object-fit: cover;">
        </div>

        <!-- Right Side: Login Form -->
        <div class="col-md-6 d-flex justify-content-center align-items-center">
            <div class="card shadow p-4" style="width: 90%; border-radius: 15px; background-color: #ffffff; box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.1);">
                
                

                <h4 class="text-center mb-4 form-label" style="font-size: 1.5rem; font-weight: 600; color: #2c3e50;">Login to Your Account</h4>
                <div class="alert" id="alert-message" style="display:none;"></div>

                <!-- Success Message -->
                @if (session('message'))
                    <div class="alert {{session('class')}} alert-dismissible fade show" role="alert">
                        {{ session('message') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                <form method="POST"  action="{{route('user_login')}}" enctype="multipart/form-data">
                    @csrf

                    <!-- Email input -->
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Email address" style="border-radius: 8px;" required>
                    </div>

                    <!-- Password input -->
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" style="border-radius: 8px;" required>
                    </div>

                    <!-- Submit button -->
                    <button type="submit" class="btn btn-danger w-100 login-btn" style="border-radius: 8px; transition: background-color 0.3s ease;">
                        Login
                    </button>

                    <!-- Forgot password link -->
                    <div class="text-center mt-3">
                        {{-- <a href="javascript:void(0);" class="text text-decoration-none">Forgot Password?</a> --}}
                       
                    </div>
                    <div class="text-center mt-3">
                        <span class="text">Don't have an account? </span><a href="{{route('register')}}" class="text text-decoration-none">Sign up</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@include('viw_footer')

<script>
    var loginUrl = "{{ route('user_login') }}"; // Laravel route for AJAX
</script>

<script src="<?php echo env('APP_URL').'/resources/js/users.js'; ?>"></script>
