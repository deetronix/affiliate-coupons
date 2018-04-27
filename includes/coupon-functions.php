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

/**
 * Get coupons
 *
 * @param array $args
 * @return WP_Query
 */
function affcoups_get_coupons( $args = array(), $query = true ) {

    $defaults = array(
        'post_type'      => 'affcoups_coupon',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        //'nopaging' => true,
        'orderby'        => 'name',
        'order'          => 'ASC',
    );

    // Parse args
    $args = wp_parse_args( $args, $defaults );

    // Prepare additional queries
    $meta_queries = array(
        'relation' => 'AND'
    );

    $tax_queries = array(
        'relation' => 'AND'
    );

    //-- Order
    if ( ! empty( $args['affcoups_order'] ) ) {

        $order_options = array( 'ASC', 'DESC' );

        $order = strtoupper( $args['affcoups_order'] );

        if ( in_array( $order, $order_options ) )
            $args['order'] = $order;
    }

    if ( ! empty( $args['affcoups_orderby'] ) ) {

        $orderby = strtolower( $args['affcoups_orderby'] );

        if ( 'name' === $orderby ) {
            $args['orderby'] = 'name';

        } elseif ( 'date' === $orderby ) {
            $args['orderby'] = 'date';

        } elseif ( 'random' === $orderby ) {
            $args['orderby'] = 'rand';

        } elseif ( 'title' === $orderby ) {
            $args['orderby'] = 'meta_value';
            $args['meta_key'] = AFFCOUPS_PREFIX . 'coupon_title';

        } elseif ( 'description' === $orderby ) {
            $args['orderby'] = 'meta_value';
            $args['meta_key'] = AFFCOUPS_PREFIX . 'coupon_description';

        } elseif ( 'discount' === $orderby ) {
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = AFFCOUPS_PREFIX . 'coupon_discount';

        } elseif ( 'valid_from' === $orderby ) {
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = AFFCOUPS_PREFIX . 'coupon_valid_from';

        } elseif ( 'valid_until' === $orderby ) {
            $args['orderby'] = 'meta_value_num';
            $args['meta_key'] = AFFCOUPS_PREFIX . 'coupon_valid_until';
        }

    }

    //-- ID
    if ( ! empty( $args['affcoups_coupon_id'] ) ) {

        $coupon_ids = explode(',', esc_html( $args['affcoups_coupon_id'] ) );

        if ( sizeof( $coupon_ids ) > 0 )
            $args['post__in'] = $coupon_ids;
    }

    //-- Category
    if ( ! empty( $args['affcoups_coupon_category'] ) ) {

        $coupon_categories = explode(',', esc_html( $args['affcoups_coupon_category'] ) );

        $coupon_category_tax_field = ( isset( $coupon_categories[0] ) && is_numeric( $coupon_categories[0] ) ) ? 'term_id' : 'slug';

        $tax_queries[] = array(
            'taxonomy' => 'affcoups_coupon_category',
            'field' => $coupon_category_tax_field,
            'terms' => $coupon_categories,
            'operator' => 'IN'
        );
    }

    //-- Type
    if ( ! empty( $args['affcoups_coupon_type'] ) ) {

        $coupon_types = explode(',', esc_html( $args['affcoups_coupon_type'] ) );

        $coupon_type_tax_field = ( isset( $coupon_types[0] ) && is_numeric( $coupon_types[0] ) ) ? 'term_id' : 'slug';

        $tax_queries[] = array(
            'taxonomy' => 'affcoups_coupon_type',
            'field' => $coupon_type_tax_field,
            'terms' => $coupon_types,
            'operator' => 'IN'
        );
    }

    //-- Vendor
    if ( ! empty( $args['affcoups_coupon_vendor'] ) ) {

        $coupon_vendors = explode(',', esc_html( $args['affcoups_coupon_vendor'] ) );

        $meta_queries[] = array(
            'key'     => AFFCOUPS_PREFIX . 'coupon_vendor',
            'value'   => $coupon_vendors,
            'compare' => 'IN',
        );
    }

    //-- Expiration
    if ( isset( $args['affcoups_coupon_hide_expired'] ) && true === $args['affcoups_coupon_hide_expired'] ) {

        $meta_queries[] = array(
            'relation' => 'OR',
            // Until date not set yet
            array(
                'key' => AFFCOUPS_PREFIX . 'coupon_valid_until',
                'value'   => '',
                'compare' => 'NOT EXISTS',
                'type' => 'NUMERIC'
            ),
            // Already expired
            array(
                'key' => AFFCOUPS_PREFIX . 'coupon_valid_until',
                'value' => time(),
                'compare' => '>=',
                'type' => 'NUMERIC'
            )
        );
    }

    // Set meta queries
    if ( sizeof( $meta_queries ) > 1 ) {
        $args['meta_query'] = $meta_queries;
    }

    // Set tax queries
    if ( sizeof( $tax_queries ) > 1 ) {
        $args['tax_query'] = $tax_queries;
    }

    //affcoups_debug( $args, 'affcoups_get_coupons $args' );

    // Fetch posts
    $posts = ( $query ) ? new WP_Query( $args ) : get_posts( $args );

    return $posts;
}

