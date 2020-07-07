<?php
 // Added by WP Rocket
 // Added by WP Rocket

define('WP_CACHE', true);
define( 'WPCACHEHOME', '/home/fc342997/goodwatch.cc/www/wp-content/plugins/wp-super-cache/' );
define( 'WP_MEMORY_LIMIT', '256M' );
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе
 * установки. Необязательно использовать веб-интерфейс, можно
 * скопировать файл в "wp-config.php" и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки MySQL
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** Параметры MySQL: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', 'fc342997_db' );

/** Имя пользователя MySQL */
define( 'DB_USER', 'fc342997_db' );

/** Пароль к базе данных MySQL */
define( 'DB_PASSWORD', '8Tec3jW8' );

/** Имя сервера MySQL */
define( 'DB_HOST', '127.0.0.1' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу.
 * Можно сгенерировать их с помощью {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными. Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'a9ea9<@h>8=|OwZYM;96Da0y7u&|BebSnWkr,xDInG/30]oe5h{_~d*cH1F+cz6r' );
define( 'SECURE_AUTH_KEY',  'IQUU;e7$W=$I2N.PD$-,_hi{qxPl1kkHTT{a0E!qE7l-7=p>xci@JTF6!E}D&Q<O' );
define( 'LOGGED_IN_KEY',    '%|*g[WW/Fj5vR3PYYG#]2I4{bk.giJ9<IRgsI&cgnsWSP@sy}=E`f?kpyz%VcFY%' );
define( 'NONCE_KEY',        '{04:%_FE$DSR9PSI#b:J2fSujsg`{X/R.xXFowA-%W~)C)G>hUCvNm6EaV<mpv@?' );
define( 'AUTH_SALT',        'og|}b``mMM%0Uqz6z_1R.)rMpwYhq[6U;5i(3MQLUmeL9oZST!pKlrfF#j4ky :0' );
define( 'SECURE_AUTH_SALT', 'LK_L]Z VOO<?~|W%uxpJ x]t7_iW!J.{|Wn.UFM .qEYn:s7;&]i^6DZ#Q&U9f>I' );
define( 'LOGGED_IN_SALT',   'm-G[s8.o@c{-d,F71s<x+7=hqZ RI?gi$W7vs;ZX<5d`{4mc?9Uoi==2l[w]!w?I' );
define( 'NONCE_SALT',       'KbyD{H{EGaTT0V%eYy4^qxu1]U{[Nv-@C?_poU||}s42[l5|;u`o,0GR-&:a;+pd' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'gw_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в Кодексе.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once( ABSPATH . 'wp-settings.php' );