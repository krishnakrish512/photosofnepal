<div class="container">
    <div class="row align-items-center justify-content-between">
        <div class="col-lg-5 mb-5 mb-lg-0">
            <h2><?php the_sub_field( 'title' ); ?></h2>
            <p class="lead"><?php the_sub_field( 'description' ); ?></p>
			<?php
			if ( get_sub_field( 'link_url' ) || get_sub_field( 'page_link' ) ):
				if ( get_sub_field( 'is_link_external' ) ):
					?>
                    <a href="<?php the_sub_field( 'link_url' ); ?>" target="_blank" rel="noreferrer noopener"
                       class="btn btn-primary"><?php the_sub_field( 'link_label' ); ?></a>
				<?php
				else:
					?>
                    <a href="<?php the_sub_field( 'page_link' ); ?>"
                       class="btn btn-primary"><?php the_sub_field( 'link_label' ); ?></a>
				<?php
				endif;
			endif;
			?>
        </div>
        <div class="col-lg-6 mt-5 mt-lg-0">
            <ul class="photo-grid">
				<?php
				$images = get_sub_field( 'images' );
				foreach ( $images as $image ):
					?>
                    <li>
                            <span>
                                <img src="<?= esc_url( wp_get_attachment_image_url( $image['ID'] ) ) ?>"
                                     alt="<?= esc_attr( $image['caption'] ? $image['caption'] : $image['title'] ) ?>">
                            </span>
                    </li>
				<?php
				endforeach;
				?>
            </ul>
        </div>
    </div>
</div>