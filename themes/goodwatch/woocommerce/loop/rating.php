<?php

global $product;
$rating = $product->get_average_rating();
$count  = $product->get_review_count();
?>
<div class="rate">
    <div class="star-rate">
		<? the_rating( $rating ) ?>
    </div>
    <span class="rate-count">(<?= $count ?>)</span>
</div>