/**
 * Get coupon options
 *
 * @param array $args
 * @return array
 */
function affcoups_get_coupon_options( $args = array() ) {

    $defaults = array(
        'orderby' => 'date',
        'order' => 'DESC'
    );

    // Parse args
    $args = wp_parse_args( $args, $defaults );

    $coupons = affcoups_get_coupons( $args, false );

    $options = array(
        0 => __('Please select...', 'affiliate-coupons' )
    );

    if ( is_array( $coupons ) && sizeof( $coupons ) > 0 ) {

        foreach ( $coupons as $coupon ) {
            $options[$coupon->ID] = $coupon->post_title;
        }
    }

    return $options;
}

/**
 * Get coupon vendor id
 *
 * @param null $coupon_id
 * @return bool|mixed
 */
function affcoups_get_coupon_vendor_id( $coupon_id = null ) {

    if ( empty ( $coupon_id ) )
        $postid = get_the_ID();

    $vendor_id = get_post_meta( $coupon_id, AFFCOUPS_PREFIX . 'coupon_vendor', true );

    return ( ! empty ( $vendor_id ) ) ? $vendor_id : false;
}

/**
 * Get coupon thumbnail image
 *
 * @param null $coupon_id
 * @param null $size
 * @return bool|mixed
 */
function affcoups_get_coupon_image( $coupon_id = null, $size = null ) {

    if ( empty ( $coupon_id ) )
        $coupon_id = get_the_ID();

    // Get thumbnail from coupon
    $image_size = ( 'small' === $size ) ? 'affcoups-thumb-small' : 'affcoups-thumb';
	
	
	//affcoups_debug($coupon_feature_image);
	
	if ( has_post_thumbnail( $coupon_id ) ) {
	 
		$coupon_thumbnail_id = get_post_thumbnail_id( $coupon_id );
		$coupon_image_alt = get_post_meta( $coupon_thumbnail_id, '_wp_attachment_image_alt', true );
		$coupon_image_url = get_the_post_thumbnail_url( $coupon_id, $image_size );
		
		$coupon_feature_image = array(
		  'url' => $coupon_image_url,
          'alt' => $coupon_image_alt
        );
		
		//affcoups_debug($coupon_feature_image);
		
		return $coupon_feature_image;
	   
    } else {
		
		$coupon_images = rwmb_meta( AFFCOUPS_PREFIX . 'coupon_image', 'type=image&size=' . $image_size, $coupon_id );
		
		if ( ! empty ( $coupon_images ) && is_array( $coupon_images ) ) {
			
			return array_shift( $coupon_images );
			
			// Get thumbnail from vendor
		} else {
			$vendor_id = affcoups_get_coupon_vendor_id( $coupon_id );
			
			if ( ! empty ( $vendor_id ) ) {
				$vendor_images = affcoups_get_vendor_thumbnail( $vendor_id, $size );
				
				if ( ! empty ( $vendor_images ) && is_array( $vendor_images ) )
					return $vendor_images;
			}
		}
		
		
	}

    // No thumbnail found
    return false;
}

/**
 * Display the coupon thumbnail
 *
 * @param null $coupon_id
 */
function affcoups_the_coupon_thumbnail( $coupon_id = null ) {

    if ( empty ( $coupon_id ) )
        $coupon_id = get_the_ID();

    // Prepare image
    $image = affcoups_get_coupon_image( $coupon_id );
    $image_url = ( ! empty ( $image['url'] ) ) ? $image['url'] : AFFCOUPS_URL . '/public/img/placeholder-thumb.png';
    $image_alt = ( ! empty ( $image['alt'] ) ) ? $image['alt'] : affcoups_get_coupon_title( $coupon_id );

    // Build image
    $image = '<img class="affcoups-coupon__image" src="' . $image_url . '" alt="' . $image_alt . '" />';

    // Build thumbnail
    $coupon_url = affcoups_get_coupon_url();

    if ( ! empty( $coupon_url ) ) {

        $coupon_title = affcoups_get_coupon_title( $coupon_id );
        $coupon_title = affcoups_cleanup_html_attribute( $coupon_title );

        $thumbnail = '<a class="affcoups-coupon__thumbnail" href="' . $coupon_url . '" title="' . $coupon_title . '" target="_blank" rel="nofollow">';
        $thumbnail .= $image;
        $thumbnail .= '</a>';
    } else {
        $thumbnail = '<span class="affcoups-coupon__thumbnail">';
        $thumbnail .= $image;
        $thumbnail .= '</a>';
    }

    // Output
    echo wp_kses_post( $thumbnail );
}

