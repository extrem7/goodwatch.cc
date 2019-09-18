<? /* Template Name: Город */ ?>
<? get_header();
global $isCity;
$isCity = true;
?>
    <main class="content container">
        <h1 class="text-center title main-title mb-4"><? the_title() ?></h1>
        <div class="row dynamic-content mb-3">
			<? while ( have_rows( 'blocks' ) ):the_row() ?>
                <div class="col-md-4 payment-item">
                    <i class="far fa-<? the_sub_field( 'icon' ) ?>"></i>
                    <div class="title base-title"><? the_sub_field( 'title' ) ?></div>
                    <div><? the_sub_field( 'text' ) ?></div>
                </div>
			<? endwhile; ?>
        </div>
		<? while ( have_rows( 'categories' ) ):the_row();
			$category = get_sub_field( 'category' );
			?>
            <div class="title medium-title mb-3"><?= $category->name ?></div>
            <div class="row catalog">
				<? foreach ( get_sub_field( 'products' ) as $post ) {
					global $product;
					$product = wc_get_product( $post );
					wc_get_template_part( 'content', 'product' );
				}
				wp_reset_query();
				?>
            </div>
            <div class="d-flex justify-content-center mt-4 mb-4">
                <a href="<?= get_term_link( $category ) ?>"
                   class="button btn-red b-lg"><? the_sub_field( 'button' ) ?> <i
                            class="fa fa-angle-double-right"></i></a>
            </div>
		<? endwhile; ?>
		<? if ( get_field( 'seo_text' ) ): ?>
            <div class="seo-text dynamic-content short-text"><? the_field( 'seo_text' ) ?></div>
            <div class="show-full-text text-right"><a href="#" class="link"><? pll_e( 'Читать полностью' ) ?>...</a>
            </div>
		<? endif; ?>
    </main>
<? get_footer() ?>