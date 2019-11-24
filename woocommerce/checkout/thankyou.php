<?php
/* @var $order WC_Order */
?>
    <a href="<? bloginfo( 'url' ) ?>" class="h-100 d-flex align-items-center justify-content-center">
        <img src="<?= path() ?>assets/img/thank-you.jpg" alt="thank-you" class="img-fluid">
    </a>
<? do_action( 'woocommerce_thankyou_' . $order->get_payment_method(), $order->get_id() ); ?>
<? do_action( 'woocommerce_thankyou', $order->get_id() ); ?>