/**
 * Get coupon discount
 *
 * @param null $coupon_id
 * @return bool|mixed
 */
function affcoups_get_coupon_discount( $coupon_id = null ) {

    if ( empty ( $coupon_id ) )
        $coupon_id = get_the_ID();

    $discount = get_post_meta( $coupon_id, AFFCOUPS_PREFIX . 'coupon_discount', true );

    return ( ! empty ( $discount ) ) ? $discount : false;
}

/**
 * Get coupon title
 *
 * @param null $coupon_id
 * @return mixed|string
 */
function affcoups_get_coupon_title( $coupon_id = null ) {

    if ( empty ( $coupon_id ) )
        $coupon_id = get_the_ID();

    // Coupon
    $title = get_post_meta( $coupon_id, AFFCOUPS_PREFIX . 'coupon_title', true );

    if ( ! empty ( $title ) )
        return $title;

    // Vendor
    $vendor_id = affcoups_get_coupon_vendor_id( $coupon_id );

    if ( ! empty ( $vendor_id ) )
        $title = get_the_title( $vendor_id );

    // Fallback
    if ( empty ( $title ) )
        $title = get_the_title( $coupon_id );

    return $title;
}

/**
 * Get coupon description
 *
 * @param null $coupon_id
 * @return string
 */
function affcoups_get_coupon_description( $coupon_id = null ) {

    if ( empty ( $coupon_id ) )
        $coupon_id = get_the_ID();

    // Coupon
    $description = get_post_meta( $coupon_id, AFFCOUPS_PREFIX . 'coupon_description', true );

    // Vendor
    if ( empty ( $description ) ) {
        $vendor_id = affcoups_get_coupon_vendor_id( $coupon_id );

        if ( ! empty ( $vendor_id ) )
            $description = get_post_meta( $vendor_id, AFFCOUPS_PREFIX . 'vendor_description', true );
    }

    // Fallback
    if ( empty ( $description ) )
        $description = affcoups_get_post_content( $coupon_id );

    return $description;
}

/**
 * Get coupon excerpt
 *
 * @param null $coupon_id
 * @return mixed
 */
function affcoups_get_coupon_excerpt( $coupon_id = null ) {

    if ( empty ( $coupon_id ) )
        $coupon_id = get_the_ID();

    $description = affcoups_get_coupon_description( $coupon_id );

    $description = trim( $description );

    $excerpt_length = affcoups_get_option( 'excerpt_length', 90 );

    $excerpt = affcoups_truncate_string( $description, $excerpt_length );

    return $excerpt;
}

/**
 * Output the coupon excerpt
 *
 * @param $coupon_id
 */
function affcoups_the_coupon_excerpt( $coupon_id = null ) {

    if ( empty ( $coupon_id ) )
        $coupon_id = get_the_ID();

    $description = affcoups_get_coupon_description( $coupon_id );
    $excerpt = affcoups_get_coupon_excerpt( $coupon_id );

    echo wp_kses_post( $excerpt );

    if ( $excerpt != $description ) {
	    echo wp_kses_post( '<a href="#" class="affcoups-toggle-desc" data-affcoups-toggle-desc="true">' . __('More', 'affiliate-coupons' ) . '</a>' );
    }
}

/**
 * Get coupon code
 *
 * @param null $coupon_id
 * @return bool|mixed
 */
function affcoups_get_coupon_code( $coupon_id = null ) {

    if ( empty ( $coupon_id ) )
        $coupon_id = get_the_ID();

    $code = get_post_meta( $coupon_id, AFFCOUPS_PREFIX . 'coupon_code', true );

    return ( ! empty ( $code ) ) ? $code : false;
}

/**
 * Display the coupon code
 *
 * @param null $coupon_id
 */
