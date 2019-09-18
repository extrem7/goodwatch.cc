<? get_header(); ?>
    <main class="content container">
        <article class="article">
            <h1 class="title medium-title text-center"><? the_title() ?></h1>
            <div class="article-date text-center"><?= get_the_date( 'd-m-Y' ) ?></div>
            <div class="dynamic-content"><? the_post_content() ?></div>
        </article>
    </main>
<? get_footer(); ?>