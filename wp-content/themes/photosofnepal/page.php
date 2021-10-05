<?php

get_header();
while ( have_posts() ):
	the_post();
	?>
    <div class="container">
        <div class="cms-content">
			<?php the_content(); ?>
        </div>
    </div>
<?php

endwhile;

if ( have_rows( 'sections' ) ) {
	while ( have_rows( 'sections' ) ):
		the_row();
		get_template_part( '/partials/flexible-content/' . get_row_layout() );
	endwhile;
}

get_footer();