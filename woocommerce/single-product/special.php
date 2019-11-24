<?
global $product, $special;

$mainPrice = $product->get_price();

$special = watch()->woo()->specialProduct( get_the_ID() );
if (!$special || $special == $post->ID || watch()->woo()->specialOfferDiscount()) {
	return;
}
?>
<div class="col-12 special-product">
    <div class="title main-title text-center mb-3"><? pll_e('Специальное предложение') ?></div>
    <div class="box-info">
        <form method="post" class="special-wrapper">
			<? wc_get_template_part( 'content', 'product-special' ); ?>
            <span class="special-add">+</span>
			<?
			$post    = get_post( $special );
			$product = wc_get_product( $special );
			wc_get_template( 'content-product-special.php', [ 'special' => true ] );

			$specialPrice = $product->get_meta( 'special_price' );
			$sum          = $mainPrice + $specialPrice;
			$economy      = $product->get_price() - $specialPrice;
			?>
            <span class="special-add">=</span>
            <div class="text-center special-price">
				<?= wc_price( $sum ) ?>
                <button class="button btn-red add-to-cart"><? pll_e('Купить') ?></button>
                <p><? pll_e('Вы экономите') ?>: <?= wc_price( $economy ) ?></p>
            </div>
            <input type="hidden" name="action" value="special">
			<? wp_reset_query(); ?>
        </form>
    </div>
</div>