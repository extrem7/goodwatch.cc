<?php

require_once "LP_CRM.php";

class ThemeWoo
{
    private $crm;

    public function __construct()
    {
        $this->setup();
        $this->crm = new LP_CRM();
    }

    private function setup()
    {
        add_action('after_setup_theme', function () {
            add_theme_support('woocommerce');
        });
        add_action('init', function () {
            //remove_action( 'wp_footer', array( WC()->structured_data, 'output_structured_data' ), 10 );
            add_action('woocommerce_shop_loop', array(wc()->structured_data, 'generate_product_data'), 10);
            remove_action('woocommerce_email_order_details', array(
                WC()->structured_data,
                'output_email_structured_data'
            ), 30);
        });
        add_filter('woocommerce_enqueue_styles', '__return_empty_array');

        remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
        remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

        add_filter('woocommerce_currency_symbol', function ($currency_symbol, $currency) {

            switch ($currency) {
                case 'RUB':
                    $currency_symbol = ' руб.';
                    break;
                case 'UAH':
                    $currency_symbol = ' грн';
                    break;
            }

            return $currency_symbol;
        }, 10, 2);

        add_filter('wp_list_categories', function ($output, $args) {

            if (is_single()) {
                global $post;

                $terms = get_the_terms($post->ID, $args['taxonomy']);
                foreach ($terms as $term) {
                    if (preg_match('#cat-item-' . $term->term_id . '#', $output)) {
                        $output = str_replace('cat-item-' . $term->term_id, 'cat-item-' . $term->term_id . ' current-cat', $output);
                    }
                }
            }

            return $output;
        }, 10, 2);

        add_filter("woocommerce_catalog_orderby", function ($orderby) {
            $orderby['menu_order'] = pll__('По умолчанию');
            $orderby['date'] = pll__('По новизне');
            $orderby['price'] = pll__('От дешевых к дорогим');
            $orderby['price-desc'] = pll__('От дорогих к дешевым');

            return $orderby;
        }, 20);

        add_filter('pre_get_posts', function ($wp) {
            // add sku to search
            global $wpdb;

            //Check to see if query is requested
            if (!isset($wp->query['s']) || !isset($wp->query['post_type']) || $wp->query['post_type'] != 'product') {
                return;
            }
            $sku = $wp->query['s'];
            $ids = $wpdb->get_col($wpdb->prepare("SELECT post_id FROM $wpdb->postmeta WHERE meta_key='_sku' AND meta_value = %s;", $sku));
            if (!$ids) {
                return;
            }
            unset($wp->query['s']);
            unset($wp->query_vars['s']);
            $wp->query['post__in'] = array();
            foreach ($ids as $id) {
                $post = get_post($id);
                if ($post->post_type == 'product_variation') {
                    $wp->query['post__in'][] = $post->post_parent;
                    $wp->query_vars['post__in'][] = $post->post_parent;
                } else {
                    $wp->query_vars['post__in'][] = $post->ID;
                }
            }
        }, 15);

        add_action('wp', function () {
            // disable shop page
            global $post;
            if (is_shop() && !is_search() && !is_admin()):
                global $wp_query;
                $wp_query->set_404();
                status_header(404);
            endif;
        });

        add_action('woocommerce_before_shop_loop', function () {
            $title = is_search() ? wp_title(null, false) : woocommerce_page_title(false);
            echo "<h1 class=\"woocommerce-products-header__title page-title title main-title mb-4\">$title</h1>";
        });

        add_action('woocommerce_after_shop_loop', function () {
            get_template_part('views/seo-description');
        });

        add_action('wp_ajax_buyOneClick', [$this, 'buyOneClick']);
        add_action('wp_ajax_nopriv_buyOneClick', [$this, 'buyOneClick']);
        $this->metaTags();
        $this->cart();
        $this->checkout();
        $this->perPageSorting();
        $this->customFields();
        $this->comments();
        $this->specialOffer();
    }

