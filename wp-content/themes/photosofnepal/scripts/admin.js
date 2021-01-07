$ = jQuery;

$(document).ready(function () {
    $("h1.wp-heading-inline").html("Photographs");

    $("a.page-title-action").attr("href", localized_var.add_photograph_url);

    $("tr.type-product a[href*='/wp-admin/post.php?post=']").each(function () {
        const productId = $(this).closest('tr').attr('id').split('-')[1];

        this.href = localized_var.edit_photograph_url + "?product_id=" + productId;
    })

});
