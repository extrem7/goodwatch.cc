<div class="modal fade" id="call-back" tabindex="-1" role="dialog" aria-labelledby="call-back" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="title base-title text-center mb-3"><? pll_e( 'Заказать звонок' ) ?></div>
				<? pll_cf7( 192, 333, 'contact-form' ) ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="one-click" tabindex="-1" role="dialog" aria-labelledby="one-click" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="title base-title text-center mb-3"><? pll_e( 'Купить в 1 клик' ) ?></div>
                <form class="contact-form">
                    <div class="form-group d-flex align-items-center justify-content-between flex-wrap">
                        <input type="tel" name="phone" class="control-form material" placeholder="Телефон" required>
                        <input type="hidden" name="product_id">
                    </div>
                    <div class="text-center">
                        <button class="button btn-outline-black"><? pll_e( 'Купить' ) ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="thanks" tabindex="-1" role="dialog" aria-labelledby="thanks" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="title base-title text-center mb-3"><? pll_e( 'Спасибо.<br> Мы свяжемся с Вами как можно скорей!' ) ?></div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addedToCart" tabindex="-1" role="dialog" aria-labelledby="thanks" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="title base-title text-center mb-3"><? pll_e( 'Спасибо.<br> Продукт добавлен в корзину!' ) ?></div>
                <div class="text-center mb-4">
                    <a href="<? cart_url() ?>" class="button btn-red btn-lg w-100"><? pll_e( 'Смотреть корзину' ) ?></a>
                    <a href="" rel="nofollow" data-dismiss="modal"
                       class="button btn-outline-black btn-lg w-100 mt-2"><? pll_e( 'Продолжить покупки' ) ?></a>
                </div>
            </div>
        </div>
    </div>
</div>