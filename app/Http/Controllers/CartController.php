<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\Product;

class CartController extends Controller
{
    public function show()
    {
        $cart = Session::get('cart', []);
        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get(); // Hol dir die Produkte basierend auf den IDs aus der Session
        return view('cart.index', ['products' => $products, 'cart' => $cart]);
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        $cart = Session::get('cart', []);
        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {
            $cart[$productId] = $quantity;
        }

        Session::put('cart', $cart);

        return response()->noContent();
    }

    public function getCartCount()
    {
        $cart = Session::get('cart', []);
        $totalItems = array_sum($cart);
        return response()->json(['count' => $totalItems]);
    }

    public function clear()
    {
        Session::forget('cart'); // Entfernt die 'cart'-Session-Variable
        return redirect()->route('cart.show')->with('status', 'Warenkorb wurde geleert.');
    }
}
