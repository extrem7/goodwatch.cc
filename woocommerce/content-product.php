<?php

global $product, $isCity;

$product = new WC_Product( $product );

if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$title = get_the_title();

$isLoop = in_the_loop();
echo $isLoop ? '<div class="col-sm-6 col-xl-4">' : '';
echo $isCity ? '<div class="col-sm-6 col-lg-4">' : '';
?>
    <div <? wc_product_class( 'product-card' ); ?>>
        <a href="<? the_permalink() ?>" class="product-thumbnail">
			<? woocommerce_show_product_loop_sale_flash() ?>
			<? if ( $product->get_meta( 'label_new' ) ): ?>
                <span class="label-product new text-uppercase">NEW</span>
			<? endif; ?>
			<? if ( $product->is_featured() ): ?>
                <span class="label-product top text-uppercase">TOП</span>
			<? endif; ?>
            <img data-src="<?= get_the_post_thumbnail_url(null,'medium') ?>" alt="<?= $title ?>" title="<?= $title ?>"  class="img-fluid owl-lazy">
        </a>
        <div class="product-information">
            <a href="<? the_permalink() ?>" class="product-name"><? watch()->woo()->trimTitle(get_the_title()); ?></a>
			<? woocommerce_template_loop_rating() ?>
            <div class="product-code">Код: <? the_sku() ?></div>
            <div class="d-flex align-items-end justify-content-between product-action">
				<? woocommerce_template_loop_price() ?>
				<? woocommerce_template_loop_add_to_cart() ?>
            </div>
        </div>
    </div>
<?= $isLoop || $isCity ? '</div>' : '' ?>