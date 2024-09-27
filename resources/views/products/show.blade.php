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
                        <td><strong>Produktnummer:</strong></td>
                        <td>{{ $product->sku }}</td>
                    </tr>
                    <tr>
                        <td><strong>Beschreibung:</strong></td>
                        <td>{{ $product->description }}</td>
                    </tr>
                    <tr>
                        <td><strong>Preis:</strong></td>
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
                <input type="number" id="quantity" name="quantity" min="1" value="1" step="1">
                <button type="button" class="quantity-button plus">+</button>
            </div>
            
            <form action="{{ route('cart.add') }}" method="POST" id="add-to-cart-form" data-ajax="true">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <!-- Das versteckte quantity-Feld -->
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="buy-now-button">In den Warenkorb</button>
            </form>
            
            
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel">Fehler</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- dynamischer text wird hier erzeugt --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Schließen</button>
                </div>
            </div>
        </div>
    </div>
    


@endsection