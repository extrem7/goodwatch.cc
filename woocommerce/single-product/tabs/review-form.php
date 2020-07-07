<form action="<? site_url() ?>/wp-comments-post.php" method="post" class="comment-form box-form">
    <div class="title medium-title white-color mb-3"><? pll_e('Написать отзыв'); ?></div>
    <p class="comment-form-author mb-3">
        <input id="author" class="control-form material-lg material" placeholder="<? pll_e('Ваше Имя'); ?>" name="author" type="text"
               size="30" required>
    </p>
    <div class="comment-form-rating row mb-3">
        <label class="col-md-12 col-xl-3"><? pll_e('Ваша оценка'); ?></label>
        <select name="rating" id="rating" required="" style="display: none;">
            <option value="">Оценка…</option>
            <option value="5">Отлично</option>
            <option value="4">Хорошо</option>
            <option value="3">Средне</option>
            <option value="2">Неплохо</option>
            <option value="1">Очень плохо</option>
        </select>
    </div>
    <p class="comment-form-author mb-3 row align-items-center">
        <label class="col-md-12 col-xl-3"><? pll_e('Достоинства'); ?></label>
        <span class="col-md-12 col-xl-9">
            <input class="control-form material-lg material" name="disadvantages" type="text" size="30"></span>
    </p>
    <p class="comment-form-author row align-items-center mb-3">
        <label class="col-md-12 col-xl-3"><? pll_e('Недостатки') ?></label>
        <span class="col-md-12 col-xl-9">
            <input class="control-form material-lg material" name="advantages" type="text" size="30"></span>
    </p>
    <p class="comment-form-comment mb-3">
        <textarea class="control-form material material-lg" name="comment" placeholder="<? pll_e('Коментарий'); ?>" cols="45" rows="8"></textarea>
    </p>
    <p class="form-submit">
        <input name="submit" type="submit" id="submit" class="submit button btn-outline-black" value="<? pll_e('Отправить') ?>">
        <input type="hidden" name="comment_post_ID" value="<? the_ID() ?>" id="comment_post_ID">
        <input type="hidden" name="comment_parent" id="comment_parent" value="0">
    </p>
</form>