<?php

//cool functions for development

function pre( $array ) {
	echo "<pre>";
	print_r( $array );
	echo "</pre>";
}

function dd($array)
{
    pre($array);
    exit;
}

function path() {
	return get_template_directory_uri() . '/';
}

function tel( $phone ) {
	return 'tel:' . preg_replace( '/[^0-9]/', '', $phone );
}

function the_post_content() {
	global $id;
	echo apply_filters( 'the_content', wpautop( get_post_field( 'post_content', $id ), true ) );
}

function the_image( $name, $class = '', $post = null, $size = 'full' ) {
	if ( $post == null ) {
		global $post;
	}

	$image = get_field( $name, $post );

	if ( $post == 'option' ) {
		$src = $image['url'];
		$alt = $image['alt'];
		echo "<img src='$src' alt='$alt' class='$class' />";
	} else {

		echo wp_get_attachment_image( $image, $size, false, [ 'class' => $class ] );
	}
}

function the_icon( $name, $echo = true ) {
	$icon = file_get_contents( path() . "assets/img/icons/$name.svg" );
	if ( $echo ) {
		echo $icon;

		return true;
	}

	return file_get_contents( path() . "assets/img/icons/$name.svg" );
}

function the_checkbox( $field, $print, $post = null ) {
	if ( $post == null ) {
		global $post;
	}
	echo get_field( $field, $post ) ? $print : null;
}

function the_table( $field, $post = null ) {
	if ( $post == null ) {
		global $post;
	}
	$table = get_field( $field, $post );
	if ( $table ) {
		echo '<table>';
		if ( $table['header'] ) {
			echo '<thead>';
			echo '<tr>';
			foreach ( $table['header'] as $th ) {
				echo '<th>';
				echo $th['c'];
				echo '</th>';
			}
			echo '</tr>';
			echo '</thead>';
		}
		echo '<tbody>';
		foreach ( $table['body'] as $tr ) {
			echo '<tr>';
			foreach ( $tr as $td ) {
				echo '<td>';
				echo $td['c'];
				echo '</td>';
			}
			echo '</tr>';
		}
		echo '</tbody>';
		echo '</table>';
	}
}

function the_link( $field, $post = null, $classes = "" ) {
	if ( $post == null ) {
		global $post;
	}
	$link = get_field( $field, $post );
	if ( $link ) {
		echo "<a ";
		echo "href='{$link['url']}'";
		echo "class='$classes'";
		echo "target='{$link['target']}'>";
		echo $link['title'];
		echo "</a>";
	}
}

function repeater_image( $name ) {
	echo 'src="' . get_sub_field( $name )['url'] . '" ';
	echo 'alt="' . get_sub_field( $name )['alt'] . '" ';
}

function lang() {
	return ICL_LANGUAGE_CODE;
}

function current_location() {
	if ( isset( $_SERVER['HTTPS'] ) &&
	     ( $_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1 ) ||
	     isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) &&
	     $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' ) {
		$protocol = 'https://';
	} else {
		$protocol = 'http://';
	}
	$uri_parts = explode( '?', $_SERVER['REQUEST_URI'], 2 );

	return $protocol . $_SERVER['HTTP_HOST'] . $uri_parts[0];
}

function pll_cf7( $ru, $uk, $class = '' ) {
	$id = lang() == 'ru' ? $ru : $uk;
	echo do_shortcode( "[contact-form-7 id='$id' html_class='$class']" );
}


// woocommerce functions

function categoryImage( $termId ) {
	return get_term_meta( $termId, 'thumbnail_id', true );
}

function the_price( $product = null ) {
	if ( $product == null ) {
		global $product;
	}
	echo wc_price( $product->get_price() );
}

function the_sku( $product = null ) {
	if ( $product == null ) {
		global $product;
	}
	echo $product->get_sku();
}

function the_cart_url( $product = null ) {
	if ( $product == null ) {
		global $product;
	}
	echo $product->add_to_cart_url();
}

function the_rating( $rate ) {
	for ( $i = 1; $i <= $rate; $i ++ ) {
		echo '<i class="fas fa-star"></i>';
	}
	for ( $i = 1; $i <= 5 - floor( $rate ); $i ++ ) {
		echo '<i class="far fa-star"></i>';
	}
}

function the_checkout_field( $key, $field, $checkout, $placeholder ) {
	$field['class'][]       = 'form-group';
	$field['label']         = null;
	$field['input_class'][] = 'control-form';
	$field['placeholder']   = $placeholder;
	woocommerce_form_field( $key, $field, $checkout->get_value( $key ) );
}

function shop_url() {
	echo get_permalink( wc_get_page_id( 'shop' ) );
}

function cart_url() {
	echo wc_get_cart_url();
}

function checkout_url() {
	echo wc_get_checkout_url();
}

function wishlist_url() {
	echo tinv_url_wishlist_default();
}

function account_url() {
	echo get_permalink( wc_get_page_id( 'myaccount' ) );
}

function cart_content() {
	echo WC()->cart->get_cart_contents_count() ?: '';
}

function cart_active() {
	echo WC()->cart->get_cart_contents_count() && ! is_cart() ? 'active' : '';
}

function cart_total() {
	echo WC()->cart->get_total();
}

function product_in_cart( $id ) {

	foreach ( WC()->cart->get_cart() as $key => $val ) {
		$_product = $val['data'];

		if ( $id == $_product->id ) {
			return $key;
		}
	}

	return false;
}

function sort_by_key( $array, $on, $order = SORT_ASC ) {
	$new_array      = array();
	$sortable_array = array();
	if ( count( $array ) > 0 ) {
		foreach ( $array as $k => $v ) {
			if ( is_array( $v ) ) {
				foreach ( $v as $k2 => $v2 ) {
					if ( $k2 == $on ) {
						$sortable_array[ $k ] = $v2;
					}
				}
			} else {
				$sortable_array[ $k ] = $v;
			}
		}
		switch ( $order ) {
			case SORT_ASC:
				asort( $sortable_array );
				break;
			case SORT_DESC:
				arsort( $sortable_array );
				break;
		}
		foreach ( $sortable_array as $k => $v ) {
			$new_array[ $k ] = $array[ $k ];
		}
	}

	return $new_array;
}

function is_gender()
{
    global $wp_query;
    $tax = $wp_query->get('tax_query');
    unset($tax['relation']);
    foreach ($tax as $key => $val) {
        if ($val['taxonomy'] === 'pa_gender') {
            return true;
        }
    }
    return false;
}

// lifehacks (мне стыдно за это)

function pll__($string)
{
    return icl_t('watch', $string, $string);
}

function pll_e($string)
{
    echo pll__($string);
}

function cl_acf_set_language()
{
    return acf_get_setting('default_language');
}

function wpml_fix_start()
{
    add_filter('acf/settings/current_language', 'cl_acf_set_language', 100);
}

function wpml_fix_end()
{
    remove_filter('acf/settings/current_language', 'cl_acf_set_language', 100);
}
