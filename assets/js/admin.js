jQuery(document).ready(function ($) {

    /**
     * Controls
     */
    $('.affcoups-input-colorpicker').wpColorPicker();

    /**
     * Widgets
     */
    $(".widget-title h3:contains('Affiliate Coupons - ')").each(function() {
        replace_widget_title_icon( $(this) );
    });

    function replace_widget_title_icon( el ) {
        var widget_title = el.html();

        widget_title = widget_title.replace('Affiliate Coupons - ', '<span class="affcoups-icon"></span>');

        el.html(widget_title);
    }

});