<? /* Template Name: Гарантия */ ?>
<? get_header(); ?>
    <main class="content container">
        <h1 class="text-center title medium-title mb-5"><? pll_e( 'Гарантия качества' ) ?></h1>
        <div class="row dynamic-content">
			<? while ( have_rows( 'blocks' ) ):the_row() ?>
                <div class="col-md-4 guarantee-item">
                    <i class="far fa-<? the_sub_field( 'icon' ) ?>"></i>
                    <div class="title base-title"><? the_sub_field( 'title' ) ?></div>
                    <div><? the_sub_field( 'text' ) ?></div>
                </div>
			<? endwhile; ?>
        </div>
        <div class="row dynamic-content mt-5">
            <div class="col-md-12 col-lg-6">
				<? the_post_content() ?>
            </div>
            <div class="col-md-12 col-lg-6 mt-3 mt-lg-0">
                <div class="title base-title mb-3 text-center"><? pll_e( 'Обмен и возврат товара' ) ?></div>
                <p style="text-align: center"><? pll_e( 'Как обменять и вернуть товар?' ) ?></p>
                <div class="steps mt-4">
					<? while ( have_rows( 'steps' ) ):the_row() ?>
                        <div class="text-center">
                            <i class="fas fa-<? the_sub_field( 'icon' ) ?>"></i>
                            <div class="title base-title mb-2"><? pll_e( 'Шаг' ) ?> <? the_row_index() ?></div>
                            <div><? the_sub_field( 'text' ) ?></div>
                        </div>
					<? endwhile; ?>
                </div>
            </div>
        </div>
        <div class="row dynamic-content mt-5">
            <div class="col-md-12 col-lg-6">
                <div class="box-info">
                    <div class="red-color"><? pll_e( 'Заполните форму' ) ?></div>
                    <div class="title secondary-title mb-4"><? pll_e( 'Заявка на гарантийное обслуживание' ) ?></div>
					<? pll_cf7( 216, 332 ) ?>
                </div>
            </div>
            <div class="col-md-12 col-lg-6 mt-3 mt-lg-0">
				<? the_field( 'disclaimer' ) ?>
            </div>
        </div>
    </main>
<? get_footer() ?>