function affcoups_the_coupon_code( $coupon_id = null ) {

    if ( empty ( $coupon_id ) )
        $coupon_id = get_the_ID();

    $copy_img = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAMAAAC6V+0/AAABI1BMVEUAAAAzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzPLD7eUAAAAYHRSTlMAAQIEBQYHCAoLDg8QEhMUFRYXGBocHR4gISIjKy0xMjM2ODo9P0FCRUZJSktMTlFSWFtcYmRma21wcXN3eHt8f4CDho6SmqKlqLC0ucDDx8jT3ODi5Obo6evt7/H1+f2nUYbbAAAAy0lEQVQYGa3BezvCUADA4d/RUCm3mrlMiZAIxVaas9wSucyllPv5/p/C9oznyd+8L3+VvelfmPw2/3kiO+pcEErYY4B0QTRUhUDEWhtyJmD3FhBvD/jydoSFfUDrXSaJv3cFaTcBpWUCcU/5ys1DE0R9km/G1nZOtqIaI0fDDCrYK+vT14v8mG0+dq6WojubG+T2CLmqXW0pr2Sc6hA7HsWXfU0Bz0+AXjMQlgkcSKCozgjozhxyHDIfDede3WmEZqwpfKveSzsv+Edfyg4bpMKWWckAAAAASUVORK5CYII=';

    $copy_img = apply_filters( 'affcoups_coupon_copy_img_src', $copy_img );

    $code = affcoups_get_coupon_code( $coupon_id );
    ?>

    <div class="affcoups-clipboard affcoups-coupon-code" data-clipboard-text="<?php echo esc_attr( $code ); ?>" data-affcoups-clipboard-confirmation-text="<?php esc_attr_e('Copied!', 'affiliate-coupons'); ?>">
        <img class="affcoups-coupon-code__copy" src="<?php echo esc_attr( $copy_img ); ?>" alt="<?php esc_attr_e('Copy', 'affiliate-coupons'); ?>" />
        <?php echo esc_attr( $code ); ?>
    </div>
    <?php
}

/**
 * Get coupon url
 *
 * @param null $coupon_id
 * @return bool|mixed
 */
function affcoups_get_coupon_url( $coupon_id = null ) {

    if ( empty( $coupon_id ) )
        $coupon_id = get_the_ID();

    $url = get_post_meta( $coupon_id, AFFCOUPS_PREFIX . 'coupon_url', true );

    if ( empty( $url ) ) {
        $vendor_id = affcoups_get_coupon_vendor_id( $coupon_id );

        if ( ! empty( $vendor_id ) )
            $url = affcoups_get_vendor_url( $vendor_id );
    }

    return $url;
}

/**
 * Get coupon types
 *
 * @param null $coupon_id
 * @return array|bool|WP_Error
 */
function affcoups_get_coupon_types( $coupon_id = null ) {

    if ( empty( $coupon_id ) )
        $coupon_id = get_the_ID();

    $term_list = wp_get_post_terms( $coupon_id, 'affcoups_coupon_type', array( "fields" => "all" ) );

    if ( sizeof( $term_list ) > 0 ) {
        return $term_list;
    }

    return false;
}

/**
 * Display coupon types
 *
 * @param null $coupon_id
 */
function affcoups_the_coupon_types( $coupon_id = null ) {

    if ( empty( $coupon_id ) ) {
	    $coupon_id = get_the_ID();
    }

    $types = '';

    $term_list = affcoups_get_coupon_types( $coupon_id );

    if ( is_array( $term_list ) && sizeof( $term_list ) > 0 ) {

        foreach($term_list as $term_single) {
            echo '<span class="affcoups-type affcoups-type--' . esc_html( $term_single->slug ) . '">';
            echo esc_attr( $term_single->name );
            echo '</span>';
        }
    }

    echo esc_attr( $types );
}

/**
 * Check if coupon has valid dates
 *
 * @param null $coupon_id
 * @return bool
 */
function affcoups_coupon_has_valid_dates( $coupon_id = null ) {

    if ( empty ( $coupon_id ) )
        $coupon_id = get_the_ID();

    $valid_from = get_post_meta( $coupon_id, AFFCOUPS_PREFIX . 'coupon_valid_from', true );
    $valid_until = get_post_meta( $coupon_id, AFFCOUPS_PREFIX . 'coupon_valid_until', true );

    return ( ! empty ( $valid_from ) || ! empty ( $valid_until ) ) ? true : false;
}

/**
 * Display coupon valid dates
 *
 * @param null $coupon_id
 */
