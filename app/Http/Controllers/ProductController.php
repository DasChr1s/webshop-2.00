<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {

        return view('products.show', compact('product'));
    }

    public function searchProduct(Request $request)
    {
        $search = $request->input('search');
        $products = Product::where('name', 'like', "%$search%")->get();

        return view('products.index', compact('products'));
    }

   
}
