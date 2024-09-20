<div class="row">
    @if ($products->isEmpty())
        <p>Keine Produkte gefunden.</p>
    @else
        @foreach ($products as $product)
            <x-product-card :product="$product" />
        @endforeach
    @endif
</div>
