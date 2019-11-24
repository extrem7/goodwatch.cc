<div class="col-12 col-lg-3">
    <div class="catalog-filter">
        <div class="filter-mob">
            <div class="filter-mob-btn"><? pll_e('Фильтры / Сортировка') ?> <span><i
                            class="fas fa-chevron-down"></i></span></div>
            <div class="mob-wrapper-filter">
                <? global $mobileSort, $wp;
                $mobileSort = true;
                woocommerce_catalog_ordering();
                $mobileSort = false;
                dynamic_sidebar('right-sidebar');
                ?>
            </div>
        </div>
    </div>
</div>