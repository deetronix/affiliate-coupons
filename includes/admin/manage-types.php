<?php
/**
 * Manage Types
 *
 * @package     AffiliateCoupons\Coupons\ManageTypes
 * @since       1.1.2
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add new columns
 *
 * @param $columns
 *
 * @return mixed
 */
function affcoups_coupon_type_extend_columns( $columns ) {

	$columns['affcoups_coupon_type_shortcodes'] = __( 'Shortcodes', 'affiliate-coupons' );

	return $columns;
}

add_filter( 'manage_edit-affcoups_coupon_type_columns', 'affcoups_coupon_type_extend_columns' );

/**
 * Add columns content
 *
 * @param $content
 * @param $column_name
 * @param $term_id
 *
 * @return string
 */
function affcoups_coupon_type_extend_columns_content( $content, $column_name, $term_id ) {

	if ( 'affcoups_coupon_type_shortcodes' === $column_name ) {
		?>
        <p>
            <input type='text' onClick="this.select();" value='[affcoups type="<?php echo esc_attr( $term_id ); ?>"]' readonly='readonly'/>
        </p>
		<?php
	}

	return $content;
}

add_filter( 'manage_affcoups_coupon_type_custom_column', 'affcoups_coupon_type_extend_columns_content', 10, 3 );
