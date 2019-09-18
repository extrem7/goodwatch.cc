<?php
wp_enqueue_script( 'tinvwl' );
?>
<div class="tinv-wishlist woocommerce tinv-wishlist-clear shop_table">
    <div class="notices-area w-100"><? wc_print_notices() ?></div>
    <form action="<?= esc_url( tinv_url_wishlist() ); ?>" method="post" autocomplete="off">
        <table class="tinvwl-table-manage-list">
            <thead>
            <tr>
                <th class="product-thumbnail"><? pll_e('Фото продукта') ?></th>
                <th class="">
                    <span class="tinvwl-full"><? esc_html_e( 'Product Name', 'ti-woocommerce-wishlist' ); ?></span>
                    <span class="tinvwl-mobile"><? esc_html_e( 'Product', 'ti-woocommerce-wishlist' ); ?></span></th>
                <th class="product-price"><? esc_html_e( 'Unit Price', 'ti-woocommerce-wishlist' ); ?></th>
                <th class="product-stock"><? pll_e('Статус') ?></th>
                <th class="product-action">&nbsp;</th>
                <th class="product-remove"></th>
            </tr>
            </thead>
            <tbody>
			<?
			foreach ( $products as $wl_product ) {
				$product = apply_filters( 'tinvwl_wishlist_item', $wl_product['data'] );
				unset( $wl_product['data'] );
				if ( $wl_product['quantity'] > 0 && apply_filters( 'tinvwl_wishlist_item_visible', true, $wl_product, $product ) ) {
					$product_url = apply_filters( 'tinvwl_wishlist_item_url', $product->get_permalink(), $wl_product, $product );
					do_action( 'tinvwl_wishlist_row_before', $wl_product, $product );
					?>
                    <tr class="<?= esc_attr( apply_filters( 'tinvwl_wishlist_item_class', 'wishlist_item', $wl_product, $product ) ); ?>">
                        <td class="product-thumbnail">
                            <a href="<?= $product_url ?>" class="photo d-block" target="_blank"
                               style="background-image: url('<?= wp_get_attachment_image_url( $product->get_image_id(), 'woocommerce_gallery_thumbnail' ) ?>')"></a>
                        </td>
                        <td class="product-name">
                            <a class="red-color" href="<?= $product_url ?>"><?= $product->get_name() ?></a>
                            <span class="articul">Код: <?= $product->get_sku() ?></span>
                        </td>
                        <td class="product-price">
							<?
							echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $product ), $wl_product, $product );
							?>
                        </td>
                        <td class="product-stock">
							<?
							$availability = (array) $product->get_availability();
							if ( ! array_key_exists( 'availability', $availability ) ) {
								$availability['availability'] = '';
							}
							if ( ! array_key_exists( 'class', $availability ) ) {
								$availability['class'] = '';
							}
							$availability_html = empty( $availability['availability'] ) ? '<p class="status ' . esc_attr( $availability['class'] ) . '"><span></span><span class="tinvwl-txt">' . esc_html__( 'In stock', 'ti-woocommerce-wishlist' ) . '</span></p>' : '<p class="status ' . esc_attr( $availability['class'] ) . '"><span></span><span>' . esc_html( $availability['availability'] ) . '</span></p>';

							echo apply_filters( 'tinvwl_wishlist_item_status', $availability_html, $availability['availability'], $wl_product, $product );
							?>
                        </td>
                        <td class="product-action">
							<? if ( empty( $availability['availability'] ) ): ?>
                                <a rel="nofollow" href="<?= $product->add_to_cart_url() ?>"
                                   data-id="<?= $product->get_id() ?>"
                                   data-quantity="1"
                                   data-product_id="<?= $product->get_id() ?>"
                                   data-product_sku="<?= $product->get_sku() ?>"
                                   class="button add-to-cart button btn-red add_to_cart_button ajax_add_to_cart"><? pll_e('Купить') ?></a>
							<?endif; ?>
                            <div class="added_to_cart d-none"></div>
                        </td>
                        <td class="product-remove">
                            <button type="submit" name="tinvwl-remove"
                                    value="<?= esc_attr( $wl_product['ID'] ); ?>"
                                    title="<? _e( 'Remove', 'ti-woocommerce-wishlist' ) ?>"><i
                                        class="ftinvwl ftinvwl-times"></i>
                            </button>
                        </td>
                    </tr>
					<?
					do_action( 'tinvwl_wishlist_row_after', $wl_product, $product );
				}
			}
			?>
            </tbody>
            <tfoot class="d-none">
            <tr>
                <td colspan="100">
					<? do_action( 'tinvwl_after_wishlist_table', $wishlist ); ?>
					<? wp_nonce_field( 'tinvwl_wishlist_owner', 'wishlist_nonce' ); ?>
                </td>
            </tr>
            </tfoot>
        </table>
    </form>
</div>
