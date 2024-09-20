import $ from 'jquery';

$(document).ready(function() {
    // Funktion zum Berechnen des Gesamtwerts des Warenkorbs
    window.calculateCartTotal = function() {
        let total = 0;

        // Hole alle Warenkorb-Elemente
        $('.cart-page-item').each(function() {
            const price = parseFloat($(this).find('.cart-page-item-price').text().replace('€', '').trim());
            const quantity = parseInt($(this).find('.cart-page-item-quantity').text().replace('x', '').trim());

            if (!isNaN(price) && !isNaN(quantity)) {
                total += price * quantity;
            }
        });

        // Zeige den Gesamtwert an
        $('#cart-total').text(`Gesamtwert: €${total.toFixed(2)}`);
    }

    // Berechne den Gesamtwert beim Laden der Seite
    calculateCartTotal();
});
