@include('viw_header')
@include('viw_user_navbar')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-lg border-0">
                <div class="card-body p-4">

                    <!-- Welcome -->
                    <h4 class="mb-4 text-center">Welcome, <span class="text-primary">{{$users['name']}}</span></h4>
                    <!-- Referral Link -->
                    <div class="alert " id="alert-message" style="display: none;"></div>
                    <label for="withdraw_amount" class="form-label fw-semibold">
                        Withdraw Amount
                    </label>
                    <?php 
                    // echo $users['payment_request']; die;
                    // if($users['payment_request'] == 1){
                    //     echo "test"; die;
                    // } else {
                    //     echo "tsdfsdf"; die;
                    // }
                    // echo "<pre>";
                        // print_r($users['payment_request']); die;
                    
                    if($users['payment_request'] == 1) {?>
                    <small class="text-danger d-block">
                        Your amount will be transferred into your account within the next 24 hours.
                    </small>
                    <?php } ?>


                    <form method="POST" id="payment_request_form" enctype="multipart/form-data">
                        @csrf
                        <input 
                            type="text" 
                            name="amount" 
                            id="amount" 
                            class="form-control mb-3" 
                            readonly
                            value="{{$users['amount']}}"
                            readonly
                        >
                        <input type="hidden" name="user_id" value="{{$users['id']}}">
                        <input type="hidden" name="payment_id" value = "{{$users['payment_id']}}">
                        <button type="submit" class="btn btn-success w-100 payment_request" <?php echo ($users['payment_request'] == 1) ? 'disabled' : ''; ?> >Send Request</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('viw_footer')

<script>
    var payment_request_url = "{{ route('payment_request') }}"; // Laravel route for AJAX
</script>

<script src="<?php echo env('APP_URL').'/resources/js/payment.js'; ?>"></script>
