@include('viw_header')
@include('viw_user_navbar')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-body">
                    <h4 class="mb-4 text-center">Update Profile</h4>

                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @elseif (session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('user.update_profile') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Mobile</label>
                            <input type="text" name="mobile" value="{{ old('mobile', $user->mobile) }}" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Update Profile</button>
                    </form#>
                </div>
            </div>
        </div>
    </div>
</div>

@include('viw_footer')

<script>
    setTimeout(() => {
        $('.alert').hide();
    }, 1000);
</script>
