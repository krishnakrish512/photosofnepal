(function ($) {
    $(document).ready(function () {

        // $("a.page-title-action").attr("href", localized_var.add_photograph_url);
        //
        // $("tr.type-product a[href*='/wp-admin/post.php?post=']").each(function () {
        //     const productId = $(this).closest('tr').attr('id').split('-')[1];
        //
        //     this.href = localized_var.edit_photograph_url + "?product_id=" + productId;
        // })

        const urlParams = new URLSearchParams(window.location.search);
        const postType = urlParams.get('post_type');

        // if (postType === "product") {
        //
        //
        //     wp.media.featuredImage.frame().on('open', function () {
        //         $(".media-router #menu-item-upload").trigger('click');
        //     });
        //
        //     // wp.media.frame.on('all', function (e) {
        //     //     console.log(e);
        //     // });
        //
        //     wp.media.frame.on('library:selection:add', function () {
        //         $(".media-router #menu-item-upload").trigger('click');
        //     });
        //
        //     //automatically select image after upload complete
        //     typeof wp.Uploader !== 'undefined' && wp.Uploader.queue.on('reset', function () {
        //         // From the primary toolbar (".media-toolbar-primary")
        //         // get the insert button view (".media-button-select")
        //         // and execute its click (as specified in its options).
        //         wp.media.frame.toolbar.get('primary').get('select').options.click();
        //     });
        // }

        // if (postType === "gallery") {
        //     wp.media.view.Modal.prototype.on('open', function () {
        //         $(".media-router #menu-item-upload").trigger('click');
        //     });
        // }

        $('h2:contains("About Yourself"):first').css('display', 'none');
        $('h2:contains("About Yourself"):first + table').css('display', 'none');

        $('h2:contains("Personal Options")').css('display', 'none');
        $('h2:contains("Personal Options") + table').css('display', 'none');
    });
})(jQuery);