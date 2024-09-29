@props(['product'])
{{-- <form action="{{ route('cart.clear') }}" method="POST" style="display: inline;">
    @csrf
    <button type="submit" class="btn btn-danger">Warenkorb leeren</button>
</form> --}}
<div class="col-md-4 mb-4">
    <a href="{{ route('products.show', $product->id) }}" class="text-decoration-none">
        <div class="card">
            @if($product->image_url)
                <img src="{{ asset('product_image/' . $product->image_url) }}" class="card-img-top" alt="{{ $product->name }}">
            @else
                <img src="{{ asset('product_image/placeholder.jpg') }}" class="card-img-top" alt="">
            @endif
            <div class="card-body">
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class=" card-text truncate">{{ $product->description }}</p>
                <p class="card-text"><strong>Preis:</strong> €{{ number_format($product->price + ($product->price * ($product->tax_rate / 100)), 2) }}</p>
                
                <a href="{{ route('products.show', $product->id) }}" class="view-product-button">Produkt anzeigen</a>

                <form action="{{ route('cart.add') }}" method="POST" style="display: inline;" data-ajax="true">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="buy-now-button cart-button">In den Warenkorb</button>
                </form>
            </div>
        </div>
    </a>
</div>




<script>
  

</script>
