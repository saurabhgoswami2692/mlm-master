@include('viw_header')

<div class="container py-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">All Boards</h5>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($boards->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Board Name</th>
                                <th>Total Members</th>
                                {{-- <th>Joined At</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            foreach($boards as $index => $board) { ?>
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td><a href="{{ route('admin.boards.details',$board->board_id ) }}" >{{ $board->board_name }}</a></td>
                                    <td>{{ $board->total_members }}</td>
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
