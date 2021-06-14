<?php
if ( ! ( is_front_page() || is_singular( 'product' ) ) ) {
	echo "</main>";
}

if ( ! ( is_account_page() && ! is_user_logged_in() ) ):
	?>
    <footer class="footer dark">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 align-self-center col-md-6">
                    <div class="footer-widget">
                        <p class="mb-0 h5 text-lg-center product-by">Product of <a href="https://nirvanstudio.com/"
                                                                                   target="_blank">
                                <br>
                                <img src="<?php echo get_template_directory_uri() . '/assets/images/Nirvan-Studio-photo.png' ?>"
                                     alt="" style="height: 40px;"></a></p>
                        <a href="<?= get_home_url() ?>" class="h1 footer__logo d-none"><img
                                    src="<?= wp_get_attachment_image_url( get_theme_mod( 'custom_logo' ), 'full' ) ?>"
                                    class="img-fluid d-block"
                                    alt="<?php bloginfo( 'name' ); ?>">
                        </a>
                    </div>
                </div>
				<?php
				$args = [
					'taxonomy' => 'product_cat',
					'orderby'  => 'count',
					'order'    => 'DESC',
					'number'   => 12
				];

				$popular_categories = get_terms( $args );
				?>
                <div class="col-lg-5 border-left pl-lg-5">
                    <div class="footer-widget pl-lg-5">
                        <h4 class="widget-title">Popular Category <i class="icon-keyboard_arrow_down"></i></h4>
                        <div class="slideItem">
                            <ul class="category">
								<?php
								foreach ( $popular_categories as $category ):
									?>
                                    <li>
                                        <a href="<?= esc_url( get_term_link( $category->term_id ) ) ?>"><?= $category->name ?></a>
                                    </li>
								<?php
								endforeach;
								?>
                            </ul>
                        </div>

                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="footer-widget">
                        <h4 class="widget-title">Company <i class="icon-keyboard_arrow_down"></i></h4>
                        <div class="slideItem">
							<?php
							wp_nav_menu( [
								'theme_location' => 'footer',
								'container'      => ''
							] )
							?>
                        </div>

                    </div>
                </div>
                <div class="col-lg-2 ">
                    <div class="footer-widget">
                        <h4 class="widget-title">Follow Us </h4>
                        <ul class="inline-list footer__social-icon ">
							<?php
							$social = get_field( 'social', 'option' );

							if ( $social['facebook'] ) {
								echo "<li><a href='" . $social['facebook'] . "' target='_blank' rel='noopener noreferrer'> <span class='icon-facebook'></span> </a></li>";
							}
							if ( $social['instagram'] ) {
								echo "<li><a href='" . $social['instagram'] . "' target='_blank' rel='noopener noreferrer'> <span class='icon-instagram'></span> </a></li>";
							}
							if ( $social['twitter'] ) {
								echo "<li><a href='" . $social['twitter'] . "' target='_blank' rel='noopener noreferrer'> <span class='icon-twitter'></span> </a></li>";
							}
							?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class=" footer-bottom">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-lg-6 col-md-6 text-center my-4 my-md-0">
                        <p><i class="far fa-copyright"></i> <?= date( 'Y' ) ?> Image Pasal | All Right Reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
<?php
endif;

wp_footer(); ?>

</body>
</html>