@extends('layouts.app')

@section('content')
    <div class="product-detail">
        <div class="product-image">
            <img src="{{ asset('product_image/' . $product->image_url) }}" alt="{{ $product->name }}">
        </div>
        <div class="product-info">
            <table class="product-table">
                <tbody>
                    <tr>
                        <td><strong>Name:</strong></td>
                        <td>{{ $product->name }}</td>
                    </tr>
                    <tr>
                        <td><strong>SKU:</strong></td>
                        <td>{{ $product->sku }}</td>
                    </tr>
                    <tr>
                        <td><strong>Description:</strong></td>
                        <td>{{ $product->description }}</td>
                    </tr>
                    <tr>
                        <td><strong>Price:</strong></td>
                        <td>
                            <div class="price-container">
                                <p class="price">€{{ number_format($product->price, 2) }}</p>
                                <span class="tax-info">inkl. {{ $product->tax_rate }}% UST</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="quantity-container">
                <button type="button" class="quantity-button minus">-</button>
                <input type="number" id="quantity" name="quantity" min="1" value="1">
                <button type="button" class="quantity-button plus">+</button>
            </div>
            <form action="{{ route('cart.add') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="quantity" id="quantity" value="1">
                <button type="submit" class="buy-now-button">Jetzt kaufen</button>
            </form>
        </div>
    </div>
@endsection


