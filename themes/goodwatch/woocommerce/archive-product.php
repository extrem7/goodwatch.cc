<? get_header(); ?>
    <main class="content container">
        <div class="row">
			<?// dynamic_sidebar('right-sidebar') ?>
			<?//= do_shortcode('[woof_products per_page=8 is_ajax=1]') ?>
			<? if ( ! is_search() ) {
				get_sidebar();
			} ?>
            <div class="col-12 <?= is_search() ?: 'col-lg-9' ?>">
                <div class="notices-area w-100"><? wc_print_notices() ?></div>
                <h1 class="woocommerce-products-header__title page-title title main-title mb-4">
					<?= is_search() ? wp_title( null, false ) : woocommerce_page_title( false ) ?>
                </h1>
				<? woocommerce_catalog_ordering() ?>
                <div class="row catalog">
					<?
					if ( wc_get_loop_prop( 'total' ) ) {
						while ( have_posts() ) {
							the_post();
							wc_get_template_part( 'content', 'product' );
						}
					} else {
						do_action( 'woocommerce_no_products_found' );
					} ?>
                </div>
				<? woocommerce_pagination() ?>
            </div>
        </div>
        <div class="seo-text dynamic-content short-text"><? the_field( 'seo_text', get_queried_object() ) ?></div>
		<? if ( get_field( 'seo_text', get_queried_object() ) ): ?>
            <div class="show-full-text text-right"><a href="#" class="link"><? pll_e( 'Читать полностью' ) ?>...</a>
            </div>
		<? endif; ?>

        <div style="display: none" itemscope itemtype="http://schema.org/Product">
            <p itemprop="Name"><?= get_queried_object()->name ?></p>
            <div itemtype="http://schema.org/AggregateOffer" itemscope="" itemprop="offers">
				<? global $wp_query;
				$all    = $wp_query->found_posts;
				$prices = WooFilters::minMaxPrice();
				$min    = $prices->min_price;
				$max    = $prices->max_price;
				?>
                <meta content="<?= $all ?>" itemprop="offerCount">
                <meta content="<?= $max ?>" itemprop="highPrice">
                <meta content="<?= $min ?>" itemprop="lowPrice">
                <meta content="UAH" itemprop="priceCurrency">
            </div>
        </div>
    </main>
<? get_footer();
