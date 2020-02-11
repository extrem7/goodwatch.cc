<?php
/* @var $wrap_before string
 * @var $delimiter string
 * @var $wrap_after string
 */

if (is_tax('pwb-brand')) {
    $brands = apply_filters('wpml_object_id', 2583, 'post');
    $breadcrumb[1][0] = get_the_title($brands);
    $breadcrumb[1][1] = get_permalink($brands);
}

if (is_filtered()) {
    global $wp_query;
    if (!empty($wp_query->query_vars['tax_query'])) {
        foreach ($wp_query->query_vars['tax_query'] as $value) {
            if (is_array($value)) {
                if (strpos($value['taxonomy'], 'pa_') === false) continue;
                foreach ($value['terms'] as $slug) {
                    $term = get_term_by('slug', $slug, $value['taxonomy']);
                    array_push($breadcrumb, [$term->name]);
                }
            }
        }
    }
}

if (!empty($breadcrumb)) {
    echo $wrap_before;
    foreach ($breadcrumb as $key => $crumb) {
        $icon = $key == 0 ? '<i class="fas fa-home"></i> ' : '';
        if (!empty($crumb[1]) && sizeof($breadcrumb) !== $key + 1) {
            echo '<a href="' . esc_url($crumb[1]) . '">' . $icon . esc_html($crumb[0]) . '</a>';
        } else {
            echo esc_html($crumb[0]);
        }
        if (sizeof($breadcrumb) !== $key + 1) {
            echo $delimiter;
        }
    }
    echo $wrap_after;
}