<?php
$cta = get_sub_field( 'link' );
?>
<section class="info-bar bg-gray py-4 section-spacing">
    <p class="mb-0 text-center">
		<?php the_sub_field( 'description' ); ?>
        <a href="<?= $cta['url'] ?>" class="btn btn-primary ml-2"><?= $cta['label'] ?></a>
    </p>
</section>