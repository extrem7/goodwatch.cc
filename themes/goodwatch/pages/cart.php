<? /* Template Name: Корзина */ ?>
<? get_header(); ?>
    <main class="content container">
		<?
		if ( is_wishlist() ):the_post_content();
		else:
			if ( ! is_order_received_page() ): ?>
                <h1 class="title medium-title"><? the_title() ?></h1>
				<?= do_shortcode( '[woocommerce_cart]' ) ?>
			<? endif;
			echo do_shortcode( '[woocommerce_checkout]' );
		endif;
		?>
    </main>
<? get_footer() ?>