<?
$gallery = get_field( 'gallery' );
if ( ! empty( $gallery ) ): ?>
	<div class="product-additionally-gallery">
        <div class="d-flex align-items-center justify-content-center product-gallery-wrapper">
            <div class="gallery owl-additional-gallery owl-carousel">
                <? foreach ( $gallery as $img ): ?>
                    <div class="gallery-item">
                        <a class="gallery-item-thumb" data-fancybox="gallery-additional" href="<?= $img['sizes']['shop_single']  ?>">
                            <img src="<?= $img['sizes']['shop_single'] ?> " alt="gallery" class="img-fit">
                        </a>
                    </div>
                <? endforeach; ?>
            </div>
        </div>
	</div>
<? endif; ?>