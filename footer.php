<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-6 col-lg-2 col-xl-3">
                <div class="footer-title"><? pll_e('Информация') ?></div>
				<? wp_nav_menu( [
					'menu'       => 'information',
					'container'  => null,
					'menu_class' => null
				] ); ?>
            </div>
            <div class="col-12 col-sm-6 col-lg-3 col-xl-3">
                <div class="footer-title"><? pll_e('Подписаться на рассылку') ?></div>
                <div>
	                <? pll_cf7( 190, 335 ) ?>
                    <div class="social-link">
						<?
                        wpml_fix_start();
                        while ( have_rows( 'social', 'option' ) ):the_row() ?>
                            <a href="<? the_sub_field( 'link' ) ?>" target="_blank">
                                <i class="fab fa-<? the_sub_field( 'class' ) ?>"></i>
								<? the_sub_field( 'name' ) ?></a>
						<? endwhile;
                        wpml_fix_end();?>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-6 col-lg-3 col-xl-3 mt-4 mt-lg-0">
                <div class="footer-title"><? pll_e('Обратная связь') ?></div>
	            <? pll_cf7( 189, 336 ) ?>
            </div>
            <div class="col-12 col-sm-6 col-lg-4 col-xl-3 mt-4 mt-lg-0">
                <div class="d-flex flex-column flex-md-row">
                    <div class="text-center text-md-left">
                        <div class="footer-title"><? pll_e('Принимаем к оплате') ?></div>
                        <img src="<?= path() ?>assets/img/icons/payment.png" alt="payment">
                    </div>
                    <div class="footer-contact">
                        <div class="footer-title"><? pll_e('Контакты') ?></div>
						<?
                        wpml_fix_start();
                        the_field( 'contacts', 'option', false );
                        wpml_fix_end();
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-sm-6">© 2019 <? pll_e('Все права защищены') ?></div>
            <div class="col-sm-6 text-right"><? pll_e('Разработка и поддержка') ?> <a href="https://raxkor.com/" target="_blank">Raxkor</a></div>
        </div>
    </div>
</footer>
<? get_template_part( 'views/modal' ) ?>
<? wp_footer() ?>
<script type="text/javascript" src="<?= path() ?>assets/node_modules/jquery-lazy/jquery.lazy.min.js"></script>
<script type="text/javascript" src="<?= path() ?>assets/node_modules/jquery-lazy/jquery.lazy.plugins.min.js"></script>
</body>
</html>