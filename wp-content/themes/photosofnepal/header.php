<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800;900&display=swap"
          rel="stylesheet">

    <?php wp_head(); ?>
</head>
<body>
<?php
if (!(is_account_page() && !is_user_logged_in())):
    ?>
    <header class="header header__light" id="header">
        <div class="container header__wrapper">
            <a href="<?= get_home_url() ?>" class="header__logo h1 mb-0 text-uppercase">
                <img src="<?= wp_get_attachment_image_url(get_theme_mod('custom_logo'), 'full') ?>"
                     class="img-fluid d-block"
                     alt="<?php bloginfo('name'); ?>">
            </a>
            <nav class="header__nav">
                <div class="header__nav--inner">
                    <?php
                    wp_nav_menu([
                        'theme_location' => 'primary',
                        'menu_class' => 'inline-list header__nav--list mb-md-0',
                        'container' => '',
                    ]);
                    echo "<a class='special-link d-none'>
                        
                    Free Dashain Images</a>";
                    if (!is_user_logged_in()):
                        ?>
                        <ul class="mobile-header-tools">
                            <?php
                            echo "<li><a href='" . wc_get_page_permalink('myaccount') . "' class='btn btn-outline d-block mb-3'>Login</a></li>";
                            echo "<li><a href='" . wc_get_page_permalink('myaccount') . "#registration' class='btn btn-primary d-block' >Sign up</a></li>";
                            ?>
                        </ul>
                    <?php
                    endif;
                    ?>
                    <span class="btn-toggle-close">
               <i class="icon-close"></i>
            </span>
                </div>
            </nav>
            <div class="header__tools">
                <ul class="header__tools--user inline-list mb-0 ">
                    <li>
                        <a href="<?= get_page_link(get_page_by_title('Dashain Offer')) ?>" class="special-link d-none">
                            <span class="svg-diyo">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 500 500" enable-background="new 0 0 500 500" xml:space="preserve" class="svg" preserveAspectRatio="xMidYMid ">
<path fill-rule="evenodd" clip-rule="evenodd" fill="#F7C300" d="M207.76,219.4c5.084-37.718,35.058-52.62,37.92-93.36
	c15.273,16.093,34.28,36.851,29.28,67.68c-1.812,29.463-34.447,45.473-23.761,79.68c-22.403-16.917,14.943-64.556-18.239-66.24
	c-34.377,16.01-0.283,55.871,17.52,68.64c-3.3-0.939-5.251-3.229-8.16-4.56c-0.275-0.755,0.377-0.583,0.48-0.96
	C224.644,262.646,203.957,245.801,207.76,219.4z" id="path-0"></path>
<path fill-rule="evenodd" clip-rule="evenodd" fill="#97591D" d="M301.12,346.84c-20.143,28.142-83.087,26.823-103.68,0
	C231.424,346.842,263.793,346.81,301.12,346.84z" id="path-1"></path>
<path fill-rule="evenodd" clip-rule="evenodd" fill="#97591D" d="M303.76,343.48c-4.911-0.129-10.357,0.277-14.88-0.24
	c5.173-6.587,9.802-13.718,15.6-19.68c2.551,3.77,6.019,6.621,8.641,10.319C310.504,337.688,307.399,341.377,303.76,343.48z" id="path-2"></path>
<path fill-rule="evenodd" clip-rule="evenodd" fill="#97591D" d="M185.2,334.12c2.873-3.207,4.869-7.292,8.16-10.08
	c4.636,6.564,10.971,12.709,15.12,18.96C196.533,345.175,188.339,341.55,185.2,334.12z" id="path-3"></path>
<path fill-rule="evenodd" clip-rule="evenodd" fill="#97591D" d="M213.28,342.76c-6.151-6.009-12.194-13.405-16.8-20.16
	c10.24,0,20.48,0,30.72,0C223.845,329.647,217.529,335.809,213.28,342.76z" id="path-4"></path>
