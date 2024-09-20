@extends('layouts.app')

@section('content')
    <div class="cart-page-container">
        <h1 class="cart-page-title">Warenkorb</h1>
        @if ($products->isEmpty())
            <p class="cart-page-empty">Ihr Warenkorb ist leer.</p>
        @else
            <ul class="cart-page-list">
                @foreach ($products as $product)
                    <li class="cart-page-item" data-product-id="{{ $product->id }}">
                        <a href="{{ route('products.show', $product->id) }}" class="cart-page-item-link">
                            @if ($product->image_url)
                                <img src="{{ asset('product_image/' . $product->image_url) }}" class="cart-page-item-img"
                                    alt="{{ $product->name }}">
                            @else
                                <img src="{{ asset('product_image/placeholder.jpg') }}" class="cart-page-item-img" alt="">
                            @endif
                        </a>
                        <span class="cart-page-item-name">{{ $product->name }}</span>
                        <span class="cart-page-item-price">€{{ number_format($product->price, 2) }}</span>
                        <span class="cart-page-item-quantity">x {{ $cart[$product->id] }}</span>
                        <div class="cart-page-item-actions">
                            <form action="{{ route('cart.destroy', $product->id) }}" method="POST" class="cart-page-item-delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="cart-page-item-delete">Delete</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>

            <!-- Gesamtwert des Warenkorbs anzeigen -->
            <div class="cart-page-total" align="right">
                <h2 id="cart-total">Gesamtwert: €0.00</h2>
                <button class="order-button">Bestellen</button>
            </div>
            
        @endif
    </div>
@endsection