	public function trimTitle($title) {
		$arr1 = array("Мужские часы ","Годинник чоловічий ","Женские часы ","Годинник жіночій ","Женские умные часы ", "Розумний годинник   		жіночій ");	
		
		echo str_replace($arr1,"",$title); 
	}
	
    public function buyOneClick()
    {
        $response = [];

        $product = $_POST['product_id'] ?? null;
        $phone = $_POST['tel'] ?? '';
        $product = wc_get_product($product);

        if (!$product->exists() || !$phone) {
            $response['status'] = 'error';
        } else {
            $name = "Покупка в один клик $phone";

            $address = [
                'first_name' => $name,
                'phone' => $phone,
                'country' => 'UA'
            ];

            $order = wc_create_order();
            $order->add_product($product);
            $order->set_address($address, 'billing');
            $order->calculate_totals();
            $this->crm->sendOrder($order->get_id());
            $response['status'] = $order ? 'ok' : 'error';
        }
        echo json_encode($response);
        exit();
    }

    public function printAttributes($product)
    {
        $attributes = $product->get_attributes();
        global $additional;

        foreach ($attributes as $attribute):
            $terms = get_terms($attribute->get_name(), ['hide_empty' => false]);
            $sup = '';
            foreach ($terms as $option) {
                if ($option->description) {
                    $additional[] = $option->description;
                    $sup = count($additional) . ')';
                }
            }
            if ($attribute->get_visible()) :
                ?>
                <tr>
                    <td><?= wc_attribute_label($attribute->get_name()) ?><sup> <?= $sup ?></sup></td>
                    <td>
                        <?
                        $values = [];
                        if ($attribute->is_taxonomy()) {
                            $attribute_taxonomy = $attribute->get_taxonomy_object();
                            $attribute_values = wc_get_product_terms($product->get_id(), $attribute->get_name(), array('fields' => 'all'));
                            foreach ($attribute_values as $attribute_value) {
                                $value_name = esc_html($attribute_value->name);
                                if ($attribute_taxonomy->attribute_public) {
                                    $values[] = '<a href="' . esc_url(get_term_link($attribute_value->term_id, $attribute->get_name())) . '" rel="tag">' . $value_name . '</a>';
                                } else {
                                    $values[] = $value_name;
                                }
                            }
                        } else {
                            $values = $attribute->get_options();
                            foreach ($values as &$value) {
                                $value = make_clickable(esc_html($value));
                            }
                        }

                        echo implode(', ', $values) ?>
                    </td>
                </tr>
            <? endif;
        endforeach;
    }

    public function minMaxPrice()
    {
        global $wpdb;
        $tax = get_queried_object();

        $args = [
            'meta_query' => [
                [
                    'key' => '_stock_status',
                    'value' => 'instock'
                ]
            ]
        ];
        if (is_tax()) {
            $args['tax_query'] = [
                [
                    'taxonomy' => $tax->taxonomy,
                    'terms' => $tax->term_id,
                    'field' => 'id',
                    'include_children' => true,
                    'operator' => 'IN'
                ]
            ];
        }
        $categoryQuery = new WP_Query($args);

        $args = $categoryQuery->query_vars;
        $tax_query = isset($args['tax_query']) ? $args['tax_query'] : array();
        $meta_query = isset($args['meta_query']) ? $args['meta_query'] : array();

        if (!is_post_type_archive('product') && !empty($args['taxonomy']) && !empty($args['term'])) {
            $tax_query[] = [
                'taxonomy' => $args['taxonomy'],
                'terms' => [$args['term']],
                'field' => 'slug',
            ];
        }

        foreach ($meta_query + $tax_query as $key => $query) {
            if (!empty($query['price_filter']) || !empty($query['rating_filter'])) {
                unset($meta_query[$key]);
            }
        }

        $meta_query = new WP_Meta_Query($meta_query);
        $tax_query = new WP_Tax_Query($tax_query);

        $meta_query_sql = $meta_query->get_sql('post', $wpdb->posts, 'ID');
        $tax_query_sql = $tax_query->get_sql($wpdb->posts, 'ID');

        $sql = "SELECT min( FLOOR( price_meta.meta_value ) ) as min_price, max( CEILING( price_meta.meta_value ) ) as max_price FROM {$wpdb->posts} ";
        $sql .= " LEFT JOIN {$wpdb->postmeta} as price_meta ON {$wpdb->posts}.ID = price_meta.post_id " . $tax_query_sql['join'] . $meta_query_sql['join'];
        $sql .= " 	WHERE {$wpdb->posts}.post_type IN ('" . implode("','", array_map('esc_sql', apply_filters('woocommerce_price_filter_post_type', array('product')))) . "')
			AND {$wpdb->posts}.post_status = 'publish'
			AND price_meta.meta_key IN ('" . implode("','", array_map('esc_sql', apply_filters('woocommerce_price_filter_meta_keys', array('_price')))) . "')
			AND price_meta.meta_value > '' ";
        $sql .= $tax_query_sql['where'] . $meta_query_sql['where'];

        $search = WC_Query::get_main_search_query_sql();
        if ($search) {
            $sql .= ' AND ' . $search;
        }

        return $wpdb->get_row($sql); // WPCS: unprepared SQL ok.
    }

