<?php
/**
 * Manage Coupons
 *
 * @package     AffiliateCoupons\Coupons\ManageCoupons
 * @since       1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

/*
 * Add new columns
 */
function affcoups_coupon_extend_columns( $defaults ) {

    $defaults['affcoups_coupon_thumb'] = __( 'Thumbnail', 'affiliate-coupons' );

    return $defaults;
}
add_filter('manage_affcoups_coupon_posts_columns', 'affcoups_coupon_extend_columns', 10);

/*
 * Add columns content
 */
function affcoups_coupon_extend_columns_content( $column_name, $postid ) {

    if ( $column_name == 'affcoups_coupon_thumb' ) {

        $image = affcoups_get_coupon_thumbnail( $postid, 'small' );

        if ( ! empty ( $image['url'] ) ) {
            ?>
            <img src="<?php echo $image['url'];?>" alt="thumbnail" />
            <?php
        }

    }
}
add_action('manage_affcoups_coupon_posts_custom_column', 'affcoups_coupon_extend_columns_content', 10, 2);