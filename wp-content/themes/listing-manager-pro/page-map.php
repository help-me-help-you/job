<?php
/**
 * Template name: Map
 */

get_header( 'minimal' ); ?>

<?php
    global $wp_query;
    ListingManager\Type\ListingType::query();
    $query = ListingManager\Logic\FilterLogic::filter_query( $wp_query );
    $query->posts = $query->get_posts();
    $wp_query = $query;
?>
<?php $ids = []; ?>

<div class="map-search-wrapper">
	<div class="map-search">
		<div class="map-search-inner">
			<div class="map-search-content tse-scrollable">
                <div class="tse-content">
                    <?php if ( have_posts() ) : ?>
                        <?php dynamic_sidebar( 'page-map' ); ?>

                        <div class="map-search-items">
                            <?php while( have_posts() ) : the_post(); ?>
	                            <?php $ids[] = get_the_ID(); ?>

                                <div class="map-search-item" data-marker-id="<?php the_ID(); ?>">
                                    <div class="map-search-item-image">
                                        <?php if ( has_post_thumbnail() ) : ?>
                                            <?php $image = wc_get_product_attachment_props( get_post_thumbnail_id() ); ?>
                                            <a href="<?php the_permalink(); ?>" style="background-image: url(<?php echo esc_attr( $image['src'] ); ?>);"></a>
                                        <?php endif; ?>

                                        <?php $product = wc_get_product( get_the_ID() ); ?>

                                        <?php if ( $product ) : ?>
                                            <?php $price = $product->get_price_html(); ?>

                                            <?php if ( ! empty( $price ) ) : ?>
                                                <div class="map-search-item-price">
                                                    <?php echo wp_kses( $price, wp_kses_allowed_html( 'post' ) ); ?>
                                                </div><!-- /.map-search-item-price -->
                                            <?php endif; ?>
                                        <?php endif; ?>

	                                    <?php $terms = wp_get_object_terms( get_the_ID(), 'product_cat', ['parent' => 0 ] ); ?>
	                                    <?php if ( ! empty( $terms ) ) : ?>
		                                    <?php $term = array_shift( $terms ); ?>
		                                    <?php $font_icon = get_term_meta( $term->term_id, 'font_icon', true ); ?>

		                                    <?php if ( ! empty( $font_icon ) ) : ?>
                                                <div class="map-search-item-category">
				                                    <?php echo $font_icon; ?>
                                                </div><!-- /.map-search-item-category -->
		                                    <?php endif; ?>
	                                    <?php endif; ?>
                                    </div><!-- /.map-search-item-image -->

                                    <div class="map-search-item-content">
                                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

                                        <?php $location = \ListingManager\Product\ListingProduct::get_location_name(); ?>
                                        <?php if ( ! empty( $location ) ) : ?>
                                            <div class="map-search-item-location">
                                                <?php echo wp_kses_post( $location ); ?>
                                            </div><!-- /.map-search-item-location -->
                                        <?php endif; ?>
                                    </div><!-- /.map-search-item-content-->
                                </div><!-- /.map-search-item -->
                            <?php endwhile; ?>
                        </div><!-- /.map-search-items -->
                    <?php endif; ?>

                    <?php listing_manager_pro_pagination(); ?>
                </div><!-- /.tse-content -->
			</div><!-- /.map-search-content -->

			<div class="map-search-holder">
				<?php echo do_shortcode('[listing_manager_google_map map_types=on map_zoom=on show_all_markers=on ids=' . implode( ',', $ids ) . ']'); ?>
			</div><!-- /.map-search-holder -->
		</div><!-- /.map-search-inner -->
	</div><!-- /.map-search -->
</div><!-- /.map-search-wrapper -->

<?php if ( class_exists( '\ListingManager\Bootstrap' ) ) : ?>
	<?php \ListingManager\Utilities::reset_query(); ?>
<?php endif; ?>

<?php get_footer( 'minimal' ); ?>
