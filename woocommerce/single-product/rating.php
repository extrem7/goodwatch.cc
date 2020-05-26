<?php

global $product;
$rating = $product->get_average_rating();
$count  = $product->get_review_count();
if($count == 0): $count = 1; endif;
?>
<div class="rate" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
	<? if ( ! in_the_loop() ): ?>
		<span class="d-none" itemprop="ratingValue"><?= $rating ?></span>
        <span class="d-none" itemprop="bestRating">5</span>
        <span class="d-none" itemprop="worstRating">0</span>
	<? endif; ?>
	<div class="star-rate">
		<? the_rating( $rating ) ?>
	</div>
	<? if ( ! in_the_loop() ): ?>
		<span class="d-none" itemprop="reviewCount"><?= $count ?></span>
	<? endif; ?>
	<span class="rate-count">(<?= $count ?>)</span>
</div>
