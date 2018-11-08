<?php if ( ! empty( $_SESSION['compare'] ) ) : ?>
	<?php $ids = $_SESSION['compare']; ?>
<?php endif; ?>

<?php if ( ! empty( $_GET['ids'] ) ) : ?>
	<?php $ids = explode( ',', $_GET['ids'] ); ?>
<?php endif; ?>

<?php if ( ! empty( $ids ) ) : ?>
	<div class="listing-manager-compare-wrapper">
		<div class="listing-manager-compare-description-wrapper">
			<div class="listing-manager-compare-description">
				<ul>
					<li><?php echo esc_html__( 'Location', 'listing-manager' ); ?></li>
					<li><?php echo esc_html__( 'Price', 'listing-manager' ); ?></li>

					<?php do_action( 'listing_manager_compare_field_keys' ); ?>
				</ul>
			</div><!-- /.listing-compare-description -->
		</div><!-- /.listing-manager-compare-description-wrapper -->

		<?php query_posts( [
			'post_type' 		=> 'product',
			'post__in' 			=> $ids,
			'post_status'		=> 'publish',
			'posts_per_page'	=> -1,
            'tax_query'         => [
                [
                    'taxonomy'  => 'product_type',
                    'field'     => 'slug',
                    'terms'     => 'listing',
                ],
            ],
		] ) ; ?>

		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ): the_post() ?>
				<div class="listing-manager-compare-col-wrapper">
					<div class="listing-manager-compare-col">
						<div class="listing-manager-compare-image">
					        <?php if ( has_post_thumbnail() ) : ?>
					            <?php $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'thumbnail' ); ?>
					            <?php $image = $image[0]; ?>
							<?php endif; ?>

							<a href="<?php the_permalink(); ?>" class="listing-manager-compare-image-link" style="background-image: url('<?php echo $image; ?>');"></a>
						</div><!-- /.listing-compare-image -->

						<div class="listing-manager-compare-title">
							<h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?><br></a></h2>
						</div><!-- /.listing-compare-title -->

						<ul class="listing-manager-compare-list">
							<li>
				                <?php $location = ListingManager\Product\ListingProduct::get_location_name(); ?>
				                <?php if ( ! empty( $location ) ) : ?>
				                	<?php echo wp_kses( $location, wp_kses_allowed_html( 'post' ) ); ?>
				                <?php else : ?>
                                <span class="undefined"><?php echo esc_html__( 'Undefined', 'listing-manager' ); ?></span>
				                <?php endif; ?>
							</li>

							<li>
								<?php $product = wc_get_product( get_the_ID() ); ?>
					            <?php $price = $product->get_price_html(); ?>
					            <?php if ( ! empty( $price ) ) : ?>
					                <?php echo wp_kses( $price, wp_kses_allowed_html( 'post' ) ); ?>
					            <?php else : ?>
					            	<span class="undefined"><?php echo esc_html__( 'Undefined', 'listing-manager' ); ?></span>
					            <?php endif; ?>
							</li>

							<?php do_action( 'listing_manager_compare_field_values', get_the_ID() ); ?>
						</ul><!-- /.listing-manager-compare-list -->
					</div><!-- /.listing-manager-compare-col -->
				</div><!-- /.listing-manager-compare-col-wrapper -->
			<?php endwhile; ?>
		<?php endif; ?>

		<?php wp_reset_query(); ?>
	</div><!-- /.listing-manager-compare-wrapper -->
<?php else : ?>
	<div class="alert alert-warning">
		<?php echo esc_html__( 'No listings found for comparison.', 'listing-manager' ); ?>
	</div><!-- /.alert -->
<?php endif; ?>
