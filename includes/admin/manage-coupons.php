<?php
/**
 * Manage Coupons
 *
 * @package     AffiliateCoupons\Coupons\ManageCoupons
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add new columns
 *
 * @param $defaults
 *
 * @return mixed
 */
function affcoups_coupon_extend_columns( $defaults ) {

	$defaults['affcoups_coupon_thumb']      = __( 'Thumbnail', 'affiliate-coupons' );

	$defaults = apply_filters( 'affcoups_coupon_posts_columns', $defaults );

    $defaults['affcoups_coupon_shortcode'] = __( 'Shortcode', 'affiliate-coupons' );

	return $defaults;
}

add_filter( 'manage_affcoups_coupon_posts_columns', 'affcoups_coupon_extend_columns', 10 );

/**
 * Add columns content
 *
 * @param $column_name
 * @param $postid
 */
function affcoups_coupon_extend_columns_content( $column_name, $postid ) {

	if ( 'affcoups_coupon_thumb' === $column_name ) {

	    $Coupon = new Affcoups_Coupon( $postid );
		$image = $Coupon->get_image( 'small' );

		if ( ! empty ( $image['url'] ) ) {
			?>
            <img src="<?php echo esc_attr( $image['url'] ); ?>" alt="thumbnail" style="display: inline-block; max-width: 125px; height: auto;"/>
			<?php
		}

	} elseif ( 'affcoups_coupon_shortcode' === $column_name ) {
		?>
        <p>
            <input type='text' onClick="this.select();" value='[affcoups id="<?php echo esc_attr( $postid ); ?>"]' readonly='readonly' style="display: block; width: 100%;" />
        </p>
        <?php
	}

    do_action( 'affcoups_coupon_posts_columns_content', $column_name, $postid );
}
add_action( 'manage_affcoups_coupon_posts_custom_column', 'affcoups_coupon_extend_columns_content', 10, 2 );
