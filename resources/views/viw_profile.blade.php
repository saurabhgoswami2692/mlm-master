@include('viw_header')

<div class="d-flex vh-100 align-items-center justify-content-center bg-light">
    <div class="card shadow p-4 w-100" style="max-width: 800px;">
        
        <!-- Member Profile -->
        <h4 class="mb-4 text-center">Member Profile</h4>

        <div class="row">
            <div class="col-md-6">
                <div class="card p-3 mb-3">
                    <label class="form-label fw-bold mb-1">Name:</label>
                    <span class="text-muted">{{ ucfirst($member_datas->name) }}</span>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card p-3 mb-3">
                    <label class="form-label fw-bold mb-1">Mobile:</label>
                    <span class="text-muted">{{ $member_datas->mobile }}</span>
                </div>
            </div>
        </div>

        <!-- Due Payment Section -->
        <h5 class="mb-2 p-2">Dues</h5>
        <div class="p-2 alert-payment alert " style="display:none;"></div>
        <div class="row align-items-center">
            <div class="col-md-8">
                <label class="form-label fw-bold mb-1">Due Amount:</label>
                <input type="text" class="form-control" id="payment_amount" value="{{ $member_datas->memberships->amount - $member_datas->payment->sum('paid') }}" >
                <input type="hidden" name="member_id" id="member_id" value="{{$member_datas->id}}">
                <input type="hidden" name="original_amount" id="original_amount" value="{{ $member_datas->memberships->amount - $member_datas->payment->sum('paid') }}">
            </div>
            <div class="col-md-4 text-end">
                <button class="btn btn-danger btn mt-3" data-bs-toggle="modal" data-bs-target="#paymentModal" id="payment_btn">Pay</button>
            </div>
        </div>

        <!-- Payment History -->
        <h5 class="mb-2 p-2">Payments</h5>
        <div class="table-responsive">
            <table class="table table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Reg. Date</th>
                        <th>Amount</th>
                        <th>Paid</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($member_datas->payment as $index => $payment)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ date('d-m-Y', strtotime($payment->created_at)) }}</td>
                        <td><span class="badge bg-success">{{ $member_datas->memberships->amount }}</span></td>
                        <td><span class="badge bg-success">{{ $payment->paid }}</span></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
@include('viw_footer')
