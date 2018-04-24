<?php
/**
 * Manage Vendors
 *
 * @package     AffiliateCoupons\Coupons\ManageVendors
 * @since       1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/*
 * Add new columns
 */
function affcoups_vendor_extend_columns( $defaults ) {

    $defaults['affcoups_vendor_thumb'] = __( 'Thumbnail', 'affiliate-coupons' );
    $defaults['affcoups_vendor_shortcodes'] = __( 'Shortcodes', 'affiliate-coupons' );

    return $defaults;
}
add_filter('manage_affcoups_vendor_posts_columns', 'affcoups_vendor_extend_columns', 10);

/*
 * Add columns content
 */
function affcoups_vendor_extend_columns_content( $column_name, $postid ) {

    if ( $column_name == 'affcoups_vendor_thumb' ) {

        $image = affcoups_get_vendor_thumbnail( $postid, 'small' );

        if ( ! empty ( $image['url'] ) ) {
            ?>
            <img src="<?php echo $image['url'];?>" alt="thumbnail" style="display: inline-block; max-width: 144px; height: auto;" />
            <?php
        }

    } else if ( $column_name == 'affcoups_vendor_shortcodes' ) {

        echo '[affcoups vendor="' . $postid . '"]';
    }
}
add_action('manage_affcoups_vendor_posts_custom_column', 'affcoups_vendor_extend_columns_content', 10, 2);