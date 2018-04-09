jQuery(document).ready(function ($) {

    /**
     * Copy to clipboard
     */
    var clipboard = new Clipboard(".affcoups-clipboard");

    clipboard.on("success", function(e) {

        /*
        console.info('Action:', e.action);
        console.info('Text:', e.text);
        console.info('Trigger:', e.trigger);

        //console.log(e);
         */

        e.clearSelection();
    });

    $(document).on( "click", ".affcoups-clipboard", function(event) {

        var clicked = $(this);
        var current = $(this).html();

        var confirmationLabel = $(this).data("affcoups-clipboard-confirmation-text");

        clicked.html(confirmationLabel);

        setTimeout(function() {
            clicked.html(current);
        }, 2500);

    });

    /**
     * Toggle excerpt/description
     */
    $(document).on( "click", "[data-affcoups-toggle-desc]", function(e) {
        e.preventDefault();

        var descriptionContainer = $(this).parents(".affcoups-coupon__description");

        descriptionContainer.toggleClass("affcoups-coupon__description--full");
    });

});

