@include('viw_header')

<div class="container py-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Add New Product</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.store_product') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label fw-semibold">Product Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                
                <div class="mb-3">
                    <label for="description" class="form-label fw-semibold">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                </div>
                
                <div class="mb-3">
                    <label for="amount" class="form-label fw-semibold">Amount (₹)</label>
                    <input type="number" class="form-control" id="amount" name="amount" required>
                </div>
                
                <div class="mb-3">
                    <label for="image" class="form-label fw-semibold">Product Image</label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*" required>
                </div>
                
                <div class="text-end">
                    <button type="submit" class="btn btn-primary">Submit Product</button>
                </div>
            </form>
        </div>
    </div>
</div>

@include('viw_footer')
