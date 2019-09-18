<?
global $product;
if ( ! $product->is_in_stock() )
	return ?>
<div>
	<? wc_get_template_part('global/add-to-cart-ajax') ?>
    <? wc_get_template_part('global/buy-one-click') ?>
</div>