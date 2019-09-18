<? /* Template Name: Главная */ ?>
<? get_header(); ?>
    <section class="banner container">
        <div class="banner-wrapper">
            <div class="owl-theme owl-carousel banner-slider owl-custom-dot">
				<? foreach ( get_field( 'banners' ) as $img ):
					?>
                    <a href="<?= $img['caption'] ?>" class="item"><img src="<?= $img['url'] ?>" alt="<?= $img['alt'] ?>"></a>
				<? endforeach; ?>
            </div>
        </div>
    </section>
    <main class="container">
        <section class="section-popular">
            <div class="title main-title text-center mb-4"><? pll_e('Популярное') ?></div>
            <div class="owl-carousel owl-theme owl-category mb-1">
				<? foreach ( get_field( 'popular' ) as $category ):
					$img = categoryImage( $category->term_id );
					?>
                    <div class="item">
                        <a href="<?= get_term_link( $category ) ?>" class="d-block text-center">
							<?= wp_get_attachment_image( $img, 'full',false,['class'=>'owl-lazy'] ); ?>
                            <div class="title base-title"><?= $category->name ?></div>
                        </a>
                    </div>
				<? endforeach; ?>
            </div>
        </section>
        <section class="box-info">
            <div class="owl-carousel owl-theme owl-catalog owl-custom-dot" id="last">
	            <? foreach ( get_field( 'new_products' ) as $post ):$product = wc_get_product( $post ) ?>
                    <div class="item">
			            <? wc_get_template_part( 'content', 'product' ); ?>
                    </div>
	            <? endforeach;
	            wp_reset_query() ?>
            </div>
        </section>
		<?
		$categories = get_field( 'category_banners' );
		if ( ! empty( $categories ) ):
			?>
            <section class="section-last-category">
                <div class="owl-carousel owl-theme owl-popular-category owl-custom-dot">
					<? foreach ( $categories as $img ): ?>
                        <div class="item">
                            <a href="<?= $img['caption'] ?>">
                                <img data-src="<?= $img['url'] ?>" class="transform-hover-img owl-lazy" alt="<?= $img['alt'] ?>">
                            </a>
                        </div>
					<? endforeach; ?>
                </div>
            </section>
		<? endif; ?>
        <section class="section-new mb-4">
            <div class="main-title title line text-center mb-4"><? pll_e('Новинки') ?></div>
            <div class="owl-carousel owl-theme owl-catalog owl-custom-dot" id="new">
				<? foreach ( get_field( 'new_products' ) as $post ):$product = wc_get_product( $post ) ?>
                    <div class="item">
						<? wc_get_template_part( 'content', 'product' ); ?>
                    </div>
				<? endforeach;
				wp_reset_query() ?>
            </div>
        </section>
        <section class="section-sale box-info">
            <div class="main-title title text-center mb-3"><? pll_e('Распродажа') ?></div>
            <div class="owl-carousel owl-theme owl-catalog owl-custom-dot">
				<? foreach ( get_field( 'sale_products' ) as $post ):$product = wc_get_product( $post ) ?>
                    <div class="item">
						<? wc_get_template_part( 'content', 'product' ); ?>
                    </div>
				<? endforeach;
				wp_reset_query() ?>
            </div>
        </section>
        <section class="section-brand">
            <div class="main-title title text-center mb-3"><? pll_e('Наши бренды') ?></div>
            <div class="owl-carousel owl-theme owl-brand">
				<? foreach ( get_field( 'brands' ) as $brand ):
					$img = get_term_meta( $brand->term_id, 'pwb_brand_image', true );
					?>
                    <div class="item">
                        <a href="<?= get_term_link( $brand ) ?>"><?= wp_get_attachment_image( $img, 'full',false,['class'=>'owl-lazy'] ); ?></a>
                    </div>
				<? endforeach; ?>
            </div>
        </section>
        <section class="section-shop-info">
            <div class="row">
                <div class="col-xl-4 col-12">
                    <div class="box-info h-100">
                        <div class="red-color"><? pll_e('Гарантия') ?></div>
                        <div class="title main-title"><? pll_e('Сертифицированные товары') ?></div>
                        <div class="mt-3"><? the_field( 'guarantee' ) ?></div>
                        <img src="<?= path() ?>assets/img/icons/garanty.svg" class="mt-3" alt="guarantee">
                    </div>
                </div>
				<? get_template_part( 'views/news' ) ?>
            </div>
        </section>
        <div class="seo-text dynamic-content"><? the_field( 'seo_text' ) ?></div>
    </main>
<? get_footer() ?>