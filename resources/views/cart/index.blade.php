@extends('layouts.app')

@section('content')
    <div class="cart-page-container">
        <h1 class="cart-page-title">Warenkorb</h1>
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div> 
        @endif
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
                        <span class="cart-page-item-price">€{{ number_format($product->price + ($product->price * ($product->tax_rate / 100)), 2) }}</span>
                        <span class="cart-page-item-quantity">x {{ $cart[$product->id] }}</span>
                        <span class="cart-page-item-tax">inkl. {{ $product->tax_rate }}% UST</span>
                        <div class="cart-page-item-actions">
                            <form action="{{ route('cart.destroy', $product->id) }}" method="POST" class="cart-page-item-delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="cart-page-item-delete">Entfernen</button>
                            </form>
                        </div>
                    </li>
                @endforeach
            </ul>

            <!-- Gesamtwert des Warenkorbs anzeigen -->
            <div class="cart-page-total" align="right">
                <span>(inkl. Mwst.)</span>
                <h2 id="cart-total">Gesamtwert: €0.00 </h2> 
                <a href="{{ route('order.show') }}" class="order-button">Bestellen</a>
            </div>
           
        @endif
    </div>
@endsection
