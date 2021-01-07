<?php
/*
Template Name: Edit Photograph
*/

//if ( ! wcfm_is_vendor() ) {
//	return;
//}

$product_id = $_GET['product_id'];
$product    = wc_get_product( $product_id );


if ( ! current_user_can( 'administrator' ) ) {
	if ( get_post_field( 'post_author', $product_id ) != get_current_user_id() ) {
		wp_redirect( get_home_url() );
		exit;
	}
}

global $wpdb;
$query = "SELECT postmeta.post_id AS product_id FROM {$wpdb->prefix}postmeta AS postmeta LEFT JOIN {$wpdb->prefix}posts AS products ON ( products.ID = postmeta.post_id ) WHERE postmeta.meta_key LIKE 'attribute_%' AND postmeta.meta_value = 'small' AND products.post_parent = {$product->get_id()}";

$variation_id = $wpdb->get_col( $query );

$small_product = new WC_Product_Variation( $variation_id[0] );

$query = "SELECT postmeta.post_id AS product_id FROM {$wpdb->prefix}postmeta AS postmeta LEFT JOIN {$wpdb->prefix}posts AS products ON ( products.ID = postmeta.post_id ) WHERE postmeta.meta_key LIKE 'attribute_%' AND postmeta.meta_value = 'medium' AND products.post_parent = {$product->get_id()}";

$variation_id = $wpdb->get_col( $query );

$medium_product = new WC_Product_Variation( $variation_id[0] );

$query = "SELECT postmeta.post_id AS product_id FROM {$wpdb->prefix}postmeta AS postmeta LEFT JOIN {$wpdb->prefix}posts AS products ON ( products.ID = postmeta.post_id ) WHERE postmeta.meta_key LIKE 'attribute_%' AND postmeta.meta_value = 'large' AND products.post_parent = {$product->get_id()}";

$variation_id = $wpdb->get_col( $query );

$large_product = new WC_Product_Variation( $variation_id[0] );


if ( $_SERVER['REQUEST_METHOD'] == 'POST' ) {

	if ( isset( $_POST['add_photograph_nonce'] ) ) {
		// The nonce was valid and the user has the capabilities, it is safe to continue.

		// These files need to be included as dependencies when on the front end.
		$title = filter_var( $_POST['title'], FILTER_SANITIZE_STRING );

		if ( $product->get_name() !== $title ) {
			$product->set_name( $title );
		}

		$description = filter_var( $_POST['description'], FILTER_SANITIZE_STRING );
		if ( $product->get_description() !== $description ) {
			$product->set_description( $description );
		}

		$categories = isset( $_POST['categories'] ) ? (array) $_POST['categories'] : [];
		$categories = array_map( 'esc_attr', $categories );

		$product->set_category_ids( $categories );

		$tags = isset( $_POST['tags'] ) ? (array) $_POST['tags'] : [];
		$tags = array_map( 'esc_attr', $tags );

		foreach ( $tags as &$tag ) {
			if ( (int) $tag == 0 ) {
				$new_tag = wp_insert_term( $tag, 'product_tag', [] );
				$tag     = $new_tag['term_id'];
			} else {
				$tag = (int) $tag;
			}
		}

//		var_dump( $tags );
//		exit;

		$product->set_tag_ids( $tags );


		$small_product->set_regular_price( $_POST['small_price'] );
		$small_product->save();

		$medium_product->set_regular_price( $_POST['medium_price'] );
		$medium_product->save();

		$large_product->set_regular_price( $_POST['large_price'] );
		$large_product->save();

		$product->save();

		wp_redirect( admin_url( "/edit.php?post_type=product" ) );
		exit;

	}
}

get_header();

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
                <form action="" id="image-edit" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-lg-6 text-center">
                            <div id="err-msg">
								<?php
								if ( isset( $message ) ) {
									echo $message;
								}
								?>
                            </div>
                            <img src="<?= wp_get_attachment_image_url( $product->get_image_id() ) ?>" alt=""
                                 id="uploaded-image">
                        </div>
                        <div class="col-lg-6">
                            <div class="photo-detail">
                                <div class="form-group">
                                    <label for="">Title</label>
                                    <input type="text" name="title" class="form-control"
                                           value="<?= $product->get_name() ?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="">Description</label>
                                    <textarea name="description"
                                              class="form-control"><?= $product->get_description() ?></textarea>
                                </div>

                                <div class="form-group">
                                    <h5>Price</h5>
                                    <p>If left empty default price would be Rs1000, Rs1500 & Rs2000 for small,medium and
                                        large photo respectively. </p>
                                    <div class="row">
                                        <div class="col">
                                            <label for="">Small</label>
                                            <input type="text" name="small_price" class="form-control"
                                                   value="<?= $small_product->get_price() ?>">
                                        </div>
                                        <div class="col">
                                            <label for="">Medium</label>
                                            <input type="text" name="medium_price" class="form-control"
                                                   value="<?= $medium_product->get_price() ?>">
                                        </div>
                                        <div class="col">
                                            <label for="">Large</label>
                                            <input type="text" name="large_price" class="form-control"
                                                   value="<?= $large_product->get_price() ?>">
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <p>Categories</p>
                                    <select name="categories[]" class="select2 form-control category-select" multiple
                                            style="width: 100%">
										<?php
										$categories = get_terms( 'product_cat', array(
											'hide_empty' => false,
										) );

										$product_categories = $product->get_category_ids();

										foreach ( $categories as $category ):
											?>
                                            <option value="<?= $category->term_id ?>"
												<?= ( in_array( $category->term_id, $product_categories ) ? "selected='selected'" : "" ) ?>><?= $category->name ?></option>
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
										$product_tags = $product->get_tag_ids();

										foreach ( $tags as $tag ):
											?>
                                            <option value="<?= $tag->term_id ?>"
												<?= ( in_array( $tag->term_id, $product_tags ) ? "selected='selected'" : "" ) ?>><?= $tag->name ?></option>
										<?php
										endforeach;
										?>
                                    </select>
                                    <a href="#" class="add-new-tag" title="Add new tag" data-toggle="modal"
                                       data-target="#addTagModal"><span
                                                class="icon-plus-square"></span></a>
                                </div>
								<?php wp_nonce_field( 'add_photograph', 'add_photograph_nonce' ); ?>
                                <input type="submit" value="Update" class="btn btn-primary">
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

get_footer();