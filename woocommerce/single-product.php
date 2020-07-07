<?php

global $product;
$product = wc_get_product( $post );

get_header(); ?>
    <main class="content container">
        <div class="notices-area w-100"><? wc_print_notices() ?></div>
        <div class="product" itemscope itemtype="http://schema.org/Product">
        <div class="product-main-wrapper">
            <div class="row">
                <div class="col-12 text-center mb-3">
                    <div class="title main-title"><? pll_e('Стильные часы') ?> <? watch()->woo()->trimTitle(get_the_title());  ?></div>
                    <div class="secondary-title"><? pll_e('Финальная распродажа -') ?> <span class="red-color"><? pll_e( 'скидка') ?>  <? woocommerce_show_product_loop_sale_flash() ?></span></div>
                </div>
                <div class="col-md-12 col-lg-7 product-gallery">
                    <div class="gallery">
                        <? woocommerce_show_product_thumbnails() ?>
                        <? woocommerce_show_product_images() ?>
                    </div>
                </div>
                <div class="col-md-12 col-lg-5">
                    <div class="product-info">
                        <div class="d-flex justify-content-between mb-4">
                            <? woocommerce_template_single_title() ?>
                            <div class="d-flex flex-column align-items-center">
                                <? wc_get_template_part( 'single-product/stock' ) ?>
                                <? wc_get_template_part( 'single-product/rating' ) ?>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between pb-2">
                            <? woocommerce_template_single_price() ?>
                            <? woocommerce_simple_add_to_cart() ?>
                        </div>
                        <div class="separator mt-3 mb-4"></div>
                        <? wc_get_template_part( 'single-product/short-description' ) ?>
                        <div class="separator mt-4 mb-3"></div>
                        <div class="timer-wrapper">
                            <div class="timer-label-sale">
                                <div class="inner-value">
                                    <span><? pll_e('скидка') ?> </span>
                                    <span class="sale-value"><? woocommerce_show_product_loop_sale_flash() ?></span>
                                </div>
                            </div>
                            <div class="timer">
                                <div class="timer-item text flex-column"><? pll_e('До конца распродажи осталось:') ?> </div>
                                <div class="timer-item time"><script src="https://megatimer.ru/get/8d336442e3c5984b57655d6ad122c03a.js"></script></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="product-delivery-wrapper">
                <div class="product-delivery-payment pt-4 row">
                    <? while ( have_rows( 'details', lang() ) ):the_row() ?>
                        <div class="col-md-4">
                            <div class="medium-title red-color bold mb-2"><? the_sub_field( 'title' ) ?></div>
                            <div class="text"><? the_sub_field( 'text' ) ?></div>
                        </div>
                    <? endwhile; ?>
                </div>
            </div>
        <div class="separator-product mb-4 pt-3"></div>
        <div class="title main-title text-center mb-4"><? pll_e('Характеристики') ?></div>
        <div class="row align-items-center margin-m">
            <div class="col-md-8 padding-m">
                <div class="row table-settings margin-m">
                    <? watch()->woo()->printAttributes( $product ) ?>
                </div>
            </div>
            <div class="col-md-4 padding-m text-center">
                <? wpml_fix_start(); ?>
                <? the_image('img-for-settings', 'img-for-settings', 'option') ?>
                <? wpml_fix_end(); ?>
            </div>
        </div>
        <div class="text-center">
            <a href="https://www.instagram.com/goodwatch.cc/" target="_blank" class="button btn-red btn-subscribe mt-3"><? pll_e('Подпишись на <i class="fab fa-instagram"></i> <span>Инстаграм</span> и получи 5% скидки на любые часы') ?></a>
        </div>
        <div class="product-description-box mt-4 padding-m">
            <div class="row align-items-center margin-m">
                <div class="col-md-4 text-center">
                    <img src="<? the_post_thumbnail_url('shop_single'); ?>" alt="desc" class="img-fluid">
                </div>
                <div class="col-md-8">
                    <div class="title main-title text-center mb-4"><? pll_e('Описание') ?></div>
                    <div class="dynamic-content">
                        <? the_post_content() ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="how-we-work">
            <? wc_get_template_part( 'single-product/videos' ) ?>
            <? the_field( 'how-we-work', lang() ) ?>
            <div class="text-center">
                <a rel="nofollow" href="<?= $product->add_to_cart_url() ?>" data-product_id="<? the_ID() ?>"
                   class="button add-to-cart btn-red add_to_cart_button ajax_add_to_cart"><? pll_e('Заказать со скидкой') ?></a>
                <div class="added_to_cart d-none"></div>
            </div>
        </div>
        <? wc_get_template_part( 'single-product/gallery' ) ?>
        <? woocommerce_output_related_products() ?>
        <? woocommerce_output_product_data_tabs() ?>
        <? wc_get_template_part( 'single-product/special' ) ?>
        <? wpml_fix_start(); ?>
        <? if(have_rows('shop-reviews', 'option')): ?>
        <div class="mt-5">
            <div class="title main-title text-center mb-4"><? pll_e('Отзывы покупателей'); ?></div>
            <div class="owl-reviews-shop owl-carousel owl-theme owl-custom-dot">
                <? while (have_rows('shop-reviews', 'option')):the_row();
                    $name = get_sub_field('name-review');
                    $date = get_sub_field('date-review');
                    $mark = get_sub_field('mark-review');
                    $content = get_sub_field('content-review');
                    ?>
                    <div class="text-center comment pb-0 pt-0">
                        <div class="name"><? echo $name; ?></div>
                        <div class="date"><? echo $date; ?></div>
                        <div class="star-rate mt-1 mb-1 justify-content-center">
                            <? for($i = 0; $i<$mark ; $i++): ?>
                                <i class="fas fa-star"></i>
                            <? endfor; ?>
                        </div>
                        <div class="text">
                            <a data-fancybox="gallery-additional" href="<?php echo esc_url($content['url']); ?>">
                                <img src="<?php echo esc_url($content['url']); ?>" alt="<?php echo esc_attr($content['alt']); ?>" />
                            </a>
                        </div>
                    </div>
                <? endwhile; ?>
            </div>
        </div>
        <? endif; ?>
        <? wpml_fix_end(); ?>
        <div class="mt-5 guarantee-box">
            <? the_field( 'guarantee-our-shop', lang() ) ?>
        </div>
        <? wc_get_template_part( 'single-product/banners' ) ?>
        </div>
    </main>
<? get_footer();