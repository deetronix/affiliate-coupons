<?php
/**
 * Coupon functions
 *
 * @package     AffiliateCoupons\CouponFunctions
 * @since       1.0.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/*
 * Coupon Template classes
 */
function affcoups_the_coupon_classes( $classes ) {

    // Add classes

    echo $classes;
}

function affcoups_get_coupon_vendor_id( $postid = null ) {

    if ( empty ( $postid ) )
        $postid = get_the_ID();

    $vendor_id = get_post_meta( $postid, AFFILIATE_COUPONS_PREFIX . 'coupon_vendor', true );

    return ( ! empty ( $vendor_id ) ) ? $vendor_id : false;
}

/*
 * Coupons
 */
function affcoups_get_coupon_thumbnail( $postid = null, $size = null ) {

    if ( empty ( $postid ) )
        $postid = get_the_ID();

    // Get thumbnail from coupon
    $image_size = ( 'small' === $size ) ? 'affcoups-thumb-small' : 'affcoups-thumb';

    $images = rwmb_meta( AFFILIATE_COUPONS_PREFIX . 'coupon_image', 'size=' . $image_size, $postid );

    if ( ! empty ( $images ) ) {
        return array_shift( $images );

    // Get thumbnail from vendor
    } else {
        $vendor_id = affcoups_get_coupon_vendor_id( $postid );

        if ( ! empty ( $vendor_id ) ) {
            $vendor_image = affcoups_get_vendor_thumbnail( $vendor_id, $size );

            if ( ! empty ( $vendor_image ) )
                return $vendor_image;
        }
    }

    // No thumbnail found
    return false;
}

function affcoups_the_coupon_thumbnail( $postid = null ) {

    if ( empty ( $postid ) )
        $postid = get_the_ID();

    $thumbnail = affcoups_get_coupon_thumbnail( $postid );

    // Prepare attributes
    $thumb_url = ( ! empty ( $thumbnail['url'] ) ) ? $thumbnail['url'] : AFFILIATE_COUPONS_URL . '/public/assets/img/thumb.png';
    $thumb_alt = ( ! empty ( $thumbnail['alt'] ) ) ? $thumbnail['alt'] : affcoups_get_coupon_title( $postid );

    // Build thumbnail
    $thumbnail = "<img src='" . $thumb_url . "' alt='" . $thumb_alt . "' />";

    // Output
    echo $thumbnail;
}

function affcoups_get_coupon_discount( $postid = null ) {

    if ( empty ( $postid ) )
        $postid = get_the_ID();

    $discount = get_post_meta( $postid, AFFILIATE_COUPONS_PREFIX . 'coupon_discount', true );

    return ( ! empty ( $discount ) ) ? $discount : false;
}

function affcoups_get_coupon_title( $postid = null ) {

    if ( empty ( $postid ) )
        $postid = get_the_ID();

    // Coupon
    $title = get_post_meta( $postid, AFFILIATE_COUPONS_PREFIX . 'coupon_title', true );

    if ( ! empty ( $title ) )
        return $title;

    // Vendor
    $vendor_id = affcoups_get_coupon_vendor_id( $postid );

    if ( ! empty ( $vendor_id ) )
        $title = get_the_title( $vendor_id );

    // Fallback
    if ( empty ( $title ) )
        $title = get_the_title( $postid );

    return $title;
}

function affcoups_get_coupon_description( $postid = null ) {

    if ( empty ( $postid ) )
        $postid = get_the_ID();

    // Coupon
    $description = get_post_meta( $postid, AFFILIATE_COUPONS_PREFIX . 'coupon_description', true );

    // Vendor
    if ( empty ( $description ) ) {
        $vendor_id = affcoups_get_coupon_vendor_id( $postid );

        if ( ! empty ( $vendor_id ) )
            $description = get_post_meta( $vendor_id, AFFILIATE_COUPONS_PREFIX . 'vendor_description', true );
    }

    // Fallback
    if ( empty ( $description ) )
        $description = affcoups_get_post_content( $postid );

    return $description;
}

function affcoups_get_coupon_code( $postid = null ) {

    if ( empty ( $postid ) )
        $postid = get_the_ID();

    $code = get_post_meta( $postid, AFFILIATE_COUPONS_PREFIX . 'coupon_code', true );

    return ( ! empty ( $code ) ) ? $code : false;
}

