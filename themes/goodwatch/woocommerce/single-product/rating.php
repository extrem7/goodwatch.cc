<?php

global $product;
$rating = $product->get_average_rating();
$count  = $product->get_review_count();
?>
<div class="rate" itemprop="aggregateRating" itemscope itemtype="http://schema.org/AggregateRating">
	<? if ( ! in_the_loop() ): ?>
		<span class="d-none" itemprop="ratingValue"><?= $rating ?></span>
	<? endif; ?>
	<div class="star-rate">
		<? the_rating( $rating ) ?>
	</div>
	<? if ( ! in_the_loop() ): ?>
		<span class="d-none" itemprop="reviewCount"><?= $count ?></span>
	<? endif; ?>
	<span class="rate-count">(<?= $count ?>)</span>
</div>
