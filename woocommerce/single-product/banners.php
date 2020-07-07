<?
$banners = get_field( 'banners',   lang() );
if ( ! empty( $banners ) ):
	?>
	<div class="product-banner">
		<div class="box-info">
			<div class="main-title title text-center mb-3"><? pll_e('Прямые поставки товаров') ?></div>
			<div class="owl-carousel owl-theme owl-banner owl-custom-dot">
				<? foreach ( get_field( 'banners', lang()) as $img ): ?>
					<div class="item"><img src="<?= $img['url'] ?>" alt="<?= $img['alt'] ?>"></div>
				<? endforeach; ?>
			</div>
		</div>
	</div>
<? endif; ?>