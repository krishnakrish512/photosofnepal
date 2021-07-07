<?php
get_header();


global $wp_query;
$author = get_user_by( 'slug', $wp_query->query_vars['author_name'] );


$term = $wp_query->queried_object;

//$vendor_data    = get_term_meta( $term->term_id, 'vendor_data', true );
$vendor_data = WC_Product_Vendors_Utils::get_vendor_data_by_id( $term->term_id );
?>
    <section class="search-hero text-center text-white search-hero__inner section-spacing">
        <div class="search-hero__content sticky-search-bar ">
            <h1 class="search-hero__title">Moving the world with images</h1>
            <div class="search-hero__form has-badge input-style">
                <span class="badge mr-2 font-weight-normal text-dark" id="portfolio-button">Portfolio <i
                            class="fas fa-times ml-3"></i></span>
                <form action="<?= get_home_url() ?>" class="">
                    <input type="text" name="s" id="s" class="form-control" placeholder="Search photos"/>
                    <input type="hidden" name="post_type" value="product">
                    <input type="hidden" name="author" value="<?= $author->ID ?>"/>
                    <span><i class="icon-search"></i></span>
                </form>
            </div>
        </div>
    </section>
    <section class="profile section-spacing">
        <div class="container-fluid">
            <div class="d-flex align-items-center justify-content-center">
                <div class="profile__info text-center">
                    <h1 class="profile__info-name"><?= $vendor_data['name'] ?></h1>
                    <p><?= $vendor_data['count'] ?> Photos</p>
                </div>
            </div>
        </div>
    </section>
    <section class="profile__tab">
        <div class="container-fluid">
            <nav class="mb-5">
                <div class="nav nav-tabs justify-content-center" id="nav-tab" role="tablist">
                    <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab"
                       aria-controls="nav-home" aria-selected="true"><span class="icon-photo mr-2"></span> Photos</a>

                    <a class="nav-item nav-link" id="nav-gallery-tab" data-toggle="tab" href="#nav-gallery" role="tab"
                       aria-controls="nav-gallery" aria-selected="false"><span class="icon-stack mr-2"></span>
                        Galleries</a>
                    <a class="nav-item nav-link" id="nav-about-tab" data-toggle="tab" href="#nav-about" role="tab"
                       aria-controls="nav-contact" aria-selected="false"><span class="far fa-user mr-2"></span>
                        About</a>
                </div>
            </nav>
        </div>
    </section>
    <div class="tab-content section-spacing" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <div class="discover-photos">
                <div class="container-fluid">
                    <div class="infiniteScroll-gallery discover-photos__grid justified-gallery section-spacing">
						<?php
						while ( have_posts() ):
							the_post();
							$photograph = wc_get_product( get_the_ID() );

							$photograph_image_id = $photograph->get_image_id();

							$args = [
								'post_type'   => 'gallery',
								'post_status' => 'publish',
								'meta_query'  => [
									[
										'key'     => 'photographs',
										'value'   => $photograph_image_id,
										'compare' => 'LIKE'
									]
								],
							];

							$gallery = get_posts( $args );
							if ( ! empty( $gallery ) ) {
								$gallery_url = get_permalink( $gallery[0] );
							}
							?>
                            <div class="discover-photos__grid-item">
                                <img src="<?= wp_get_attachment_image_url( $photograph_image_id, 'photography_thumbnail' ) ?>"
                                     alt="<?= $photograph->get_title() ?>">
                                <figcaption>
                                    <div class="figure-tools">
                                        <div class="figure-icons">
											<?php echo do_shortcode( "[ti_wishlists_addtowishlist product_id='" . $photograph->get_id() . "']" ); ?>
											<?php
											if ( ! empty( $gallery ) ):
												?>
                                                <a href="<?= esc_url( $gallery_url ) ?>"> <span
                                                            class="icon-stack"></span></a>
											<?php
											endif;
											?>
                                        </div>
                                    </div>

                                    <div class="figure-info">
                                        <h6 class="font-weight-light"><?= $photograph->get_title() ?></h6>
                                        <a href="#" class="btn btn-primary btn-sm" data-toggle="modal"
                                           data-target="#exampleModal">Buy</a>
                                    </div>
                                </figcaption>
                                <a href="<?= esc_url( $photograph->get_permalink() ); ?>"
                                   class="stretched-link"></a>
                            </div>
						<?php
						endwhile;
						?>
                    </div>
					<?php
					global $wp_query;

					$total_pages  = $wp_query->max_num_pages;
					$current_page = max( 1, get_query_var( 'paged' ) );
					if ( $total_pages > 1 ) :
						$paginate_links = paginate_links( [
							'base'      => get_pagenum_link( 1 ) . '%_%',
							'format'    => isset( $_GET['s'] ) ? '&paged=%#%' : '?paged=%#%',
							'current'   => $current_page,
							'total'     => $total_pages,
							'prev_text' => "<i class='fas fa-angle-left'></i>",
							'next_text' => "<i class='fas fa-angle-right'></i>",
							'type'      => 'array'
						] );
						?>
                        <div class="row">
                            <div class="col-lg-4"></div>
                            <div class="col-lg-4 text-center">
                                <button class="btn btn-primary btn-lg btn-width--lg next-page">Next</button>
                            </div>
                            <div class="col-lg-4">
                                <div class="pagination-wrap">
                                    <nav aria-label="Page navigation">
                                        <ul class="pagination text-center justify-content-center">
											<?php
											foreach ( $paginate_links as $paginate_link ):
												echo "<li class='page-item'>" . $paginate_link . "</li>";
											endforeach;
											?>
                                        </ul>
                                    </nav>
                                </div><!-- end pagination-wrap -->
                            </div><!-- end col-lg-12 -->
                        </div><!-- end row -->
					<?php
					endif;
					?>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-gallery" role="tabpanel" aria-labelledby="nav-gallery-tab">
            <div class="discover-collection">
                <div class="container-fluid">
                    <div class="row gutter-md">
						<?php
						$args = [
							'post_type'   => 'gallery',
							'post_status' => 'publish',
							'author'      => is_array( $vendor_data['admins'] ) ? $vendor_data['admins'][0] : $vendor_data['admins']
						];

						$gallery_query = new WP_Query( $args );

						if ( $gallery_query->have_posts() ):
							while ( $gallery_query->have_posts() ):
								$gallery_query->the_post();

								$gallery_photos = get_field( 'photographs' );
								?>
                                <div class="col-lg-3 col-sm-6 col-md-4">
                                    <div class="card card-hover border-0 mb-3">
                                        <div class="card-image">
                                            <a href="<?php the_permalink(); ?>">
                                                <img src="<?= wp_get_attachment_image_url( get_post_thumbnail_id(), 'profile_gallery' ) ?>"
                                                     class="card-img-top" alt="<?php the_title() ?>"></a>

                                        </div>
                                        <div class="card-body">
                                            <a href="<?php the_permalink(); ?>"
                                               class="card-title h5"><?php the_title(); ?></a>
                                            <p class="card-text"><?= count( $gallery_photos ) ?> Photos</p>
                                        </div>
                                    </div>
                                </div>
							<?php
							endwhile;
							wp_reset_postdata();
						endif;
						?>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="nav-about" role="tabpanel" aria-labelledby="nav-about-tab">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center">
                        <div class="profile__image mb-5">
                            <!--							--><? //= get_avatar( get_the_author_meta( 'ID' ), 150 ); ?>
                            <img src="<?= wp_get_attachment_image_url( $vendor_data['logo'] ) ?>" alt="">
                        </div>
                        <h3><?= $vendor_data['name'] ?></h3>
                        <p class="mb-5"><?= $vendor_data['profile'] ?></p>
                        <div class="profile__share d-flex justify-content-center mb-5">
                            <ul class="profile__share-icon inline-list share-icons">
                                <li><a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#" class="twitter"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fas fa-envelope"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
get_footer();