    public function queries()
    {
        return new class
        {
            public function latest($limit)
            {
                $query = new WP_Query([
                    'post_type' => 'product',
                    'post_per_page' => $limit,
                    'post_status' => 'publish',
                    'orderby' => 'date',
                    'tax_query' => [
                        [
                            'taxonomy' => 'product_visibility',
                            'field' => 'name',
                            'terms' => 'featured',
                            'operator' => 'IN',
                        ]
                    ]

                ]);

                return $query;
            }

            public function popular($limit)
            {
                $query = new WP_Query([
                    'post_type' => 'product',
                    'post_per_page' => $limit,
                    'post_status' => 'publish',
                    'meta_key' => 'total_sales',
                    'orderby' => [
                        'meta_value_num' => 'DESC'
                    ],
                ]);

                return $query;
            }

            public function sale($limit)
            {
                $query = new WP_Query([
                    'post_type' => 'product',
                    'post_per_page' => $limit,
                    'post_status' => 'publish',
                    'orderby' => 'meta_value_num',
                    'meta_key' => '_price',
                    'order' => 'asc',
                    'tax_query',
                    [
                        [
                            'taxonomy' => 'product_cat',
                            'terms' => 20,
                            'field' => 'id',
                            'include_children' => true,
                            'operator' => 'IN'
                        ]
                    ]
                ]);

                return $query;
            }

            public function featured($limit, $category)
            {
                $query = new WP_Query([
                    'post_type' => 'product',
                    'post_status' => 'publish',
                    'posts_per_page' => $limit,
                    'tax_query' => [
                        'relation' => 'AND',
                        [
                            'taxonomy' => 'product_visibility',
                            'field' => 'name',
                            'terms' => 'featured',
                            'operator' => 'IN'
                        ],
                        [
                            'taxonomy' => 'product_cat',
                            'terms' => $category,
                            'field' => 'id',
                            'include_children' => true,
                            'operator' => 'IN'
                        ]
                    ]
                ]);

                return $query;
            }

            public function viewed()
            {
                $rvps = new Rvps();
                $viewed = $rvps->rvps_get_products();
                $query = new WP_Query([
                    'post_type' => 'product',
                    'post_status' => 'publish',
                    'post__in' => $viewed
                ]);

                return $query;
            }

            public function wishlist()
            {
                $wlp = TInvWL_Public_Wishlist_View::instance();
                $wishlist = $wlp->get_current_wishlist();
                $products = $wlp->get_current_products(tinv_wishlist_get(6));
                $ids = array_map(function ($product) {
                    return $product['product_id'];
                }, $products);
                if (!empty($products)) {
                    $query = new WP_Query([
                        'post_type' => 'product',
                        'post_status' => 'publish',
                        'post__in' => $ids
                    ]);

                    return $query;
                }
            }
        };
    }

