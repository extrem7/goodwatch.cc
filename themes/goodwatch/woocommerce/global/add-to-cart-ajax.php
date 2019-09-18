<? global $product ?>
<a rel="nofollow" href="<?= $product->add_to_cart_url() ?>" data-product_id="<? the_ID() ?>"
   class="button add-to-cart btn-red add_to_cart_button ajax_add_to_cart"><? pll_e('Купить') ?></a>
<div class="added_to_cart d-none"></div>