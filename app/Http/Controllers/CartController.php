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
        // Validierung der Produkt-ID und Menge
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        // Hol den aktuellen Warenkorb aus der Session
        $cart = Session::get('cart', []);

        // Prüfen, ob das Produkt bereits im Warenkorb ist
        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {
            $cart[$productId] = $quantity;
        }

        // Warenkorb in der Session aktualisieren
        Session::put('cart', $cart);

        // Gib die neue Gesamtanzahl der Artikel zurück
        $totalItems = array_sum($cart);

        return response()->json(['success' => true, 'count' => $totalItems]);
    }



    public function getCartCount()
    {
        $cart = Session::get('cart', []);
        $totalItems = array_sum($cart);
        return response()->json(['count' => $totalItems]);
    }

    public function clear()
    {
        Session::forget('cart');
        return redirect()->route('cart.show')->with('status', 'Warenkorb wurde geleert.');
    }

    public function destroy($id)
    {
        $cart = Session::get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            Session::put('cart', $cart);
        }

        return redirect()->route('cart.show')->with('status', 'Produkt wurde aus dem Warenkorb entfernt.');
    }

    public function update(Request $request, $productId)
    {
        $quantity = $request->input('quantity');

        // Überprüfe die Menge
        if (is_numeric($quantity) && $quantity > 0 && intval($quantity) == $quantity) {
            // Hol den aktuellen Warenkorb aus der Session
            $cart = Session::get('cart', []);

            // Überprüfe, ob das Produkt im Warenkorb ist
            if (isset($cart[$productId])) {
                // Aktualisiere die Menge
                $cart[$productId] = $quantity;
            } else {
                // Füge das Produkt hinzu, falls es noch nicht im Warenkorb ist
                $cart[$productId] = $quantity;
            }

            // Speichern den aktualisierten Warenkorb in der Session
            Session::put('cart', $cart);

            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => 'Ungültige Menge'], 400);
        }
    }

 
}