    public function metaTags()
    {
        add_action("product_cat_edit_form_fields", function ($term) {
            ?>
            <tr class="form-field">
                <th scope="row" valign="top"><label>Заголовок (title)</label></th>
                <td>
                    <input type="text" name="mayak[title]"
                           value="<?php echo esc_attr(get_term_meta($term->term_id, 'title', 1)) ?>"><br/>
                    <p class="description">Не более 60 знаков, включая пробелы</p>
                </td>
            </tr>
            <tr class="form-field">
                <th scope="row" valign="top"><label>Заголовок h1</label></th>
                <td>
                    <input type="text" name="mayak[h1]"
                           value="<?php echo esc_attr(get_term_meta($term->term_id, 'h1', 1)) ?>"><br/>
                    <p class="description">Заголовок страницы</p>
                </td>
            </tr>

            <tr class="form-field">
                <th scope="row" valign="top"><label>Ключевые слова</label></th>
                <td>
                    <input type="text" name="mayak[keywords]"
                           value="<?php echo esc_attr(get_term_meta($term->term_id, 'keywords', 1)) ?>"><br/>
                    <p class="description">Ключевые слова (keywords)</p>
                </td>
            </tr>
            <?php
        });

        add_action('edited_product_cat', 'save_category_meta');
        add_action('create_product_cat', 'save_category_meta');
        function save_category_meta($term_id)
        {
            if (!isset($_POST['mayak'])) {
                return;
            }
            $mayak = array_map('trim', $_POST['mayak']);
            foreach ($mayak as $key => $value) {
                if (empty($value)) {
                    delete_term_meta($term_id, $key);
                    continue;
                }
                update_term_meta($term_id, $key, $value);
            }

            return $term_id;
        }

        /* add_filter('single_term_title', function () {
             $pci = get_queried_object()->term_id;

             return get_term_meta($pci, 'title', true);
         }, 10, 1);
         /*add_filter('single_term_title', function ($pct) {
             if (empty($pct)) {
                 $pct = get_queried_object()->name;
             }

             return $pct;
         }, 10, 1);*/

        add_action('wp_head', function () {
            $keywords = "";
            if (is_product_category() || is_tax('product_brand')) {
                $meta = get_term_meta(get_queried_object()->term_id, 'keywords', true);
                $keywords = '<meta name="keywords" content="' . $meta . '">' . "\n";
            }
            if (is_tax('product_brand')) {
                $meta = get_queried_object()->description;
                echo '<meta name="description" content="' . $meta . '">' . "\n";
            }
            echo $keywords;
        }
            , 1, 1);
        add_filter('woocommerce_page_title', function ($title) {
            $pch = get_term_meta(get_queried_object()->term_id, 'h1', true);
            if ($pch) return $pch;
            return $title;
        }, 10, 2);

    }

    private function cart()
    {
        add_action('woocommerce_before_checkout_form', function () {
            remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
        }, 9);
        add_action('woocommerce_add_to_cart', function () {
            global $addedToCart;
            $addedToCart = true;
        }, 10, 3);
        add_action('template_redirect', function () {
            if (isset($_POST['remove-all']) && $_POST['remove-all']) {
                WC()->cart->empty_cart();
                wp_redirect(home_url(), 301);
            }
            if (isset($_POST['save']) && $_POST['save']) {
                $this->saveForLater();
            }

        });
        /*add_filter('woocommerce_add_to_cart_fragments', function ($array) {
            ob_start();
            get_template_part('views/modal');
            $array['modal'] = ob_get_contents();
            ob_end_clean();
            return $array;
        }, 10, 1);*/
    }

