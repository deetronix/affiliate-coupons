jQuery(document).ready(function(a) {
    a(".affcoups-input-colorpicker").wpColorPicker(), a(document).on("click", "#affcoups-delete-log-submit", function(b) {
        a("#affcoups-delete-log").val("1");
    });
});