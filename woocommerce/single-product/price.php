<?php global $product; ?>
<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
    <span class="d-none" itemprop="priceCurrency" content="UAH">грн.</span>
    <link class="d-none" itemprop="availability" href="http://schema.org/InStock" />
    <link class="d-none" itemprop="url" href="<?= get_page_link(); ?>"/>
    <div class="product-price" itemprop="price" content="<?= $product->get_price() ?>"><?= wc_price( $product->get_price() ); ?></div>
	<? if ( $product->is_on_sale() ): ?>
        <div class="product-old-price"><?= wc_price( $product->get_regular_price() ) ?></div>
	<? endif; ?>
</div>