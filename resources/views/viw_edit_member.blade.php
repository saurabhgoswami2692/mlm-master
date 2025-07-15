@include('viw_header')
<div class="container mt-4">
    <!-- Back Button -->

    <div class="text-end">
        <a href="{{ route('members_by_type','all-members') }}" class="btn btn-primary mb-3">
            <i class="fas fa-arrow-left"></i> Back
        </a>
    </div>

    <!-- Centered Form -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow p-4 border rounded">
                <h4 class="text-center mb-3">Update Member</h4>
                <div class="alert" id="alert-message" style="display:none;"></div>

                <form method="POST" id="user_form" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="exampleInputName" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="exampleInputName" name="name" 
                                   value="{{$member->name}}" placeholder="Enter name">
                        </div> 
                        <div class="col-md-6">
                            <label for="exampleInputMobile" class="form-label">Mobile</label>
                            <input type="text" class="form-control" id="exampleInputMobile" name="mobile" 
                                   value="<?php echo $member->mobile; ?>" placeholder="Enter mobile">
                        </div>
                    </div> 

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="exampleInputEmail1" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" name="email" 
                                   value="<?php echo $member->email; ?>" placeholder="Enter email">
                            <small class="form-text text-muted">We'll never share your email.</small>    
                        </div> 
                        <div class="col-md-6">
                            <label class="form-label">Gender</label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="male" name="gender" value="male" 
                                           <?php echo ($member->gender == 'male') ? 'checked' : ''; ?>>
                                    <label for="male" class="form-check-label">Male</label>
                                </div>
                                <div class="form-check">
                                    <input type="radio" class="form-check-input" id="female" name="gender" value="female" 
                                           <?php echo ($member->gender == 'female') ? 'checked' : ''; ?>>
                                    <label for="female" class="form-check-label">Female</label>
                                </div>
                            </div>
                        </div> 
                    </div> 

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="exampleInputWeight" class="form-label">Weight (In KG's)</label>
                            <input type="number" id="exampleInputWeight" class="form-control" name="weight" 
                                   value="<?php echo $member->weight; ?>" placeholder="Enter weight">
                        </div> 
                        <div class="col-md-6">
                            <label for="exampleInputHeight" class="form-label">Height (In CM's)</label>
                            <input type="number" id="exampleInputHeight" class="form-control" name="height" 
                                   value="<?php echo $member->height; ?>" placeholder="Enter height">
                        </div> 
                    </div> 

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="exampleInputPlan" class="form-label">Select Plan</label>
                            <select class="form-control select_plan" name="plan" id="select_plan">
                                <option>Select a plan</option>
                                <?php foreach($plans as $plan){ ?>
                                    <option value="{{$plan['id']}}" <?php echo ($plan['id'] == $member->memberships->plan_id) ? 'selected="selected"' : ''; ?>>{{ $plan['name'] }}</option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="exampleInputAmount" class="form-label">Amount (to be paid)</label>
                            <input type="number" id="exampleInputAmount" class="form-control plan_amount" name="amount" value="{{ $member->memberships->amount }}" placeholder="Enter amount">
                        </div> 
                    </div> 

                    <input type="hidden" name="id" value="<?php echo $member->id; ?>">

                    <button type="submit" class="btn btn-primary w-100 user-btn-submit">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
@include('viw_footer')

<script>
    var userStoreUrl = "{{ route('member_update') }}"; // Laravel route for AJAX
    var getPlanUrl = "{{ route('get_plan') }}"; // Define route in a JavaScript variable
</script>
<script src="<?php echo env('APP_URL').'/resources/js/users.js'; ?>"></script>

