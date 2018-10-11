jQuery(document).ready(function ($) {

    /**
     * Controls
     */
    $(".affcoups-input-colorpicker").wpColorPicker();

    /**
     * Settings: Delete Log
     */
    $( document ).on( 'click', '#affcoups-delete-log-submit', function(event) {
        $('#affcoups-delete-log').val('1');
    });

});