<path fill-rule="evenodd" clip-rule="evenodd" fill="#97591D" d="M245.68,343c-9.167,0.564-19.621,0.674-29.04,0.24
	c4.436-6.684,9.603-12.637,13.92-19.44C236.238,329.562,240.651,336.589,245.68,343z" id="path-5"></path>
<path fill-rule="evenodd" clip-rule="evenodd" fill="#97591D" d="M282.16,343.24c-9.724-0.213-20.089,0.418-28.561,0
	c3.814-6.905,9.258-12.183,13.2-18.96C272.693,329.668,277.717,337.201,282.16,343.24z" id="path-6"></path>
<path fill-rule="evenodd" clip-rule="evenodd" fill="#97591D" d="M234.4,322.84c9.36-0.56,19.76-0.08,29.52-0.24
	c-4.172,7.43-9.293,13.907-14.64,20.16C244.567,335.872,239.077,329.764,234.4,322.84z" id="path-7"></path>
<path fill-rule="evenodd" clip-rule="evenodd" fill="#EDE224" d="M174.64,319.24c50.611,0.289,97.208-0.04,148.799,0
	c-2.896,5.423-6.429,10.211-10.319,14.64c-2.622-3.698-6.09-6.55-8.641-10.319c-5.798,5.962-10.427,13.093-15.6,19.68
	c4.522,0.518,9.969,0.111,14.88,0.24c-0.245,1.755-1.884,2.116-2.64,3.359c-37.327-0.03-69.696,0.002-103.68,0
	c-0.799-1.124-3.159-1.957-2.88-3.359c4.491-0.309,10.224,0.624,13.92-0.48c-4.149-6.251-10.484-12.396-15.12-18.96
	c-3.292,2.788-5.287,6.873-8.16,10.08C181.237,329.603,177.265,325.096,174.64,319.24z M227.2,322.6c-10.24,0-20.48,0-30.72,0
	c4.605,6.755,10.649,14.151,16.8,20.16C217.529,335.809,223.845,329.647,227.2,322.6z M249.28,342.76
	c5.347-6.253,10.468-12.73,14.64-20.16c-9.76,0.16-20.16-0.319-29.52,0.24C239.077,329.764,244.567,335.872,249.28,342.76z
	 M300.16,322.6c-9.761,0.16-20.16-0.319-29.521,0.24c4.935,6.585,9.501,13.539,15.36,19.2
	C290.345,335.345,296.678,329.358,300.16,322.6z M230.56,323.8c-4.317,6.804-9.484,12.757-13.92,19.44
	c9.418,0.434,19.873,0.324,29.04-0.24C240.651,336.589,236.238,329.562,230.56,323.8z M266.8,324.28
	c-3.942,6.777-9.386,12.055-13.2,18.96c8.472,0.418,18.837-0.213,28.561,0C277.717,337.201,272.693,329.668,266.8,324.28z" id="path-8"></path>
<path fill-rule="evenodd" clip-rule="evenodd" fill="#97591D" d="M286,342.04c-5.859-5.661-10.426-12.615-15.36-19.2
	c9.36-0.56,19.76-0.08,29.521-0.24C296.678,329.358,290.345,335.345,286,342.04z" id="path-9"></path>
<path fill-rule="evenodd" clip-rule="evenodd" fill="#97591D" d="M241.84,219.16c-9.544,16.402-4.183,39.657,5.76,52.08
	c-13.387-9.278-40.292-40.901-13.68-54C237.299,217.141,240.698,217.022,241.84,219.16z" id="path-10"></path>
<path fill-rule="evenodd" clip-rule="evenodd" fill="#97591D" d="M162.4,296.92c27.536,19.598,79.044,17.614,86.88-17.76
	c8.443,32.568,62.211,34.138,87.84,15.6c-4.115,8.525-8.27,17.011-13.44,24.48c-0.08,0-0.16,0-0.24,0
	c-51.592-0.04-98.188,0.289-148.799,0c-5.426-5.935-8.38-14.341-12.24-21.84C162.4,297.24,162.4,297.08,162.4,296.92z" id="path-11"></path>
