<?php if ( is_array( $packages ) ) : ?>
	<div class="listing-manager-packages">
		<?php foreach( $packages as $package ) : ?>
			<?php $product = wc_get_product( $package->ID ); ?>
			<?php $exclude = get_post_meta( $package->ID, LISTING_MANAGER_PACKAGE_PREFIX . 'exclude' , true )?>
			<?php $class = get_post_meta( $package->ID, LISTING_MANAGER_PACKAGE_PREFIX . 'class' , true ); ?>

			<?php if ( empty( $exclude ) ) : ?>
				<div class="listing-manager-package-wrapper <?php if ( ! empty( $class ) ) : ?><?php echo esc_attr( $class )?><?php endif; ?>">
					<div class="listing-manager-package">
						<div class="listing-manager-package-header">
							<div class="listing-manager-package-header-inner">
								<h2><?php echo esc_html( $package->post_title ); ?></h2>

								<?php if ( ! empty( $package->post_excerpt ) ) : ?>
									<p>
										<?php echo esc_html( $package->post_excerpt ); ?>
									</p>
								<?php endif; ?>
							</div><!-- /.listing-manager-package-header-inner -->
						</div><!-- /.listing-manager-package-header -->

						<div class="listing-manager-package-price">
							<?php echo wp_kses( $product->get_price_html(), wp_kses_allowed_html( 'post' ) ); ?>
						</div><!-- /.listing-manager-package-price -->					

						<ul class="listing-manager-package-list">
							<li>
								<strong><?php echo esc_html__( 'Time interval', 'listing-manager' ); ?></strong>
								<span><?php echo ListingManager\Product\PackageProduct::get_duration_formatted( $package->ID ); ?></span>
							</li>

							<li>
								<strong><?php echo esc_html__( 'No. of listings', 'listing-manager' ); ?></strong>
								<span><?php echo ListingManager\Product\PackageProduct::get_limit_formatted( $package->ID ); ?></span>
							</li>
						</ul>

						<div class="listing-manager-package-content">
							<?php echo wp_kses( $package->post_content, wp_kses_allowed_html( 'post' ) ); ?>
						</div><!-- /.listing-manager-package-content -->

						<div class="listing-manager-package-button-wrapper">
							<a href="?add-to-cart=<?php echo esc_attr( $package->ID ); ?>" data-quantity="1" data-product_id="<?php echo esc_attr( $package->ID ); ?>" class="button ajax_add_to_cart">
								<?php echo esc_html__( 'Add to cart', 'listing-manager' ); ?>
							</a>
						</div><!-- /.listing-manager-package-button-wrapper -->
					</div><!-- /.listing-manager-package -->
				</div><!-- /.listing-manager-package-wrapper -->
			<?php endif; ?>
		<?php endforeach; ?>
	</div><!-- /.listing-manager-packages -->
<?php endif; ?>