function affcoups_the_coupon_code( $postid = null ) {

    if ( empty ( $postid ) )
        $postid = get_the_ID();

    $copy_img = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAMAAAC6V+0/AAABI1BMVEUAAAAzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzPLD7eUAAAAYHRSTlMAAQIEBQYHCAoLDg8QEhMUFRYXGBocHR4gISIjKy0xMjM2ODo9P0FCRUZJSktMTlFSWFtcYmRma21wcXN3eHt8f4CDho6SmqKlqLC0ucDDx8jT3ODi5Obo6evt7/H1+f2nUYbbAAAAy0lEQVQYGa3BezvCUADA4d/RUCm3mrlMiZAIxVaas9wSucyllPv5/p/C9oznyd+8L3+VvelfmPw2/3kiO+pcEErYY4B0QTRUhUDEWhtyJmD3FhBvD/jydoSFfUDrXSaJv3cFaTcBpWUCcU/5ys1DE0R9km/G1nZOtqIaI0fDDCrYK+vT14v8mG0+dq6WojubG+T2CLmqXW0pr2Sc6hA7HsWXfU0Bz0+AXjMQlgkcSKCozgjozhxyHDIfDede3WmEZqwpfKveSzsv+Edfyg4bpMKWWckAAAAASUVORK5CYII=';

    $copy_img = apply_filters( 'affcoups_coupon_copy_img_src', $copy_img );

    $code = affcoups_get_coupon_code( $postid );
    ?>

    <div class="affcoups-clipboard affcoups-coupon-code" data-clipboard-text="<?php echo $code; ?>" data-affcoups-clipboard-confirmation-text="<?php _e('Copied!', 'affiliate-coupons'); ?>">
        <img class="affcoups-coupon-code__copy" src="<?php echo $copy_img; ?>" alt="<?php _e('Copy', 'affiliate-coupons'); ?>" />
        <?php echo $code; ?>
    </div>
    <?php
}

function affcoups_get_coupon_url( $postid = null ) {

    if ( empty ( $postid ) )
        $postid = get_the_ID();

    $url = get_post_meta( $postid, AFFILIATE_COUPONS_PREFIX . 'coupon_url', true );

    if ( empty ( $url ) ) {
        $vendor_id = affcoups_get_coupon_vendor_id( $postid );

        if ( ! empty ( $vendor_id ) )
            $url = affcoups_get_vendor_url( $vendor_id );
    }

    return $url;
}

function affcoups_get_coupon_types( $postid = null ) {

    if ( empty ( $postid ) )
        $postid = get_the_ID();

    $term_list = wp_get_post_terms( $postid, 'affcoups_coupon_type', array( "fields" => "all" ) );

    if ( sizeof( $term_list ) > 0 ) {
        return $term_list;
    }

    return false;
}

function affcoups_the_coupon_types( $postid = null ) {

    if ( empty ( $postid ) )
        $postid = get_the_ID();

    $types = '';

    $term_list = affcoups_get_coupon_types( $postid );

    if ( is_array( $term_list ) && sizeof( $term_list ) > 0 ) {

        foreach($term_list as $term_single) {
            echo '<span>';
            echo $term_single->name;
            echo '</span>';
        }
    }

    echo $types;
}

function affcoups_coupon_has_valid_dates( $postid = null ) {

    if ( empty ( $postid ) )
        $postid = get_the_ID();

    $valid_from = get_post_meta( $postid, AFFILIATE_COUPONS_PREFIX . 'coupon_valid_from', true );
    $valid_until = get_post_meta( $postid, AFFILIATE_COUPONS_PREFIX . 'coupon_valid_until', true );

    return ( ! empty ( $valid_from ) || ! empty ( $valid_until ) ) ? true : false;
}

function affcoups_the_coupon_valid_dates( $postid = null ) {

    if ( empty ( $postid ) )
        $postid = get_the_ID();

    $date_format = get_option( 'date_format' );
    $date_format = apply_filters( 'affcoups_coupon_validation_date_format', $date_format );

    $dates = '';

    $valid_from = get_post_meta( $postid, AFFILIATE_COUPONS_PREFIX . 'coupon_valid_from', true );
    $valid_until = get_post_meta( $postid, AFFILIATE_COUPONS_PREFIX . 'coupon_valid_until', true );

    if ( ! empty ( $valid_from ) && time() < $valid_from ) {
        $dates .= __('Valid from', 'affiliate-coupons') . ' ' . date_i18n( $date_format, $valid_from );
    }

    if ( ! empty ( $valid_until ) ) {

        $dates .= ( empty ( $dates ) ) ? __('Valid until', 'affiliate-coupons') : ' ' . __('until', 'affiliate-coupons');
        $dates .= ' ' . date_i18n( $date_format, $valid_until );
    }

    echo $dates;
}