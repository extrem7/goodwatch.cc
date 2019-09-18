<?php

if ( is_tax( 'pwb-brand' ) ) {
	$brands = pll_get_post( 2583 );
	$breadcrumb[1][0] = get_the_title($brands);
	$breadcrumb[1][1] = get_permalink( $brands );
}

if ( ! empty( $breadcrumb ) ) {
	echo $wrap_before;
	foreach ( $breadcrumb as $key => $crumb ) {
		$icon = $key == 0 ? '<i class="fas fa-home"></i> ' : '';
		if ( ! empty( $crumb[1] ) && sizeof( $breadcrumb ) !== $key + 1 ) {
			echo '<a href="' . esc_url( $crumb[1] ) . '">' . $icon . esc_html( $crumb[0] ) . '</a>';
		} else {
			echo esc_html( $crumb[0] );
		}
		if ( sizeof( $breadcrumb ) !== $key + 1 ) {
			echo $delimiter;
		}
	}
	echo $wrap_after;
}
