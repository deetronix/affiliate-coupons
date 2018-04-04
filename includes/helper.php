<?php
/**
 * Helper
 *
 * @package     AffiliateCoupons\Helper
 * @since       1.0.0
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Cleanup string in order to be used inside html attributes (title, alt etc.) without breaking the markup
 *
 * @param $str
 *
 * @return mixed|string
 */
function affcoups_cleanup_html_attribute( $str ) {

	// Remove html.
	$str = strip_tags( $str );

	// Remove apostrophes.
	$str = str_replace( array( '"', "'" ), '', $str );

	return $str;
}

/**
 * Convert separated strings to array
 *
 * @param $string
 *
 * @return array
 */
function affcoups_convert_separated_strings_to_array( $string ) {

	// Remove spaces.
	$string = str_replace( ' ', '', $string );

	// Convert to array.
	$array = explode( ',', $string );

	return $array;
}

/**
 * Get options
 *
 * return array options or empty when not available
 */
function affcoups_get_options() {
	return get_option( 'affcoups_settings', array() );
}

/**
 * Get single option
 *
 * @param $key
 * @param null $default
 *
 * @return null
 */
function affcoups_get_option( $key, $default = null ) {
	$options = affcoups_get_options();

	return ( isset( $options[ $key ] ) ) ? $options[ $key ] : $default;
}

/**
 * Output public assets folder url
 */
function affcoups_the_assets() {
	echo esc_url( affcoups_get_assets_url() );
}

/**
 * Get public assets folder url
 *
 * @return string
 */
function affcoups_get_assets_url() {
	return AFFCOUPS_URL . 'public/';
}

/**
 * Check whether it's development environment or not
 */
function affcoups_is_development() {
	return ( strpos( get_bloginfo( 'url' ), 'affcoups.dev' ) !== false ) ? true : false;
}

/**
 * Check if AMP endpoint
 */
function affcoups_is_amp() {

	if ( function_exists( 'is_amp_endpoint' ) && is_amp_endpoint() ) {
		return true;
	}

	if ( function_exists( 'is_wp_amp' ) && is_wp_amp() ) {
		return true;
	}

	return false;
}

/**
 * Check whether we are on our admin pages or not
 *
 * @return bool
 */
function affcoups_is_plugin_admin_area() {

	$screen = get_current_screen();

	return ( strpos( $screen->id, 'affcoups' ) !== false ) ? true : false;
}

/**
 * Get website url
 *
 * @param $path
 * @param string $source
 *
 * @return string
 */
function affcoups_get_website_url( $path = '', $source = 'plugin-settings' ) {

	$url = 'https://affcoups.com/';

	if ( ! empty( $path ) ) {
		$url .= trim( $path, '/' ) . '/';
	}

	return esc_url( add_query_arg( array(
		'utm_source'   => $source,
		'utm_medium'   => 'plugin-row',
		'utm_campaign' => 'Affiliate Coupons',
	), $url ) );
}

/**
 * Truncate string
 *
 * @param $str
 * @param int $limit
 * @param string $pad
 *
 * @return mixed|string
 */
function affcoups_truncate_string( $str, $limit = 200, $pad = '...' ) {

	$limit = intval( $limit );

	if ( strlen( $str ) > $limit ) {
		$str = preg_replace( '/\s+?(\S+)?$/', '', substr( $str, 0, $limit + 1 ) );

		$str = rtrim( $str, '.' );
		$str = rtrim( $str, ',' );
		$str = rtrim( $str, '-' );

		$str .= $pad;
	}

	return $str;
}

// @codingStandardsIgnoreStart
/**
 * Debug
 *
 * @param $args
 * @param bool $title
 */
function affcoups_debug( $args, $title = false ) {

	if ( $title ) {
		echo '<h3>' . esc_html( $title ) . '</h3>';
	}

	if ( $args ) {
		echo '<pre>';
		print_r( $args );
		echo '</pre>';
	}
}

/**
 * Debug log
 *
 * @param $log
 */
function affcoups_debug_log( $log ) {

	if ( ! affcoups_is_development() ) {
		return;
	}

	if ( is_array( $log ) || is_object( $log ) ) {
		error_log( print_r( $log, true ) );
	} else {
		error_log( $log );
	}
}
// @codingStandardsIgnoreEnd