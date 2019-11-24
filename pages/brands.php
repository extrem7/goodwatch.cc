<? /* Template Name: Бренды */ ?>
<? get_header(); ?>
    <main class="content container">
        <div class="brand-list row">
			<? $brands = get_terms( 'pwb-brand' );
			foreach ( $brands as $brand ):
				$img = get_term_meta( $brand->term_id, 'pwb_brand_banner', true );
				if ( ! $img ) {
					continue;
				}
				?>
                <div class="col-xl-3 col-md-4 col-sm-6 brand-item">
                    <a href="<?= get_term_link( $brand ) ?>" class="title secondary-title"><?= $brand->name ?></a>
                    <div class="brand-image">
						<?= wp_get_attachment_image( $img, 'medium', false, [ 'class' => 'img-fluid' ] ); ?>
                    </div>
                    <div class="brand-short-text"><?= $brand->description ?></div>
                    <div class="text-right">
                        <a href="<?= get_term_link( $brand ) ?>" class="link">В каталог</a>
                    </div>
                </div>
			<? endforeach; ?>
        </div>
    </main>
<? get_footer() ?>