<? $order_button_text = 'Оформить покупки' ?>
<div id="payment" class="woocommerce-checkout-payment">
	<?php if ( WC()->cart->needs_payment() ) : ?>
        <ul class="wc_payment_methods payment_methods methods d-none">
			<?php
			if ( ! empty( $available_gateways ) ) {
				foreach ( $available_gateways as $gateway ) {
					wc_get_template( 'checkout/payment-method.php', array( 'gateway' => $gateway ) );
				}
			} else {
				echo '<li class="woocommerce-notice woocommerce-notice--info woocommerce-info">' . apply_filters( 'woocommerce_no_available_payment_methods_message', WC()->customer->get_billing_country() ? esc_html__( 'Sorry, it seems that there are no available payment methods for your state. Please contact us if you require assistance or wish to make alternate arrangements.', 'woocommerce' ) : esc_html__( 'Please fill in your details above to see available payment methods.', 'woocommerce' ) ) . '</li>'; // @codingStandardsIgnoreLine
			}
			?>
        </ul>
	<?php endif; ?>
    <div class="form-row place-order">
        <div class="text-center text-md-left">
			<?php echo apply_filters( 'woocommerce_order_button_html', '<button type="submit" class="button alt button btn-red mt-4" name="woocommerce_checkout_place_order" id="place_order" value="' . esc_attr( $order_button_text ) . '" data-value="' . esc_attr( $order_button_text ) . '">' . esc_html( $order_button_text ) . '</button>' ); // @codingStandardsIgnoreLine ?>
        </div>

		<?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>
    </div>
</div>
<?php
if ( ! is_ajax() ) {
	do_action( 'woocommerce_review_order_after_payment' );
}
