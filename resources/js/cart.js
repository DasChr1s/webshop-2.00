$(document).ready(function() {
    const $cartCountElement = $('#cart-count');
    const $quantityInput = $('#quantity');
    const $errorModal = $('#errorModal');

    // Function to update the cart count without CSS effect
    function loadCartCount() {
        $.getJSON("/cart/count", function(data) {
            $cartCountElement.text(data.count); // Set only the number, no CSS effect
        });
    }

    // Function to update the cart count with CSS effect
    function updateCartCount() {
        $.getJSON("/cart/count", function(data) {
            $cartCountElement.text(data.count);
            // Highlight the badge visually
            $cartCountElement.addClass('update');
            setTimeout(() => $cartCountElement.removeClass('update'), 500); // Remove the class after 500ms
        });
    }

    // Validate the quantity before submitting the form
    function isValidQuantity() {
        const quantity = parseInt($quantityInput.val(), 10);
        return !isNaN(quantity) && quantity > 0;
    }

    // Event listener for the form to add items to the cart
    $('form[method="POST"]').each(function() {
        const $form = $(this);
        // Ensure the event listener is not added multiple times
        if (!$form.data('eventListenerAdded')) {
            $form.on('submit', function(event) {
                event.preventDefault(); // Prevent the default submit behavior

                // Check if the quantity is valid (applies to detail page)
                if ($quantityInput.length && !isValidQuantity()) {
                    $errorModal.modal('show'); // Show error modal if the quantity is invalid
                    return; // Stop form submission if invalid
                }

                // Proceed with AJAX if the quantity is valid
                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    data: $form.serialize(),
                    success: function() {
                        // Update the cart count
                        updateCartCount();
                    },
                    error: function() {
                        console.error('Error adding to cart.');
                    }
                });
            });
            $form.data('eventListenerAdded', true); // Mark the form as processed
        }
    });

    // Load the cart count on every page load or document ready without effect
    loadCartCount();
});
