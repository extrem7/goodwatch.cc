<?php
global $post, $product;
$brands  = wp_get_post_terms( get_the_ID(), 'product_brand' );
if ( ! empty( $brands ) ):
	$brand = array_shift( $brands );
	$img = get_term_meta( $brand->term_id, 'pwb_brand_image', true ); ?>
    <a href="<?= get_term_link( $brand ) ?>" class="brand-logo d-flex justify-content-center mb-2">
		<?= wp_get_attachment_image( $img, 'full', false, [ 'class' => 'img-fluid' ] ); ?>
    </a>
<? endif; ?>