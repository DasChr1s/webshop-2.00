<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use App\Models\GuestOrder;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Address;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderShipped;

class GuestOrderController extends Controller
{
    public function store(Request $request)
    {
        // Validierung
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
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
            // Adresse erstellen
            $address = Address::create([
                'street' => $validated['street'],
                'city' => $validated['city'],
                'postal_code' => $validated['postal_code'],
                'country' => $validated['country'],
            ]);

            // Erstelle eine neue Gastbestellung
            $guestOrder = GuestOrder::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'address_id' => $address->id,
                'total_price' => $totalPrice,
            ]);

            // Füge die Bestellpositionen hinzu
            foreach ($validated['cart'] as $item) {
                $product = Product::find($item['product_id']);

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

            // Sende eine E-Mail mit den Bestelldaten
            Mail::to($validated['email'])->send(new OrderShipped($guestOrder));

            return response()->json(['success' => true, 'order_id' => $guestOrder->id]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Fehler bei der Bestellung: ' . $e->getMessage()], 500);
        }
    }



    public function showOrderForm()
    {

        // Warenkorb aus der Session holen
        $cart = Session::get('cart', []);

        // Wenn der Warenkorb leer ist, zur Warenkorbseite zurückkehren
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('status', 'Ihr Warenkorb ist leer.');
        }

        // Produkte anhand der IDs im Warenkorb laden
        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get();

        return view('cart.order-data', ['products' => $products, 'cart' => $cart]);
    }

   
}
