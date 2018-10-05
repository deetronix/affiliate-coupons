<?php
/**
 * Manage Vendors
 *
 * @package     AffiliateCoupons\Coupons\ManageVendors
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
function affcoups_vendor_extend_columns( $defaults ) {

	$defaults['affcoups_vendor_thumb']      = __( 'Thumbnail', 'affiliate-coupons' );
	$defaults['affcoups_vendor_shortcodes'] = __( 'Shortcodes', 'affiliate-coupons' );

	return $defaults;
}

add_filter( 'manage_affcoups_vendor_posts_columns', 'affcoups_vendor_extend_columns', 10 );

/**
 * Add columns content
 *
 * @param $column_name
 * @param $postid
 */
function affcoups_vendor_extend_columns_content( $column_name, $postid ) {

	if ( 'affcoups_vendor_thumb' === $column_name ) {

        $Vendor = new Affcoups_Vendor( $postid );
        $image = $Vendor->get_image( 'small' );

		if ( ! empty( $image['url'] ) ) {
			?>
            <img src="<?php echo esc_attr( $image['url'] ); ?>" alt="thumbnail" style="display: inline-block; max-width: 144px; height: auto;"/>
			<?php
		}
	} elseif ( 'affcoups_vendor_shortcodes' === $column_name ) {
		?>
        <p>
            <input type='text' onClick="this.select();" value='[affcoups vendor="<?php echo esc_attr( $postid ); ?>"]' readonly='readonly'/>
        </p>
		<?php
	}
}

add_action( 'manage_affcoups_vendor_posts_custom_column', 'affcoups_vendor_extend_columns_content', 10, 2 );
