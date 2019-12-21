<?php
/**
 * Functions
 *
 * @package     AffiliateCoupons\Functions
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $affcoups_shortcode_atts; // User input
global $affcoups_template_args; // Template variables

/**
 * Check content if scripts must be loaded
 */
function affcoups_has_plugin_content() {

	global $post;

	if ( ( is_a( $post, 'WP_Post' ) && ( has_shortcode( $post->post_content, 'affcoups' ) || has_shortcode( $post->post_content, 'affcoups_coupons' ) ) ) ) {
		return true;
	}

	return false;
}

/**
 * Get coupon post type slug
 *
 * @return string
 */
function affcoups_get_coupon_post_type_slug() {
	return apply_filters( 'affcoups_coupon_post_type_slug', 'coupons' );
}

/**
 * Get coupons
 *
 * @param array $args
 * @param bool $return_posts
 * @return array
 */
function affcoups_get_coupons( $args = array(), $return_posts = false ) {

    $coupons = array();

    $hide_invalid = ( isset( $args['affcoups_coupon_hide_invalid'] ) && true === $args['affcoups_coupon_hide_invalid'] ) ? true : false;
    $hide_expired = ( isset( $args['affcoups_coupon_hide_expired'] ) && true === $args['affcoups_coupon_hide_expired'] ) ? true : false;

    $max = ( isset( $args['affcoups_max'] ) && is_numeric( $args['affcoups_max'] ) ) ? $args['affcoups_max'] : 0;

    $defaults = array(
        'post_type'      => AFFCOUPS_COUPON_POST_TYPE,
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        //'nopaging' => true,
        'orderby'        => 'name',
        'order'          => 'ASC',
    );

    // Parse args
    $args = wp_parse_args( $args, $defaults );

    // Prepare additional queries
    $meta_queries = array(
        'relation' => 'AND'
    );

    $tax_queries = array(
        'relation' => 'AND'
    );

    //-- Number
    if ( ! empty ( $max ) && ( $hide_invalid || $hide_expired ) )
        $args['posts_per_page'] = -1;

    if ( $args['posts_per_page'] < 1 )
        $args['posts_per_page'] = 999999999999;

    //-- Order
    if ( ! empty( $args['affcoups_order'] ) ) {

        $order_options = array( 'ASC', 'DESC' );

        $order = strtoupper( $args['affcoups_order'] );

        if ( in_array( $order, $order_options ) ) {
            $args['order'] = $order;
        }
    }

    if ( ! empty( $args['affcoups_orderby'] ) ) {

        $orderby = strtolower( $args['affcoups_orderby'] );

        if ( 'name' === $orderby ) {
            $args['orderby'] = 'name';

        } elseif ( 'date' === $orderby ) {
            $args['orderby'] = 'date';

        } elseif ( 'random' === $orderby ) {
            $args['orderby'] = 'rand';

        } elseif ( 'title' === $orderby ) {
            $args['orderby']  = 'meta_value';
            $args['meta_key'] = AFFCOUPS_PREFIX . 'coupon_title';

        } elseif ( 'description' === $orderby ) {
            $args['orderby']  = 'meta_value';
            $args['meta_key'] = AFFCOUPS_PREFIX . 'coupon_description';

        } elseif ( 'discount' === $orderby ) {
            $args['orderby']  = 'meta_value_num';
            $args['meta_key'] = AFFCOUPS_PREFIX . 'coupon_discount';

        } elseif ( 'valid_from' === $orderby ) {
            $args['orderby']  = 'meta_value_num';
            $args['meta_key'] = AFFCOUPS_PREFIX . 'coupon_valid_from';

        } elseif ( 'valid_until' === $orderby || 'valid_to' === $orderby ) {
            $args['orderby']  = 'meta_value_num';
            $args['meta_key'] = AFFCOUPS_PREFIX . 'coupon_valid_until';

        } elseif ( 'none' === $orderby ) {
            $args['orderby']  = 'none';
        }
    }

    //-- ID
    if ( ! empty( $args['affcoups_coupon_id'] ) ) {

        if ( is_array( $args['affcoups_coupon_id'] ) ) {
            $coupon_ids = $args['affcoups_coupon_id'];
        } else {
            $coupon_ids = explode( ',', esc_html( $args['affcoups_coupon_id'] ) );
        }

        if ( sizeof( $coupon_ids ) > 0 ) {
            $args['post__in'] = $coupon_ids;
            $args['posts_per_page'] = sizeof( $coupon_ids );

            if ( 'none' === $args['orderby'] )
                $args['orderby'] = 'post__in';
        }
    }

    //-- Category
    if ( ! empty( $args['affcoups_coupon_category'] ) ) {

        $coupon_categories = explode( ',', esc_html( $args['affcoups_coupon_category'] ) );

        $coupon_category_tax_field = ( isset( $coupon_categories[0] ) && is_numeric( $coupon_categories[0] ) ) ? 'term_id' : 'slug';

        $tax_queries[] = array(
            'taxonomy' => 'affcoups_coupon_category',
            'field'    => $coupon_category_tax_field,
            'terms'    => $coupon_categories,
            'operator' => 'IN'
        );
    }

    //-- Type
    if ( ! empty( $args['affcoups_coupon_type'] ) ) {

        $coupon_types = explode( ',', esc_html( $args['affcoups_coupon_type'] ) );

        $coupon_type_tax_field = ( isset( $coupon_types[0] ) && is_numeric( $coupon_types[0] ) ) ? 'term_id' : 'slug';

        $tax_queries[] = array(
            'taxonomy' => 'affcoups_coupon_type',
            'field'    => $coupon_type_tax_field,
            'terms'    => $coupon_types,
            'operator' => 'IN'
        );
    }

    //-- Vendor
    if ( ! empty( $args['affcoups_coupon_vendor'] ) ) {

        $coupon_vendors = explode( ',', esc_html( $args['affcoups_coupon_vendor'] ) );

        $meta_queries[] = array(
            'key'     => AFFCOUPS_PREFIX . 'coupon_vendor',
            'value'   => $coupon_vendors,
            'compare' => 'IN',
        );
    }

    //-- Expiration
    if ( isset( $args['affcoups_coupon_hide_invalid'] ) && true === $args['affcoups_coupon_hide_invalid'] ) {

        $hide_invalid = true;

        /*
        $meta_queries[] = array(
            'relation' => 'OR',
            // From date not set yet
            array(
                'key'     => AFFCOUPS_PREFIX . 'coupon_valid_from',
                'value'   => '',
                'compare' => 'NOT EXISTS',
                'type'    => 'NUMERIC'
            ),
            // Not valid yet
            array(
                'key'     => AFFCOUPS_PREFIX . 'coupon_valid_from',
                'value'   => time(),
                'compare' => '<',
                'type'    => 'NUMERIC'
            )
        );
        */
    }

    if ( isset( $args['affcoups_coupon_hide_expired'] ) && true === $args['affcoups_coupon_hide_expired'] ) {

        $hide_expired = true;

        /*
        $meta_queries[] = array(
            array(
                'key'     => AFFCOUPS_PREFIX . 'coupon_valid_until',
                'compare' => 'EXISTS',
            ),
        );
        */

        /*
        $meta_queries[] = array(
            'relation' => 'OR',
            // Until date not set yet
            /*
            array(
                'key'     => AFFCOUPS_PREFIX . 'coupon_valid_until',
                'value'   => '',
                'compare' => 'NOT EXISTS',
            ),*/
            /*
            array(
                'key'     => AFFCOUPS_PREFIX . 'coupon_valid_until',
                'compare' => 'NOT EXISTS',
            ),
            */
            /*array(
                'key'     => AFFCOUPS_PREFIX . 'coupon_valid_until',
                'compare' => 'EXISTS',
            ),*/
            /*
            array(
                'key'     => AFFCOUPS_PREFIX . 'coupon_valid_until',
                'value'   => '',
                'compare' => '=',
            ),
            */
            /*array(
                'key'     => AFFCOUPS_PREFIX . 'coupon_valid_until',
                'value'   => '',
                'compare' => 'NOT EXISTS',
                'type'    => 'NUMERIC'
            ),*/
            // Already expired
            /*array(
                'key'     => AFFCOUPS_PREFIX . 'coupon_valid_until',
                'value'   => time(),
                'compare' => '>=',
                'type'    => 'NUMERIC'
            )
        );*/
    }

    // Set meta queries
    if ( sizeof( $meta_queries ) > 1 ) {
        $args['meta_query'] = $meta_queries;
    }

    // Set tax queries
    if ( sizeof( $tax_queries ) > 1 ) {
        $args['tax_query'] = $tax_queries;
    }

    //affcoups_debug( $args, 'affcoups_get_coupons $args' );

    $coupon_pre_posts = apply_filters( 'affcoups_get_coupons_pre_posts', array(), $args );
    //affcoups_debug( $coupon_pre_posts, 'affcoups_get_coupons $coupon_pre_posts' );

    $args = apply_filters( 'affcoups_get_coupons_args', $args, $coupon_pre_posts );
    //affcoups_debug( $args, 'affcoups_get_coupons $args' );

    // Fetch posts
    if ( $args['posts_per_page'] === 0 ) {
        $coupon_posts = $coupon_pre_posts;
    } else {
        $coupons_query = new WP_Query( $args );
        //affcoups_debug( $coupons_query->posts, 'affcoups_get_coupons $coupons_query->posts' );
        $coupon_posts = ( isset( $coupons_query->posts ) ) ? array_merge_recursive( $coupon_pre_posts, $coupons_query->posts ) : null;
        wp_reset_postdata();
    }

    //affcoups_debug( $coupon_posts, 'affcoups_get_coupons $coupon_posts' );
    $coupon_posts = apply_filters( 'affcoups_get_coupons_posts', $coupon_posts, $args );

    /*
     * Handle filtering coupons by invalid/expired dates
     */
    if ( $hide_invalid || $hide_expired ) {

        foreach ( $coupon_posts as $coupon_key => $coupon_post ) {

            if ( $hide_invalid ) {

                $coupon_valid_from = get_post_meta( $coupon_post->ID, AFFCOUPS_PREFIX . 'coupon_valid_from', true );

                if ( ! empty ( $coupon_valid_from ) && time() < $coupon_valid_from )
                    unset ( $coupon_posts[$coupon_key] );
            }

            if ( $hide_expired ) {

                $coupon_valid_until = get_post_meta( $coupon_post->ID, AFFCOUPS_PREFIX . 'coupon_valid_until', true );

                if ( ! empty ( $coupon_valid_until ) && $coupon_valid_until < time() )
                    unset ( $coupon_posts[$coupon_key] );
            }
        }

        if ( ! empty ( $max ) && sizeof( $coupon_posts ) > $max )
            $coupon_posts = array_slice( $coupon_posts, 0, $max );
    }

    //affcoups_debug( $coupon_posts );

    if ( $return_posts )
        return $coupon_posts;

    if ( is_array( $coupon_posts ) && sizeof( $coupon_posts ) > 0 ) {

        foreach ( $coupon_posts as $coupon_post ) {
            $coupons[] = new Affcoups_Coupon( $coupon_post );
        }
    }

    //-- Apply filters
    $coupons = apply_filters( 'affcoups_get_coupons_objects', $coupons );

    //affcoups_debug( $coupons, '$coupons' );

    return $coupons;
}

