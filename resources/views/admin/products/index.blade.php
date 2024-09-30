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
                @foreach ($products as $product)
                    <tr>
                        <td>
                            <img src="{{ asset('product_image/' . $product->image_url) }}" alt="{{ $product->name }}"
                                style="width: 50px; height: 50px; object-fit: cover;">
                        </td>
                        <td>{{ $product->sku }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->price }} €</td>
                        <td>{{ number_format($product->price + $product->price * ($product->tax_rate / 100), 2) }} €</td>
                        <td>{{ $product->tax_rate }} %</td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-sm me-2" title="Edit">
                                    <i class="bi bi-pencil"></i> Bearbeiten
                                </a>
                                <button type="button" class="btn btn-danger btn-sm" title="Delete"
                                    onclick="showErrorModal('{{ $product->id }}', '{{ $product->name }}');">
                                    <i class="bi bi-trash3"></i> Löschen
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @component('components.modals.error', ['message' => 'Wollen Sie den Artikel wirklich löschen?'])
    @endcomponent
    <script>
        function showErrorModal(productId, productName) {
            const modal = new bootstrap.Modal(document.getElementById('errorModal'));
            const deleteButton = document.getElementById('confirmDelete');
            const deleteForm = document.getElementById('deleteForm');

            // Setze die Action-URL des Formulars auf die Produkt-ID
            deleteForm.action = `/admin/products/${productId}`;

            // Zeige das Modal an
            modal.show();
        }
    </script>
@endsection
