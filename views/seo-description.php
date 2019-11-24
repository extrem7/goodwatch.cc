<?php
$term = get_queried_object();

ob_start();
do_action('woocommerce_archive_description');
$ruleDescription = ob_get_contents();
$ruleDescription = substr(substr($ruleDescription, 30), 0, -6);
ob_end_clean();
$ruleUnique = !in_array(null, [$term->description, $ruleDescription]) && (strpos(substr($term->description, 0, 5),
            substr(strip_tags($ruleDescription), 0, 5)) === false);

$seoDescription = is_filtered() && $ruleUnique && $ruleDescription ? $ruleDescription : get_field('seo_text', $term);
?>
    <div class="seo-text dynamic-content short-text"><?= $seoDescription ?></div>
<? if ($seoDescription): ?>
    <div class="show-full-text text-right"><a href="#" class="link"><? pll_e('Читать полностью') ?>...</a>
    </div>
<? endif; ?>