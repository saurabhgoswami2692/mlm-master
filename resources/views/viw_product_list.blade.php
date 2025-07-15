@include('viw_header')

<div class="container py-5">
    <div class="card shadow-lg">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">All Products</h5>
                <a href="{{route('admin.add_product')}}" name="btn_submit" class="btn btn-light btn-sm text-primary bg-white">Add Product</a>
            </div>
            <!-- Card body with table or content can go here -->
        </div>

        <div class="card-body">
            
            @if($products->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                {{-- <th>Description</th> --}}
                                <th>Amount</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $index => $product)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ ucfirst($product['product_name']) ?? '-' }}</td>
                                    <td>{{ $product['product_amount'] ?? '-' }}</td>
                                    <td><img src="{{ asset('storage/app/public/' . $product['product_image']) }}" width="80"></td>
                                    <td>
                                        <a href="{{route('admin.edit.product',$product->product_id)}}" class="btn btn-primary">Edit</a>
                                    </td>
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
