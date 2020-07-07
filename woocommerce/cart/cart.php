<form class="woocommerce-cart-form" action="<?= esc_url( wc_get_cart_url() ); ?>" method="post">
    <table class="shop_table shop_table_responsive cart woocommerce-cart-form__contents w-100">
        <thead>
        <tr>
            <th><? pll_e('Фото продукта') ?></th>
            <th><? pll_e('Название') ?></th>
            <th class="text-center"><? pll_e('Стоимость') ?></th>
            <th class="text-center"><? pll_e('Количество') ?></th>
            <th><? pll_e('Итоговая стоимость') ?></th>
            <th></th>
        </tr>
        </thead>
        <tbody>
		<?
		foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) {
			$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
			$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );
//var_dump($cart_item['offerTo']);
//var_dump($cart_item['key']);
//echo "<br>";
			if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) ) {
				$product_permalink = apply_filters( 'woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink( $cart_item ) : '', $cart_item, $cart_item_key );
				?>
                <tr class="woocommerce-cart-form__cart-item <?= esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">
                    <td class="product-thumbnail">
                        <a href="<?= $product_permalink ?>" class="photo d-block" target="_blank"
                           style="background-image: url('<?= wp_get_attachment_image_url( $_product->get_image_id(), 'woocommerce_gallery_thumbnail' ) ?>')"></a>
                    </td>
                    <td class="product-name" data-title="<?php esc_attr_e( 'Product', 'woocommerce' ); ?>">
						<?= $_product->get_name() ?>
                        <span class="articul">Код: <?= $_product->get_sku() ?></span>
                    </td>
                    <td class="product-price" data-title="<?php esc_attr_e( 'Price', 'woocommerce' ); ?>">
						<?php
						echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
                        if ( $cart_item['data']->price !== wc_get_product($product_id)->get_price() )
							echo '<br>Special offer'
						?>
                    </td>
                    <td class="product-qty" data-title="<?php esc_attr_e( 'Quantity', 'woocommerce' ); ?>">
						<?php
						if ( $_product->is_sold_individually() ) {
							$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
						} else {
							$product_quantity = woocommerce_quantity_input( array(
								'input_name'   => "cart[{$cart_item_key}][qty]",
								'input_value'  => $cart_item['quantity'],
								'max_value'    => $_product->get_max_purchase_quantity(),
								'min_value'    => '0',
								'product_name' => $_product->get_name(),
							), $_product, false );
						}

						echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item ); // PHPCS: XSS ok.
						?>
                    </td>
                    <td class="product-subtotal" data-title="<?php esc_attr_e( 'Total', 'woocommerce' ); ?>">
						<?php
						echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key ); // PHPCS: XSS ok.
						?>
                    </td>
                    <td class="product-remove">
						<?php
						// @codingStandardsIgnoreLine
						echo apply_filters( 'woocommerce_cart_item_remove_link', sprintf(
							'<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s">&times;</a>',
							esc_url( wc_get_cart_remove_url( $cart_item_key ) ),
							__( 'Remove this item', 'woocommerce' ),
							esc_attr( $product_id ),
							esc_attr( $_product->get_sku() )
						), $cart_item_key );
						?>
                    </td>
                </tr>
				<?php
			}
		}
		?>
        <tr class="d-none">
            <td colspan="6" class="actions">
                <button type="submit" class="button" name="update_cart"
                        value="<?php esc_attr_e( 'Update cart', 'woocommerce' ); ?>"><?php esc_html_e( 'Update cart', 'woocommerce' ); ?></button>
				<?php do_action( 'woocommerce_cart_actions' ); ?>
				<?php wp_nonce_field( 'woocommerce-cart', 'woocommerce-cart-nonce' ); ?>
            </td>
        </tr>
        </tbody>
    </table>
    <div class="actions d-flex align-items-center flex-column flex-md-row justify-content-between">
        <a href="<? shop_url() ?>" class="button btn-outline-black mb-4 mb-md-0"><? pll_e('Продолжить покупки') ?></a>
		<?php if ( wc_coupons_enabled() ) { ?>
            <div class="coupon d-flex flex-column flex-sm-row">
                <input
                        type="text" name="coupon_code" class="input-text control-form mr-3 mb-2 mb-md-0" id="coupon_code" value=""
                        placeholder="<?php esc_attr_e( 'Coupon code', 'woocommerce' ); ?>"/>
                <button type="submit" class="button btn-outline-black" name="apply_coupon"
                        value="<?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?>"><?php esc_attr_e( 'Apply coupon', 'woocommerce' ); ?></button>
				<?php do_action( 'woocommerce_cart_coupon' ); ?>
            </div>
		<?php } ?>
    </div>
</form>
<div class="cart-collaterals d-none">
	<?php
	/**
	 * Cart collaterals hook.
	 *
	 * @hooked woocommerce_cross_sell_display
	 * @hooked woocommerce_cart_totals - 10
	 */
	do_action( 'woocommerce_cart_collaterals' );
	?>
</div>

