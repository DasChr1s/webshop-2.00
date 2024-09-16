import $ from 'jquery';

$(document).ready(function() {

    $('.quantity-button.plus').click(function() {
        let currentValue = parseInt($('#quantity').val(), 10);
        $('#quantity').val(currentValue + 1);
    });

    $('.quantity-button.minus').click(function() {
        let currentValue = parseInt($('#quantity').val(), 10);
        if (currentValue > 1) {
            $('#quantity').val(currentValue - 1);
        }
    });
});