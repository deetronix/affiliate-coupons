<?php
/**
 * Darken color
 *
 * @param $color
 * @param int $dif
 *
 * @return null|string
 */
function affcoups_assets_color_darken( $color, $dif = 5 ) {

	if ( empty( $color ) ) {
		return null;
	}

	$color = str_replace( '#', '', $color );
	if ( strlen( $color ) !== 6 ) {
		return '000000';
	}
	$rgb = '';

	for ( $x = 0; $x < 3; $x ++ ) {
		$c   = hexdec( substr( $color, ( 2 * $x ), 2 ) ) - $dif;
		$c   = ( $c < 0 ) ? 0 : dechex( $c );
		$rgb .= ( strlen( $c ) < 2 ) ? '0' . $c : $c;
	}

	return '#' . $rgb;
}

/**
 * Embed AMP styles
 *
 * @param $file
 *
 * @return mixed|string
 */
function affcoups_asset_embed( $file ) {

	$response = wp_remote_get( $file );

	if ( ! is_array( $response ) || ! isset( $response['body'] ) ) {
		return '';
	}

	$content = $response['body'];

	$target_url = AFFCOUPS_PLUGIN_URL . 'assets/dist/';

	$rewrite_url = function ( $matches ) use ( $target_url ) {
		$url = $matches['url'];
		// First check also matches protocol-relative urls like //example.com
		if ( ( isset( $url[0] ) && '/' === $url[0] ) || false !== strpos( $url, '://' ) || 0 === strpos( $url, 'data:' ) ) {
			return $matches[0];
		}

		return str_replace( $url, $target_url . '/' . $url, $matches[0] );
	};

	$content = preg_replace_callback( '/url\((["\']?)(?<url>.*?)(\\1)\)/', $rewrite_url, $content );
	$content = preg_replace_callback( '/@import (?!url\()(\'|"|)(?<url>[^\'"\)\n\r]*)\1;?/', $rewrite_url, $content );
	// Handle 'src' values (used in e.g. calls to AlphaImageLoader, which is a proprietary IE filter)
	$content = preg_replace_callback( '/\bsrc\s*=\s*(["\']?)(?<url>.*?)(\\1)/i', $rewrite_url, $content );

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
	if ( ! affcoups_is_development() ) {
		$amp_styles = get_transient( 'affcoups_amp_styles' );
	}

	if ( empty( $amp_styles ) ) {
		$amp_styles = affcoups_asset_embed( AFFCOUPS_PLUGIN_URL . 'assets/dist/css/amp.css' );

		set_transient( 'affcoups_amp_styles', $amp_styles, 60 * 60 * 24 * 7 );
	}

	// Custom styles
	$custom_css_activated = ( isset( $options_output['custom_css_activated'] ) && '1' === $options_output['custom_css_activated'] ) ? 1 : 0;
	$custom_css           = ( ! empty( $options_output['custom_css'] ) ) ? $options_output['custom_css'] : '';

	if ( '1' === $custom_css_activated && '' !== $custom_css ) {
		$amp_styles .= stripslashes( $custom_css );
	}

	if ( ! empty( $amp_styles ) ) {
		$amp_styles = affcoups_cleanup_css_for_amp( $amp_styles );
	}

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
	$css = str_replace( '!important', '', $css );

	return $css;
}

/**
 * Get settings css
 *
 * @param bool $apply_prefix
 *
 * @return string
 */
function affcoups_get_settings_css( $apply_prefix = true ) {

	$options = affcoups_get_options();

	$prefix       = ( $apply_prefix ) ? '.affcoups ' : '';
	$settings_css = '';

    // Clipboard colors
    if ( ! empty( $options['clipboard_bg_color'] ) && ! empty( $options['clipboard_color'] ) ) {
        $settings_css .= $prefix . '.affcoups-clipboard { background-color: ' . $options['clipboard_bg_color'] . '; color: ' . $options['clipboard_color'] . '; border-color: ' . affcoups_assets_color_darken( $options['clipboard_bg_color'], 20 ) .'; }';
    }

	// Discount colors
	if ( ! empty( $options['discount_bg_color'] ) && ! empty( $options['discount_color'] ) ) {
		$settings_css .= $prefix . '.affcoups-coupon__discount { background-color: ' . $options['discount_bg_color'] . '; color: ' . $options['discount_color'] . '; }';
	}

	// Button Colors
	if ( ! empty( $options['button_bg_color'] ) && ! empty( $options['button_color'] ) ) {
		$settings_css .= affcoups_get_assets_button_styles( $options['button_bg_color'], $options['button_color'], $prefix );
	}

	$settings_css = apply_filters( 'affcoups_settings_css', $settings_css, $prefix );

	return $settings_css;
}

/**
 * Generate button styles
 *
 * @param null $bg_color
 * @param null $color
 * @param string $prefix
 *
 * @return string
 */
function affcoups_get_assets_button_styles( $bg_color, $color, $prefix = '' ) {

	$styles = '';

	$selector = 'a.affcoups-coupon__button';

	$styles .= $prefix . $selector . ' { background-color: ' . $bg_color . '; color: ' . $color . '; }';
	$styles .= $prefix . $selector . ':visited { color: ' . $color . '; }';
	$styles .= $prefix . $selector . ':hover, ' . $prefix . $selector . ':focus, ' . $prefix . $selector . ':active { background-color: ' . affcoups_assets_color_darken( $bg_color, 10 ) . '; color: ' . $color . '; }';

	return $styles;
}
