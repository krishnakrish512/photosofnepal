<?php
/*
Template Name: Dashain Offer
*/

get_header();
while (have_posts()):
    the_post();
    ?>
    <section class="blog-page-title section-spacing">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <h3>Dashain Offer</h3>
            </div>
            <div class="col-lg-5">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="http://localhost/photosofnepal">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Dashain Offer</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
</section>
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <div class="col-lg-5 mb-5 mb-lg-0">
                <h2>Happy Dashain</h2>
                <p class="lead">We are collecting the free images for you, we will get back you soon.</p>
                <a href="http://localhost/photosofnepal/" class="btn btn-primary">Shop Now</a>
            </div>
            <div class="col-lg-6 mt-5 mt-lg-0">
                <ul class="photo-grid">
                    <li>
                        <span>
                            <img src="http://localhost/photosofnepal/wp-content/uploads/2021/05/Dashain-festival-swing-1.jpg" alt="Dashain festival - swing">
                        </span>
                    </li>
                    <li>
                        <span>
                            <img src="http://localhost/photosofnepal/wp-content/uploads/2021/01/Bardia-2017-1-scaled-23.jpg" alt="Bardia, Nepal">
                        </span>
                    </li>
                    <li>
                </ul>
            </div>
        </div>
    </div>
<?php
endwhile;

get_footer();