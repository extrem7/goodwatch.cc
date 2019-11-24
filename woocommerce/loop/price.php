<?php global $product; ?>
<div>
	<? if ( $product->is_on_sale() ): ?>
        <div class="product-old-price"><?= wc_price( $product->get_regular_price() ) ?></div>
	<? endif; ?>
    <div class="product-price"><?= wc_price( $product->get_price() ); ?></div>
</div>