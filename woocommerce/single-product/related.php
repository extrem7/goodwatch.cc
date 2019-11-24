<? if ( $related_products ) : ?>
    <div class="col-12 mt-5">
        <div class="title main-title line text-center"><? pll_e('Похожие товары') ?></div>
        <div class="owl-carousel owl-theme owl-catalog owl-custom-dot">
			<? foreach ( $related_products as $related_product ) {
				$post_object = get_post( $related_product->get_id() );
				setup_postdata( $GLOBALS['post'] =& $post_object );
				wc_get_template_part( 'content', 'product' );
			} ?>
        </div>
    </div>
<?php endif;
wp_reset_postdata();
