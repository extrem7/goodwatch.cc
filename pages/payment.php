<? /* Template Name: Оплата */ ?>
<? get_header(); ?>
    <main class="content container">
        <h1 class="text-center title medium-title mb-5"><? the_title() ?></h1>
        <div class="mb-4"><? the_post_content() ?></div>
        <div class="row dynamic-content">
	        <? while ( have_rows( 'methods' ) ):the_row() ?>
                <div class="col-md-4 payment-item">
                    <i class="far fa-<? the_sub_field( 'icon' ) ?>"></i>
                    <div class="title base-title"><? the_sub_field( 'title' ) ?></div>
                    <div><? the_sub_field( 'text' ) ?></div>
                </div>
	        <? endwhile; ?>
        </div>
        <div class="text-center title medium-title mb-4 mt-3">Доставка</div>
        <? the_table('shipping') ?>
        <? pll_cf7( 191, 334 ) ?>
    </main>
<? get_footer() ?>