/**
 * Setup Coupon
 *
 * @param $coupon_post
 * @return mixed
 */
function affcoups_setup_coupon( $coupon_post ) {

    $classname = apply_filters( 'Affcoups_Coupon', 'affcoups_coupon_classname' );

    return new $classname( $coupon_post );
}

/**
 * Get coupon options
 *
 * @param array $args
 *
 * @return array
 */
function affcoups_get_coupon_options( $args = array() ) {

    $defaults = array(
        'orderby' => 'date',
        'order'   => 'DESC'
    );

    // Parse args
    $args = wp_parse_args( $args, $defaults );

    $coupons = affcoups_get_coupons( $args, true );

    $options = array(
        0 => __( 'Please select...', 'affiliate-coupons' )
    );

    if ( is_array( $coupons ) && sizeof( $coupons ) > 0 ) {

        foreach ( $coupons as $coupon ) {
            $options[ $coupon->ID ] = $coupon->post_title;
        }
    }

    return $options;
}

/**
 * Display coupon categories
 */
function affcoups_get_category_taxonomy() {

    $options = array(
        0 => __( 'Please select...', 'affiliate-coupons' )
    );

    $terms = get_terms( [
        'taxonomy' => 'affcoups_coupon_category'
    ] );

    if ( sizeof( $options ) > 0 ) {

        foreach ( $terms as $term ) {
            $options[ $term->term_id ] = $term->name;
        }

    }

    return $options;
}

