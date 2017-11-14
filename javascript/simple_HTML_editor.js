// Remove this when/if bootstrap forms updates
(function($) {
    $(function() {
        var wsiwgs = $("textarea.wysiwyg");
        if(wsiwgs.length) {
            wsiwgs.each(function() {
                var wsiwg = $(this);
                wsiwg.tinymce({
                    theme: "modern",
                    theme_advanced_toolbar_location: "top",
                    theme_advanced_buttons1: wsiwg.attr("data-buttons"),
                    theme_advanced_buttons2: "",
                    theme_advanced_buttons3: "",
                    theme_advanced_blockformats: wsiwg.attr("data-blockformats"),
                    content_css: (wsiwg.attr("data-css") ? ($("base")).attr("href") + wsiwg.attr("data-css") : null)
                });
            });
        }
    });
})(jQuery);
