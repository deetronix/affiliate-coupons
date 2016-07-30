<?php
/*
 * Coupons template
 */

if ( ! isset ( $posts ) )
    return;

// Default values
if ( ! isset ( $grid ) )
    $grid = '3';
?>
<div class="affcoups-coupons-grid affcoups-coupons-grid--col-<?php echo $grid; ?>">
    <?php while ( $posts->have_posts() ) { ?>
        <?php $posts->the_post(); ?>
        <div class="affcoups-coupons-grid__item">

            <div class="<?php affcoups_the_coupon_classes('affcoups-coupon'); ?>">
                <div class="affcoups-coupon__header">
                    <div class="affcoups-coupon__thumbnail">
                        <?php affcoups_the_coupon_thumbnail(); ?>
                    </div>

                    <?php if ( affcoups_get_coupon_discount() ) { ?>
                        <span class="affcoups-coupon__discount"><?php echo affcoups_get_coupon_discount(); ?></span>
                    <?php } ?>
                </div>

                <div class="affcoups-coupon__content">
                    <h3 class="affcoups-coupon__title"><?php echo affcoups_get_coupon_title(); ?></h3>

                    <?php if ( affcoups_get_coupon_types() ) { ?>
                        <div class="affcoups-coupon__types">
                            <?php affcoups_the_coupon_types(); ?>
                        </div>
                    <?php } ?>

                    <div class="affcoups-coupon__description">
                        <?php echo affcoups_get_coupon_description(); ?>
                    </div>

                    <?php if ( affcoups_get_coupon_code() ) { ?>
                        <div class="affcoups-coupon__code">
                            <?php affcoups_the_coupon_code(); ?>
                        </div>
                    <?php } ?>

                    <?php if ( ! empty ( affcoups_has_coupon_valid_dates() ) ) { ?>
                        <div class="affcoups-coupon__valid-dates">
                            <?php affcoups_the_coupon_valid_dates(); ?>
                        </div>
                    <?php } ?>
                </div>

                <div class="affcoups-coupon__footer">
                    <a class="affcoups-coupon__button" href="<?php echo affcoups_get_coupon_url(); ?>" title="<?php echo affcoups_get_coupon_title(); ?>" rel="nofollow" target="_blank"><span class="affcoups-coupon__button-icon"></span> <?php _e('Go to the deal', 'affiliate-coupons'); ?></a>
                </div>

            </div>

        </div>
    <?php } ?>
</div>