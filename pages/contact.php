<? /* Template Name: Контакты */ ?>
<? get_header(); ?>
    <main class="content container">
        <h1 class="text-center title medium-title mb-5"><? the_title() ?></h1>
        <div class="row contact-info">
            <div class="col-md-3 col-sm-6 text-center">
                <i class="fas fa-address-book"></i>
                <div class="title base-title text-center mt-3 mb-3"><? pll_e( 'Адрес' ) ?></div>
                    <? $address = get_field( 'address' ); ?>
                    <div><? echo $address; ?></div>
            </div>
            <div class="col-md-3 col-sm-6 text-center">
                <i class="fas fa-phone"></i>
                <div class="title base-title text-center mt-3 mb-3"><? pll_e( 'Телефоны' ) ?></div>
				<? while ( have_rows( 'phones' ) ):the_row();
					$phone = get_sub_field( 'phone' ) ?>
                    <a href="<?= tel( $phone ) ?>"><?= $phone ?></a>
				<? endwhile; ?>
            </div>
            <div class="col-md-3 col-sm-6 text-center">
                <i class="far fa-clock"></i>
                <div class="title base-title text-center mt-3 mb-3"><? pll_e( 'Время работы' ) ?></div>
				<? while ( have_rows( 'times' ) ):the_row(); ?>
                    <div><? the_sub_field( 'time' ) ?></div>
				<? endwhile; ?>
            </div>
            <div class="col-md-3 col-sm-6 text-center">
                <i class="far fa-comment-dots"></i>
                <div class="title base-title text-center mt-3 mb-3"><? pll_e( 'Мессенджеры' ) ?></div>
				<? while ( have_rows( 'messengers' ) ):the_row(); ?>
                    <a href="<? the_sub_field( 'link' ) ?>"><? the_sub_field( 'messenger' ) ?></a>
				<? endwhile; ?>
            </div>
        </div>
		<? watch()->views()->social() ?>
	    <? pll_cf7( 191, 334 ) ?>
    </main>
<? get_footer() ?>