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
