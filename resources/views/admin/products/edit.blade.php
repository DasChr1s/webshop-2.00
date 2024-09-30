@extends('layouts.admin-layout')

@section('title', 'Edit Product')

@section('admin-content')
    <main class="product-form main-content">
        <h1>Produkt bearbeiten</h1>

        <form id="productForm" action="{{ route('admin.products.update', $product->id) }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="sku" class="form-label">SKU <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('sku') is-invalid @enderror" name="sku" id="sku"
                    value="{{ old('sku', $product->sku) }}" required>
                @error('sku')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="name"
                    value="{{ old('name', $product->name) }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Beschreibung <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('description') is-invalid @enderror" name="description" id="description"
                    value="{{ old('description', $product->description) }}" required>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="price" class="form-label">Netto Preis <span class="text-danger">*</span></label>
                <input type="number" class="form-control @error('price') is-invalid @enderror" name="price"
                    id="price" value="{{ old('price', $product->price) }}" required step="0.001" min="0">
                <div id="priceError" class="text-danger" style="display: none;"></div>
                @error('price')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tax" class="form-label">Steuer <span class="text-danger">*</span></label>
                <input type="number" class="form-control @error('tax') is-invalid @enderror" name="tax" id="tax"
                    value="{{ old('tax', $product->tax_rate) }}" required step="0.01" min="0">
                <div id="taxError" class="text-danger" style="display: none;"></div>
                @error('tax')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="image_url" class="form-label">Bild <span class="text-muted" data-toggle="tooltip"
                        title="Only JPG or PNG formats are allowed."><i class="bi bi-question-circle"></i></span><span
                        class="text-danger">*</span></label>

                <!-- Vorschau-Bereich für das Bild -->
                <div class="image-preview mt-2" style="display: {{ $product->image_url ? 'block' : 'none' }};">
                    <img id="imagePreview" src="{{ asset('product_image/' . $product->image_url) }}" alt="Image Preview"
                        class="img-fluid" style="max-height: 200px; object-fit: cover;" />
                    <button type="button" id="removeImage" class="btn btn-danger mt-2">Bild entfernen</button>
                </div>

                <input type="file" class="form-control @error('image_url') is-invalid @enderror" name="image_url"
                    id="image_url" accept=".jpg,.jpeg,.png" style="display: {{ $product->image_url ? 'none' : 'block' }};">
                <div id="imageError" class="text-danger" style="display: none;"></div>
                @error('image_url')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" id="submitButton" class="btn btn-primary">Aktualisieren</button>

            @if ($errors->any())
                <div class="alert alert-danger mt-3">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </form>
    </main>

    <script>
        $(document).ready(function() {
            const fileInput = $('#image_url');
            const imagePreview = $('#imagePreview');
            const imagePreviewContainer = $('.image-preview');
            const removeImageButton = $('#removeImage');
            const submitButton = $('#submitButton');

            // Tooltips aktivieren
            $('[data-toggle="tooltip"]').tooltip();

            // Wenn bereits ein Bild vorhanden ist, zeigen wir das Bild und verstecken das Input-Feld
            if (imagePreview.attr('src')) {
                imagePreviewContainer.show(); // Bildvorschau anzeigen
                fileInput.hide(); // Upload-Feld ausblenden
                submitButton.prop('disabled', false); // Submit-Button aktivieren
            } else {
                fileInput.show(); // Upload-Feld anzeigen
                submitButton.prop('disabled', true); // Submit-Button deaktivieren
            }

            // Bildvorschau anzeigen, wenn eine Datei hochgeladen wird
            fileInput.on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.attr('src', e.target.result); // Vorschau für das hochgeladene Bild
                        imagePreviewContainer.show(); // Vorschau anzeigen
                        fileInput.hide(); // Upload-Feld ausblenden
                        submitButton.prop('disabled', false); // Submit-Button aktivieren
                    };
                    reader.readAsDataURL(file);
                }
                validateImage(file);
            });

            // Bild entfernen
            removeImageButton.on('click', function() {
                // Input zurücksetzen
                fileInput.val(''); // Reset des file inputs
                imagePreview.attr('src', ''); // Vorschau zurücksetzen
                imagePreviewContainer.hide(); // Vorschau ausblenden

                // Das Input-Feld zum Hochladen anzeigen
                fileInput.show();
                submitButton.prop('disabled', true); // Submit-Button deaktivieren
            });

            // Preisvalidierung
            $('#price').on('input', function() {
                const value = $(this).val();
                const regex =
                /^(?!0\d)\d+(\.\d{0,3})?$/; // Maximal 3 Nachkommastellen, keine führenden Nullen

                if (!regex.test(value)) {
                    $('#priceError').text(
                        'Der Preis darf maximal drei Nachkommastellen haben und keine Buchstaben oder unzulässigen Zeichen enthalten.'
                        ).show();
                } else {
                    $('#priceError').hide();
                }
                enableSubmitButton(); // Überprüfen, ob der Button aktiviert werden kann
            });

            // Steuervalidierung
            $('#tax').on('input', function() {
                const value = $(this).val();
                const regex =
                /^(?!0\d)\d+(\.\d{0,2})?$/; // Maximal 2 Nachkommastellen, keine führenden Nullen

                if (!regex.test(value)) {
                    $('#taxError').text(
                        'Die Steuer darf maximal zwei Nachkommastellen haben und keine Buchstaben oder unzulässigen Zeichen enthalten.'
                        ).show();
                } else {
                    $('#taxError').hide();
                }
                enableSubmitButton(); // Überprüfen, ob der Button aktiviert werden kann
            });

            // Bildvalidierung
            function validateImage(file) {
                const allowedExtensions = /(\.jpg|\.jpeg|\.png)$/i;
                if (file && !allowedExtensions.exec(file.name)) {
                    $('#imageError').text('Bitte laden Sie ein Bild im JPG oder PNG Format hoch.').show();
                    submitButton.prop('disabled', true); // Submit-Button deaktivieren
                } else {
                    $('#imageError').hide();
                }
                enableSubmitButton(); // Überprüfen, ob der Button aktiviert werden kann
            }

            // Überprüfen, ob der Submit-Button aktiviert werden kann
            function enableSubmitButton() {
                const priceErrorVisible = $('#priceError').is(':visible');
                const taxErrorVisible = $('#taxError').is(':visible');
                const imageErrorVisible = $('#imageError').is(':visible');
                const priceValue = $('#price').val();
                const taxValue = $('#tax').val();
                const imageValue = fileInput.val();

                // Wenn Fehler sichtbar sind oder Werte nicht gültig sind, Button deaktivieren
                if (priceErrorVisible || taxErrorVisible || imageErrorVisible ||
                    !priceValue || !taxValue || (!imageValue && !imagePreview.attr('src'))) {
                    submitButton.prop('disabled', true);
                } else {
                    submitButton.prop('disabled', false);
                }
            }
        });
    </script>
@endsection
