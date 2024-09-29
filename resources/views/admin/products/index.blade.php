@extends('layouts.admin-layout')

@section('admin-content')
    <h1>Produkte</h1>
    <div class="mb-3">
        <a href="{{ route('admin.products.create') }}" class="btn add-btn" title="add">
            <i class="bi bi-plus-circle"></i> Produkt hinzufügen
        </a>
    </div>
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Bild</th>
                    <th>SKU</th>
                    <th>Name</th>
                    <th>Netto Preis</th>
                    <th>Brutto Preis</th>
                    <th>Steuer</th>
                    <th>Aktion</th>
                </tr>
            </thead>
            <tbody>
                @foreach($products as $product)
                    <tr>
                        <td>
                            <img src="{{ asset('product_image/' . $product->image_url) }}" alt="{{ $product->name }}" style="width: 50px; height: 50px; object-fit: cover;">
                        </td>
                        <td>{{ $product->sku }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price }} €</td>
                        <td>{{ number_format($product->price + ($product->price * ($product->tax_rate / 100)), 2) }} €</td>
                        <td>{{ $product->tax_rate }} %</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="#" class="btn btn-warning btn-sm me-2" title="Edit">
                                    <i class="bi bi-pencil"></i> Bearbeiten
                                </a>
                                <a href="#" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Are you sure you want to delete this item?');">
                                    <i class="bi bi-trash3"></i> Löschen
                                </a>
                            </div>
                            
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="{{ asset('js/calcPrice.js') }}"></script>
@endsection
