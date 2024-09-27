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
use App\Models\GuestOrderItem;
use Illuminate\Support\Facades\Validator;

class GuestOrderController extends Controller
{
    public function store(Request $request)
    {
        // Retrieve cart from session
        $cart = Session::get('cart', []);

        // Validate request data (excluding cart)
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'street' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:255',
        ]);

        // Validate cart
        if (empty($cart)) {
            \Log::error('Cart is empty');
            return response()->json(['error' => 'Cart is empty'], 400);
        }

        // Calculate total price
        $totalPrice = 0;
        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if (!$product) {
                \Log::error('Invalid product ID in cart: ' . $productId);
                return response()->json(['error' => 'Invalid product ID in cart'], 400);
            }
            $totalPrice += $product->price * $quantity;
        }

        DB::beginTransaction();

        // Create a new guest order
        $guestOrder = GuestOrder::create([
            'name' => $validated['name'],
            'guest_email' => $validated['email'],
            'billing_address' => $validated['street'],
            'billing_city' => $validated['city'],
            'billing_postal_code' => $validated['postal_code'],
            'status' => 'pending',
        ]);

        // Add the order items
        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);

            GuestOrderItem::create([
                'guest_order_id' => $guestOrder->id,
                'product_id' => $productId,
                'quantity' => $quantity,
                'price' => $product->price,
            ]);
        }

        // Clear the cart in the session
        Session::forget('cart');
       

        DB::commit();

        // Send an email with the order details
        Mail::to($validated['email'])->queue(new OrderShipped($guestOrder));

        // Redirect to the cart page
        return redirect()->route('cart.show')->with('status', 'Order has been sent successfully')->send();


    }

    public function showOrderForm()
    {
        // Retrieve cart from session
        $cart = Session::get('cart', []);

        // If the cart is empty, return to the cart page
        if (empty($cart)) {
            return redirect()->route('cart.show')->with('status', 'Ihr Warenkorb ist leer.');
        }

        // Load products based on the IDs in the cart
        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)->get();

        return view('cart.order-data', ['products' => $products, 'cart' => $cart]);
    }
}