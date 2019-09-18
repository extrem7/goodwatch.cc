<div class="row widget-block align-items-center">
    <div class="col-md-6"><?= do_shortcode('[instagram-feed]') ?></div>
    <div class="col-md-6 mt-3 mt-md-0">
        <div class="d-flex align-items-center justify-content-center">
			<? while ( have_rows( 'social', 16 ) ):the_row() ?>
                <a href="<? the_sub_field( 'link' ) ?>" target="_blank">
                    <i class="fab fa-<? the_sub_field( 'class' ) ?>"></i>
					<?= str_replace( 'https://', '', get_sub_field( 'link' ) ) ?>
                </a>
			<? endwhile; ?>
        </div>
    </div>
</div>