</svg>
                            </span>Free Tihar Images</a>
                    </li>
                    <li><a href="<?= wc_get_cart_url() ?>" class="header__tools-cart"> <span
                                    class="icon-shopping-cart"></span><label
                                    class="ml-3">Cart <span
                                        class="font-weight-bold"><?= WC()->cart->get_cart_contents_count() ?></span></label>
                        </a></li>
                    <?php
                    if (is_user_logged_in()) {
                        $logged_in_user = wp_get_current_user();
                        ?>
                        <li>
                            <div class="btn-usernav-toggle">
                                <i class="far fa-user mr-2"></i>
                                <label><?= $logged_in_user->first_name ? $logged_in_user->first_name : $logged_in_user->display_name ?></label>
                            </div>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
                <?php
                if (!is_user_logged_in()):
                    ?>
                    <ul class="header__tools--access inline-list mb-0 border-left ml-5">
                        <?php
                        echo "<li><a href='" . wc_get_page_permalink('myaccount') . "' class='btn btn-white'>Login</a></li>";
                        echo "<li><a href='" . wc_get_page_permalink('myaccount') . "#registration' class='btn btn-primary text-white' >Sign up</a></li>";
                        ?>
                    </ul>
                <?php
                endif;
                ?>
                <button class="btn-nav-toggle ml-3 ">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
        </div>
    </header>

<?php
endif;

//if ( ( is_account_page() && is_user_logged_in() ) || is_cart() || is_checkout() || is_wishlist() ):
?>
<!--<section class="page-title  search-hero__inner section-spacing">-->
<!--    <div class="container">-->
<!--        <div class="page-title__content ">-->
<!--            <h4>--><?php
//				if ( is_cart() ) {
//					echo "Cart";
//				} else if ( is_checkout() ) {
//					echo "Checkout";
//				} else if ( is_wishlist() ) {
//					echo "Wishlist";
//				} else {
//					photography_myaccount_page_title();
//				}
//				?><!--</h4>-->
<!--        </div>-->
<!--    </div>-->
<!--</section>-->
<?php
//endif;
?>
<?php
if (is_user_logged_in()):
    $logged_in_user = wp_get_current_user();
    ?>
    <div class="slidemenu " id="user-slidemenu">
        <div class="slidemenu__inner">
          <span class="slidemenu__close" id="usernav-close">
            <span class="icon-close"></span>
          </span>
            <h5 class="user-name border-bottom border-black mb-4 pb-4"><i
                        class="far fa-user mr-2"></i> <?= $logged_in_user->first_name ? $logged_in_user->first_name : $logged_in_user->display_name ?>
            </h5>
            <ul class="slidemenu__nav mb-4">
                <li><a href="<?= wc_get_page_permalink('myaccount') . 'downloads' ?>">Downloads</a></li>
                <li><a href="<?= wc_get_page_permalink('myaccount') . 'orders' ?>">Purchase History</a></li>
                <li><a href="<?= get_page_link(get_page_by_title('Wishlist')) ?>">Wishlist</a></li>
                <li><a href="<?= wc_get_page_permalink('myaccount') . 'edit-account' ?>">Profile</a></li>
            </ul>
            <a href="<?= wp_logout_url(wc_get_page_permalink('myaccount')) ?>"
               class="btn btn-primary w-100 d-block">Logout</a>
        </div>
    </div>
<?php
endif;

if (is_page() && !is_front_page() && !(is_account_page() && !is_user_logged_in()) && (is_page_template('page-templates/dashain-offer.php') && !get_query_var('product_id'))){
global $post;
?>
<section class="blog-page-title section-spacing">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <h3><?= esc_attr($post->post_title) ?></h3>
            </div>
            <div class="col-lg-5">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= esc_url(get_home_url()) ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= esc_attr($post->post_title) ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<?php
}

if (!(is_front_page() || is_singular('product'))) {
    echo "<main class='main section-spacing'>";
}