<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="javascript:void(0);">
            <img src="{{ asset('public/images/logo.png') }}" alt="Logo" height="40" class="me-2">
            <span class="fw-bold" style="color:#0d6efd;">The Fragrance Company</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNavbar" aria-controls="adminNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        

        <div class="collapse navbar-collapse" id="adminNavbar">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-bold text-primary' : '' }}" href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.users') ? 'active fw-bold text-primary' : '' }}" href="{{ route('admin.users') }}">
                        Users
                    </a>
                </li>

                <?php
                    $isBoardActive = request()->routeIs('admin.boards') || request()->routeIs('admin.boards.details');
                 ?> 

                <li class="nav-item">
                    <a class="nav-link {{ $isBoardActive ? 'active fw-bold text-primary' : '' }}" href="{{ route('admin.boards') }}">
                        Boards
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.payout_requests') ? 'active fw-bold text-primary' : '' }}" href="{{ route('admin.payout_requests') }}">
                        Payout Requests
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.products') ? 'active fw-bold text-primary' : '' }}" href="{{ route('admin.products') }}">
                        Products
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-danger fw-bold logout_btn" href="{{ route('admin_logout') }}">
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
