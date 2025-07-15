@include('viw_header')

<div class="container py-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">{{$board_details[0]->board_name}}</h5>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($board_details->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                {{-- <th>Board Name</th> --}}
                                <th>Name</th>
                                <th>Level</th>
                                <th>Position</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($board_details as $index => $board_detail) { 
                                ?>
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    {{-- <td>{{ $board_detail->board_name }}</td> --}}
                                    <td>{{ $board_detail->name }}</td>
                                    <td>{{ $board_detail->level}}</td>
                                    <td>{{ $board_detail->position }}</td>

                                    {{-- <td>{{ $user->created_at->format('d-m-Y H:i') }}</td> --}}
                                </tr>
                            <?php } ?>
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