function affcoups_the_coupon_valid_dates( $coupon_id = null ) {

    if ( empty ( $coupon_id ) )
        $coupon_id = get_the_ID();

    $date_format = get_option( 'date_format' );
    $date_format = apply_filters( 'affcoups_coupon_validation_date_format', $date_format );

    $dates = '';

    $valid_from = get_post_meta( $coupon_id, AFFCOUPS_PREFIX . 'coupon_valid_from', true );
    $valid_until = get_post_meta( $coupon_id, AFFCOUPS_PREFIX . 'coupon_valid_until', true );

    if ( ! empty ( $valid_from ) && time() < $valid_from ) {
        $dates .= __('Valid from', 'affiliate-coupons') . ' ' . date_i18n( $date_format, $valid_from );
    }

    if ( ! empty ( $valid_until ) ) {

        $dates .= ( empty ( $dates ) ) ? __('Valid until', 'affiliate-coupons') : ' ' . __('until', 'affiliate-coupons');
        $dates .= ' ' . date_i18n( $date_format, $valid_until );
    }

    echo esc_attr( $dates );
}

/**
 * Display coupon button
 *
 * @param null $coupon_id
 */
function affcoups_the_coupon_button( $coupon_id = null ) {

    if ( empty ( $coupon_id ) )
        $coupon_id = get_the_ID();

    global $affcoups_shortcode_atts;

    $options = affcoups_get_options();

    // Button text
    if ( ! empty( $affcoups_shortcode_atts['button_text'] ) ) {
        $button_text = esc_html( $affcoups_shortcode_atts['button_text'] );
    } else {
        $button_text = ( ! empty( $options['button_text'] ) ) ? esc_html( $options['button_text'] ) : __( 'Go to the deal', 'affiliate-coupons' );
    }

    // Build button settings
    $button = array(
        'url' => affcoups_get_coupon_url( $coupon_id ),
        'title' => affcoups_cleanup_html_attribute( $button_text ),
        'text' => $button_text,
        'target' => '_blank',
        'rel' => 'nofollow'
    );

    $button = apply_filters( 'affcoups_button', $button, $coupon_id );

    $button_icon = ( ! empty( $options['button_icon'] ) ) ? esc_html( $options['button_icon'] ) : false;

    ?>
    <a class="affcoups-coupon__button" href="<?php echo esc_attr( $button['url'] ); ?>" title="<?php echo esc_attr( $button['title'] ); ?>" rel="<?php echo esc_attr( $button['rel'] ); ?>" target="<?php echo esc_attr( $button['target'] ); ?>">
        <?php if ( ! empty( $button_icon ) ) { ?>
            <span class="affcoups-icon-<?php echo esc_attr( $button_icon ); ?> affcoups-coupon__button-icon"></span>
        <?php } ?>
        
        <?php echo esc_attr( $button['text'] ); ?></a>
    <?php
}

/**
 * Display coupon categories
 */
function affcoups_get_category_taxonomy() {
 
	$options = array(
		0 => __('Please select...', 'affiliate-coupons' )
	);
	
	$terms = get_terms([
		'taxonomy' => 'affcoups_coupon_category'
	]);
	
	if ( sizeof( $options ) > 0 ) {
		
		foreach ( $terms as $term ) {
			$options[$term->term_id] = $term->name;
		}
	 
	}
    
	return $options;
}

/**
 * Display coupon types
 */
function affcoups_get_types_taxonomy() {
	
	$options = array(
		0 => __('Please select...', 'affiliate-coupons' )
	);
	
	$types = get_terms([
		'taxonomy' => 'affcoups_coupon_type'
	]);
	
	if ( sizeof( $options ) > 0 ) {
	    
        foreach ( $types as $type ) {
            $options[$type->term_id] = $type->name;
        }
        
	}
	
	return $options;
}

/**
 * Get coupon options
 */
function affcoups_get_vendors_list() {
    
    $vendors = affcoups_get_vendors();
    
    $options = array(
        0 => __('Please select...', 'affiliate-coupons' )
    );
    
    if ( is_array( $vendors ) && sizeof( $options ) > 0 ) {
        
        foreach ( $vendors as $vendor ) {
            $options[$vendor->ID] = $vendor->post_title;
        }
    }
    
    return $options;
}

/**
 * Get coupons
 */
function affcoups_get_vendors() {
	
	$args = array(
        'post_type'      => 'affcoups_vendor',
        'post_status'    => 'publish',
        'posts_per_page' => -1,
        //'nopaging' => true,
        'orderby'        => 'name',
        'order'          => 'ASC',
    );
    
    // Fetch posts
    $vendors = get_posts( $args );
    
    return $vendors;
}
