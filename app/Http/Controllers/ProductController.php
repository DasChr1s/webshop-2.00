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
    
        if (empty($search)) {
            // Wenn kein Suchbegriff eingegeben wurde, gebe alle Produkte zurück
            $products = Product::all();
        } else {
            // Andernfalls filtere nach dem Suchbegriff
            $products = Product::where('name', 'like', "%$search%")->get();
        }
    
        // Render die Teilansicht für die Produktliste
        return view('products._product-list', compact('products'))->render();
    }
    
    
}
