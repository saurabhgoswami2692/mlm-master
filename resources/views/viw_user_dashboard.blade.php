@include('viw_header')
@include('viw_user_navbar')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0">
                <div class="card-body p-4">

                    <!-- Welcome -->
                    <h4 class="mb-4 text-center">Welcome, <span class="text-primary">{{ ucfirst($dashboard_data['users']->name) ?? 'Guest' }}</span></h4>

                    <div class="alert alert-info text-center mb-4">
                        <strong>Level Progress:</strong> You need 
                        <span class="text-danger fw-bold">{{$dashboard_data['require_user']}}</span> 
                        more {{ Str::plural('member', 0) }} to reach 
                        <strong>Level {{$dashboard_data['level_upgrade']}}</strong>.
                    </div>


                    <!-- Wallet and Stats -->
                    <div class="row mb-4 text-center">
                        <div class="col-md-3">
                            <div class="p-3 border rounded shadow-sm bg-light">
                                <h6 class="text-muted">Wallet Balance</h6>
                                <h5 class="text-success">₹{{ $dashboard_data['wallet_balance'] ?? '0.00' }}</h5>
                                <?php if(isset($dashboard_data['wallet_balance'])){ ?>
                                    <a href="{{ route('withdraw_request') }}" class="btn btn-primary">Withdraw</a>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 border rounded shadow-sm bg-light">
                                <h6 class="text-muted">Total Referrals</h6>
                                <h5>{{ $dashboard_data['total_referrals'] }}</h5>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 border rounded shadow-sm bg-light">
                                <h6 class="text-muted">Level</h6>
                                <h5>{{ $dashboard_data['level'] ?? 1 }}</h5>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="p-3 border rounded shadow-sm bg-light">
                                <h6 class="text-muted">Joined On</h6>
                                <h6>{{ $dashboard_data['users']->created_at->format('d M Y') }}</h6>
                            </div>
                        </div>
                    </div>

                    <!-- Referral Link -->
                    <label for="referl_link" class="form-label fw-semibold">Referral Link</label>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="row">
                        <div class="col-md-9">
                            <input type="text" name="referl_link" id="referl_link" class="form-control mb-3 text-secondary  " readonly value="{{ env('APP_URL') . '/register?refer_id=' . $dashboard_data['users']->id }}">
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-success w-100 copy_link">Copy link</button>
                        </div>
                    </div>
                    
                    <div class="alert alert-success mt-3" id="alert_copy_link" style="display: none;">
                        Link copied to clipboard!
                    </div>

                    <!-- Referred Members Table -->
                    <?php /*
                    @if($referred_users->count() > 0)
                        <h5 class="mt-5 mb-3">Your Referred Members</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile</th>
                                        <th>Level</th>
                                        <th>Board ID</th>
                                        <th>Parent Name</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($referred_users as $index => $ref)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ ucfirst($ref->name) }}</td>
                                            <td>{{ $ref->email }}</td>
                                            <td>{{ $ref->mobile }}</td>
                                            <td>{{ $ref->level }}</td>
                                            <td>{{ $ref->board_id }}</td>
                                            <td>{{ optional($ref->parent)->name ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mt-4">No referred members yet.</p>
                    @endif */ ?>

                    <!-- Recent Activity (Static Example) -->
                    {{-- <h5 class="mt-5 mb-3">Recent Activity</h5>
                    <ul class="list-group">
                        <li class="list-group-item">✅ test5 joined using your link. (5 mins ago)</li>
                    </ul> --}}

                </div>
            </div>
        </div>
    </div>
</div>

@include('viw_footer')

<script>
    document.querySelector('.copy_link').addEventListener('click', function () {
        const copyText = document.getElementById("referl_link");
        copyText.select();
        document.execCommand("copy");
        document.getElementById("alert_copy_link").style.display = "block";
        setTimeout(() => document.getElementById("alert_copy_link").style.display = "none", 2000);
    });
</script>
