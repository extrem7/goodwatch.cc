<div>
	<h1 class="product-name" itemprop="name"><? watch()->woo()->trimTitle(get_the_title()); ?></h1>
    <div class="number">Код : <span itemprop="sku"><? the_sku() ?></span></div>
	<? $brand = get_terms( 'product_brand' )[0];
	if ( $brand ):?>
        <a class="d-none" itemprop="url" href="<?= get_term_link( $brand ) ?>" rel="nofollow">
            <span class="d-none" itemprop="brand"><?= $brand->name ?></span></a>
	<? endif; ?>
</div>