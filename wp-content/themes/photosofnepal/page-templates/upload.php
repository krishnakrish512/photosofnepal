<?php
/**
 * Template Name: Upload Page
 */

get_header();


while ( have_posts() ):
	the_post();
	?>
    <main class="main">
        <section class="upload-section section-spacing">
            <div class="container upload-container">
                <div class="row">
                    <div class="col-lg-6 text-center">
                        <div class="upload-area">
                            <form action="" method="post" enctype="multipart/form-data">
                                <div class="upload-area__content">
                                    <i class="fas fa-cloud-upload-alt"></i>
                                    <h4>Upload Photos</h4>
                                    <!-- <a href="#" class="btn btn-primary">Select Photos</a> -->
                                    <div class="file-btn-area mx-auto">
                                        <input type="file" class="" value="Select Photos">
                                        <span class="btn btn-file btn-primary w-100">
                                        Upload Photos
                                    </span>
                                    </div>
                            </form>
                            <br>

                            <p class="mt-5">Or drag and drop photos anywhere on this page</p>
                        </div>
                    </div>
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
                </div>
            </div>
            </div>

        </section>
    </main>
<?php
endwhile;

get_footer();
