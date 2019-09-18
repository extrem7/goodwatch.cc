<div class="mob-search">
    <form class="search-box" action="<?= home_url( '/' ); ?>" method="post">
        <input type="text" name="s" class="control-form input-search" placeholder="<? pll_e('Поиск') ?>" minlength="3" required>
        <input type="hidden" name="post_type" value="product">
        <button class="icon btn-search" type="submit"><i class="fas fa-search"></i></button>
        <button class="icon close-icon"><img src="<?= path() ?>assets/img/icons/delete_m.svg" alt="search"/></button>
    </form>
</div>