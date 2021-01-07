<?php
/*
Template Name: Add Photography Page
*/

if ( ! wc_current_user_has_role( 'wc_product_vendors_admin_vendor' ) || wc_current_user_has_role( 'wc_product_vendors_manager_vendor' ) ) {
	wp_redirect( get_home_url() );
	exit;
}

get_header();

while ( have_posts() ):
	the_post();
	?>
    <section class="page-title  search-hero__inner section-spacing">
        <div class="container">
            <div class="page-title__content ">
                <h4>Upload</h4>
            </div>
        </div>
    </section>
    <main class="main">
        <section class="upload-section section-spacing">
            <div class="container upload-container">
                <form action="" id="image-upload" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-6 text-center">
                            <div id="err-msg">
								<?php
								if ( isset( $message ) ) {
									echo $message;
								}
								?>
                            </div>
                            <div class="upload-area">
                                <div class="upload-area__content">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <h4>Upload Photos</h4>
                                    <!-- <a href="#" class="btn btn-primary">Select Photos</a> -->
                                    <div class="file-btn-area mx-auto">
                                        <input type="file" name="photograph" class="" value="Select Photos"
                                               accept="image/jpeg">
                                        <span class="btn btn-file btn-primary w-100">
                                        Upload Photos
                                    </span>
                                    </div>

                                    <br>

                                    <p class="mt-5">Or drag and drop photos anywhere on this page</p>
                                </div>
                            </div>
                            <img src="" alt="" id="uploaded-image">
                        </div>
                        <div class="col-lg-6">
                            <div class="upload-requirement">
                                <h4 class="mb-3">Photo Requirement</h4>
                                <ul class="mb-5">
                                    <li>.jpg only</li>
                                    <li> Max. photo dimensions are 200MP/megapixels</li>
                                </ul>
                                <h4 class="mb-3">Photo Requirement</h4>
                                <ul>
                                    <li>Min. photo dimensions are 3MP/megapixels</li>
                                    <li>No watermarks, logos, or borders</li>
                                    <li>No NSFW content</li>
                                </ul>
                            </div>
                            <div class="photo-detail d-none">
                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input type="text" name="title" class="form-control" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Description</label>
                                    <textarea name="description" class="form-control"></textarea>
                                </div>

                                <div class="form-group upload-price">
                                    <h5>Price</h5>
                                    <p>The given price bellow is the recommended price only, you can set your own price
                                        for different sizes.</p>
                                    <div class="row">
										<?php
										foreach ( [ 'small', 'medium', 'large' ] as $term_name ) {
											$term = get_term_by( 'name', $term_name, 'pa_resolution' );
											?>
                                            <div class="col" id="<?= $term_name ?>">
                                                <label for=""><?= $term_name ?></label>
                                                <input type="text" name="<?= $term_name ?>_price" class="form-control"
                                                       value="<?= get_field( 'price', $term ) ?>"
                                                       required>
                                                <span class="input-label">NPR</span>
                                                <span class="resolution"></span>
                                            </div>
											<?php
											$price[ $term_name ] = ( ! empty( $_POST["{$term_name}_price"] ) ) ? $_POST["{$term_name}_price"] : get_field( 'price', $term );
										}
										?>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <p>Galleries</p>
                                    <select name="galleries[]" multiple class="select2 form-control gallery-select"
                                            style="width: 100%">
										<?php
										$args = [
											'post_type'      => 'gallery',
											'post_status'    => 'publish',
											'posts_per_page' => - 1,
											'author'         => get_current_user_id()
										];

										$gallery_posts = get_posts( $args );
										foreach ( $gallery_posts as $gallery_post ):
											?>
                                            <option value="<?= $gallery_post->ID ?>"><?= $gallery_post->post_title ?></option>
										<?php
										endforeach;
										?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <p>Categories</p>
                                    <select name="categories[]" class="select2 form-control category-select" multiple
                                            style="width: 100%">
										<?php
										$categories = get_terms( 'product_cat', array(
											'hide_empty' => false,
										) );

										foreach ( $categories as $category ):
											?>
                                            <option value="<?= $category->term_id ?>"><?= $category->name ?></option>
										<?php
										endforeach;
										?>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <p>Tags</p>
									<?php
									$tags = get_terms( 'product_tag', array(
										'hide_empty' => false,
									) );
									?>
                                    <select name="tags[]" multiple class="select2 form-control tag-select"
                                            style="width: 100%">
										<?php
										foreach ( $tags as $tag ):
											?>
                                            <option value="<?= $tag->term_id ?>"><?= $tag->name ?></option>
										<?php
										endforeach;
										?>
                                    </select>

                                    <a href="#" class="add-new-tag" title="Add new tag" data-toggle="modal"
                                       data-target="#addTagModal"><span
                                                class="icon-plus-square"></span></a>
                                </div>
								<?php wp_nonce_field( 'add_photograph', 'add_photograph_nonce' ); ?>
                                <input type="submit" value="Upload" class="btn btn-primary">
                                <div class="spinner-border text-danger d-none" role="status">
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </section>
    </main>

    <!-- Modal -->
    <div class="modal fade" id="addTagModal" tabindex="-1" aria-labelledby="addTagModal" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add new tag</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="" id="add-tag-form">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="">Tag</label>
                            <input type="text" name="new-tag" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php

endwhile;
get_footer();