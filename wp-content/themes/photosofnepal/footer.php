<footer class=" d-none py-5 footer <?= is_account_page() && ! is_user_logged_in() ? 'd-none' : '' ?>">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-3 text-center text-md-left">
                <p class="mb-0">Product of <a href="https://nirvanstudio.com/" target="_blank" >
                <img src="<?php echo get_template_directory_uri() . '/assets/images/Nirvan-Studio-04.svg' ?>" alt="" style="height: 40px;"></a></p>  
                <a href="<?= get_home_url() ?>" class="h1 footer__logo d-none"><img
                            src="<?= wp_get_attachment_image_url( get_theme_mod( 'custom_logo' ), 'full' ) ?>"
                            class="img-fluid d-block"
                            alt="<?php bloginfo( 'name' ); ?>">
                </a>
            </div>
            <div class="col-lg-6 col-md-6 text-center my-4 my-md-0">
                <p>Copyright <?= date( 'Y' ) ?> | All Right Reserved.</p>
            </div>
            <div class="col-lg-3 col-md-3 text-center text-md-right">
                <ul class="inline-list footer__social-icon">
					<?php
					$social = get_field( 'social', 'option' );

					if ( $social['facebook'] ) {
						echo "<li><a href='" . $social['facebook'] . "'> <span class='icon-facebook'></span> </a></li>";
					}
					if ( $social['instagram'] ) {
						echo "<li><a href='" . $social['instagram'] . "'> <span class='icon-instagram'></span> </a></li>";
					}
					if ( $social['twitter'] ) {
						echo "<li><a href='" . $social['twitter'] . "'> <span class='icon-twitter'></span> </a></li>";
					}
					?>
                </ul>
            </div>
        </div>
    </div>
</footer>
<footer class="footer dark">
    <div class="container">
            <div class="row">
                <div class="col-lg-2 align-self-center">
                    <div class="footer-widget">
                    <p class="mb-0 h5 text-center">Product of <a href="https://nirvanstudio.com/" target="_blank" >
                    <img src="<?php echo get_template_directory_uri() . '/assets/images/Nirvan-Studio-04.svg' ?>" alt="" style="height: 40px;"></a></p>  
                    <a href="<?= get_home_url() ?>" class="h1 footer__logo d-none"><img
                                src="<?= wp_get_attachment_image_url( get_theme_mod( 'custom_logo' ), 'full' ) ?>"
                                class="img-fluid d-block"
                                alt="<?php bloginfo( 'name' ); ?>">
                    </a>
                    </div>
                </div>
                <div class="col-lg-6 border-left pl-md-5">
                    <div class="footer-widget">
                        <h4>Category</h4>
                        <ul class="category">
                            <li> <a href="#">Culture</a></li>
                            <li> <a href="#">Fashion</a></li>
                            <li> <a href="#">Nature</a></li>
                            <li> <a href="#">Landscape</a></li>
                            <li> <a href="#">Culture</a></li>
                            <li> <a href="#">Fashion</a></li>
                            <li> <a href="#">Nature</a></li>
                            <li> <a href="#">Landscape</a></li>
                            <li> <a href="#">Culture</a></li>
                            <li> <a href="#">Fashion</a></li>
                            <li> <a href="#">Nature</a></li>
                            <li> <a href="#">Landscape</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="footer-widget">
                        <h4>Company</h4>
                        <ul>
                            <li> <a href="#">About</a></li>
                            <li> <a href="#">Blog</a></li>
                            <li> <a href="#">Contact</a></li>
                            <li> <a href="#">Landscape</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="footer-widget">
                        <h4>Follow Us</h4>
                    <ul class="inline-list footer__social-icon">
                        <?php
                        $social = get_field( 'social', 'option' );

                        if ( $social['facebook'] ) {
                            echo "<li><a href='" . $social['facebook'] . "'> <span class='icon-facebook'></span> </a></li>";
                        }
                        if ( $social['instagram'] ) {
                            echo "<li><a href='" . $social['instagram'] . "'> <span class='icon-instagram'></span> </a></li>";
                        }
                        if ( $social['twitter'] ) {
                            echo "<li><a href='" . $social['twitter'] . "'> <span class='icon-twitter'></span> </a></li>";
                        }
                        ?>
                    </ul>
                    </div>
                </div>
            </div>
    </div>
    <div class="footer-bottom">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 col-md-6 text-center my-4 my-md-0">
                    <p>Copyright <?= date( 'Y' ) ?> | All Right Reserved.</p>
                </div>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>

</body>
</html>