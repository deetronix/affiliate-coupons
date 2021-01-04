<?php
/**
 * Widget template
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
?>

<?php affcoups_tpl_the_wrapper_start(); ?>

    <div class="affcoups-widget">

        <?php foreach( $coupons as $coupon ) { ?>

            <div class="<?php $coupon->the_classes('affcoups-coupon' ); ?>"<?php $coupon->the_container(); ?>>

                <div class="affcoups-coupon__header">

                    <?php $coupon->the_image(); ?>

                    <?php if ( $coupon->get_discount() ) { ?>
                        <span class="affcoups-coupon__discount"><?php echo esc_attr( $coupon->get_discount() ); ?></span>
                    <?php } ?>

                </div>

                <div class="affcoups-coupon__content">

                    <span class="affcoups-coupon__title"><?php echo esc_attr( $coupon->get_title() ); ?></span>

                    <?php if ( $coupon->get_types() ) { ?>
                        <div class="affcoups-coupon__types">
                            <?php $coupon->the_types(); ?>
                        </div>
                    <?php } ?>

                    <div class="affcoups-coupon__description">
                        <?php echo wp_kses_post( $coupon->get_description() ); ?>
                    </div>

                    <?php if ( $coupon->show_code() ) { ?>
                        <div class="affcoups-coupon__code">
                            <?php $coupon->the_code(); ?>
                        </div>
                    <?php } ?>

                    <?php if ( $coupon->show_valid_dates() ) { ?>
                        <div class="affcoups-coupon__valid-dates">
                            <?php $coupon->the_valid_dates(); ?>
                        </div>
                    <?php } ?>

                </div>

                <div class="affcoups-coupon__footer">
                    <?php $coupon->the_button(); ?>
                </div>

            </div>

        <?php } ?>

    </div>

<?php affcoups_tpl_the_wrapper_end(); ?>
