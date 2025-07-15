@include('viw_header')

<div class="container py-5">
    <div class="card shadow-lg">
        <form method="GET" action="{{ url()->current() }}">
            <div class="row py-5 p-2">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Search..." value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                </div>
                <div class="col-md-2">
                    <a href="{{ url()->current() }}" class="btn btn-secondary w-100">Reset</a>
                </div>
            </div>
        </form>
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">All Payout Requests</h5>
        </div>
        <div class="card-body"> 
            
            @if($payout_requests->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Mobile</th>
                                <th>Amount</th>
                                {{-- <th>Joined At</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($payout_requests as $index => $payout_request)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ ucfirst($payout_request['name']) ?? '-' }}</td>
                                    <td>{{ $payout_request['email'] ?? '-' }}</td>
                                    <td>{{ $payout_request['mobile'] ?? '-' }}</td>
                                    <td>{{ $payout_request['amount'] ?? '-' }}</td>
                                    {{-- <td>-</td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
      
            @else
                <p class="text-muted">No users found.</p>
            @endif
        </div>
    </div>
</div>

@include('viw_footer')
