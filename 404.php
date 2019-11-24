<? get_header(); ?>
    <main class="content container">
        <div class="text-center d-flex align-items-center flex-column h-100 justify-content-center">
            <img src="<?= path() ?>assets/img/icons/error.svg" alt="error">
            <div class="title medium-title"><? pll_e('Страница не найдена') ?></div>
            <div class="mt-2 mb-2"><? pll_e('Вернитесь на главную страницу <br> или воспользуйтесь поиском') ?></div>
            <a href="<? bloginfo( 'url' ) ?>" class="button btn-outline-black"><? pll_e('На главную') ?></a>
        </div>
    </main>
<? get_footer(); ?>