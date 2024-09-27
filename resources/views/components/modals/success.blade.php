<!-- resources/views/modals/success.blade.php -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">Bestellung erfolgreich!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Hier wird die Erfolgsmeldung eingefügt -->
                <p id="successMessage"></p>
            </div>
            <div class="modal-footer">
                
                <a href="{{ route('cart.show') }}" class="btn btn-primary">Weiter zur Bestellübersicht</a>
            </div>
        </div>
    </div>
</div>
