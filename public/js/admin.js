jQuery(document).ready(function(a) {
    a(".affcoups-input-colorpicker").wpColorPicker(), a("[data-affcoups-settings-nav]").on("click", function(b) {
        b.preventDefault();
        var c = a(".affcoups-settings-nav-item"), d = a(this).parent("li"), e = a(this).data("affcoups-settings-nav");
        if (e) {
            var f = a('[data-affcoups-settings-content="' + e + '"]');
            if (f) {
                var g = a(".affcoups-settings-content");
                if (g) {
                    c.removeClass("active"), g.removeClass("active"), d.addClass("active"), f.addClass("active");
                    var h = a("#affcoups_settings_active_tab");
                    if (h && h.val(e), "undefined" != typeof history.pushState) {
                        var i = window.location.href, j = new URL(i);
                        j.searchParams.set("tab", e), history.pushState({}, null, j);
                    }
                }
            }
        }
    }), a(document).on("click", "#affcoups-delete-log-submit", function(b) {
        a("#affcoups-delete-log").val("1");
    });
});