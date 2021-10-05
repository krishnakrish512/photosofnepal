function masnoryGrid() {
    $('.masnory-grid').isotope({
        itemSelector: '.masnory-grid__item',
        percentPosition: true,
        masonry: {
            columnWidth: '.masnory-grid__item',
        }
    });
}

function searchSticky() {
    var scroll = $(window).scrollTop();
    var bannerHeight = $(window).height();

    if (scroll >= bannerHeight) {
        $('.search-hero__content').addClass('sticky');
    } else {
        $('.search-hero__content').removeClass('sticky');
    }
}

function infiniteScroll() {
    if ($(window).scrollTop() + $(window).height() === $(document).height()) {
        const photographHtml = $('.infiniteScroll-gallery');
        if (photographHtml.length) {
            let data = {
                'action': 'photography_loadmore',
                'query': loadmore_params.posts, // that's how we get params from wp_localize_script() function
                'page': loadmore_params.current_page
            };

            $.ajax({ // you can also use $.post here
                url: loadmore_params.ajax_url, // AJAX handler
                data: data,
                type: 'POST',
                success: function (data) {
                    if (data) {
                        photographHtml.append(data);
                        photographHtml.justifiedGallery('norewind');
                        loadmore_params.current_page++;

                        if (loadmore_params.current_page === parseInt(loadmore_params.max_page)) {
                            photographHtml.removeClass('infiniteScroll-gallery'); // if last page, remove the button
                        }

                    } else {
                        photographHtml.removeClass('infiniteScroll-gallery'); // if no data, remove the button as well
                    }
                    $('div.jg-spinner').toggleClass('d-none');
                }
            });
        }
    }

}

function justifyGallery() {
    $('.justified-gallery').justifiedGallery({
        rowHeight: 250,
        // lastRow: 'justify',
        margins: 3,
        captions: false
    }).on('jg.complete', function (e) {
        const seeMoreDivs = $(e.target.parentElement.nextElementSibling);
        if (seeMoreDivs.length && seeMoreDivs[0].className.includes('justified-gallery-see-more')) {
            $(e.target.parentElement.nextElementSibling).toggleClass('d-none');
        }
    });

    $('.justified-gallery--sm').justifiedGallery({
        rowHeight: 170,
        // lastRow: 'justify',
        margins: 3,
        captions: false
    });

    var winWidth = $(window).width();
    if (winWidth < 768) {
        $('.justified-gallery--sm').justifiedGallery({
            rowHeight: 100,
            // lastRow: 'justify',
            margins: 3,
            captions: false
        });
    }
}

function slideMenu() {
    $('.btn-usernav-toggle').on('click', function () {
        $('#user-slidemenu').addClass('is-open');
        $('body').css({
            'overflow': 'hidden',
            'padding-right': 17,
        })
    });
    $('#usernav-close').on('click', function () {
        $('#user-slidemenu').removeClass('is-open');
        $('body').css({
            'overflow': '',
            'padding-right': '',
        })
    })
}

function mobileMenu() {
    $('.btn-nav-toggle').on('click', function () {
        $('.header__nav').addClass('mobile-nav-open');
    });
    $('.btn-toggle-close').on('click', function () {
        $('.header__nav').removeClass('mobile-nav-open');
    });
}

// function lightgallery(){
// $('a[data-rel^=lightcase]').lightcase({
//     transition:false,
//     showCaption: false,
//     shrinkFactor: 0.9,
//     maxWidth: 1000,
//     maxHeight: 700,


// });


$('.lg-popup').magnificPopup({
    delegate: 'a', // child items selector, by clicking on it popup will open
    type: 'image',
    midClick: true,
    closeOnContentClick: true
    // other options
})

//For hidden  page title /collection page
var loc = window.location.href; // returns the full URL
if (/collections/.test(loc)) {
    $('.blog-page-title').addClass('d-none');
}

if (/privacy-policy/.test(loc)) {
    $('.blog-page-title > .container, .main > .container').addClass('container-medium');
}
if (/privacy-policy/.test(loc)) {
    $('.main > .container').addClass('container-medium');
}



