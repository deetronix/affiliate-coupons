jQuery(document).ready(function ($) {

    function replaceWidgetTitleIcon( el ) {
        var widgetTitle = el.html();

        widgetTitle = widgetTitle.replace("Affiliate Coupons - ", "<span class='affcoups-icon'></span>");

        el.html(widgetTitle);
    }
    
    /**
     * Controls
     */
    $(".affcoups-input-colorpicker").wpColorPicker();

    /**
     * Widgets
     */
    $(".widget-title h3:contains('Affiliate Coupons - ')").each(function() {
        replaceWidgetTitleIcon( $(this) );
    });

    /**
     * Settings: Delete Log
     */
    jQuery( document ).on( 'click', '#affcoups-delete-log-submit', function(event) {
        jQuery('#affcoups-delete-log').val('1');
    });

});