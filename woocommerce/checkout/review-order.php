<table class="sub-total woocommerce-checkout-review-order-table">
    <tr>
        <td><? pll_e('Всего товаров') ?></td>
        <td><? cart_content() ?> шт.</td>
    </tr>
    <tr>
        <td><? pll_e('На сумму') ?></td>
        <td><? wc_cart_totals_subtotal_html(); ?></td>
    </tr>
	<? $special = watch()->woo()->specialOfferDiscount();
	if ( $special ):
		?>
        <tr>
            <td><? pll_e('Спец. скидка') ?></td>
            <td><?= wc_price( $special ) ?></td>
        </tr>
	<? endif; ?>
	<? foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
        <tr class="cart-discount coupon-<?= esc_attr( sanitize_title( $code ) ); ?>">
            <th><? wc_cart_totals_coupon_label( $coupon ); ?></th>
            <td><? wc_cart_totals_coupon_html( $coupon ); ?></td>
        </tr>
	<? endforeach; ?>
    <tr>
        <td><? pll_e('Итоговая стоимость') ?></td>
        <td><span class="red-color"><? wc_cart_totals_order_total_html(); ?></span></td>
    </tr>
</table>