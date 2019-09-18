<div class="col-xl-8 col-12 last-article">
	<div class="box-info h-100">
		<div class="title main-title text-center mb-3"><? pll_e('Последнее в блоге') ?></div>
		<div class="row align-items-center">
			<?
			$last = new WP_Query( [ 'posts_per_page' => 3 ] );
			while ( $last->have_posts() ):$last->the_post();
				?>
				<div class="col-md-4">
					<article>
						<div class="article-header text-center">
							<? the_post_thumbnail( 'full', [ 'class' => 'img-fluid' ] ) ?>
						</div>
						<div class="article-body">
							<div class="title base-title"><? the_field( 'title' ) ?></div>
							<div class="small-size">
								<? the_field( 'text' ) ?>
							</div>
							<div class="text-right">
								<a href="<? the_permalink() ?>"
								   class="button btn-outline-black"><? pll_e('Читать') ?></a>
							</div>
						</div>
					</article>
				</div>
			<? endwhile; wp_reset_query() ?>
		</div>
	</div>
</div>