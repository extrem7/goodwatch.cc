<?php

global $product;

$attachment_ids = $product->get_gallery_image_ids();
$main_id        = get_post_thumbnail_id();

if ( in_array( $main_id, $attachment_ids ) ) {
	unset( $attachment_ids[ array_search( $main_id, $attachment_ids ) ] );
}
array_unshift( $attachment_ids, $main_id );

if ( $attachment_ids && $product->get_image_id() ):?>
    <div class="thumbnails">
		<?
		$active  = 'active';
		foreach ( $attachment_ids as $attachment_id ):
			$image = wp_get_attachment_image_url( $attachment_id, 'thumbnail' );
			$big = wp_get_attachment_image_url( $attachment_id, 'shop_single' );
			?>
            <div class="item">
                <a class="thumbnail <?= $active ?>" style="background-image: url('<?= $image ?>')"
                   data-fancybox="gallery" href="<?= $big ?>"></a>
            </div>
			<? $active = ''; endforeach; ?>
    </div>
<? endif; ?>
