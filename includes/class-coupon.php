<?php
/**
 * Coupon Class
 *
 * @package     AffiliateCoupons\CouponClass
 * @since       1.5.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) exit;

if (!class_exists('Affcoups_Coupon')) {

    class Affcoups_Coupon
    {
        // General
        public $options;

        // Variables
        public $post; // WP_Post
        public $id;
        public $vendor_id = 0;
        public $vendor;

        /**
         * Affcoups_Coupon constructor.
         * @param $post WP_Post or Post ID
         */
        public function __construct( $post ) {

            if ( is_numeric( $post ) )
                $post = get_post( $post );

            $this->options = affcoups_get_options();

            // Setup coupon
            $this->post = $post;
            $this->id = $post->ID;

            // Setup vendor
            $vendor_id = get_post_meta( $post->ID, AFFCOUPS_PREFIX . 'coupon_vendor', true );

            if ( ! empty( $vendor_id ) ) {
                $this->vendor_id = $vendor_id;
                $this->vendor = new Affcoups_Vendor( $vendor_id );
            }
        }

        /**
         * Get coupon id
         *
         * @return int
         */
        public function get_id() {
            return $this->id;
        }

        /**
         * Output coupon classes
         *
         * @param $classes
         */
        public function the_classes( $classes ) {

            $add_classes = array();

            // Sale?
            //if ( $this->is_on_sale() )
              //  $add_classes[] = 'sale';

            $add_classes = apply_filters( 'affcoups_coupon_add_classes', $add_classes, $this );

            // Maybe add extra classes
            if ( sizeof( $add_classes ) > 0 ) {
                foreach ( $add_classes as $class ) {
                    $classes .= ' affcoups-coupon--' . $class;
                }
            }

            // Output
            echo $classes;
        }

        /**
         * Output container attributes
         *
         * @param bool $echo
         * @return string
         */
        public function the_container( $echo = true ) {

            $output = '';

            $attributes = array();

            // HTML ID
            //$output .= ' id="affcoups-course-' . $this->id . '"';

            // Course ID
            $attributes['coupon-id'] = $this->id;

            // Add more via filter
            $attributes = apply_filters( 'affcoups_coupon_container_attributes', $attributes, $this );

            if ( sizeof( $attributes ) != 0 ) {

                foreach ( $attributes as $key => $value ) {

                    // Add attribute to output
                    if ( ! empty ( $value ) )
                        $output .= ' data-affcoups-' . $key . '="' . str_replace('"', "'", $value) . '"';
                }
            }

            if ( ! $echo )
                return $output;

            if ( ! empty ( $output ) )
                echo $output;
        }

        /**
         * Display the coupon image
         */
        function the_image() {

            // Prepare image
            $image     = $this->get_image();
            $image_url = ( ! empty ( $image['url'] ) ) ? $image['url'] : AFFCOUPS_URL . '/public/img/placeholder-thumb.png';
            $image_alt = ( ! empty ( $image['alt'] ) ) ? $image['alt'] : $this->get_title();

            // Build image
            $image = '<img class="affcoups-coupon__image" src="' . $image_url . '" alt="' . $image_alt . '" />';

            // Build thumbnail
            $coupon_url = $this->get_url();

            if ( ! empty( $coupon_url ) ) {

                $coupon_title = $this->get_title();
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
         * Get coupon image
         *
         * @param null $size
         *
         * @return bool|mixed
         */
        function get_image( $size = null ) {

            // Get thumbnail from coupon
            $image_size = ( 'small' === $size ) ? 'affcoups-thumb-small' : 'affcoups-thumb';

            if ( has_post_thumbnail( $this->id ) ) {

                $coupon_thumbnail_id = get_post_thumbnail_id( $this->id );
                $coupon_image_alt    = get_post_meta( $coupon_thumbnail_id, '_wp_attachment_image_alt', true );
                $coupon_image_url    = get_the_post_thumbnail_url( $this->id, $image_size );

                $coupon_feature_image = array(
                    'url' => $coupon_image_url,
                    'alt' => $coupon_image_alt
                );

                return $coupon_feature_image;

            } else {

                $coupon_images = rwmb_meta( AFFCOUPS_PREFIX . 'coupon_image', 'type=image&size=' . $image_size, $this->id );

                if ( ! empty ( $coupon_images ) && is_array( $coupon_images ) ) {
                    return array_shift( $coupon_images );

                // Get thumbnail from vendor
                } else {

                    $vendor_image = ( $this->vendor ) ? $this->vendor->get_image( $size ) : null;

                    if ( ! empty( $vendor_image ) )
                        return $vendor_image;
                }
            }

            // No image found
            return null;
        }

        /**
         * Get coupon title
         *
         * @return mixed|string
         */
        function get_title() {

            // Coupon title
            $title = get_post_meta( $this->id, AFFCOUPS_PREFIX . 'coupon_title', true );

            if ( ! empty ( $title ) )
                return $title;

            // Vendor title
            $vendor_title = ( $this->vendor ) ? $this->vendor->get_title() : null;

            if ( ! empty( $vendor_title ) )
                return $vendor_title;

            // Fallback: Coupon post title
            return get_the_title( $this->id );
        }

        /**
         * Get coupon url
         *
         * @return bool|mixed
         */
        function get_url() {

            // Coupon url
            $url = get_post_meta( $this->id, AFFCOUPS_PREFIX . 'coupon_url', true );

            if ( ! empty( $url ) )
                return $url;

            // Vendor url
            $vendor_url = ( $this->vendor ) ? $this->vendor->get_url() : null;

            if ( ! empty ( $vendor_url ) )
                return $vendor_url;

            return null;
        }

        /**
         * Get coupon description
         *
         * @return string
         */
        function get_description() {

            // Coupon description
            $description = get_post_meta( $this->id, AFFCOUPS_PREFIX . 'coupon_description', true );

            if ( ! empty ( $description ) )
                return $description;

            // Vendor description
            $vendor_description = get_post_meta( $this->vendor_id, AFFCOUPS_PREFIX . 'vendor_description', true );

            if ( ! empty( $vendor_description ) )
                return $vendor_description;

            // Fallback: Coupon post content
            if ( ! isset( $this->post->post_content ) )
                return null;

            $post_content = apply_filters( 'the_content', $this->post->post_content );
            $post_content = str_replace( ']]>', ']]&gt;', $post_content );

            return $post_content;
        }

        /**
         * Get coupon excerpt
         *
         * @return mixed
         */
        function get_excerpt() {

            $description = $this->get_description();

            $description = trim( $description );

            $excerpt_length = affcoups_get_option( 'excerpt_length', 90 );

            $excerpt = affcoups_truncate_string( $description, $excerpt_length );

            return $excerpt;
        }

        /**
         * Output the coupon excerpt
         */
        function the_excerpt() {

            $description = $this->get_description();
            $excerpt     = $this->get_excerpt();

            echo wp_kses_post( $excerpt );

            if ( $excerpt != $description ) {
                echo wp_kses_post( '<a href="#" class="affcoups-toggle-desc" data-affcoups-toggle-desc="true">' . __( 'More', 'affiliate-coupons' ) . '</a>' );
            }
        }

        /**
         * Get coupon types
         *
         * @return array|bool|WP_Error
         */
        function get_types() {

            $term_list = wp_get_post_terms( $this->id, 'affcoups_coupon_type', array( "fields" => "all" ) );

            if ( sizeof( $term_list ) > 0 ) {
                return $term_list;
            }

            return null;
        }

        /**
         * Display coupon types
         */
        function the_types() {

            $types = '';

            $term_list = $this->get_types();

            if ( is_array( $term_list ) && sizeof( $term_list ) > 0 ) {

                foreach ( $term_list as $term_single ) {
                    echo '<span class="affcoups-type affcoups-type--' . esc_html( $term_single->slug ) . '">';
                    echo esc_attr( $term_single->name );
                    echo '</span>';
                }
            }

            echo esc_attr( $types );
        }

        /**
         * Get coupon discount
         *
         * @return bool|mixed
         */
        function get_discount() {

            $discount = get_post_meta( $this->id, AFFCOUPS_PREFIX . 'coupon_discount', true );

            return ( ! empty ( $discount ) ) ? $discount : null;
        }

        /**
         * Check if coupon has valid dates
         *
         * @return bool
         */
        function has_valid_dates() {

            $valid_from  = get_post_meta( $this->id, AFFCOUPS_PREFIX . 'coupon_valid_from', true );
            $valid_until = get_post_meta( $this->id, AFFCOUPS_PREFIX . 'coupon_valid_until', true );

            return ( ! empty ( $valid_from ) || ! empty ( $valid_until ) ) ? true : false;
        }

        /**
         * Display coupon valid dates
         */
        function the_valid_dates() {

            $date_format = get_option( 'date_format' );
            $date_format = apply_filters( 'affcoups_coupon_validation_date_format', $date_format );

            $dates = '';

            $valid_from  = get_post_meta( $this->id, AFFCOUPS_PREFIX . 'coupon_valid_from', true );
            $valid_until = get_post_meta( $this->id, AFFCOUPS_PREFIX . 'coupon_valid_until', true );

            if ( ! empty ( $valid_from ) && time() < $valid_from ) {
                $dates .= __( 'Valid from', 'affiliate-coupons' ) . ' ' . date_i18n( $date_format, $valid_from );
            }

            if ( ! empty ( $valid_until ) ) {
                $dates .= ( empty ( $dates ) ) ? __( 'Valid until', 'affiliate-coupons' ) : ' ' . __( 'until', 'affiliate-coupons' );
                $dates .= ' ' . date_i18n( $date_format, $valid_until );
            }

            echo esc_attr( $dates );
        }

        /**
         * Get coupon code
         *
         * @return bool|string
         */
        function get_code() {

            $code = get_post_meta( $this->id, AFFCOUPS_PREFIX . 'coupon_code', true );

            return ( ! empty ( $code ) ) ? $code : null;
        }

        /**
         * Display the coupon code
         */
        function the_code() {

            $code = $this->get_code();

            if ( empty( $code ) )
                return;

            $copy_img = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAUCAMAAAC6V+0/AAABI1BMVEUAAAAzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzMzPLD7eUAAAAYHRSTlMAAQIEBQYHCAoLDg8QEhMUFRYXGBocHR4gISIjKy0xMjM2ODo9P0FCRUZJSktMTlFSWFtcYmRma21wcXN3eHt8f4CDho6SmqKlqLC0ucDDx8jT3ODi5Obo6evt7/H1+f2nUYbbAAAAy0lEQVQYGa3BezvCUADA4d/RUCm3mrlMiZAIxVaas9wSucyllPv5/p/C9oznyd+8L3+VvelfmPw2/3kiO+pcEErYY4B0QTRUhUDEWhtyJmD3FhBvD/jydoSFfUDrXSaJv3cFaTcBpWUCcU/5ys1DE0R9km/G1nZOtqIaI0fDDCrYK+vT14v8mG0+dq6WojubG+T2CLmqXW0pr2Sc6hA7HsWXfU0Bz0+AXjMQlgkcSKCozgjozhxyHDIfDede3WmEZqwpfKveSzsv+Edfyg4bpMKWWckAAAAASUVORK5CYII=';

            $copy_img = apply_filters( 'affcoups_coupon_copy_img_src', $copy_img );

            ?>
            <div class="affcoups-clipboard affcoups-coupon-code" data-clipboard-text="<?php echo esc_attr( $code ); ?>" data-affcoups-clipboard-confirmation-text="<?php esc_attr_e( 'Copied!', 'affiliate-coupons' ); ?>">
                <img class="affcoups-coupon-code__copy" src="<?php echo esc_attr( $copy_img ); ?>" alt="<?php esc_attr_e( 'Copy', 'affiliate-coupons' ); ?>"/>
                <?php echo esc_attr( $code ); ?>
            </div>
            <?php
        }

        /**
         * Display coupon button
         */
        function the_button() {

            global $affcoups_shortcode_atts;

            // Button text
            if ( ! empty( $affcoups_shortcode_atts['button_text'] ) ) {
                $button_text = esc_html( $affcoups_shortcode_atts['button_text'] );
            } else {
                $button_text = ( ! empty( $this->options['button_text'] ) ) ? esc_html( $this->options['button_text'] ) : __( 'Go to the deal', 'affiliate-coupons' );
            }

            // Build button settings
            $button = array(
                'url'    => $this->get_url(),
                'title'  => affcoups_cleanup_html_attribute( $button_text ),
                'text'   => $button_text,
                'target' => '_blank',
                'rel'    => 'nofollow'
            );

            $button = apply_filters( 'affcoups_button', $button, $this->id );

            $button_icon = ( ! empty( $options['button_icon'] ) ) ? esc_html( $options['button_icon'] ) : false;

            ?>
            <a class="affcoups-coupon__button" href="<?php echo esc_attr( $button['url'] ); ?>" title="<?php echo esc_attr( $button['title'] ); ?>" rel="<?php echo esc_attr( $button['rel'] ); ?>" target="<?php echo esc_attr( $button['target'] ); ?>">
                <?php if ( ! empty( $button_icon ) ) { ?>
                    <span class="affcoups-icon-<?php echo esc_attr( $button_icon ); ?> affcoups-coupon__button-icon"></span>
                <?php } ?>

                <?php echo esc_attr( $button['text'] ); ?></a>
            <?php
        }
    }
}