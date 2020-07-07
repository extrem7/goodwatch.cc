<?php

global $product, $post, $nails;

if ( ! comments_open() ) {
	return;
}

$comments = get_comments( [
	'parent'  => 0,
	'post_id' => get_the_ID(),
	'status'  => 'approve'
] );
?>
    <h2 class="woocommerce-Reviews-title"><?
		if ( get_option( 'woocommerce_enable_review_rating' ) === 'yes' && ( $count = $product->get_review_count() ) ) {
			printf( esc_html( _n( '%1$s review for %2$s', '%1$s reviews for %2$s', $count, 'woocommerce' ) ), esc_html( $count ), '<span>' . get_the_title() . '</span>' );
		} else {
			_e( 'Reviews', 'woocommerce' );
		}
		?></h2>
    <ul class="reviews">
<? if ( ! empty( $comments ) ) :
	for ( $c = 0; $c < count( $comments ); $c ++ ) {
		global $comment;
		$comment = $comments[ $c ];
		wc_get_template( 'single-product/review.php', [ 'number' => $c ] );
	}
	?>
    </ul>
	<? if ( count( $comments ) > 2 ): ?>
    <a href="#" class="button btn-outline-black comments-load"><? pll_e('Загрузить еще') ?></a><? endif; ?>
<? else : ?>
    <p class="woocommerce-noreviews"><? _e( 'There are no reviews yet.', 'woocommerce' ); ?></p>
<? endif; ?>