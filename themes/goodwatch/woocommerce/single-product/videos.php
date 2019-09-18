<? if ( have_rows( 'videos' ) ): ?>
    <div class="col-12 product-video">
		<? while ( have_rows( 'videos' ) ):the_row();
			$embed = preg_replace( "/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i", '$1', get_sub_field( 'youtube' ) );
			$url   = 'https://www.youtube.com/embed/' . $embed;
			$img   = "https://img.youtube.com/vi/$embed/sddefault.jpg";
			?>
            <div class="embed-responsive embed-responsive-16by9 youtube"
                 style="background-image:url('<?= $img ?>');">
                <div class="play-button"></div>
                <iframe data-src="<?= $url ?>" class="embed-responsive-item" style="display: none"
                        allowfullscreen></iframe>
            </div>
		<? endwhile; ?>
    </div>
<? endif; ?>