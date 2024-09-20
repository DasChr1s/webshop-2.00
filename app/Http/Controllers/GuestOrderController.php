<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\GuestOrder;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Address;

class GuestOrderController extends Controller
{
    public function store(Request $request)
    {
        // Validierung
        $validated = $request->validate([
            'email' => 'required|email',
            'address_id' => 'required|exists:addresses,id',
            'cart' => 'required|array',
            'cart.*.product_id' => 'required|exists:products,id',
            'cart.*.quantity' => 'required|integer|min:1',
        ]);

        // Berechne den Gesamtpreis
        $totalPrice = array_reduce($validated['cart'], function ($carry, $item) {
            $product = Product::find($item['product_id']);
            return $carry + ($product->price * $item['quantity']);
        }, 0);

        DB::beginTransaction();

        try {
            // Erstelle eine neue Gastbestellung
            $guestOrder = GuestOrder::create([
                'email' => $validated['email'],
                'address_id' => $validated['address_id'],
                'total_price' => $totalPrice,
            ]);

            // Füge die Bestellpositionen hinzu
            foreach ($validated['cart'] as $item) {
                $product = Product::find($item['product_id']);
                // Optional: Überprüfe, ob genug Lagerbestand vorhanden ist
                if ($product->stock < $item['quantity']) {
                    DB::rollBack();
                    return response()->json(['error' => 'Nicht genügend Lagerbestand für Produkt ID ' . $item['product_id']], 400);
                }

                OrderItem::create([
                    'guest_order_id' => $guestOrder->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ]);
            }

            // Leere den Warenkorb in der Session
            Session::forget('cart');

            DB::commit();

            return response()->json(['success' => true, 'order_id' => $guestOrder->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Fehler bei der Bestellung: ' . $e->getMessage()], 500);
        }
    }
}
