import $ from 'jquery';

$(document).ready(function() {

    function updateHiddenQuantity() {
        // Synchronisiere den Wert des sichtbaren Eingabefeldes mit dem versteckten Feld
        const currentValue = $('#quantity').val();
        $('input[name="quantity"]').val(currentValue);
    }

    $('.quantity-button.plus').click(function() {
        let currentValue = parseInt($('#quantity').val(), 10);
        $('#quantity').val(currentValue + 1);
        updateHiddenQuantity(); // Aktualisiere das versteckte Feld
    });

    $('.quantity-button.minus').click(function() {
        let currentValue = parseInt($('#quantity').val(), 10);
        if (currentValue > 1) {
            $('#quantity').val(currentValue - 1);
            updateHiddenQuantity(); // Aktualisiere das versteckte Feld
        }
    });

    // Initiale Synchronisierung, falls der Benutzer das Eingabefeld manuell ändert
    $('#quantity').on('change', function() {
        updateHiddenQuantity();
    });
});