    private function checkout()
    {
        add_filter('woocommerce_add_error', function ($error) {
            if (strpos($error, 'Поле ') !== false) {
                $error = str_replace("Поле ", "", $error);
            }
            if (strpos($error, 'Оплата ') !== false) {
                $error = str_replace("Оплата ", "", $error);
            }

            return $error;
        });
        add_filter('woocommerce_checkout_fields', function ($fields) {
            $fields['billing']['billing_address_1']['required'] = false;
            $fields['billing']['billing_country']['required'] = false;
            $fields['billing']['billing_city']['required'] = false;
            $fields['billing']['billing_postcode']['required'] = false;
            $fields['billing']['billing_address_2']['required'] = false;
            $fields['billing']['billing_state']['required'] = false;
            unset($fields['billing']['billing_last_name']);
            unset($fields['billing']['billing_company']);
            unset($fields['billing']['billing_postcode']);
            unset($fields['billing']['billing_state']);
            unset($fields['billing']['billing_email']);
            unset($fields['billing']['billing_country']);
            unset($fields['billing']['billing_address_2']);
            unset($fields['billing']['billing_state']);

            return $fields;
        });
        add_filter('default_checkout_billing_country', function () {
            return 'UA';
        });

        add_action('woocommerce_before_checkout_form', function () {
            remove_action('woocommerce_before_checkout_form', 'woocommerce_checkout_coupon_form', 10);
        }, 9);

        add_action('woocommerce_checkout_create_order', function (WC_Order $order, $data) {
            $comment = $data['order_comments'];
            $billing = $_POST['shipping'];
            $payment = $_POST['payment'];
            $order->set_customer_note("Комментарий: $comment \r\nДоставка : $billing \r\nОплата : $payment \r\n");

            $_SESSION['shipping'] = $billing;
            $_SESSION['payment'] = $payment;

            return $order;
        }, 20, 2);
    }

    private function perPageSorting()
    {
        global $limit;
        $limit = 40;
        if (!isset($_COOKIE['perpage'])) {
            setcookie('perpage', $limit, time() + (10 * 365 * 24 * 60 * 60), '/');
        } else {
            $limit = $_COOKIE['perpage'];
        }
        if (isset($_POST['perpage'])) {
            setcookie('perpage', $_POST['perpage'], time() + (10 * 365 * 24 * 60 * 60), '/');
            global $paged;
            $paged = 1;
            $limit = $_POST['perpage'];
        }
        add_action('pre_get_posts', function ($query) {
            global $limit;
            if (!is_admin() && (is_shop() || is_product_category() || is_tax('product_brand')) && $query->is_main_query()) {
                $query->set('posts_per_page', 40);
            }
        });
    }

    private function customFields()
    {
        add_action('woocommerce_product_options_pricing', function () {
            woocommerce_wp_text_input([
                'id' => 'special_price',
                'label' => 'Cпец. предложение(грн)',
            ]);
        });
        add_action('woocommerce_product_options_general_product_data', function () {
            woocommerce_wp_checkbox([
                'id' => 'label_new',
                'label' => 'Новый товар',
            ]);
        });

        add_action('woocommerce_process_product_meta', function ($post_id) {
            $product = wc_get_product($post_id);
            $fields = ['label_new'];
            foreach ($fields as $field) {
                $title = $_POST[$field] ?? '';
                $product->update_meta_data($field, sanitize_text_field($title));
            }

            $special_price = $_POST['special_price'] ?? null;
            $product->update_meta_data('special_price', intval(sanitize_text_field($special_price)));

            $product->save();
        });
    }

    private function saveForLater()
    {
        $cart = WC()->cart;
        $key = $_POST['save'];
        $item = $cart->get_cart_item($key);

        $cart->remove_cart_item($key);

        $instance = TInvWL_Public_Wishlist_View::instance();
        $wishlist = $instance->get_current_wishlist();

        $wlp = new TInvWL_Product($wishlist);
        $wlp->add_product(apply_filters('tinvwl_addtowishlist_add', [
            'product_id' => $item['product_id'],
            'quantity' => 1,
        ]));
    }

    public function miniCart()
    {
        $WC_Widget_Cart = new WC_Widget_Cart();
        $WC_Widget_Cart->widget([], ['title' => '']);
    }

