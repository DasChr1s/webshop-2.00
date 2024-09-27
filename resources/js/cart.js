import $ from 'jquery';

$(document).ready(function () {
    const $cartCountElement = $('#cart-count');
    const $quantityInput = $('#quantity');
    const $errorModal = $('#errorModal');
    const $errorModalBody = $errorModal.find('.modal-body'); // Modal Body Element

    // Funktion, um die Anzahl im Warenkorb ohne CSS-Effekt zu aktualisieren
    function loadCartCount() {
        $.getJSON("/cart/count", function (data) {
            $cartCountElement.text(data.count); // Setzt nur die Zahl, ohne CSS-Effekt
        });
    }

    // Funktion, um die Anzahl im Warenkorb mit CSS-Effekt zu aktualisieren
    function updateCartCount() {
        $.getJSON("/cart/count", function (data) {
            $cartCountElement.text(data.count);
            // Hebt das Badge visuell hervor
            $cartCountElement.addClass('update');
            setTimeout(() => $cartCountElement.removeClass('update'), 500); // Entfernt die Klasse nach 500ms
        });
    }

    // Funktion zur Validierung der Menge
    function isValidQuantity(quantity) {
        const parsedQuantity = parseFloat(quantity);

        if (isNaN(parsedQuantity) || parsedQuantity <= 0) {
            $errorModalBody.text('Bitte geben Sie eine gültige Zahl ein.'); // Aktualisiert den Text im Modal
            return false; // Ungültige Menge
        }

        if (!Number.isInteger(parsedQuantity)) {
            $errorModalBody.text('Bitte geben Sie eine ganze Zahl ein.'); // Aktualisiert den Text im Modal
            return false; // Keine Ganzzahl
        }

        return true; // Menge ist gültig
    }

    // Event-Listener für die Aktualisieren-Schaltfläche
    $('.cart-page-item-update').on('click', function () {
        const $item = $(this).closest('.cart-page-item');
        const productId = $item.data('product-id');
        const quantity = $item.find('.cart-page-item-quantity-input').val();

        // Überprüfe die Menge
        if (!isValidQuantity(quantity)) {
            $errorModal.modal('show');
            return;
        }

        // Führe AJAX-Anfrage zur Aktualisierung der Menge durch
        $.ajax({
            url: `/cart/update/${productId}`,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            data: { quantity: quantity },
            success: function () {
                // Aktualisiere die Warenkorb-Anzahl
                updateCartCount();
                // Aktualisiere die Seite oder entferne das Element, wenn der Warenkorb leer ist
                if ($('.cart-page-item').length === 0) {
                    $('.cart-page-list').remove();
                    $('.cart-page-total').remove(); // Entfernt das Gesamtwert-Div
                }
            },
            error: function () {
                console.error('Fehler beim Aktualisieren der Menge.');
            }
        });
    });

    // Event-Listener für das Formular zum Löschen von Artikeln im Warenkorb
    $('.cart-page-item-delete-form').on('submit', function (event) {
        event.preventDefault(); // Verhindert das Standard-Formularverhalten

        const $form = $(this);
        $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: $form.serialize(),
            success: function () {
                // Entfernt das Produkt aus der Liste
                const $cartItem = $form.closest('.cart-page-item');
                $cartItem.remove();

                // Aktualisiert die Anzahl im Warenkorb
                updateCartCount();

                // Überprüft, ob der Warenkorb jetzt leer ist
                if ($('.cart-page-item').length === 0) {
                    // Entfernt die Produktliste und zeigt die Leer-Nachricht an
                    $('.cart-page-list').remove();
                    $('.cart-page-total').remove(); // Entfernt das Gesamtwert-Div
                }
            },
            error: function () {
                console.error('Fehler beim Löschen des Produkts.');
            }
        });
    });

    // Event-Listener für das Formular zum Hinzufügen von Artikeln zum Warenkorb
     // Füge einen Event-Listener für den Klick auf den Button mit der Klasse .buy-now-button hinzu
     $('.cart-button').on('click', function(event) {
        event.preventDefault(); // Verhindert das Standard-Submit-Verhalten

        const $form = $(this).closest('form'); // Holt das zugehörige Formular
        const isAjaxForm = $form.data('ajax'); // Prüft, ob es ein Ajax-Formular ist

        // Überprüft, ob das Formular tatsächlich als Ajax-Formular markiert ist
        if (isAjaxForm) {

            // Validierung der Menge (wenn notwendig)
            const $quantityInput = $form.find('input[name="quantity"]');
            if ($quantityInput.length && !isValidQuantity($quantityInput.val())) {
                $errorModal.modal('show'); // Zeigt das Fehlermodul an, wenn die Menge ungültig ist
                return; // Stoppt das Formular, wenn ungültig
            }

            // Sende die Daten per AJAX
            $.ajax({
                url: $form.attr('action'),
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                data: $form.serialize(),
                success: function(response) {
                    // Erfolg: Aktualisiert die Anzahl im Warenkorb oder zeigt eine Erfolgsmeldung
                    updateCartCount();
                },
                error: function() {
                    console.error('Fehler beim Hinzufügen zum Warenkorb.');
                }
            });
        }
    });

    // Lädt die Anzahl im Warenkorb bei jedem Seitenaufruf oder beim Dokumentenladen ohne Effekt
    loadCartCount();
});
