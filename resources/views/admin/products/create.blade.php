@extends('layouts.admin-layout')

@section('title', 'Create Product')

@section('admin-content')
<main class="product-form main-content">
    <h1>Produkt erstellen</h1>

    <form id="productForm" action="" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-3">
            <label for="sku" class="form-label">SKU <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="sku" id="sku" required>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="name" id="name" required>
        </div>

        <div class="mb-3">
            <label for="price" class="form-label">Netto Preis <span class="text-danger">*</span></label>
            <input type="number" class="form-control" name="price" id="price" required step="0.001" min="0">
            <div id="priceError" class="text-danger" style="display: none;"></div>
        </div>

        <div class="mb-3">
            <label for="tax" class="form-label">Steuer <span class="text-danger">*</span></label>
            <input type="number" class="form-control" name="tax" id="tax" required step="0.01" min="0">
            <div id="taxError" class="text-danger" style="display: none;"></div>
        </div>

        <div class="mb-3">
            <label for="image_url" class="form-label">Bild <span class="text-muted" data-toggle="tooltip" title="Only JPG or PNG formats are allowed."><i class="bi bi-question-circle"></i></span><span class="text-danger">*</span></label>
            <input type="file" class="form-control" name="image_url" id="image_url" accept=".jpg,.jpeg,.png" required>
            <div id="imageError" class="text-danger" style="display: none;"></div>
            
            <!-- Vorschau-Bereich für das Bild -->
            <div class="image-preview mt-2" style="display: none;">
                <img id="imagePreview" src="#" alt="Image Preview" class="img-fluid" style="max-height: 200px; object-fit: cover;"/>
                <button type="button" id="removeImage" class="btn btn-danger mt-2">Bild entfernen</button>
            </div>
        </div>
        
        <button type="submit" id="submitButton" class="btn btn-primary" disabled>Erstellen</button>

        @if ($errors->any())
            <div class="error-messages">
                <div>
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
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

        // Bildvorschau anzeigen
        fileInput.on('change', function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.attr('src', e.target.result);
                    imagePreviewContainer.show(); // Vorschau anzeigen
                };
                reader.readAsDataURL(file);
            }
            validateImage(file);
        });

        // Bild entfernen
        removeImageButton.on('click', function() {
            fileInput.val(''); // Input zurücksetzen
            imagePreview.attr('src', '#'); // Vorschau zurücksetzen
            imagePreviewContainer.hide(); // Vorschau ausblenden
            $('#imageError').hide();
            enableSubmitButton(); // Submit-Button aktivieren
        });

        // Preisvalidierung
        $('#price').on('input', function() {
            const value = $(this).val();
            const regex = /^(?!0\d)\d+(\.\d{0,3})?$/; // Maximal 3 Nachkommastellen, keine führenden Nullen
            
            // Überprüfen, ob der Wert nur aus Zahlen und gültigen Zeichen besteht
            if (!regex.test(value)) {
                $('#priceError').text('Der Preis darf maximal drei Nachkommastellen haben und keine Buchstaben oder unzulässigen Zeichen enthalten.').show();
            } else {
                $('#priceError').hide();
            }
            enableSubmitButton(); // Überprüfen, ob der Button aktiviert werden kann
        });

        // Steuervalidierung
        $('#tax').on('input', function() {
            const value = $(this).val();
            const regex = /^(?!0\d)\d+(\.\d{0,2})?$/; // Maximal 2 Nachkommastellen, keine führenden Nullen
            
            // Überprüfen, ob der Wert nur aus Zahlen und gültigen Zeichen besteht
            if (!regex.test(value)) {
                $('#taxError').text('Die Steuer darf maximal zwei Nachkommastellen haben und keine Buchstaben oder unzulässigen Zeichen enthalten.').show();
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
                !priceValue || !taxValue || !imageValue) {
                submitButton.prop('disabled', true);
            } else {
                submitButton.prop('disabled', false);
            }
        }
    });
</script>
@endsection
