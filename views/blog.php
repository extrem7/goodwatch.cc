<a href="<? the_permalink() ?>" class="article-item">
	<? the_post_thumbnail() ?>
    <div class="article-description">
        <div class="title base-title"><? the_title() ?></div>
        <div class="article-date"><?= get_the_date( 'd-m-Y' ) ?></div>
		<? if ( has_excerpt() ): ?>
            <div><? the_excerpt() ?></div><? endif; ?>
    </div>
</a>