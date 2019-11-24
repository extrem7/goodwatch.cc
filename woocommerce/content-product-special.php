<? global $product ?>
<div class="product-card">
    <div class="product-information">
        <a href="<? the_permalink() ?>" class="d-flex align-items-center">
			<? the_post_thumbnail( 'woocommerce_gallery_thumbnail', [ 'class' => 'img-fluid' ] )//size 100-125 ?>
            <div>
                <div class="product-name"><? the_title() ?></div>
				<? woocommerce_template_loop_rating() ?>
                <div class="product-code">Код товара: <? the_sku() ?></div>
                <div class="product-price"><?= wc_price( $special ? $product->get_meta( 'special_price' ) : $product->get_price() ); ?></div>
            </div>
        </a>
    </div>
</div>