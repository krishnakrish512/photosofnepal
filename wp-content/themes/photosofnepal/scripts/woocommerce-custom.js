$(document).ready(function () {
    // console.log($('.product-variation .size-table__item'));
    // $('.product-variation .size-table__item').removeClass('is-active');

    if ($(".woocommerce-MyAccount-navigation").length) {
        $(".woocommerce").addClass("dashboard");
    }

    $('[data-toggle="tooltip"]').tooltip();


    $(document).on('change', '.variation-radios input', function () {
        $('select[name="' + $(this).attr('name') + '"]').val($(this).val()).trigger('change');
    });
    $(document).on('woocommerce_update_variation_values', function () {
        $('.variation-radios input').each(function (index, element) {
            $(element).removeAttr('disabled');
            var thisName = $(element).attr('name');
            var thisVal = $(element).attr('value');
            if ($('select[name="' + thisName + '"] option[value="' + thisVal + '"]').is(':disabled')) {
                $(element).prop('disabled', true);
            }
        });
    });


    //set first variation as default radio button and trigger select change on product single page
    if ($('.variation-radios input:first')) {
        const firstChild = $('.variation-radios input:first');
        firstChild.attr('checked', 'checked');
        $('select[name="' + firstChild.attr('name') + '"]').val(firstChild.val()).trigger('change');
    }

    $('.product-variation .size-table__item').click(function (e) {
        $('.product-variation .size-table__item').removeClass('is-active');
        $(this).addClass('is-active');
    });

    $('.photograph-add-to-cart').click(function (e) {
        e.preventDefault();
        console.log('add-to-cart clicked');
    });

});