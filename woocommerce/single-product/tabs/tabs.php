<?php
global $product;
?>
<div class="product-tab">
    <div class="wrapper-tab">
        <div class="wrapper-tab-contain">
            <ul class="nav nav-tabs">
                <li class="nav-item w-50 text-center">
                    <a class="active" id="guarantee" data-toggle="tab" href="#guarantee-tab"><? pll_e('Гарантия') ?></a>
                </li>
                <li class="nav-item w-50 text-center">
                    <a id="review" data-toggle="tab" href="#review-tab"><? pll_e('Отзывы') ?></a>
                </li>
            </ul>
            <div class="tab-content dynamic-content">
                <div class="tab-pane guarantee-tab ade active show" id="guarantee-tab" role="tabpanel">
					<? the_field( 'guarantee', lang() ) ?>
                    <div>
                        <a href="<? the_field( 'guarantee_page', 'option' ) ?>" target="_blank"
                           class="button btn-outline-black mt-4"><? pll_e('Подробнее') ?></a>
                    </div>
                </div>
                <div class="tab-pane review-tab fade" id="review-tab" role="tabpanel">
					<? wc_get_template( 'single-product-reviews.php' ) ?>
                </div>
            </div>
        </div>
        <div class="last-review">
            <!--
            <div class="d-flex align-items-center justify-content-between">
                <div class="medium-title title"><? pll_e('Последние отзывы') ?></div>
                <button class="button btn-outline-black" id="write-review"><? pll_e('Написать отзыв') ?></button>
            </div>
            -->

            <!--
			<? /*$comments = get_comments( [
				//'parent'  => 0,
				//'post_id' => get_the_ID(),
				//'status'  => 'approve',
				//'number'  => 2
			//] );
			if ( ! empty( $comments ) ):
				?>
                <ul class="reviews">
					<?
					global $comment;
					foreach ( $comments as $comment )
						wc_get_template( 'single-product/review.php', [ 'comment' => $comment ] ) ?>
                </ul>
			<? else: ?>
                <p class="woocommerce-noreviews"><? _e( 'There are no reviews yet.', 'woocommerce' ); ?></p>
			<? endif; */?>
            -->
            <div id="reviews" class="woocommerce-Reviews" style="display: block">
                <div id="review_form_wrapper">
                    <div id="review_form">
                        <div id="respond" class="comment-respond">
							<? wc_get_template_part( 'single-product/tabs/review-form' ) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>