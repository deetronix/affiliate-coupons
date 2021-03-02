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
 *
 * @depreacted
 *
 * Html wrapper was moved into the templates directly
 */
function affcoups_tpl_the_wrapper_start() {

	global $affcoups_template_args;

	?>
    <div class="affcoups">
	<?php
}

/**
 * Output template wrapper end html
 *
 * @depreacted
 *
 * Html wrapper was moved into the templates directly
 */
function affcoups_tpl_the_wrapper_end() {

	global $affcoups_template_args;

	?>
    </div><!-- /.affcoups -->
	<?php
}

/**
 * Output the coupon image markup
 *
 * @param Affcoups_Coupon $coupon
 */
function affcoups_tpl_the_coupon_image( $coupon ) {

    $coupon->the_image();
}

/**
 * Output the coupon discount markup
 *
 * @param Affcoups_Coupon $coupon
 */
function affcoups_tpl_the_coupon_discount( $coupon ) {

    if ( $coupon->get_discount() ) { ?>
        <span class="affcoups-coupon__discount"><?php echo esc_attr( $coupon->get_discount() ); ?></span>
    <?php
    }
}

/**
 * Output the coupon title markup
 *
 * @param Affcoups_Coupon $coupon
 */
function affcoups_tpl_the_coupon_title( $coupon ) {

    $coupon_title = $coupon->get_title();
    $coupon_title = affcoups_cleanup_html_attribute( $coupon_title );

    $coupon_url = esc_url( $coupon->get_url() );

    $options = affcoups_get_options();
    $title_linked = ( isset( $options['title_linked'] ) && '1' === $options['title_linked'] ) ? true : false;

    if ( $title_linked && ! empty( $coupon_url ) ) {
        ?>
        <a class="affcoups-coupon__title" href="<?php echo $coupon_url; ?>" title="<?php echo $coupon_title; ?>" target="_blank" rel="nofollow"><?php echo $coupon_title; ?></a>
        <?php
    } else {
        ?>
        <span class="affcoups-coupon__title"><?php echo $coupon_title; ?></span>
        <?php
    }
}

/**
 * Output the coupon types markup
 *
 * @param Affcoups_Coupon $coupon
 */
function affcoups_tpl_the_coupon_types( $coupon ) {

    if ( $coupon->get_types() ) { ?>
        <div class="affcoups-coupon__types">
            <?php $coupon->the_types(); ?>
        </div>
    <?php }
}

/**
 * Output the coupon description markup
 *
 * @param Affcoups_Coupon $coupon
 */
function affcoups_tpl_the_coupon_description( $coupon ) {

    ?>
    <div class="affcoups-coupon__description">
        <?php echo wp_kses_post( $coupon->get_description() ); ?>
    </div>
    <?php
}

/**
 * Output the coupon description with excerpt markup
 *
 * @param Affcoups_Coupon $coupon
 */
function affcoups_tpl_the_coupon_description_with_excerpt( $coupon ) {

    ?>
    <div class="affcoups-coupon__description">
        <div class="affcoups-coupon__description-excerpt">
            <?php $coupon->the_excerpt(); ?>
        </div>
        <div class="affcoups-coupon__description-full">
            <?php echo wp_kses_post( $coupon->get_description() ); ?>
            <a href="#" class="affcoups-toggle-desc" data-blub="true" data-affcoups-toggle-desc="true"><?php _e('Show Less', 'affiliate-coupons' ); ?></a>
        </div>
    </div>
    <?php
}

/**
 * Output the coupon code markup
 *
 * @param Affcoups_Coupon $coupon
 */
function affcoups_tpl_the_coupon_code( $coupon ) {

    if ( $coupon->show_code() ) { ?>
        <div class="affcoups-coupon__code">
            <?php $coupon->the_code(); ?>
        </div>
    <?php }
}

/**
 * Output the coupon valid dates markup
 *
 * @param Affcoups_Coupon $coupon
 */
function affcoups_tpl_the_coupon_valid_dates( $coupon ) {

    if ( $coupon->show_valid_dates() ) { ?>
        <div class="affcoups-coupon__valid-dates">
            <?php $coupon->the_valid_dates(); ?>
        </div>
    <?php }
}

/**
 * Output the coupon button markup
 *
 * @param Affcoups_Coupon $coupon
 * @param array $args
 */
function affcoups_tpl_the_coupon_button( $coupon, $args = array() ) {

    $coupon->the_button( $args );
}