/**
 * Display coupon types
 */
function affcoups_get_types_taxonomy() {

    $options = array(
        0 => __( 'Please select...', 'affiliate-coupons' )
    );

    $types = get_terms( [
        'taxonomy' => 'affcoups_coupon_type'
    ] );

    if ( sizeof( $options ) > 0 ) {

        foreach ( $types as $type ) {
            $options[ $type->term_id ] = $type->name;
        }

    }

    return $options;
}

/**
 * Get coupon options
 */
function affcoups_get_vendors_list() {

    $vendors = affcoups_get_vendors();

    $options = array(
        0 => __( 'Please select...', 'affiliate-coupons' )
    );

    if ( is_array( $vendors ) && sizeof( $options ) > 0 ) {

        foreach ( $vendors as $vendor ) {
            $options[ $vendor->ID ] = $vendor->post_title;
        }
    }

    return $options;
}

/**
 * Get coupons
 */
function affcoups_get_vendors() {

    $args = array(
        'post_type'      => AFFCOUPS_VENDOR_POST_TYPE,
        'post_status'    => 'publish',
        'posts_per_page' => - 1,
        //'nopaging' => true,
        'orderby'        => 'name',
        'order'          => 'ASC',
    );

    // Fetch posts
    $vendors = get_posts( $args );

    return $vendors;
}

