<? /* Template Name: О нас */ ?>
<? get_header(); ?>
    <main class="content container">
        <div class="row">
            <div class="col-md-6 dynamic-content">
				<? the_post_content() ?>
            </div>
            <div class="col-md-6 dynamic-content mt-3 mt-md-0">
				<? the_field( 'text' ); ?>
            </div>
            <div class="col-md-12 mt-5">
                <div class="title medium-title text-center mb-4 mt-2 mt-md-0"><? the_field( 'advantages_title' ) ?></div>
                <div class="row advantages">
					<? while ( have_rows( 'advantages' ) ):the_row() ?>
                        <div class="col-xl-3 col-sm-6 col-12 advantage">
                            <div>
                                <div class="title "><? the_sub_field( 'title' ) ?></div>
								<? the_sub_field( 'item' ) ?>
                            </div>
                        </div>
					<? endwhile; ?>
                </div>
            </div>
        </div>
        <div class="row about-gallery">
			<? foreach ( get_field( 'gallery' ) as $img ): ?>
                <div class="col-md-3 col-6">
                    <a href="<?= $img['sizes']['large'] ?>" data-fancybox="gallery" class="gallery-item">
                        <img src="<?= $img['sizes']['medium'] ?>" alt="<?= $img['alt'] ?>" title="<?= $img['title'] ?>"
                             class="img-fluid">
                    </a>
                </div>
			<? endforeach; ?>
        </div>
        <div class="number-advantages">
            <div class="title medium-title text-center mb-5 mt-2"><? the_field( 'numbers_title' ) ?></div>
            <div class="row">
				<? while ( have_rows( 'numbers' ) ):the_row() ?>
                    <div class="col-lg-4 col-sm-6 col-12">
                        <img <? repeater_image( 'icon' ) ?>>
						<? the_sub_field( 'text' ) ?>
                    </div>
				<? endwhile; ?>
            </div>
        </div>
        <div class="about-decorative-block">
            <div class="dynamic-content text-center"><? the_field( 'what_next' ) ?></div>
        </div>
        <div class="title medium-title text-center mb-4 mt-5"><? pll_e('Мы в социальных сетях') ?></div>
	    <? watch()->views()->social() ?>
    </main>
<? get_footer() ?>