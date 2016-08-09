jQuery(document).ready(function ($) {

    var clipboard = new Clipboard('.affcoups-clipboard');

    clipboard.on('success', function(e) {

        /*
        console.info('Action:', e.action);
        console.info('Text:', e.text);
        console.info('Trigger:', e.trigger);

        //console.log(e);
         */

        e.clearSelection();
    });

});

jQuery( document ).on( 'click', '.affcoups-clipboard', function(event) {

    var clicked = jQuery(this);
    var current = jQuery(this).html();

    var confirmationLabel = jQuery(this).data('affcoups-clipboard-confirmation-text');

    clicked.html(confirmationLabel);

    setTimeout(function() {
        clicked.html(current);
    }, 2500);

});