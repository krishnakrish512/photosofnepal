<footer class="py-5 footer <?= is_account_page() && ! is_user_logged_in() ? 'd-none' : '' ?>">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-3 text-center text-md-left">
                <p class="mb-0">Product of <a href="https://nirvanstudio.com/" targent="_blank" style="height: 40px;">
                <img src="https://nirvanstudio.com/wp-content/uploads/2020/11/Nirvan-Studio-1.png" alt=""></a></p>  
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

<?php wp_footer(); ?>

</body>
</html>