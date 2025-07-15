@include('viw_header')
<div class="container mt-4">
    <!-- Back Button (Aligned Left) -->
    <div class="text-end">
      <a href="{{ route('plans') }}" class="btn btn-primary mb-3">
          <i class="fas fa-arrow-left"></i> Back
      </a>
  </div>

    <!-- Centered Card -->
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow p-4 border rounded">
                <h4 class="text-center mb-3">Add level</h4>
                <div class="alert" id="alert-message" style="display: none;"></div>

                <form method="POST" id="plan_form" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="planName" class="form-label">Level name</label>
                        <input type="text" class="form-control" id="planName" name="name" 
                               value="<?php echo isset($plan) ? $plan->name : ''; ?>" 
                               placeholder="Enter plan name">
                    </div> 

                    <div class="mb-3">
                        <label for="planPrice" class="form-label">Commission</label>
                        <input type="number" id="planPrice" class="form-control" name="price" 
                               value="<?php echo isset($plan) ? $plan->price : ''; ?>" 
                               placeholder="Enter price">        
                    </div> 

                    <input type="hidden" name="plan_id" id="plan_id" 
                           value="<?php echo isset($plan) ? $plan->id : ''; ?>">

                    <button type="submit" class="btn btn-primary w-100 btn-plan-submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>  
  @include('viw_footer')
  <?php if(isset($plan)){ ?>
  <script>
    var planStoreUrl = "{{ route('plan_update') }}"; // Laravel route for AJAX
  </script>
<?php } else { ?>
  <script>
    var planStoreUrl = "{{ route('plan_store') }}"; // Laravel route for AJAX
</script>
<?php } ?> 
<script src="<?php echo env('APP_URL').'/resources/js/plans.js'; ?>"></script>

