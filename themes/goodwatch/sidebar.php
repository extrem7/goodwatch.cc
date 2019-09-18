<div class="col-12 col-lg-3">
    <div class="catalog-filter">
        <div class="filter-mob">
            <div class="filter-mob-btn"><? pll_e( 'Фильтры / Сортировка' ) ?> <span><i
                            class="fas fa-chevron-down"></i></span></div>
            <div class="mob-wrapper-filter">
				<? global $mobileSort, $wp;
				$mobileSort = true;
				woocommerce_catalog_ordering();
				$mobileSort = false;

				$current_url = home_url( $wp->request );
				$action      = substr( $current_url, 0, strpos( $current_url, '/page' ) );
				?>
                <form action="<?= $action ?>">
					<? if ( ! is_tax( 'pwb-brand' ) ): ?>
                        <div class="filter-item">
							<?
							$brands         = get_terms( 'pwb-brand', [] );
							$brands_checked = isset( $_GET['brands'] ) && $_GET['brands'] ? explode( ',', $_GET['brands'] ) : [];
							?>
                            <div class="title secondary-title filter-slide"><? pll_e( 'Бренды' ) ?> <span><i
                                            class="fas fa-chevron-down"></i></span></div>
                            <input type='hidden' class='result' name='brands'
                                   value='<?= $_GET['brands'] ?>' <?= empty( $brands_checked ) ? 'disabled' : '' ?>>
                            <div class="filters">
								<? foreach ( $brands as $brand ):
									$checked = in_array( $brand->term_id, $brands_checked ) ? 'checked' : '';
									?>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input"
                                                   id="<?= $brand->term_id ?>"
                                                   value="<?= $brand->term_id ?>" <?= $checked ?>>
                                            <label class="custom-control-label"
                                                   for="<?= $brand->term_id ?>"><?= $brand->name ?></label>
                                        </div>
                                    </div>
								<? endforeach; ?>
                            </div>
                        </div>
					<? endif; ?>
					<? watch()->woo()->filters()->priceFilter() ?>
					<? watch()->woo()->filters()->attributes() ?>
                    <div class="text-center mt-4">
                        <input type="hidden" name="paged" value="1">
                        <button class="button btn-outline-black mt-2 transform-hover"><? pll_e( 'Отфильтровать' ) ?></button>
						<? if ( is_filtered() ): ?>
                            <a href="<?= parse_url( $_SERVER["REQUEST_URI"], PHP_URL_PATH ) ?>"
                               class="button mt-2 btn-outline-black transform-hover"><? pll_e( 'Сбросить фильтр' ) ?></a>
						<? endif; ?>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>