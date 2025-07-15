<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    public function index(){   
        return view('viw_product');
    }

    public function product_list(Request $req){
        $products = Product::orderBy('product_id','desc')->get();
        return view('viw_product_list',compact('products'));
    }

    public function add_product(Request $req){
        return view('viw_add_product');
    }

    public function store_product(Request $req)
    {   
        // Validate input
        $validated = $req->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'amount'      => 'required|numeric',
            'image'       => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($req->hasFile('image')) {
            $image       = $req->file('image');
            $imageName   = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath   = $image->storeAs('products', $imageName, 'public'); // stored in storage/app/public/products
        }

        // Store product data
        Product::create([
            'product_name'   => $validated['name'],
            'product_desc'   => $validated['description'],
            'product_amount' => $validated['amount'],
            'product_image'  => $imagePath ?? null,
        ]);

        return redirect()->back()->with('success', 'Product added successfully!');
    }

    public function edit_product(Request $req, $product_id){
        $active_page = 'products';
        $products = Product::where('product_id',$product_id)->first();
        return view('viw_edit_product',compact('products'));
    }

    public function update_product(Request $req,$product_id){
        $data = $req->all();
        if ($req->hasFile('image')) {
            $image       = $req->file('image');
            $imageName   = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $imagePath   = $image->storeAs('products', $imageName, 'public'); // stored in storage/app/public/products
        }

        // Update product
        Product::where('product_id',$product_id)->update([
            'product_name'   => $data['name'],
            'product_desc'   => $data['description'],
            'product_amount' => $data['amount'],
            'product_image'  => $imagePath ?? $data['image_name'],
        ]);

        return redirect()->back()->with([
            'class' => 'alert-success',
            'message' => 'Product updated successfully!'
        ]);
    }

}
