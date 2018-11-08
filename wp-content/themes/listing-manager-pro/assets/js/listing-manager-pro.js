jQuery(document).ready(function($) {
    'use strict';

    /**
     * Masonry
     */
    var container = $('.blog .posts, .search .posts');
    container.imagesLoaded(function() {
        container.masonry({
            itemSelector: '.post',
            percentPosition: true,
            gutter: 30
        });
    });

    /**
     * Scrollbar
     */
    $('.map-search-content').TrackpadScrollEmulator();

    /**
     * Hero animate
     */
    $('.hero').addClass('hero-animate');

    /**
     * Page navigation scroll
     */
    $('.page-navigation a').on('click', function(e) {
        e.preventDefault();

        var id = $(this).attr('href');

        $.scrollTo(id, 1200, {
            axis: 'y',
            offset: -80
        });
    });

    /**
     * Site navigation
     */
    $('.site-navigation-toggle').on('click', function(e) {
        $('.site-navigation').toggleClass('open');
    });

    /**
     * Product loop gallery
     */
    $('.product-loop-gallery').slick({
        infinite: true,
        dots: false,
        arrows: true,
        slidesToShow: 1,
        slidesToScroll: 1
    });

    /**
     * Product detail gallery
     */
    $('.woocommerce-product-gallery__wrapper').slick({
        infinite: true,
        dots: false,
        arrows: true,
        slidesToShow: 3,
        slidesToScroll: 1,
        responsive: [
            {
                breakpoint: 544,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
        ]        
    });

    /**
     * WooCommerce Tabs
     */
    $('.woocommerce-tabs a').on('click', function(e) {
        if (e.originalEvent) {
            var href = $(this).attr('href');
            var id = $(href);

            $.scrollTo(id, 1200, {
                axis: 'y',
                offset: -40
            });
        }
    });

    /**
     * Google Map Single
     */
    var mapObject = $('#map-object-product');

    if (mapObject.length) {
        var mapCenter = new google.maps.LatLng(mapObject.data('latitude'), mapObject.data('longitude'));
        var styles = mapObject.data('styles');
        var zoom = mapObject.data('zoom');
        var image = mapObject.data('image');
        var markers = [];
        var mapOptions = {
            center: mapCenter,
            styles: styles,
            zoom: zoom,
            scrollwheel: false,
            mapTypeControl: false,
            streetViewControl: false,
            zoomControl: false,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        };

        var map = new google.maps.Map(document.getElementById('map-object-product'), mapOptions);
        var marker = new RichMarker({
            flat: true,
            position: mapCenter,
            map: map,
            shadow: 0,
            content: '<div class="marker"><div class="marker-inner"><span class="marker-image" style="background-image: url(' + image + ')"></span></div></div>'
        });

        markers.push(marker);
    }
});