function responsiveFooter() {
    if ($(window).width() <= 768) {
        $('.widget-title i').on('click', function () {
            $(this).parent().next('.slideItem').slideToggle();
        })
    }
    ;

}

$(document).ready(function () {
    justifyGallery();
    slideMenu();
    mobileMenu();
    // lightgallery();
    responsiveFooter();


    // $(document).on('click', '#photograph-loadmore', function (e) {
    //     const button = $(this);
    //     const photographHtml = $('.infiniteScroll-gallery');
    //     let data = {
    //         'action': 'photography_loadmore',
    //         'query': loadmore_params.posts, // that's how we get params from wp_localize_script() function
    //         'page': loadmore_params.current_page
    //     };
    //
    //     $.ajax({ // you can also use $.post here
    //         url: loadmore_params.ajax_url, // AJAX handler
    //         data: data,
    //         type: 'POST',
    //         beforeSend: function (xhr) {
    //             button.text('Loading...'); // change the button text, you can also add a preloader image
    //         },
    //         success: function (data) {
    //             if (data) {
    //                 photographHtml.append(data);
    //                 photographHtml.justifiedGallery('norewind');
    //                 button.text('More posts'); // insert new posts
    //                 loadmore_params.current_page++;
    //
    //                 if (loadmore_params.current_page === parseInt(loadmore_params.max_page)) {
    //                     button.remove(); // if last page, remove the button
    //                 }
    //
    //             } else {
    //                 button.remove(); // if no data, remove the button as well
    //             }
    //         }
    //     });
    // });

    $('#portfolio-button').click(function () {
        window.location = localized_var.home_url;
    });


    //pagination next button
    const nextPageLink = $('ul.pagination li a.next');
    if (!nextPageLink.length) {
        $('.next-page').addClass('d-none');
    }

    //archive page pagination
    $('.next-page').click(function () {
        window.location = nextPageLink.attr(('href'));
    });

    //woocommerce my-account login form
    if (location.hash === "#registration" && $(".registrations__container").length) {
        $(".registrations__container .nav-tabs #login-tab").removeClass("active");
        $(".registrations__container .nav-tabs #register-tab").addClass("active");
        $(".registrations__container .tab-content #login").removeClass("show active");
        $(".registrations__container .tab-content #register").addClass("show active");

    }

    if ($("#coupon-container").length) {
        const coupon = $("#coupon-container");
        coupon.insertAfter('.shop_table.woocommerce-checkout-review-order-table');
    }

    //add-photography form
    $('input[name=photograph]').on("change", function () {

        //validate image is of jpg format
        if (this.files[0]["type"] === "image/jpeg") {
            const filename = this.files[0].name.split('.')[0];

            if (this.files && this.files[0]) {
                const reader = new FileReader();

                const img = new Image();

                reader.onload = function (e) {
                    img.src = e.target.result;
                };

                img.onload = () => {
                    //validate image has minimum height or width of 2000px
                    if (img.width < 2000 && img.height < 2000) {
                        $("div#err-msg").html("Please upload image with width or height above 2000px");
                    } else {
                        $("div#err-msg").html("");
                        $('#uploaded-image').attr('src', img.src);
                        $(".upload-section .photo-detail input[name='title']").val(filename);
                        $('.upload-section .upload-requirement').addClass('d-none');
                        $('.upload-section .upload-area').addClass('d-none');
                        $('.upload-section .photo-detail').toggleClass('d-none');

                        $(".upload-section .photo-detail #small span.resolution").html(getSmallImageDimensions(img.width, img.height));
                        $(".upload-section .photo-detail #medium span.resolution").html(getMediumImageDimensions(img.width, img.height));

                        $(".upload-section .photo-detail #large span.resolution").html(`${img.width} x ${img.height} px`);
                    }
                }

                reader.readAsDataURL(this.files[0]);
            }
        } else {
            $("div#err-msg").html("Select valid image format");
        }
    });

    const getSmallImageDimensions = (width, height) => {
        const smallWidth = localized_var.image_sizes['small'][0];
        const smallHeight = localized_var.image_sizes['small'][1];

        const aspectRatio = width / height;

        let newWidth, newHeight = 0;

        if (width >= height) {
            newWidth = smallWidth;
            newHeight = Math.floor(newWidth / aspectRatio);
        } else {
            newHeight = smallHeight;
            newWidth = Math.floor(newHeight * aspectRatio);
        }

        return `${newWidth} x ${newHeight} px`;
    }

    const getMediumImageDimensions = (width, height) => {
        const mediumWidth = localized_var.image_sizes['medium'][0];
        const mediumHeight = localized_var.image_sizes['medium'][1];

        const aspectRatio = width / height;

        let newWidth, newHeight = 0;

        if (width > height) {
            newWidth = mediumWidth;
            newHeight = Math.floor(mediumWidth / aspectRatio);
        } else {
            newHeight = mediumHeight;
            newWidth = Math.floor(newHeight * aspectRatio);
        }

        return `${newWidth} x ${newHeight} px`;
    }

    $("#image-upload").on('submit', function (e) {
        e.preventDefault();

        $submitButton = $('input[type=submit]');

        let formData = new FormData(this);

        formData.append('action', 'add_new_photograph');

        $.ajax({ // you can also use $.post here
            url: localized_var.ajax_url, // AJAX handler
            data: formData,
            type: 'POST',
            processData: false,
            contentType: false,
            beforeSend: function () {
                $submitButton.val('Uploading');
                $("form#image-upload .spinner-border").toggleClass('d-none');
            },
            success: function (data) {
                $("form#image-upload .spinner-border").toggleClass('d-none');
                $submitButton.val('Uploaded');
                window.location = localized_var.admin_products_list;
            }
        });
    });

    $('.select2').select2();

    // $('.tag-select').select2({tags: true, selectOnClose: false});

    $('.tag-select').tagit({
        fieldName: 'tags[]',
        availableTags: localized_var.product_tags,
    });

    $(".photography-product-search").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: localized_var.ajax_url,
                dataType: "json",
                data: {
                    term: request.term,
                    action: 'photography_search_autocomplete'
                },
                success: function (data) {
                    response(data);
                }
            });
        },
        // minLength: 2,
        select: function (event, ui) {
            // console.log("Selected: " + ui.item.value + " aka " + ui.item.id);
            $('#s').val(ui.item.value);
            $(".photography-product-search-form").trigger('submit');
        }
    });
});


