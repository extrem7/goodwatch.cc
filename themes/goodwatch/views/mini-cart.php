<a href="<? cart_url() ?>" class="item cart-link <? cart_active() ?>">
	<? if ( ! is_cart() || !is_checkout() ): ?>
        <div class="widget_shopping_cart_content"><? woocommerce_mini_cart() ?></div>
	<? endif; ?>
    <i class="fas fa-shopping-basket"></i>
</a>