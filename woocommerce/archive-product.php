<? get_header(); ?>
    <main class="content container">
        <div class="row">
            <? if (!is_search()) {
                get_sidebar();
            } ?>
            <div class="col-12 <?= is_search() ?: 'col-lg-9' ?>">
                <div class="notices-area w-100"><? wc_print_notices() ?></div>
                <div class="premmerce-filter-ajax-container">
                    <?php do_action('woocommerce_before_shop_loop'); ?>
                    <div class="row catalog">
                        <?
                        if (wc_get_loop_prop('total')) {
                            while (have_posts()) {
                                the_post();
                                wc_get_template_part('content', 'product');
                            }
                        } else {
                            do_action('woocommerce_no_products_found');
                        } ?>
                    </div>
                    <?php do_action('woocommerce_after_shop_loop'); ?>
                </div>
            </div>
        </div>
		<?php
			$category = get_queried_object();
			$cat_id = get_term($category->term_id);
		    $slug = $cat_id->slug;
			$products = wc_get_products( array( 'status' => 'publish', 'category' => $slug, 'posts_per_page' => 5 ) );
			if($products):
		?>
		<div class="dynamic-content">
			<h3><?php pll_e('Цены'); ?> на <?php woocommerce_page_title(); ?></h3>
		</div>
		<div class="table-responsive mt-3">
			<table class="table table-striped">
				<tr>
					<th><?php pll_e('Товар'); ?></th>
					<th><?php pll_e('Цена'); ?></th>
				</tr>
				<?php foreach ( $products as $product ):?>
				<tr>
					<td><?php echo $product->get_title(); ?></td>
					<td><?php echo $product->get_price(); ?></td>
				</tr>
				<? endforeach; ?>
			</table>
		</div>
		<?php endif; ?>
        <div style="display: none" itemscope itemtype="http://schema.org/Product">
            <p itemprop="Name"><?= get_queried_object()->name ?></p>
            <div itemtype="http://schema.org/AggregateOffer" itemscope="" itemprop="offers">
                <? global $wp_query;
                $all = $wp_query->found_posts;
                $prices = watch()->woo()->minMaxPrice();
                $min = $prices->min_price;
                $max = $prices->max_price;
                ?>
                <meta content="<?= $all ?>" itemprop="offerCount">
                <meta content="<?= $max ?>" itemprop="highPrice">
                <meta content="<?= $min ?>" itemprop="lowPrice">
                <meta content="UAH" itemprop="priceCurrency">
            </div>
        </div>
    </main>
<? get_footer();