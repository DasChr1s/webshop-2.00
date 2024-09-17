import $ from 'jquery';

$(document).ready(function() {
    const $cartCountElement = $('#cart-count');

    // Function to update the cart count
    function updateCartCount() {
        $.getJSON("/cart/count", function(data) {
            $cartCountElement.text(data.count);
        });
    }

    // Event listener for deleting items from the cart
    $('.cart-page-item-delete-form').on('submit', function(event) {
        event.preventDefault(); // Prevent the default form submit

        const $form = $(this);
        const productId = $form.closest('.cart-page-item').data('product-id');

        $.ajax({
            url: $form.attr('action'),
            type: 'POST',
            data: $form.serialize(),
            success: function(response) {
                // Remove the product from the list
                $form.closest('.cart-page-item').remove();

                // Update the cart count
                updateCartCount();

                // Check if the cart is now empty and display message if needed
                if ($('.cart-page-item').length === 0) {
                    $('.cart-page-list').remove(); // Remove the product list
                    $('.cart-page-container').append('<p class="cart-page-empty">Ihr Warenkorb ist leer.</p>');
                }
            },
            error: function() {
                console.error('Fehler beim Löschen des Produkts.');
            }
        });
    });
});
