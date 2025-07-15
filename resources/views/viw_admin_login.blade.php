@include('viw_header')

<div class="d-flex align-items-center justify-content-center min-vh-100 bg-dark text-white px-3">
    <div class="card shadow p-4 w-100" style="max-width: 400px; border-radius: 12px; background-color: #2c3e50;">
        
        {{-- Flash Message --}}
        @if (session('msg'))
            <div class="alert {{ session('class') ?? 'alert-warning' }} alert-dismissible fade show" role="alert">
                {{ session('msg') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Logo (optional) --}}
        <div class="text-center mb-3">
            {{-- <img src="{{ asset('logo.png') }}" class="img-fluid" alt="Logo" width="80"> --}}
        </div>

        <h4 class="text-center mb-4">Login to your account</h4>

        <form method="POST" action="{{ route('admin_login') }}" enctype="multipart/form-data">
            @csrf

            {{-- Email --}}
            <div class="mb-3">
                <label for="email" class="form-label">Email address</label>
                <input type="email"
                       class="form-control"
                       id="email"
                       name="email"
                       value="{{ old('email') }}"
                       placeholder="Enter your email"
                       required>
            </div>

            {{-- Password --}}
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password"
                       class="form-control"
                       id="password"
                       name="password"
                       placeholder="Enter your password"
                       required>
            </div>

            {{-- Submit --}}
            <button type="submit" class="btn btn-danger w-100 login-btn">Login</button>

            {{-- Forgot Password --}}
            <div class="text-center mt-3">
                <a href="#" class="text-light text-decoration-none">Forgot Password?</a>
            </div>
        </form>
    </div>
</div>

<style>
    .bg-dark {
        background-color: #1a252f !important;
    }
    .card {
        border-radius: 12px;
    }
    .login-btn {
        background-color: #e74c3c;
        border: none;
    }
    .login-btn:hover {
        background-color: #c0392b;
    }
    .form-label {
        color: #ecf0f1;
    }
</style>

@include('viw_footer')

<script>
    var loginUrl = "{{ route('admin_login') }}";
</script>

<script src="{{ env('APP_URL') }}/resources/js/login.js"></script>
