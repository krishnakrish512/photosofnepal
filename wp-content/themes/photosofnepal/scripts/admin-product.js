(function ($) {
    $(document).ready(function () {

        if ($("h1.wp-heading-inline").length) {
            $("h1.wp-heading-inline").html("Photographs");
        }

        if ($("#postimagediv h2").length) {
            $("#postimagediv h2").html("Photograph");
        }

        if ($("#product_catdiv").length) {
            $("#product_catdiv h2").html("Phorograph Categories");
        }

        if ($("#tagsdiv-product_tag").length) {
            $("#tagsdiv-product_tag h2").html("Phorograph Tags");
        }

        if ($("#wp-content-editor-container").length) {
            $("<h2>Photograph Description</h2>").insertBefore("#wp-content-editor-container");
        }

        if ($("#set-post-thumbnail").length && $('#_thumbnail_id').val() === "-1") {
            $("#set-post-thumbnail").html("Upload Photo")
        }

        wp.media.featuredImage.frame().on('open', function () {
            $(".media-router #menu-item-upload").trigger('click');
        });


        wp.media.frame.on('library:selection:add', function () {
            $(".media-router #menu-item-upload").trigger('click');
        });

        //automatically select image after upload complete
        typeof wp.Uploader !== 'undefined' && wp.Uploader.queue.on('reset', function () {
            // From the primary toolbar (".media-toolbar-primary")
            // get the insert button view (".media-button-select")
            // and execute its click (as specified in its options).
            wp.media.frame.toolbar.get('primary').get('select').options.click();
        });
    });
})(jQuery);