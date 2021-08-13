'use strict';
import Masonry from '../../../../node_modules/masonry-layout'

// Global for access from pro version
let affcoupsActivateMasonry = (container) => {

    if ( jQuery(window).width() < 481 )
        return false;

    let columnWidth;

    [2,3,4,5,6,7,8,9,10].find(function(item, index, array) {

        if ( jQuery(container).hasClass('affcoups-coupons-grid--col-' + item) ) {
            columnWidth = container.offsetWidth / item;
        }
    });

    if ( jQuery(window).width() < 769 ) {

        [3,4,5,6,7,8,9,10].find(function(item, index, array) {

            if ( jQuery(container).hasClass('affcoups-coupons-grid--col-' + item) ) {
                columnWidth = container.offsetWidth / 2;
            }
        });

    } else if ( jQuery(window).width() > 768 && jQuery(window).width() < 1025 ) {

        if ( jQuery(container).hasClass('affcoups-coupons-grid--col-7')
          || jQuery(container).hasClass('affcoups-coupons-grid--col-9')
        ){
            columnWidth = container.offsetWidth / 3;

        } else if ( jQuery(container).hasClass('affcoups-coupons-grid--col-8') ) {
            columnWidth = container.offsetWidth / 4;

        } else if ( jQuery(container).hasClass('affcoups-coupons-grid--col-10') ) {
            columnWidth = container.offsetWidth / 5;
        }
    }

    if ( undefined === columnWidth )
        return false;

    new Masonry(container, {
        itemSelector: '.affcoups-coupons-grid__item',
        columnWidth: columnWidth,
        percentPosition: true
    });
};

jQuery(document).ready(function($) {

    $('.affcoups-coupons-grid-masonry').each((i, container) => {

console.log(i);

        affcoupsActivateMasonry(container);
    });

    $(window).resize(function() {
        $('.affcoups-coupons-grid-masonry').each((i, container) => {
            affcoupsActivateMasonry(container);
        });
    });
});

export {affcoupsActivateMasonry};