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

global $affcoups_shortcode_atts;

/*
 * Get content from a single post
 */
function affcoups_get_post_content( $postid = null ) {

    if ( empty ( $postid ) )
        $postid = get_the_ID();

    $post = get_post( $postid );
    $content = $post->post_content;
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);

    return $content;
}

/**
 * Check content if scripts must be loaded
 */
function affcoups_has_plugin_content() {

    global $post;

    if( ( is_a( $post, 'WP_Post' ) && ( has_shortcode( $post->post_content, 'affcoups') || has_shortcode( $post->post_content, 'affcoups_coupons') ) ) ) {
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