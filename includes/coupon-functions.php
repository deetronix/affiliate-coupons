<?php
/**
 * Coupon functions
 *
 * @package     AffiliateCoupons\CouponFunctions
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Get coupons
 *
 * @param array $args
 *
 * @return array WP_Post
 */
function affcoups_get_coupons( $args = array() ) {

    $coupons = array();

	$defaults = array(
		'post_type'      => 'affcoups_coupon',
		'post_status'    => 'publish',
		'posts_per_page' => - 1,
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

		} elseif ( 'valid_until' === $orderby ) {
			$args['orderby']  = 'meta_value_num';
			$args['meta_key'] = AFFCOUPS_PREFIX . 'coupon_valid_until';
		}

	}

	//-- ID
	if ( ! empty( $args['affcoups_coupon_id'] ) ) {

		$coupon_ids = explode( ',', esc_html( $args['affcoups_coupon_id'] ) );

		if ( sizeof( $coupon_ids ) > 0 ) {
			$args['post__in'] = $coupon_ids;
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
	if ( isset( $args['affcoups_coupon_hide_expired'] ) && true === $args['affcoups_coupon_hide_expired'] ) {

		$meta_queries[] = array(
			'relation' => 'OR',
			// Until date not set yet
			array(
				'key'     => AFFCOUPS_PREFIX . 'coupon_valid_until',
				'value'   => '',
				'compare' => 'NOT EXISTS',
				'type'    => 'NUMERIC'
			),
			// Already expired
			array(
				'key'     => AFFCOUPS_PREFIX . 'coupon_valid_until',
				'value'   => time(),
				'compare' => '>=',
				'type'    => 'NUMERIC'
			)
		);
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

	// Fetch posts
	$coupon_posts = get_posts( $args );

	if ( is_array( $coupon_posts ) && sizeof( $coupon_posts ) > 0 ) {

	    foreach ( $coupon_posts as $coupon_post ) {
            $coupons[] = new Affcoups_Coupon( $coupon_post );
        }
    }

	return $coupons;
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

	$coupons = affcoups_get_coupons( $args );

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
		'post_type'      => 'affcoups_vendor',
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
