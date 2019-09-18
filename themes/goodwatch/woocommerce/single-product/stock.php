<?
global $product;
$availability = $product->get_availability();
$class = esc_attr($availability['class']);
$availability = $availability['availability'] ?:  pll__('Есть в наличии');
?>
<div class="status <?= $class ?>"><?= $availability ?></div>