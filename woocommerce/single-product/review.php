<?
global $comment;
$hidden = isset( $number ) && $number >= 2;
$class  = 'comment' . ( $hidden ? ' hidden' : '' );
?>
<li <? comment_class( $class, $comment ); ?> id="li-comment-<? comment_ID() ?>"
                                             style="display: <?= $hidden ? 'none' : 'block' ?>" itemscope itemtype="http://schema.org/Review">
    <span class="d-none" itemprop="itemReviewed"><? the_title() ?></span>
    <div class="name" itemprop="author"><? comment_author() ?></div>
    <div class="rate mt-1 mb-1" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
        <div class="star-rate">
            <? $rating = intval( get_comment_meta( $comment->comment_ID, 'rating', true ) );
			 the_rating( $rating ) ?>
            <span class="d-none" itemprop="ratingValue"><?= $rating ?></span>
        </div>
    </div>
    <div class="date" itemprop="datePublished" content="<? comment_date( 'Y-m-d' ) ?>"><? comment_date( 'd F Y' ) ?></div>
    <div class="comment-content" itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
        <meta itemprop="name" content="GoodWatch">
        <div class="text" itemprop="description"><? comment_text()?></div>
        <div class="row">
            <div class="col-md-12 col-xl-3">
                <div class="bold"><? pll_e('Достоинства') ?>:</div>
            </div>
            <div class="col-md-12 col-xl-9"><? the_field( 'disadvantages', $comment ) ?></div>
            <div class="col-md-12 col-xl-3">
                <div class="bold"><? pll_e('Недостатки') ?>:</div>
            </div>
            <div class="col-md-12 col-xl-9"><? the_field( 'advantages', $comment ) ?>
            </div>
        </div>
    </div>
</li>