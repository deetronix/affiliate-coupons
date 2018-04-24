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

/**
 * Embed AMP styles
 *
 * @param $file
 * @return mixed|string
 */
function affcoups_asset_embed( $file ) {

    $response = wp_remote_get( $file );

    if ( ! is_array( $response ) || ! isset( $response['body'] ) )
        return '';

    $content = $response['body'];

    $targetUrl = AFFCOUPS_URL . 'public/';

    $rewriteUrl = function ($matches) use ($targetUrl) {
        $url = $matches['url'];
        // First check also matches protocol-relative urls like //example.com
        if ((isset($url[0])  && '/' === $url[0]) || false !== strpos($url, '://') || 0 === strpos($url, 'data:')) {
            return $matches[0];
        }
        return str_replace($url, $targetUrl . '/' . $url, $matches[0]);
    };

    $content = preg_replace_callback('/url\((["\']?)(?<url>.*?)(\\1)\)/', $rewriteUrl, $content);
    $content = preg_replace_callback('/@import (?!url\()(\'|"|)(?<url>[^\'"\)\n\r]*)\1;?/', $rewriteUrl, $content);
    // Handle 'src' values (used in e.g. calls to AlphaImageLoader, which is a proprietary IE filter)
    $content = preg_replace_callback('/\bsrc\s*=\s*(["\']?)(?<url>.*?)(\\1)/i', $rewriteUrl, $content);

    return $content;
}

/**
 * Get AMP Styles
 *
 * @return mixed|null|string
 */
function affcoups_get_amp_styles() {

    $options_output = affcoups_get_options();

    // Core styles
    if ( ! affcoups_is_development() )
        $amp_styles = get_transient( 'affcoups_amp_styles' );

    if ( empty( $amp_styles ) ) {
        $amp_styles = affcoups_asset_embed( AFFCOUPS_URL . 'public/css/amp.min.css' );

        set_transient( 'affcoups_amp_styles', $amp_styles, 60 * 60 * 24 * 7 );
    }

    // Custom styles
    $custom_css_activated = ( isset ( $options_output['custom_css_activated'] ) && $options_output['custom_css_activated'] == '1' ) ? 1 : 0;
    $custom_css = ( ! empty ( $options_output['custom_css'] ) ) ? $options_output['custom_css'] : '';

    if ( $custom_css_activated == '1' && $custom_css != '' ) {
        $amp_styles .= stripslashes( $custom_css );
    }

    if ( ! empty( $amp_styles ) )
        $amp_styles = affcoups_cleanup_css_for_amp( $amp_styles );

    return $amp_styles;
}

/**
 * Cleanup css for AMP usage
 *
 * @param string $css
 *
 * @return mixed|string
 */
function affcoups_cleanup_css_for_amp( $css = '' ) {

    $css = stripslashes( $css );

    // Remove important declarations
    $css = str_replace('!important', '', $css);

    return $css;
}