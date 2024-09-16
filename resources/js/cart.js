$(document).ready(function() {
    const $cartCountElement = $('#cart-count');

    // Funktion zur Aktualisierung des Warenkorb-Zählers ohne CSS-Effekt
    function loadCartCount() {
        $.getJSON("/cart/count", function(data) {
            $cartCountElement.text(data.count); // Setzt nur die Zahl, kein CSS-Effekt
        });
    }

    // Funktion zur Aktualisierung des Warenkorb-Zählers mit CSS-Effekt
    function updateCartCount() {
        $.getJSON("/cart/count", function(data) {
            $cartCountElement.text(data.count);
            // Badge visuell hervorheben
            $cartCountElement.addClass('update');
            setTimeout(() => $cartCountElement.removeClass('update'), 500); // Entfernt die Klasse nach 500ms
        });
    }

    // Event-Listener für das Formular zum Hinzufügen von Artikeln zum Warenkorb
    $('form[method="POST"]').each(function() {
        const $form = $(this);
        // Sicherstellen, dass der Event-Listener nicht mehrfach hinzugefügt wird
        if (!$form.data('eventListenerAdded')) {
            $form.on('submit', function(event) {
                event.preventDefault(); // Verhindert das Standard-Submit-Verhalten

                $.ajax({
                    url: $form.attr('action'),
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    data: $form.serialize(),
                    success: function() {
                        // Nur wenn der Artikel erfolgreich hinzugefügt wurde, das Badge aktualisieren
                        updateCartCount();
                    },
                    error: function() {
                        console.error('Fehler beim Hinzufügen zum Warenkorb.');
                    }
                });
            });
            $form.data('eventListenerAdded', true); // Markiert das Formular als bearbeitet
        }
    });

    // Bei jedem Seitenaufruf oder nach dem Laden des Dokuments ohne Effekt
    loadCartCount();
});
