import $ from 'jquery';

$(document).ready(function() {
    function calculateGrossPrice(netPrice, taxRate) {
        return netPrice * (1 + taxRate / 100);
    }

    // Get the net price and tax rate from the HTML
    var netPrice = parseFloat($('.price').text().replace('€', '').replace(',', '.'));
    var taxRate = parseFloat($('.tax-info').text().replace('inkl. ', '').replace('% UST', ''));

    // Calculate the gross price
    var grossPrice = calculateGrossPrice(netPrice, taxRate);

    // Display the gross price
    $('.price').text('€' + grossPrice.toFixed(2).replace('.', ','));
   
});