<?php

get_header();
while ( have_posts() ):
	the_post();
	?>
    <section>
        <div class="container">
			<?php the_content(); ?>
        </div>
    </section>
<?php

endwhile;

if ( have_rows( 'sections' ) ) {
	while ( have_rows( 'sections' ) ):
		the_row();
		get_template_part( '/partials/flexible-content/' . get_row_layout() );
	endwhile;
}

get_footer();