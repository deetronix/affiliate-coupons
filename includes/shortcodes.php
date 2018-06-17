<?php
/**
 * Maybe cleanup content in order to remove empty p and br tags for our shortcodes
 */
function affcoups_maybe_cleanup_shortcode_output( $content ) {

	// array of custom shortcodes requiring the fix
	$block = join( '|', array(
		'affcoups',
		'affcoups_coupons',
	) );

	// opening tag
	$rep = preg_replace( "/(<p>)?\[($block)(\s[^\]]+)?\](<\/p>|<br \/>)?/", '[$2$3]', $content );

	// closing tag
	$rep = preg_replace( "/(<p>)?\[\/($block)](<\/p>|<br \/>)?/", '[/$2]', $rep );

	return $rep;
}

add_filter( 'the_content', 'affcoups_maybe_cleanup_shortcode_output' );

/**
 * Basic shortcode
 *
 * @param $atts
 * @param $content
 *
 * @return string*
 */
function affcoups_add_shortcode( $atts, $content ) {
	extract( shortcode_atts( array(
		'id'           => null,
		'category'     => null,
		'type'         => null,
		'vendor'       => null,
		'max'          => null,
		'grid'         => null,
		'hide_expired' => null,
		'template'     => null,
		'order'        => null,
		'orderby'      => null,
	), $atts ) );

	global $affcoups_shortcode_atts;

	$affcoups_shortcode_atts = $atts;

	// Prepare options
	$options = affcoups_get_options();

	// Defaults
	$args = array(
		'posts_per_page' => - 1,
		'orderby'        => 'name',
		'order'          => 'ASC',
	);

	//-- Max
	$args['posts_per_page'] = ( ! empty( $max ) && is_numeric( $max ) ) ? intval( $max ) : '-1';

	//-- Order
	if ( ! empty( $order ) ) {
		$args['affcoups_order'] = esc_html( $order );
	} else {
		$args['affcoups_order'] = ( ! empty( $options['order'] ) ) ? esc_html( $options['order'] ) : 'desc';
	}

	if ( ! empty( $orderby ) ) {
		$args['affcoups_orderby'] = esc_attr( $orderby );
	} else {
		$args['affcoups_orderby'] = ( ! empty( $options['orderby'] ) ) ? esc_html( $options['orderby'] ) : 'date';
	}

	//-- ID
	if ( ! empty( $id ) ) {
		$args['affcoups_coupon_id'] = esc_html( $id );
	}

	//-- Category
	if ( ! empty( $category ) ) {
		$args['affcoups_coupon_category'] = esc_html( $category );
	}

	//-- Type
	if ( ! empty( $type ) ) {
		$args['affcoups_coupon_type'] = esc_html( $type );
	}

	//-- Vendor
	if ( ! empty( $vendor ) ) {
		$args['affcoups_coupon_vendor'] = esc_html( $vendor );
	}

	//-- Expiration
	if ( ! empty( $hide_expired ) ) {
		$args['affcoups_coupon_hide_expired'] = ( 'true' === $hide_expired ) ? true : false;
	} else {
		$args['affcoups_coupon_hide_expired'] = ( isset( $options['hide_expired_coupons'] ) && '1' === $options['hide_expired_coupons'] ) ? true : false;
	}

	//affcoups_debug( $args );

	//-- Get coupons
	$coupons = affcoups_get_coupons( $args );

	//affcoups_debug( $coupons );

	ob_start();

	if ( $coupons->have_posts() ) {

		//echo 'Coupons found: ' . $coupons->post_count . '<br>';

		if ( affcoups_is_amp() ) {
			$template = 'amp';
		} else {

			// Defaults
			$template_default  = ( ! empty( $options['template'] ) ) ? esc_html( $options['template'] ) : 'standard';
			$grid_size_default = ( ! empty( $options['grid_size'] ) && is_numeric( $options['grid_size'] ) ) ? esc_html( $options['grid_size'] ) : 2;

			// Collect template settings
			$template  = ( ! empty( $template ) ) ? esc_html( $template ) : $template_default;
			$grid_size = $grid_size_default;

			// Grid Layout?
			if ( ! empty( $grid ) && is_numeric( $grid ) ) {
				$template  = 'grid';
				$grid_size = $grid;
			}
		}

		if ( 'widget' === $template ) {
			$template = 'standard';
		} // TODO: Remove when we have a real widget template

		// Store template variables
		global $affcoups_template_args;

		$affcoups_template_args['template']  = $template;
		$affcoups_template_args['grid_size'] = ( ! empty( $grid_size ) ) ? $grid_size : 0;

		//echo 'Grid: ' . $grid . '<br>';
		//echo 'Template: ' . $template . '<br>';

		// Get template file
		$file = affcoups_get_template_file( $template, 'coupons' );

		// Load template
		if ( file_exists( $file ) ) {
			include $file;
		} else {
			esc_html_e( 'Template not found.', 'affiliate-coupons' );
		}

		wp_reset_postdata();

	} else {
		esc_html_e( 'No coupons found.', 'affiliate-coupons' );
	}

	$str = ob_get_clean();

	// Remove unwanted line breaks from output
	$str = preg_replace( '/^\s+|\n|\r|\s+$/m', '', $str );

	// Return output
	return $str;
}

add_shortcode( 'affcoups', 'affcoups_add_shortcode' );

/**
 * Fallback for old shortcode
 */
add_shortcode( 'affcoups_coupons', 'affcoups_add_shortcode' );

/*
 * Debug
 */
add_shortcode( 'affcoups_debug', function ( $atts ) {

	/*
	$args = array(
	    'affcoups_coupon_id' => array( 312, 314 )
	);

	$posts = affcoups_get_coupons( $args );

	affcoups_debug( $posts );
	*/

	//affcoups_the_coupon_thumbnail( 310 );
	//$image = rwmb_meta( AFFCOUPS_PREFIX . 'vendor_image', 'type=image&size=affcoups-thumb&limit=1', 278 );
	//affcoups_debug($image);

	$expiration = get_post_meta( 556, AFFCOUPS_PREFIX . 'coupon_valid_until', true );

	//var_dump( $expiration );

} );
