<?php
/**
 * Get template file
 *
 * @param $template
 * @param string $type
 *
 * @return string
 */

function affcoups_get_template_file( $template, $type = '' ) {

	$template_file = AFFCOUPS_PLUGIN_DIR . 'templates/' . $template . '.php';

	$template_file = apply_filters( 'affcoups_template_file', $template_file, $template, $type );

	if ( file_exists( $template_file ) ) {
		return $template_file;
	}

	return ( 'widget' === $type ) ? AFFCOUPS_PLUGIN_DIR . 'templates/widget.php' : AFFCOUPS_PLUGIN_DIR . 'templates/standard.php';
}

/**
 * Template loader
 *
 * @param $template
 */
function affcoups_get_template( $template, $wrap = false ) {

	// Get template file
	$file = affcoups_get_template_file( $template );

	if ( file_exists( $file ) ) {

		if ( $wrap ) {
			echo esc_attr( '<div class="affcoups">' );
		}

		include $file;

		if ( $wrap ) {
			echo esc_attr( '</div>' );
		}

	} else {
		echo esc_attr( '<p>' . __( 'Template not found.', 'affiliate-coupons' ) . '</p>' );
	}
}

/**
 * Output template wrapper start html
 */
function affcoups_the_template_wrapper_start() {

	global $affcoups_template_args;

	?>
    <div class="affcoups">
	<?php
}

/**
 * Output template wrapper end html
 */
function affcoups_the_template_wrapper_end() {

	global $affcoups_template_args;

	?>
    </div><!-- /.affcoups -->
	<?php
}