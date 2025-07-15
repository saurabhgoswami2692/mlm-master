@include('viw_header')

<div class="container py-5">
    @if (session('message'))
        <div class="alert {{session('class')}} alert-dismissible fade show" role="alert">
            {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <!-- Success Message -->
            <h5 class="mb-0">Update Product</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.update_product', $products['product_id']) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Product Name</label>
                    <input type="text" class="form-control" id="name" name="name" value = "{{$products['product_name']}}" required>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required>{{$products['product_desc']}}</textarea>
                </div>
                
                <div class="mb-3">
                    <label for="amount" class="form-label fw-semibold">Amount (₹)</label>
                    <input type="number" class="form-control" id="amount" name="amount" value = "{{$products['product_amount']}}" required>
                </div>
                
                <div class="mb-3">
                    <label for="image" class="form-label fw-semibold">Product Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    <img src="{{ asset('storage/app/public/'. $products['product_image']) }}" style="width:80px">
                    <input type="hidden" name="image_name" id="image_name" value ="{{$products['product_image']}}" >
                    {{-- {{ asset('storage/app/public/' . $product->product_image) }} --}}
                </div>
                
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('viw_footer')
