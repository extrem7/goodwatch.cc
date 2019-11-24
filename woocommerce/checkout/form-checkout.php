<?php
do_action( 'woocommerce_before_checkout_form', $checkout );

if ( ! $checkout->is_registration_enabled() && $checkout->is_registration_required() && ! is_user_logged_in() ) {
	echo esc_html( apply_filters( 'woocommerce_checkout_must_be_logged_in_message', __( 'You must be logged in to checkout.', 'woocommerce' ) ) );

	return;
}
?>
<form name="checkout" method="post" class="checkout woocommerce-checkout"
      action="<?= esc_url( wc_get_checkout_url() ); ?>" enctype="multipart/form-data">
    <div class="row checkout">
        <div class="col-xl-3 col-md-6">
            <div class="title small-title mb-4"><? pll_e('Ваши данные') ?></div>
			<?
			$fields = $checkout->get_checkout_fields( 'billing' );

			$mail = $fields['billing_email'];
			the_checkout_field( 'billing_email', $mail, $checkout, 'Email' );
			$name = $fields['billing_first_name'];
			the_checkout_field( 'billing_first_name', $name, $checkout, pll__('ФИО'));
			$phone = $fields['billing_phone'];
			the_checkout_field( 'billing_phone', $phone, $checkout, pll__('Номер телефона') );
			?>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="title small-title mb-4"><? pll_e('Доставка') ?></div>
            <div class="form-group">
                <select class="control-form custom-select" name="shipping">
					<? while ( have_rows( 'shipping' ) ):the_row() ?>
                        <option><? the_sub_field( 'method' ) ?></option>
					<? endwhile; ?>
                </select>
            </div>
			<?php
			$fields  = $checkout->get_checkout_fields( 'order' );
			$comment = $fields['order_comments'];
			the_checkout_field( 'order_comments', $comment, $checkout, pll__('Коментарий') ); ?>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="title small-title mb-4"><? pll_e('Оплата') ?></div>
            <div class="form-group">
                <select class="control-form custom-select" name="payment">
					<? while ( have_rows( 'payment' ) ):the_row() ?>
                        <option><? the_sub_field( 'method' ) ?></option>
					<? endwhile; ?>
                </select>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div id="order_review" class="subtotal woocommerce-checkout-review-order">
                <div class="title small-title mb-4"><? pll_e('Итоговая сумма') ?></div>
				<? do_action( 'woocommerce_checkout_order_review' ); ?>
            </div>
        </div>
    </div>
</form>
