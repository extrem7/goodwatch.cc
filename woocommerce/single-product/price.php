<?php global $product; ?>
<div itemprop="offers" itemscope itemtype="http://schema.org/Offer">
    <span class="d-none" itemprop="priceCurrency" content="UAH">грн.</span>
    <link class="d-none" itemprop="availability" href="http://schema.org/InStock" />
    <link class="d-none" itemprop="url" href="<?= get_page_link(); ?>"/>
    <div class="d-flex align-items-center mb-3 mb-xl-0">
        <? if ( $product->is_on_sale() ): ?>
            <div class="product-old-price">
                <span class="label-price"><? pll_e('Старая цена'); ?></span>
                <?= wc_price( $product->get_regular_price() ) ?>
            </div>
        <? endif; ?>
        <div class="product-price" itemprop="price" content="<?= $product->get_price() ?>"><?= wc_price( $product->get_price() ); ?></div>
    </div>
</div>