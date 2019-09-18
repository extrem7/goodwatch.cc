<?
// silence is golden.

function tr_sku_search_helper($wp){
	global $wpdb;

	//Check to see if query is requested
	if( !isset( $wp->query['s'] ) || !isset( $wp->query['post_type'] ) || $wp->query['post_type'] != 'product') return;
	$sku = $wp->query['s'];
	$ids = $wpdb->get_col( $wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value = %s;", $sku) );
	if ( ! $ids ) return;
	unset( $wp->query['s'] );
	unset( $wp->query_vars['s'] );
	$wp->query['post__in'] = array();
	foreach($ids as $id){
		$post = get_post($id);
		if($post->post_type == 'product_variation'){
			$wp->query['post__in'][] = $post->post_parent;
			$wp->query_vars['post__in'][] = $post->post_parent;
		} else {
			$wp->query_vars['post__in'][] = $post->ID;
		}
	}
}
add_filter( 'pre_get_posts', 'tr_sku_search_helper', 15 );

/**
 * Отключаем принудительную проверку новых версий WP, плагинов и темы в админке,
 * чтобы она не тормозила, когда долго не заходил и зашел...
 * Все проверки будут происходить незаметно через крон или при заходе на страницу: "Консоль > Обновления".
 *
 * @see https://wp-kama.ru/filecode/wp-includes/update.php
 * @author Kama (https://wp-kama.ru)
 * @version 1.0
 */
if( is_admin() ){
	// отключим проверку обновлений при любом заходе в админку...
	remove_action( 'admin_init', '_maybe_update_core' );
	remove_action( 'admin_init', '_maybe_update_plugins' );
	remove_action( 'admin_init', '_maybe_update_themes' );

	// отключим проверку обновлений при заходе на специальную страницу в админке...
	remove_action( 'load-plugins.php', 'wp_update_plugins' );
	remove_action( 'load-themes.php', 'wp_update_themes' );

	// оставим принудительную проверку при заходе на страницу обновлений...
	//remove_action( 'load-update-core.php', 'wp_update_plugins' );
	//remove_action( 'load-update-core.php', 'wp_update_themes' );

	// внутренняя страница админки "Update/Install Plugin" или "Update/Install Theme" - оставим не мешает...
	//remove_action( 'load-update.php', 'wp_update_plugins' );
	//remove_action( 'load-update.php', 'wp_update_themes' );

	// событие крона не трогаем, через него будет проверяться наличие обновлений - тут все отлично!
	//remove_action( 'wp_version_check', 'wp_version_check' );
	//remove_action( 'wp_update_plugins', 'wp_update_plugins' );
	//remove_action( 'wp_update_themes', 'wp_update_themes' );

	/**
	 * отключим проверку необходимости обновить браузер в консоли - мы всегда юзаем топовые браузеры!
	 * эта проверка происходит раз в неделю...
	 * @see https://wp-kama.ru/function/wp_check_browser_version
	 */
	add_filter( 'pre_site_transient_browser_'. md5( $_SERVER['HTTP_USER_AGENT'] ), '__return_true' );
}