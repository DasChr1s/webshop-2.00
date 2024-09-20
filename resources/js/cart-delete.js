import $ from 'jquery';
import './cart-calculations'; // Importiere die Berechnungsdatei

$(document).ready(function() {
    const $cartCountElement = $('#cart-count');

    // Funktion zur Aktualisierung der Warenkorbanzahl
    function updateCartCount() {
        $.getJSON("/cart/count", function(data) {
            $cartCountElement.text(data.count);
        });
    }

    // Event-Listener zum Löschen von Artikeln aus dem Warenkorb
    $('.cart-page-item-delete-form').on('submit', function(event) {
        event.preventDefault(); // Verhindert das Standardverhalten des Formulars

        const $form = $(this);
        const productId = $form.closest('.cart-page-item').data('product-id');

        $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: $form.serialize(),
            success: function(response) {
                // Entferne das Produkt aus der Liste
                $form.closest('.cart-page-item').remove();

                // Aktualisiere die Warenkorbanzahl
                updateCartCount();

                // Berechne den Gesamtwert neu
                window.calculateCartTotal();

                // Überprüfe, ob der Warenkorb jetzt leer ist und zeige ggf. eine Nachricht an
                if ($('.cart-page-item').length === 0) {
                    $('.cart-page-list').remove(); // Entferne die Produktliste
                    $('.cart-page-container').append('<p class="cart-page-empty">Ihr Warenkorb ist leer.</p>');
                }
            },
            error: function() {
                console.error('Fehler beim Löschen des Produkts.');
            }
        });
    });
});