/**
 * Get template options
 *
 * @return array
 */
function affcoups_get_template_options() {

    $options = array(
        'standard' => __( 'Standard', 'affiliate-coupons' ),
        'grid'     => __( 'Grid', 'affiliate-coupons' ),
        'list' => __( 'List', 'affiliate-coupons' ),
    );

    $options = apply_filters( 'affcoups_template_options', $options );

    return $options;
}

/**
 * Get widget template options
 *
 * @return array
 */
function affcoups_get_widget_template_options() {

    $options = array(
        'widget' => __( 'Standard', 'affiliate-coupons' ),
    );

    $options = apply_filters( 'affcoups_widget_template_options', $options );

    return $options;
}

/**
 * Get style options
 *
 * @return array
 */
function affcoups_get_style_options() {

    $options = array(
        'standard' => __( 'Standard', 'affiliate-coupons' )
    );

    $options = apply_filters( 'affcoups_style_options', $options );

    return $options;
}

/**
 * Get orderby options
 *
 * @return array
 */
function affcoups_get_orderby_options() {

    $options = array(
        'name'        => __( 'Name (Post)', 'affiliate-coupons' ),
        'date'        => __( 'Date published (Post)', 'affiliate-coupons' ),
        'title'       => __( 'Title (Coupon)', 'affiliate-coupons' ),
        'description' => __( 'Description (Coupon)', 'affiliate-coupons' ),
        'discount'    => __( 'Discount (Coupon)', 'affiliate-coupons' ),
        'valid_from'  => __( 'Valid from date (Coupon)', 'affiliate-coupons' ),
        'valid_until' => __( 'Valid until date (Coupon)', 'affiliate-coupons' ),
        'random'      => __( 'Random', 'affiliate-coupons' )
    );

    $options = apply_filters( 'affcoups_orderby_options', $options );

    return $options;
}