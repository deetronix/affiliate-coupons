<?php
/**
 * Grid template
 *
 * @package AffiliateCoupons\Templates
 *
 * @var Affcoups_Coupon $coupon
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

// Check if coupons were found
if ( ! isset( $coupons ) )
    return;

// Default values
if ( ! isset ( $grid_size ) )
    $grid_size = '3';
?>
<div class="affcoups">

    <div class="affcoups-coupons-grid affcoups-coupons-grid--col-<?php echo esc_attr( $grid_size ); ?>">

        <?php foreach( $coupons as $coupon ) { ?>

            <div class="affcoups-coupons-grid__item">

                <div class="<?php $coupon->the_classes('affcoups-coupon' ); ?>"<?php $coupon->the_container(); ?>>

                    <div class="affcoups-coupon__header">
                        <?php affcoups_tpl_the_coupon_image( $coupon ); ?>
                        <?php affcoups_tpl_the_coupon_discount( $coupon ); ?>
                    </div>

                    <div class="affcoups-coupon__content">
                        <?php affcoups_tpl_the_coupon_title( $coupon ); ?>
                        <?php affcoups_tpl_the_coupon_types( $coupon ); ?>
                        <?php affcoups_tpl_the_coupon_description( $coupon ); ?>
                        <?php affcoups_tpl_the_coupon_code( $coupon ); ?>
                        <?php affcoups_tpl_the_coupon_valid_dates( $coupon ); ?>
                    </div>

                    <div class="affcoups-coupon__footer">
                        <?php affcoups_tpl_the_coupon_button( $coupon ); ?>
                    </div>

                </div>

            </div>

        <?php } ?>

    </div>

</div><!-- /.affcoups -->