@include('viw_header')
  <div class="container mt-4">
    <div class="text-end">
      <a href="{{ route('member_register') }}" class="btn btn-primary mb-3">
          <i class="fas fa-user-plus"></i> Add Member
      </a>
  </div>
      <!-- Wrapper Card -->
      <div class="card p-4 shadow-sm border rounded">      
        <!-- All Members Table -->
        <div class="card shadow-sm border rounded p-3 mb-4">
        
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="text-center m-0"><i class="<?php echo $icon; ?>"></i> <?php echo ' '.ucwords(str_replace('-',' ',$member_type)); ?></h4>
            <input type="text" id="searchPlans" class="form-control w-25" placeholder="🔍 Search Member...">
        </div>
          <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered text-center">
                  <thead class="table-dark">
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Full Name</th>
                  <th scope="col">Mobile</th>
                  <?php if($member_type == "all-members"){ ?>
                      <th scope="col">Email</th>
                      <th scope="col">Plan Name</th>
                      <th scope="col">Weight</th>
                      <th scope="col">Height</th>
                      <th scope="col">Action</th>
                  <?php } else if($member_type == "all-payments" || $member_type == "all-due-payments") {?>
                      <th scope="col">Plan Type</th>
                      <th scope="col">Plan Amount (₹)</th>
                      <th scope="col">Paid Amount (₹)</th>
                      <th scope="col">Due Amount (₹)</th>
                  <?php } ?>
                </tr>

              </thead>
              <tbody>
                <?php 
                  if(!empty($members)){
                  $i = 1;
                  foreach($members as $member){ 
                ?>        
                <tr>
                  <th scope="row">{{ $i++ }}</th>
                  <td><a href="{{ route('member_profile',$member['id']) }}">{{ ucfirst($member['name']) }}</a></td>
                  <td>{{ $member['mobile'] }}</td>
                  <?php if($member_type == "all-members"){ ?>
                      <td>{{ $member['email'] }}</td>
                      <td>{{ !empty($member['memberships']) ? $member['memberships'][0]['plan']['name'] : '-' }}</td>
                      <td>{{ $member['weight'].'KG' }}</td>
                      <td>{{ $member['height'].'CM' }}</td>
                      <td>
                        <a href="{{route('member_edit',$member['id'])}}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        {{-- <a href="#" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i> Delete
                        </a> --}}
                    </td>
                  <?php } else if($member_type == "all-payments" || $member_type == "all-due-payments") { ?>
                      <td>{{ isset($member['plan_type']) ? $member['plan_type']: '-' }}</td>
                      <td>{{ isset($member['plan_amount']) ? $member['plan_amount']: '-' }}</td>
                      <td>{{ isset($member['paid_amount']) ? $member['paid_amount']: '-' }}</td>
                      <td>{{ isset($member['rem_amount']) ? $member['rem_amount']: '-' }}</td>
                  <?php } ?>
                </tr>
                <?php } } else { ?>
                <tr>
                  <td colspan="7" class="text-center">No Record Found.</td>
                </tr>
                <?php }?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
@include('viw_footer')