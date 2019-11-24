<div class="gallery-wrapper">
    <div class="add-to-wishlist"><?= do_shortcode( '[ti_wishlists_addtowishlist]' ); ?></div>
    <div class="main-photo" style="background-image: url('<? the_post_thumbnail_url('shop_single') ?>');cursor: pointer"
         data-gallery="<? the_post_thumbnail_url('shop_single') ?>"></div>
    <img class="d-none" itemprop="image" src="<? the_post_thumbnail_url() ?>" />
</div>