//wcfm
//ajax add new tag from add-photo form
$("#add-tag-form").on("submit", function (e) {
    e.preventDefault();

    const newTag = $("input[name=new-tag]").val();

    $.ajax({
        url: localized_var.ajax_url,
        type: 'POST',
        data: {
            action: 'photography_add_product_tag',
            new_tag: newTag
        },
        success: function (res) {
            const newOption = new Option(res.name, res.term_id, false, true);
            $(".photo-detail .tag-select").append(newOption).trigger('change');
            $("input[name=new-tag]").val("");
        }
    });
});

//redirect product edit link on dashboard products list
$(document).on('click', "table#wcfm-products a[href*='/store-manager/products-manage/']", function (e) {
    e.preventDefault();
    const urlParts = $(this).attr('href').split('/');
    const productId = urlParts[urlParts.length - 1];

    window.location = localized_var.edit_photograph_url + "?product_id=" + productId;
});

$(window).scroll(function () {
    searchSticky();
    // infiniteScroll();
});

//Disable right click on images
// $(document).on('contextmenu', 'img', function () {
//     $('.single-image-display__area .caption').toggleClass('d-none');
//     return false;
// })


/* ===================================     header appear on scroll up     ====================================== */
const searchBar = $('.sticky-search-bar');
const headerHeight = searchBar.outerHeight();
let lastScroll = 0;
$(window).on('scroll', function () {
    let st = $(this).scrollTop();

    if (st > lastScroll) {
        searchBar.removeClass('is-sticky');
    } else {
        searchBar.addClass('is-sticky');
    }

    lastScroll = st;

    if (lastScroll <= headerHeight) {
        searchBar.removeClass('is-sticky');
    }
});