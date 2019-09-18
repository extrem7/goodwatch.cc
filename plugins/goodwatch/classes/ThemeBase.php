<?php

class ThemeBase {
	public function __construct() {
		$this->themeSetup();
		$this->enqueueStyles();
		$this->enqueueScripts();
		$this->customHooks();
		$this->GPSI();
		$this->registerWidgets();
		$this->registerNavMenus();
		add_action( 'plugins_loaded', function () {
			$this->ACF();
			$this->Polylang();
		} );
	}

	private function themeSetup() {
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'menus' );
		add_theme_support( 'widgets' );
		show_admin_bar( false );
	}

	private function enqueueStyles() {
		add_action( 'wp_print_styles', function () {
			wp_register_style( 'main', path() . 'assets/css/main.css' );
			wp_enqueue_style( 'main' );
			wp_register_style( 'keinakh', path() . 'assets/css/keinakh.css' );
			wp_enqueue_style( 'keinakh' );
		} );
		add_action( 'admin_enqueue_scripts', function () {
			//wp_enqueue_style('admin-styles', get_template_directory_uri() . '/assets/css/admin.css');
		} );
	}

	private function enqueueScripts() {
		add_action( 'wp_enqueue_scripts', function () {
			wp_deregister_script( 'jquery' );
			wp_register_script( 'jquery', path() . 'assets/node_modules/jquery/dist/jquery.min.js' );
			wp_enqueue_script( 'jquery' );
			wp_register_script( 'popper', path() . 'assets/node_modules/popper.js/dist/umd/popper.min.js' );
			wp_enqueue_script( 'popper' );
			wp_register_script( 'bootstrap', path() . 'assets/node_modules/bootstrap/dist/js/bootstrap.min.js' );
			wp_enqueue_script( 'bootstrap' );

			wp_register_script( 'fancybox', path() . 'assets/node_modules/@fancyapps/fancybox/dist/jquery.fancybox.js' );
			wp_enqueue_script( 'fancybox' );
			wp_register_script( 'owl.carousel', path() . 'assets/node_modules/owl.carousel/dist/owl.carousel.min.js' );
			wp_enqueue_script( 'owl.carousel' );
			wp_register_script( 'slick', path() . 'assets/node_modules/slick-carousel/slick/slick.min.js' );
			wp_enqueue_script( 'slick' );

			wp_register_script( 'jquery-ui', path() . 'assets/node_modules/jquery-ui-dist/jquery-ui.min.js' );
			wp_enqueue_script( 'jquery-ui' );
			wp_register_script( 'touch', path() . 'assets/node_modules/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js' );
			wp_enqueue_script( 'touch' );

			wp_register_script( 'mask', path() . 'assets/node_modules/jquery.inputmask/dist/inputmask/inputmask.js' );
			wp_enqueue_script( 'mask' );
			wp_register_script( 'mask-ex', path() . 'assets/node_modules/jquery.inputmask/dist/inputmask/inputmask.extensions.js' );
			wp_enqueue_script( 'mask-ex' );
			wp_register_script( 'mask-phone', path() . 'assets/node_modules/jquery.inputmask/dist/inputmask/inputmask.phone.extensions.js' );
			wp_enqueue_script( 'mask-phone' );
			wp_register_script( 'mask-j', path() . 'assets/node_modules/jquery.inputmask/dist/inputmask/jquery.inputmask.js' );
			wp_enqueue_script( 'mask-j' );
			wp_register_script( 'main', path() . 'assets/js/main.js' );
			wp_enqueue_script( 'main' );
			wp_localize_script( 'main', 'AdminAjax',
				admin_url( 'admin-ajax.php' )
			);
		} );
	}

	private function customHooks() {
		add_filter('wp_get_attachment_image_attributes', function ($attr) {
			if (!is_admin()) {
				$attr['data-src'] = $attr['src'];
				$attr['data-srcset'] = $attr['srcset'];
				$attr['srcset'] = '';
				$attr['src'] = '';
			}
			return $attr;
		});
		add_filter( 'nav_menu_css_class', function ( $classes, $item ) {
			if ( in_array( 'current-menu-item', $classes ) ) {
				$classes[] = 'active ';
			}

			return $classes;
		}, 10, 2 );
		add_action( 'navigation_markup_template', function ( $content ) {
			$content = str_replace( 'role="navigation"', '', $content );
			$content = preg_replace( '#<h2.*?>(.*?)<\/h2>#si', '', $content );

			return $content;
		} );
		//add_image_size('', 0, 0, ['center', 'center']);
		add_filter( 'wpcf7_autop_or_not', '__return_false' );
		add_filter( 'wpcf7_form_elements', function ( $content ) {
			// pre($content);
			$content = preg_replace( '/<br \/>/', '', $content );

			return $content;
		} );
		add_filter( 'body_class', function ( $classes ) {
			return $classes;
		} );
		add_action( 'template_redirect', function () {
			if ( is_attachment() ) {
				global $post;
				if ( $post && $post->post_parent ) {
					wp_redirect( esc_url( get_permalink( $post->post_parent ) ), 301 );
					exit;
				} else {
					wp_redirect( esc_url( home_url( '/' ) ), 301 );
					exit;
				}
			}
		} );
		
		function fb_disable_feed() {
			wp_redirect( get_option( 'siteurl' ) );
		}

		add_action( 'do_feed', 'fb_disable_feed', 1 );
		add_action( 'do_feed_rdf', 'fb_disable_feed', 1 );
		add_action( 'do_feed_rss', 'fb_disable_feed', 1 );
		add_action( 'do_feed_rss2', 'fb_disable_feed', 1 );
		add_action( 'do_feed_atom', 'fb_disable_feed', 1 );

		remove_action( 'wp_head', 'feed_links_extra', 3 );
		remove_action( 'wp_head', 'feed_links', 2 );
		remove_action( 'wp_head', 'rsd_link' );
	}

	private function ACF() {
		if ( function_exists( 'acf_add_options_page' ) ) {
			$main = acf_add_options_page( [
				'page_title' => 'Settings',
				'menu_title' => 'Settings',
				'menu_slug'  => 'theme-general-settings',
				'capability' => 'edit_posts',
				'redirect'   => false,
				'position'   => 2,
				'icon_url'   => 'dashicons-hammer',
			] );
			acf_add_options_sub_page( [
				'page_title'  => 'Настройки темы',
				'menu_title'  => "Настройки темы",
				'menu_slug'   => 'settings_ru',
				'parent_slug' => $main['menu_slug'],
				'post_id'     => 'ru',
			] );
			acf_add_options_sub_page( [
				'page_title'  => 'Налаштування теми',
				'menu_title'  => 'Налаштування теми',
				'parent_slug' => $main['menu_slug'],
				'menu_slug'   => 'settings_uk',
				'post_id'     => 'uk',
			] );
			acf_add_options_sub_page( [
				'page_title'  => 'Settings eng',
				'menu_title'  => "Settings eng",
				'menu_slug'   => 'settings_en',
				'parent_slug' => $main['menu_slug'],
				'post_id'     => 'en',
			] );
		}
	}

	private function GPSI() {
		add_action( 'after_setup_theme', function () {
			remove_action( 'wp_head', 'wp_print_scripts' );
			remove_action( 'wp_head', 'wp_print_head_scripts', 9 );
			remove_action( 'wp_head', 'wp_enqueue_scripts', 1 );
			add_action( 'wp_footer', 'wp_print_scripts', 5 );
			add_action( 'wp_footer', 'wp_enqueue_scripts', 5 );
			add_action( 'wp_footer', 'wp_print_head_scripts', 5 );
			remove_action( 'wp_head', 'wp_generator' );
			remove_action( 'wp_head', 'wlwmanifest_link' );
			remove_action( 'wp_head', 'rsd_link' );
			remove_action( 'wp_head', 'wp_shortlink_wp_head' );
			remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );
			add_filter( 'the_generator', '__return_false' );
			remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
			remove_action( 'wp_print_styles', 'print_emoji_styles' );
		} );

		remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
		remove_action( 'wp_head', 'wp_oembed_add_host_js' );
	}

	private function Polylang() {
		global $lang;
		$lang = pll_current_language( 'slug' );

		add_action( 'init', function () {
			pll_register_string( 'Заказать звонок', 'Заказать звонок' );
			pll_register_string( 'Поиск', 'Поиск' );
			pll_register_string( 'Популярное', 'Популярное' );
			pll_register_string( 'Новинки', 'Новинки' );
			pll_register_string( 'Распродажа', 'Распродажа' );
			pll_register_string( 'Наши бренды', 'Наши бренды' );
			pll_register_string( 'Гарантия', 'Гарантия' );
			pll_register_string( 'Сертифицированные товары', 'Сертифицированные товары' );
			pll_register_string( 'Последнее в блоге', 'Последнее в блоге' );
			pll_register_string( 'Читать', 'Читать' );
            pll_register_string( 'Читать полностью', 'Читать полностью' );

			pll_register_string( 'Описание', 'Описание' );
			pll_register_string( 'Характеристики', 'Характеристики' );
			pll_register_string( 'Гарантия', 'Гарантия' );
			pll_register_string( 'Отзывы', 'Отзывы' );
			pll_register_string( 'Подробнее', 'Подробнее' );
			pll_register_string( 'Последние отзывы', 'Последние отзывы' );
			pll_register_string( 'Написать отзыв', 'Написать отзыв' );
			pll_register_string( 'Есть в наличии', 'Есть в наличии' );
			pll_register_string( 'Купить', 'Купить' );
			pll_register_string( 'Купить в 1 клик', 'Купить в 1 клик' );

			pll_register_string( 'Категории товаров', 'Категории товаров' );
			pll_register_string( 'Заказать звонок', 'Заказать звонок' );
			pll_register_string( 'Спасибо Мы свяжемся', 'Спасибо.<br> Мы свяжемся с Вами как можно скорей!' );
			pll_register_string( 'Спасибо Продукт', 'Спасибо.<br> Продукт добавлен в корзину!' );
			pll_register_string( 'Смотреть корзину', 'Смотреть корзину' );
			pll_register_string( 'Продолжить покупки', 'Продолжить покупки' );

			pll_register_string( 'Информация', 'Информация' );
			pll_register_string( 'Подписаться на рассылку', 'Подписаться на рассылку' );
			pll_register_string( 'Обратная связь', 'Обратная связь' );
			pll_register_string( 'Принимаем к оплате', 'Принимаем к оплате' );
			pll_register_string( 'Контакты', 'Контакты' );
			pll_register_string( 'Все права защищены', 'Все права защищены' );
			pll_register_string( 'Разработка', 'Разработка и поддержка' );
			pll_register_string( 'Прямые поставки товаров', 'Прямые поставки товаров' );
			pll_register_string( 'Специальное предложение', 'Специальное предложение' );

			pll_register_string( 'Фото продукта', 'Фото продукта' );
			pll_register_string( 'Название', 'Название' );
			pll_register_string( 'Стоимость', 'Стоимость' );
			pll_register_string( 'Количество', 'Количество' );
			pll_register_string( 'Итоговая стоимость', 'Итоговая стоимость' );
			pll_register_string( 'Продолжить покупки', 'Продолжить покупки' );
			pll_register_string( 'Ваши данные', 'Ваши данные' );
			pll_register_string( 'Доставка', 'Доставка' );
			pll_register_string( 'Оплата', 'Оплата' );
			pll_register_string( 'Итоговая сумма', 'Итоговая сумма' );
			pll_register_string( 'Статус', 'Статус' );

			pll_register_string( 'Коментарий', 'Коментарий' );
			pll_register_string( 'ФИО', 'ФИО' );
			pll_register_string( 'Номер телефона', 'Номер телефона' );

			pll_register_string( 'Ваше Имя', 'Ваше Имя' );
			pll_register_string( 'Отправить', 'Отправить' );

			pll_register_string( 'Гарантия качества', 'Гарантия качества' );
			pll_register_string( 'Обмен и возврат товара', 'Обмен и возврат товара' );
			pll_register_string( 'Как обменять и вернуть товар?', 'Как обменять и вернуть товар?' );
			pll_register_string( 'Заполните форму', 'Заполните форму' );
			pll_register_string( 'Заявка на гарантийное обслуживание', 'Заявка на гарантийное обслуживание' );

			pll_register_string( 'Телефоны', 'Телефоны' );
			pll_register_string( 'Время работы', 'Время работы' );
			pll_register_string( 'Мессенджеры', 'Мессенджеры' );
			pll_register_string( 'Шаг', 'Шаг' );

			pll_register_string( 'Показать', 'Показать' );
			pll_register_string( 'Сортировать', 'Сортировать' );
			pll_register_string( 'Фильтры / Сортировка', 'Фильтры / Сортировка' );
			pll_register_string( 'Бренды', 'Бренды' );
			pll_register_string( 'Отфильтровать', 'Отфильтровать' );
			pll_register_string( 'Сбросить фильтр', 'Сбросить фильтр' );

			pll_register_string( 'По умолчанию', 'По умолчанию' );
			pll_register_string( 'По новизне', 'По новизне' );
			pll_register_string( 'От дешевых к дорогим', 'От дешевых к дорогим');
			pll_register_string(  'От дорогих к дешевым',  'От дорогих к дешевым' );

			pll_register_string( 'Всего товаров', 'Всего товаров' );
			pll_register_string( 'На сумму', 'На сумму' );
			pll_register_string( 'Спец. скидка', 'Спец. скидка' );

			pll_register_string( 'Похожие товары', 'Похожие товары' );
			pll_register_string( 'Достоинства', 'Достоинства' );
			pll_register_string( 'Недостатки', 'Недостатки' );
			pll_register_string( 'Вы экономите', 'Вы экономите' );

			pll_register_string( 'Страница не найдена', 'Страница не найдена' );
			pll_register_string( 'Вернитесь на главную страницу <br> или воспользуйтесь поиском', 'Вернитесь на главную страницу <br> или воспользуйтесь поиском' );
			pll_register_string( 'На главную', 'На главную' );

			pll_register_string( '', '' );
			pll_register_string( '', '' );
			pll_register_string( '', '' );

		} );
	}

	private function postTypePermalink() {
		add_filter( 'post_type_link', function ( $post_link, $post ) {
			if ( 'car' === $post->post_type && 'publish' === $post->post_status ) {
				$post_link = str_replace( '/' . $post->post_type . '/', '/', $post_link );
			}

			return $post_link;
		}, 10, 2 );
		add_action( 'pre_get_posts', function ( $query ) {
			if ( ! $query->is_main_query() ) {
				return;
			}
			if ( ! isset( $query->query['page'] ) || 2 !== count( $query->query ) ) {
				return;
			}
			if ( empty( $query->query['name'] ) ) {
				return;
			}
			$query->set( 'post_type', array( 'post', 'page', 'car' ) );
		} );
	}

	private function registerWidgets() {
		add_action( 'widgets_init', function () {
			register_sidebar( [
				'name'         => "Правая боковая панель сайта",
				'id'           => 'right-sidebar',
				'description'  => 'Эти виджеты будут показаны в правой колонке сайта',
				'before_title' => '<h1>',
				'after_title'  => '</h1>'
			] );
		} );
	}

	private function registerNavMenus() {
		add_action( 'after_setup_theme', function () {
			register_nav_menus( [
				'header_menu'     => 'Меню в шапке',
				'info_menu'       => 'Меню инфо',
				'categories_menu' => 'Меню категорий',
				'footer_menu'     => 'Меню в подвале'
			] );
		} );

		/*add_filter('nav_menu_link_attributes', function ($atts, $item, $args) {
			$atts['itemprop'] = 'url';
			return $atts;
		}, 10, 3);*/

		if ( ! file_exists( plugin_dir_path( __FILE__ ) . '../includes/wp-bootstrap-navwalker.php' ) ) {
			return new WP_Error( 'wp-bootstrap-navwalker-missing', __( 'It appears the wp-bootstrap-navwalker.php file may be missing.', 'wp-bootstrap-navwalker' ) );
		} else {
			require_once plugin_dir_path( __FILE__ ) . '../includes/wp-bootstrap-navwalker.php';
		}

	}
}