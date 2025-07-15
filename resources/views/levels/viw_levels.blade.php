@include('viw_header')
<div class="container mt-4">
  <div class="text-end">
    <a href="{{ route('plan_create') }}" class="btn btn-primary mb-3">
        <i class="fas fa-user-plus"></i> Add level
    </a>
</div>

  <!-- Wrapper Card -->
  <div class="card p-4 shadow-sm border rounded">
      <div class="card shadow-sm border rounded p-3">

          <!-- Table Header with Search -->
          <div class="d-flex justify-content-between align-items-center mb-3">
              <h4 class="text-center m-0"><i class="fas fa-list-alt"></i> All levels</h4>
              {{-- <input type="text" id="searchPlans" class="form-control w-25" placeholder="🔍 Search Plan..."> --}}
          </div>

          <!-- Table -->
          <div class="table-responsive">
              <table class="table table-striped table-hover table-bordered text-center">
                  <thead class="table-dark">
                      <tr>
                          <th scope="col">#</th>
                          <th scope="col">Level name</th>
                          <th scope="col" class="text-nowrap">Commission</th>
                          <th scope="col">Action</th>
                      </tr>
                  </thead>
                  <tbody id="plansTable">
                      <?php 
                        if(isset($plans) && !empty($plans)){
                          $i = 1;
                          foreach($plans as $plan){ 
                      ?>        
                      <tr>
                          <th scope="row">{{ $i++ }}</th>
                          <td>{{ ucfirst($plan['name']) }}</td>
                          <td>{{ number_format($plan['price'], 2) }}</td>
                          <td>
                              <a href="{{route('plan_edit',$plan['id'])}}" class="btn btn-warning btn-sm">
                                  <i class="fas fa-edit"></i> Edit
                              </a>
                          </td>
                      </tr>
                      <?php } } else { ?>
                        <tr>
                            <td colspna="4">No record found.</td>
                        </tr>
                     <?php } ?>
                  </tbody>
              </table>
          </div>

      </div>
  </div>

</div>

<!-- Search Functionality -->
<script>
  document.getElementById("searchPlans").addEventListener("keyup", function() {
      var value = this.value.toLowerCase();
      document.querySelectorAll("#plansTable tr").forEach(row => {
          row.style.display = row.innerText.toLowerCase().includes(value) ? "" : "none";
      });
  });
</script>

  
@include('viw_footer')