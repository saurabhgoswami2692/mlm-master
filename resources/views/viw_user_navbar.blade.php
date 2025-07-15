<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
  <div class="container">

      <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
        <img src="{{ asset('public/images/logo.png') }}" alt="Logo" height="40" class="me-2">
        <span class="fw-bold">
            <span style="color:#0d6efd;">The Fragrance Company</span>
        </span>
      </a>
    
      <!-- Navbar toggle button for mobile view -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      
      <!-- Navbar links -->
      <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto align-items-center">
              <?php if(session('user_id')){ ?>
                  <li class="nav-item"><a class="nav-link" href="{{ route('user_dashboard') }}">Dashboard</a></li>
              <?php } ?>
              <?php /*
              <li class="nav-item"><a class="nav-link" href="{{ route('product') }}">Product</a></li>
              <li class="nav-item"><a class="nav-link" href="{{ route('about_us') }}">About us</a></li>
              */ ?>
              {{-- <li class="nav-item"><a class="nav-link" href="javascript:void(0);">Contact</a></li> --}}

              @if(session('user_id'))
                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" data-bs-toggle="dropdown">
                          {{ ucfirst(session('user_name')) ?? 'User' }}
                      </a>
                      <ul class="dropdown-menu dropdown-menu-end">
                        <?php /*
                          <li><a href="{{ route('change_password') }}">Change password</a></li>
                          <li><a href="{{ route('user.edit_profile') }}">Settings</a></li>
                          */ ?>
                          <li><a class="dropdown-item" href="{{ route('user_logout') }}">Logout</a></li>
                      </ul>
                  </li>
              @else
                  <li class="nav-item"><a class="btn btn-outline-primary ms-2" href="{{ route('login') }}">Login</a></li>
              @endif
          </ul>
      </div>
  </div>
</nav>
