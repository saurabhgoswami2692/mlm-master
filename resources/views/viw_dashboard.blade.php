@include('viw_header')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<div class="container mt-4">
    <!-- Stats Section -->
    <div class="card p-4 shadow-sm border rounded">
        <div class="row">
            <div class="col-sm-3">
                <div class="card text-center shadow-sm border rounded p-3">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-users"></i> Users</h5>
                        <p class="card-text text-primary fs-3 fw-bold">{{ $total_users }}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card text-center shadow-sm border rounded p-3">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-sitemap"></i> Boards</h5>
                        <p class="card-text text-success fs-3 fw-bold">{{ $total_boards }}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card text-center shadow-sm border rounded p-3">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-network-wired"></i> Active Boards</h5>
                        <p class="card-text text-warning fs-3 fw-bold">{{$total_boards}}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="card text-center shadow-sm border rounded p-3">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-network-wired"></i> Payout Requests</h5>
                        <p class="card-text text-danger fs-3 fw-bold">{{$total_payout_requests}}</p>
                    </div>
                </div>
            </div>
            <?php /*
            <div class="col-sm-3">
                <div class="card text-center shadow-sm border rounded p-3">
                    <div class="card-body">
                        <h5 class="card-title"><i class="fas fa-wallet"></i> Total Income</h5>
                        <p class="card-text text-danger fs-3 fw-bold">₹1,50,000</p>
                    </div>
                </div>
            </div>
            */ ?>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="card mt-4 p-4 shadow-sm border rounded">
        <h4 class="mb-3">Actions</h4>
        <div class="row text-center">
            
            <div class="col-sm-4">
                <a href="{{ route('admin.users') }}" class="btn btn-secondary w-100">
                    <i class="fas fa-users"></i> View Users
                </a>
            </div>
            <div class="col-sm-4">
                <a href="{{ route('admin.boards') }}" class="btn btn-info w-100">
                    <i class="fas fa-network-wired"></i> View Boards
                </a>
            </div>
            <div class="col-sm-4">
                <a href="javascript:void(0);" class="btn btn-warning w-100">
                    <i class="fas fa-money-check-alt"></i> Payout Requests
                </a>
            </div>
        </div>
    </div>

    <!-- Pending Withdrawals -->
    <?php /*
    <div class="card mt-4 p-4 shadow-sm border rounded">
        <h4 class="mb-3">Pending Withdraw Requests</h4>
        <table class="table table-bordered text-center">
            <thead class="table-info">
                <tr>
                    <th>User</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Rahul Sharma</td>
                    <td>₹2000</td>
                    <td>14-04-2025</td>
                    <td><span class="badge bg-warning">Pending</span></td>
                </tr>
                <tr>
                    <td>Anjali Verma</td>
                    <td>₹1500</td>
                    <td>15-04-2025</td>
                    <td><span class="badge bg-warning">Pending</span></td>
                </tr>
            </tbody>
        </table>
    </div>
    */ ?>

    <!-- Charts -->
    <div class="card mt-4 p-4 shadow-sm border rounded">
        <h4 class="mb-3">Analytics</h4>
        <div class="row">
            <div class="col-md-6">
                <canvas id="levelChart"></canvas>
            </div>
            <div class="col-md-6">
                <canvas id="incomeChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    var ctx1 = document.getElementById('levelChart').getContext('2d');
    var levelChart = new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: ['Level 1', 'Level 2', 'Level 3', 'Level 4', 'Level 5'],
            datasets: [{
                label: 'Users Joined',
                data: [30, 20, 15, 10, 5],
                backgroundColor: 'rgba(54, 162, 235, 0.7)'
            }]
        }
    });

    var ctx2 = document.getElementById('incomeChart').getContext('2d');
    var incomeChart = new Chart(ctx2, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr'],
            datasets: [{
                label: 'Monthly Income',
                data: [30000, 35000, 40000, 45000],
                borderColor: 'green',
                fill: false
            }]
        }
    });
</script>

@include('viw_footer')
