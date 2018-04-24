<?php
/*
 * Post lists
 */
function affcoups_add_coupons_shortcode( $atts, $content ) {
    extract( shortcode_atts( array(
        'category' => null,
        'type' => null,
        'max' => null,
        'orderby' => null,
        'grid' => null,
        'hide_expired' => null,
    ), $atts ) );

    // Prepare options
    $options = affcoups_get_options();

    // Default Query Arguments
    $args = array(
        'post_type' => 'affcoups_coupon',
        'nopaging' => true,
        'orderby' => 'name',
        'order' => 'ASC'
    );

    // Hide expired coupons
    $hide_expired_coupons = ( isset ( $options['hide_expired_coupons'] ) ) ? true : false;

    if ( ! empty ( $hide_expired ) ) // Maybe overwrite by shortcode
        $hide_expired_coupons = ( 'true' == $hide_expired ) ? true : false;

    if ( $hide_expired_coupons ) {

        $args['meta_query'] = array(
            'relation' => 'OR',
            // Until date not set yet
            array(
                'key' => AFFILIATE_COUPONS_PREFIX . 'coupon_valid_until',
                'value'   => '',
                'compare' => 'NOT EXISTS',
                'type' => 'NUMERIC'
            ),
            // Already expired
            array(
                'key' => AFFILIATE_COUPONS_PREFIX . 'coupon_valid_until',
                'value' => time(),
                'compare' => '>=',
                'type' => 'NUMERIC'
            )
        );
    }

    // Tax Queries
    $tax_queries = array(
        'relation' => 'AND'
    );

    // Categories
    if ( ! empty ( $category ) ) {

        $tax_queries[] = array(
            'taxonomy' => 'affcoups_coupon_category',
            'field' => ( is_numeric( $category ) ) ? 'term_taxonomy_id' : 'slug',
            'terms' => esc_attr( $category ), // array( $category )
            'operator' => 'IN'
        );
    }

    // Types
    if ( ! empty ( $type ) ) {

        $tax_queries[] = array(
            'taxonomy' => 'affcoups_coupon_type',
            'field' => ( is_numeric( $type ) ) ? 'term_taxonomy_id' : 'slug',
            'terms' => esc_attr( $type ), // array( $category )
            'operator' => 'IN'
        );
    }

    if ( sizeof( $tax_queries ) > 1 ) {
        $args['tax_query'] = $tax_queries;
    }

    // Max
    $args['numberposts'] = ( ! empty ( $max ) ) ? esc_attr( $max ) : '-1';

    // Orderby
    if ( !empty ( $orderby ) )
        $args['orderby'] = esc_attr( $orderby );

    // Grid
    $grid = ( ! empty ( $grid ) && is_numeric( $grid ) ) ? esc_attr( $grid ) : 3;

    //affcoups_debug($args);

    // The Query
    $posts = new WP_Query( $args );

    ob_start();

    if ( $posts->have_posts() ) {

        // Get template file
        $file = affcoups_get_template_file( 'coupons-grid', 'coupons' );

        echo '<div class="affcoups">';

        if ( file_exists( $file ) ) {
            include( $file );
        } else {
            _e('Template not found.', 'affiliate-coupons');
        }

        echo '</div>';

        ?>
        <?php
    } else {
        echo '<p>' . __('No coupons found.', 'affiliate-coupons') . '</p>';
    }

    $str = ob_get_clean();

    // Restore original Post Data
    wp_reset_postdata();

    return $str;
}
add_shortcode('affcoups_coupons', 'affcoups_add_coupons_shortcode');