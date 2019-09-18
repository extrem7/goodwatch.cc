<? get_header() ?>
    <main class="content container">
        <h1 class="text-center title medium-title mb-5"><? single_cat_title() ?></h1>
        <div class="articles">
			<?
			while ( have_posts() ) {
				the_post();
				get_template_part( 'views/blog' );
			}
			?>
            <div class="mt-2">
				<? watch()->pagination() ?>
            </div>
        </div>
    </main>
<? get_footer() ?>