    private function comments()
    {
        add_action('comment_post', function ($id) {
            $fields = ['advantages', 'disadvantages'];
            foreach ($fields as $field) {
                update_field($field, $_POST[$field], get_comment($id));
            }
        });
        add_filter('comment_post_redirect', function () {
            return $_SERVER["HTTP_REFERER"];
        });
    }

    public function paginationText()
    {
        global $wp_query;
        $all = $wp_query->found_posts;
        if ($all !== 0) {
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $limit = $wp_query->get('posts_per_page');
            $from = ($paged - 1) * $limit + 1;
            $to = $paged * $limit;
            if ($wp_query->post_count !== $limit) {
                $to = ($paged - 1) * $limit;
                $to += $wp_query->post_count;
            }

            return lang() == 'ru' ? "Показано с $from по $to из $all" : "Показано з $from по $to із $all";
        }

        return false;
    }

    //special offer methods

    public function specialOffer()
    {
        add_action('template_redirect', function () {
            if (isset($_POST['action']) && $_POST['action'] == 'special') {
                $id = get_the_ID();
                $key = product_in_cart($id);
                if ($key) {
                    WC()->cart->remove_cart_item($key);
                }
                WC()->cart->add_to_cart($id);
            }
        });

        add_filter('woocommerce_add_to_cart_validation', function ($passed, $product_id) {
            $key = product_in_cart($product_id);
            if ($key) {
                $product = WC()->cart->get_cart()[$key];
                if ($product['offerTo']) {
                    WC()->cart->set_quantity($key, WC()->cart->get_cart()[$key]['quantity'] + 1);
                    WC_AJAX::get_refreshed_fragments();

                    return false;
                }
            }

            return $passed;
        }, 10, 5);

        add_filter('woocommerce_add_cart_item_data', function ($cartItemData, $productId) {
            if (isset($_POST['action']) && $_POST['action'] == 'special') {

                $special = $this->specialProduct($productId);
                if ($special && $productId != $special && !product_in_cart($special)) {
                    $cartItemData['offerTo'] = WC()->cart->add_to_cart($special);
                    wp_redirect(wc_get_cart_url());
                }
            }

            return $cartItemData;
        }, 10, 3);


        add_action('woocommerce_remove_cart_item', function ($removed_key) {

            foreach (WC()->cart->cart_contents as $key => $cart_item) {
                if (isset($cart_item['offerTo']) && $cart_item['offerTo'] == $removed_key) {
                    unset(WC()->cart->cart_contents[$key]['offerTo']);
                }
            }
            WC()->cart->set_session();

        }, 10, 2);

        add_filter('woocommerce_get_cart_item_from_session', function ($cartItemData, $cartItemSessionData, $cartItemKey) {
            if (isset($cartItemSessionData['offerTo'])) {
                $cartItemData['offerTo'] = $cartItemSessionData['offerTo'];
            }

            return $cartItemData;
        }, 10, 3);

        add_filter('woocommerce_calculated_total', function ($total) {
            return $total - watch()->woo()->specialOfferDiscount();
        }, 10, 2);
    }

    public function specialProduct($id)
    {
        $special = get_field('special', wp_get_post_terms($id, 'product_cat')[0]);
        $special = $special ?: get_field('special', $id);

        return $special->ID;
    }

    public function specialOfferDiscount()
    {
        $saleKey = null;
        $discount = 0;
        foreach (WC()->cart->get_cart() as $cart_item) {
            if (isset($cart_item['offerTo'])) {
                $saleKey = $cart_item['offerTo'];
            }
            if ($saleKey) {
                $special_item = WC()->cart->get_cart()[$saleKey];
                if ($special_item) {
                    $product = wc_get_product($special_item['product_id']);
                    $special = $product->get_meta('special_price');
                    if ($special) {
                        $price = $product->get_price();
                        $diff = $price - $special;
                        $discount = $diff > $discount ? $diff : $discount;
                    }
                }
            }
        }

        return $discount;
    }
}