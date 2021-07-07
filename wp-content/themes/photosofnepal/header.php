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
if ( ! ( is_account_page() && ! is_user_logged_in() ) ):
	?>
    <header class="header header__light" id="header">
        <div class="container-fluid header__wrapper">
            <a href="<?= get_home_url() ?>" class="header__logo h1 mb-0 text-uppercase">
                <img src="<?= wp_get_attachment_image_url( get_theme_mod( 'custom_logo' ), 'full' ) ?>"
                     class="img-fluid d-block"
                     alt="<?php bloginfo( 'name' ); ?>">
            </a>
            <nav class="header__nav">
                <div class="header__nav--inner">
					<?php
					wp_nav_menu( [
						'theme_location' => 'primary',
						'menu_class'     => 'inline-list header__nav--list mb-md-0',
						'container'      => '',
					] );

					if ( ! is_user_logged_in() ):
						?>
                        <ul class="mobile-header-tools">
							<?php
							echo "<li><a href='" . wc_get_page_permalink( 'myaccount' ) . "' class='btn btn-outline d-block mb-3'>Login</a></li>";
							echo "<li><a href='" . wc_get_page_permalink( 'myaccount' ) . "#registration' class='btn btn-primary d-block' >Sign up</a></li>";
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
                    <li><a href="<?= wc_get_cart_url() ?>" class="header__tools-cart"> <span
                                    class="icon-shopping-cart"></span><label
                                    class="ml-3">Cart <span
                                        class="font-weight-bold"><?= WC()->cart->get_cart_contents_count() ?></span></label>
                        </a></li>
					<?php
					if ( is_user_logged_in() ) {
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
				if ( ! is_user_logged_in() ):
					?>
                    <ul class="header__tools--access inline-list mb-0 border-left ml-5">
						<?php
						echo "<li><a href='" . wc_get_page_permalink( 'myaccount' ) . "' class='btn btn-white'>Login</a></li>";
						echo "<li><a href='" . wc_get_page_permalink( 'myaccount' ) . "#registration' class='btn btn-primary text-white' >Sign up</a></li>";
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
if ( is_user_logged_in() ):
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
                <li><a href="<?= wc_get_page_permalink( 'myaccount' ) . 'downloads' ?>">Downloads</a></li>
                <li><a href="<?= wc_get_page_permalink( 'myaccount' ) . 'orders' ?>">Purchase History</a></li>
                <li><a href="<?= get_page_link( get_page_by_title( 'Wishlist' ) ) ?>">Wishlist</a></li>
                <li><a href="<?= wc_get_page_permalink( 'myaccount' ) . 'edit-account' ?>">Profile</a></li>
            </ul>
            <a href="<?= wp_logout_url( wc_get_page_permalink( 'myaccount' ) ) ?>"
               class="btn btn-primary w-100 d-block">Logout</a>
        </div>
    </div>
<?php
endif;

if ( is_page() && ! is_front_page() && ! ( is_account_page() && ! is_user_logged_in() ) ){
global $post;
?>
<section class="blog-page-title section-spacing">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <h3><?= esc_attr( $post->post_title ) ?></h3>
            </div>
            <div class="col-lg-5">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= esc_url( get_home_url() ) ?>">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page"><?= esc_attr( $post->post_title ) ?></li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
<?php
}

if ( ! ( is_front_page() || is_singular( 'product' ) ) ) {
	echo "<main class='main section-spacing'>";
}