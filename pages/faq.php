<? /* Template Name: Faq */ ?>
<? get_header(); ?>
    <main class="content container">
        <h1 class="text-center title medium-title mb-4"><? the_title() ?></h1>
        <div class="faq-list" id="faq">
			<? $i = 0;
			while ( have_rows( 'qa_group' ) ):the_row(); ?>
                <div class="faq-group">
                    <div class="title base-title"><? the_sub_field( 'title' ) ?></div>
					<? while ( have_rows( 'faq' ) ):the_row();
						$i ++;
						?>
                        <div class="faq-item">
                            <div class="faq-header collapsed" data-toggle="collapse" data-target="#question-<?= $i ?>"
                                 aria-expanded="false"><? the_sub_field( 'q' ) ?>
                            </div>
                            <div id="question-<?= $i ?>" class="faq-content collapse" data-parent="#faq">
                                <div class="faq-answer"><? the_sub_field( 'a' ) ?></div>
                            </div>
                        </div>
					<? endwhile; ?>
                </div>
			<? endwhile; ?>
        </div>
    </main>
<? get_footer() ?>