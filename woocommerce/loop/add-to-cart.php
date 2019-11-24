<?php

global $product, $special;

$inStock = $product->is_in_stock();
?>
<div>
    <? if ($inStock && !$special)
        wc_get_template_part('global/buy-one-click') ?>
    <div class="d-flex align-items-center">
        <div class="add-to-wishlist"> <? if (!is_wishlist()) {
                echo str_replace('tinvwl-icon-heart', '', do_shortcode('[ti_wishlists_addtowishlist]'));
            } ?></div>
        <? if ($inStock && !$special)
            wc_get_template_part('global/add-to-cart-ajax') ?>
    </div>
</div>
