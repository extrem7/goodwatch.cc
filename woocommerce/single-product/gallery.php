<?
$gallery = get_field( 'gallery' );
if ( ! empty( $gallery ) ): ?>
	<div class="col-12 product-additionally-gallery">
		<div class="gallery">
			<div class="main-photo" style="background-image: url('<?= $gallery[0]['sizes']['shop_single'] ?>');cursor: pointer" data-gallery="<? the_post_thumbnail_url() ?>"></div>
			<div class="thumbnails">
				<? foreach ( $gallery as $img ): ?>
					<div class="item">
						<a class="thumbnail" data-fancybox="gallery-additional" style="background-image: url('<?= $img['sizes']['medium'] ?>');display: block" href="<?= $img['sizes']['shop_single']  ?>"></a>
					</div>
				<? endforeach; ?>
			</div>
		</div>
	</div>
<? endif; ?>