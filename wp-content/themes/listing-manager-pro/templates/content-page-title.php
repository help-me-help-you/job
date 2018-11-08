<?php $title = get_the_title(); ?>

<?php if ( ! empty( $title ) || is_search() ) : ?>
	<div class="page-title <?php if ( is_singular( ['product'] ) && has_term( 'listing', 'product_type' ) ) : ?>product-title<?php endif; ?>">
		<div class="page-title-inner">
			<?php if ( is_search() ) : ?>
				<h1><?php echo esc_html__( 'Search Results', 'listing-manager-pro' ); ?></h1>
			<?php elseif ( class_exists( 'WooCommerce' ) && is_shop() ) : ?>
				<?php $title = woocommerce_page_title( false ); ?>
				<h1>
					<?php if ( ! empty( $title ) ) : ?>
						<?php echo esc_html( $title ); ?>
					<?php else : ?>
						<?php echo esc_html__( 'Listings', 'listing-manager-pro' ); ?>
					<?php endif; ?>
				</h1>

				<?php if ( is_shop() ) : ?>
					<?php $page_id = get_option( 'woocommerce_shop_page_id', null );?>
				<?php endif; ?>
			<?php elseif ( is_archive() ) : ?>
				<h1><?php the_archive_title(); ?></h1>
			<?php elseif ( is_search() ) : ?>
                <h1>
	                <?php echo esc_html__( 'Search for', 'listing-manager-pro' ); ?>
					<?php echo get_search_query(); ?>
                </h1>
			<?php elseif ( is_home() ) : ?>
				<h1><?php echo esc_html__( 'Recent news from', 'listing-manager-pro' ); ?> <?php bloginfo( 'name' ); ?></h1>
			<?php else : ?>
                <?php if ( defined( 'LISTING_MANAGER_LISTING_PREFIX' ) ) : ?>
				    <?php $verified = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'is_verified', true ); ?>
                <?php endif; ?>

				<h1>
					<?php if ( ! empty( $verified ) && defined( 'LISTING_MANAGER_LISTING_PREFIX' ) ) : ?>
						<span class="verified">
							<i class="silk silk-tick"></i> <span><?php echo esc_html__( 'Verified listing', 'listing-manager-pro' ); ?></span>
						</span>
					<?php endif; ?>

					<span>
						<?php the_title(); ?>
                    </span>
				</h1>

                <?php if ( is_singular( ['product'] ) && defined( 'LISTING_MANAGER_LISTING_PREFIX' ) ) : ?>
                    <?php $product = wc_get_product(); ?>

                    <?php if ( $product->get_average_rating() ) : ?>
                        <?php echo wc_get_rating_html( $product->get_average_rating() ); ?>
                    <?php endif; ?>

                    <?php $latitude = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'location_latitude', true ); ?>
					<?php $longitude = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'location_longitude', true ); ?>

                    <?php if ( ! empty( $latitude ) && ! empty( $longitude ) ) : ?>
						<?php $style = ListingManager\Logic\GoogleMapLogic::get_style(); ?>
                        <div id="map-object-product" class="page-title-map"
                             data-zoom="13"
                             data-image="<?php the_post_thumbnail_url( 'thumbnail' ); ?>"
                             <?php if ( ! empty( $style ) ) : ?>data-styles='<?php echo esc_attr( $style ); ?>'<?php endif;?>
                             data-latitude="<?php echo esc_attr( $latitude ); ?>"
                             data-longitude="<?php echo esc_attr( $longitude ); ?>"></div>
                    <?php endif; ?>

					<div class="actions">
                    	<?php do_action( 'listing_manager_pro_product_actions' ); ?>
                    </div><!-- /.actions -->
                <?php endif; ?>
			<?php endif; ?>
		</div><!-- /.page-title-inner -->
	</div><!-- /.page-title -->
<?php else : ?>
	<div class="page-title <?php if ( is_singular( ['product'] ) ) : ?>product-title<?php endif; ?>">
		<div class="page-title-inner">
			<h1>
                <?php $title = get_the_title(); ?>

                <?php if ( ! empty( $title ) ) : ?>
                    <?php echo esc_attr( $title ); ?>
                <?php else : ?>
                    <?php the_time( get_option( 'date_format' ) ); ?>
                <?php endif; ?>
			</h1>
		</div><!-- /.page-title-inner -->
	</div><!-- /.page-title -->
<?php endif; ?>