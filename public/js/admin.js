jQuery(document).ready(function(a) {
    function b(a) {
        var b = a.html();
        b = b.replace("Affiliate Coupons - ", "<span class='affcoups-icon'></span>"), a.html(b);
    }
    a(".affcoups-input-colorpicker").wpColorPicker(), a(".widget-title h3:contains('Affiliate Coupons - ')").each(function() {
        b(a(this));
    }), jQuery(document).on("click", "#affcoups-delete-log-submit", function(a) {
        jQuery("#affcoups-delete-log").val("1");
    });
});