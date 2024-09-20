import $ from 'jquery';

$(document).ready(function () {
    $('#product-search').on('input', function () {
        let searchValue = $(this).val();

        $.ajax({
            url: '/search',  // Die Route zur Suchanfrage
            method: 'GET',
            data: { search: searchValue },
            success: function (response) {
                // Setze den Inhalt des #product-list Containers
                $('#product-list').html(response);
            },
            error: function (xhr) {
                console.log('Fehler bei der AJAX-Anfrage:', xhr);
            }
        });
    });
});
