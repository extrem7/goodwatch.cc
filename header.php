<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="it-rating" content="it-rat-96ce2df79b44e83b1c096943ce4efc94"/>
    <link rel="preload"
          href="https://goodwatch.cc/wp-content/themes/goodwatch/assets/node_modules/@fortawesome/fontawesome-free/webfonts/fa-regular-400.woff2"
          as="font" type="font/woff2" crossorigin>
    <title><?= wp_get_document_title() ?></title>
    <? wp_head() ?>
    <!-- Google Tag Manager -->
    <script>(function (w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start':
                    new Date().getTime(), event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-NSN2ZBC');</script>
    <!-- End Google Tag Manager -->
</head>
<body <? body_class() ?>>
<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NSN2ZBC"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->
<?
$menu = wp_nav_menu([
    'menu' => 'Header',
    'container' => null,
    'menu_class' => 'menu-top',
    'echo' => false
]);
wpml_fix_start();
?>
<header class="header">
    <div class="container">
        <div class="header-top"><?= $menu ?></div>
        <div class="header-middle">
            <? if (is_front_page()): ?>
                <div aria-label="logo">
                    <? the_image('logo', 'logo', 'option') ?>
                </div>
            <? else: ?>
                <a href="<? bloginfo('url') ?>" aria-label="logo-mini">
                    <? the_image('logo', 'logo', 'option') ?>
                </a>
            <? endif; ?>
            <? get_search_form() ?>
            <div class="phone-box">
                <i class="fas fa-phone"></i>
                <? while (have_rows('header_phones', 'option')):the_row();
                    $phone = get_sub_field('phone') ?>
                    <a href="<?= tel($phone) ?>"><?= $phone ?></a>
                <? endwhile;
                wpml_fix_end();
                ?>
            </div>
            <div class="callback">
                <a href="#" data-toggle="modal" data-target="#call-back" class="button btn-orange transform-hover">
                    <? pll_e('Заказать звонок') ?>
                </a>
            </div>
            <div class="shop-info">
                <button class="btn-search icon item" id="search-btn"><i class="fas fa-search"></i></button>
                <? watch()->views()->miniWishlist() ?>
                <? watch()->views()->miniCart() ?>
            </div>
            <button class="mobile-btn" id="mobile-menu"><span></span><span></span><span></span></button>
        </div>
    </div>
    <div class="header-bottom">
        <div class="container">
            <div class="catalog-menu-box">
                <div class="catalog-btn">
                    <span><? pll_e('Категории товаров') ?></span>
                    <i class="fas fa-bars"></i>
                </div>
                <ul class="catalog-menu pb-0 catalog-main-menu">
                    <? while (have_rows('header_menu', lang())):the_row();
                        $active = get_sub_field('link') == current_location() ? 'active' : '';
                        ?>
                        <li class="dropdown">
                            <a href="<? the_sub_field('link') ?>"
                               class="<?= $active ?>"><? the_sub_field('title') ?></a>
                        </li>
                    <? endwhile; ?>
                </ul>
                <? wp_nav_menu([
                    'menu' => 'categories',
                    'container' => null,
                    'menu_class' => 'catalog-menu main-slide-menu'
                ]); ?>
            </div>
            <div class="menu-container">
                <?= $menu ?>
                <ul class="menu">
                    <? while (have_rows('header_menu', lang())):the_row();
                        $active = get_sub_field('link') == current_location() ? 'active' : '';
                        ?>
                        <li class="dropdown">
                            <a href="<? the_sub_field('link') ?>"
                               class="<?= (get_sub_field('blocks') ? 'dropdown-toggle ' : '') . $active ?>"><? the_sub_field('title') ?></a>
                            <? if (have_rows('blocks')): ?>
                                <div class="dropdown-menu">
                                    <div class="d-flex align-items-start">
                                        <div class="filter-menu">
                                            <? while (have_rows('blocks')):the_row() ?>
                                                <div>
                                                    <div class="menu-title"><? the_sub_field('title') ?></div>
                                                    <? while (have_rows('links')):the_row() ?>
                                                        <a href="<? the_sub_field('link') ?>"
                                                           class="sub-link"><? the_sub_field('title') ?></a>
                                                    <? endwhile; ?>
                                                </div>
                                            <? endwhile; ?>
                                        </div>
                                        <? if (!empty(get_sub_field('products'))): ?>
                                            <div class="product-top">
                                                <div class="main-title title white-color text-center mt-2 mb-3">Топ
                                                    продаж
                                                </div>
                                                <div class="d-flex">
                                                    <? foreach (get_sub_field('products') as $post):
                                                        global $product;
                                                        $product = wc_get_product($post);
                                                        ?>
                                                        <div class="product-card">
                                                            <a href="<? the_permalink() ?>" class="product-thumbnail">
                                                                <img width="150" height="150"
                                                                     src="<? the_post_thumbnail_url('thumbnail') ?>"
                                                                     class="attachment-thumbnail size-thumbnail wp-post-image"
                                                                     alt="<? the_title() ?>">
                                                            </a>
                                                            <div class="product-information">
                                                                <a href="<? the_permalink() ?>"
                                                                   class="product-name text-center mb-2"><? the_title() ?></a>
                                                                <div class="d-flex align-items-center justify-content-between flex-column flex-xl-row">
                                                                    <? woocommerce_template_loop_price() ?>
                                                                    <? wc_get_template_part('global/add-to-cart-ajax') ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <? endforeach;
                                                    wp_reset_query() ?>
                                                </div>
                                            </div>
                                        <? endif; ?>
                                    </div>
                                </div>
                            <? endif; ?>
                        </li>
                    <? endwhile; ?>
                </ul>
            </div>
        </div>
    </div>
</header>
<? if (!is_front_page()): ?>
<div class="container breadcrumbs">
    <? woocommerce_breadcrumb() ?>
</div>
<? endif; ?>