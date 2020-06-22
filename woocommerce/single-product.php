<?php

global $product;
$product = wc_get_product( $post );


get_header(); ?>
    <main class="content container">
        <div class="row product" itemscope itemtype="http://schema.org/Product">
            <div class="col-md-12 col-lg-7 product-gallery">
                <div class="gallery">
					<? woocommerce_show_product_thumbnails() ?>
					<? woocommerce_show_product_images() ?>
                </div>
            </div>
            <div class="col-md-12 col-lg-5">
                <div class="product-info">
                    <div class="d-flex justify-content-between mb-3">
						<? woocommerce_template_single_title() ?>
                        <div class="d-flex flex-column align-items-center">
	                        <? wc_get_template_part( 'single-product/brand' ) ?>
							<? wc_get_template_part( 'single-product/stock' ) ?>
							<? wc_get_template_part( 'single-product/rating' ) ?>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between">
						<? woocommerce_template_single_price() ?>
						<? woocommerce_simple_add_to_cart() ?>
                    </div>
                    <div class="separator mt-3 mb-3"></div>
					<? wc_get_template_part( 'single-product/short-description' ) ?>
                    <? if ( $product->is_on_sale() ): ?>
                    <div class="timer">
                        <div class="title red-color main-title text-center mb-3">До конца акции осталось</div>
                        <script src="https://megatimer.ru/get/8d336442e3c5984b57655d6ad122c03a.js"></script>
                    </div>
                    <? endif; ?>
                    <div class="separator mt-3 mb-3"></div>
                    <div class="product-delivery-payment">
						<? while ( have_rows( 'details', lang() ) ):the_row() ?>
                            <div class="d-flex align-items-start">
                                <div class="bold"><? the_sub_field( 'title' ) ?></div>
                                <div><? the_sub_field( 'text' ) ?></div>
                            </div>
						<? endwhile; ?>
                    </div>
                </div>
            </div>
			<? woocommerce_output_related_products() ?>
			<? wc_get_template_part( 'single-product/special' ) ?>
			<? woocommerce_output_product_data_tabs() ?>
			<? wc_get_template_part( 'single-product/videos' ) ?>
			<? wc_get_template_part( 'single-product/gallery' ) ?>
			<? wc_get_template_part( 'single-product/banners' ) ?>
        </div>
    </main>
<? get_footer();