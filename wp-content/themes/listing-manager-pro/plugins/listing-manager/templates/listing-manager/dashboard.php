<div class="listing-manager-dashboard">
	<ul class="listing-manager-dashboard-nav">
		<?php $dashboard_page_id = get_theme_mod( 'listing_manager_pages_dashboard', false ); ?>
		<?php if ( ! empty( $dashboard_page_id ) ) : ?>
	        <li>
	            <a href="<?php the_permalink( $dashboard_page_id ); ?>">
		            <?php echo get_the_title( $dashboard_page_id ); ?>
	            </a>
	        </li>
		<?php endif; ?>

		<?php $listings_page_id = get_theme_mod( 'listing_manager_pages_listing_list', false ); ?>
		<?php if ( ! empty( $listings_page_id ) ) : ?>
	        <li>
	            <a href="<?php the_permalink( $listings_page_id ); ?>">
		            <?php echo get_the_title( $listings_page_id ); ?>
	            </a>
	        </li>
		<?php endif; ?>

		<?php $favorites_page_id = get_theme_mod( 'listing_manager_pages_favorites', false ); ?>
		<?php if ( ! empty( $favorites_page_id ) ) : ?>
	        <li>
	            <a href="<?php the_permalink( $favorites_page_id ); ?>">
		            <?php echo get_the_title( $favorites_page_id ); ?>
	            </a>
	        </li>
		<?php endif; ?>

	    <?php $create_page_id = get_theme_mod( 'listing_manager_pages_listing_add', false ); ?>
	    <?php if ( ! empty( $create_page_id ) ) : ?>
	        <li>
	            <a href="<?php the_permalink( $create_page_id ); ?>">
	                <?php echo get_the_title( $create_page_id ); ?>
	            </a>
	        </li>
	    <?php endif; ?>

		<?php $change_password_page_id = get_theme_mod( 'listing_manager_pages_password_change', false ); ?>
		<?php if ( ! empty( $change_password_page_id ) ) : ?>
	        <li>
	            <a href="<?php the_permalink( $change_password_page_id ); ?>">
		            <?php echo get_the_title( $change_password_page_id ); ?>
	            </a>
	        </li>
		<?php endif; ?>
	</ul><!-- /.listing-manager-dashboard-navigation -->

	<?php $submission_type = get_theme_mod( 'listing_manager_submission_type', 'free' ); ?>

	<?php if ( 'packages' === $submission_type ) : ?>
		<?php $packages = ListingManager\Product\PackageProduct::get_purchased_packages( get_current_user_id() ); ?>

		<?php if ( is_array( $packages ) ) : ?>
			<?php if ( 0 < count( $packages ) ) : ?>
				<h2><?php echo esc_html__( 'Packages Overview', 'listing-manager' ); ?></h2>

				<table class="listing-manager-dashboard-packages">				
					<thead>
						<tr>
							<th><?php echo esc_html__( 'Name', 'listing-manager' ); ?></th>
							<th><?php echo esc_html__( 'Limit', 'listing-manager' ); ?></th>
							<th><?php echo esc_html__( 'Time Interval', 'listing-manager' ); ?></th>
							<th><?php echo esc_html__( 'Assigned Listings', 'listing-manager' ); ?></th>
							<th><?php echo esc_html__( 'Expiration', 'listing-manager' ); ?></th>
						</tr>
					</thead>

					<tbody>
						<?php foreach ( $packages as $package ) : ?>
							<?php $product = wc_get_product( $package['product_id'] ); ?>

							<tr>
								<td><?php echo esc_html( $product->get_name() ); ?></td>
								<td><?php echo ListingManager\Product\PackageProduct::get_limit_formatted( $package['product_id'] ); ?></td>

								<td><?php echo ListingManager\Product\PackageProduct::get_duration_formatted( $package['product_id'] ); ?></td>

								<td>
									<?php $count = ListingManager\Product\PackageProduct::get_listing_count_for_order( $package['order_id'] ); ?>
									<?php echo esc_html( $count ); ?>
									<?php if ( 1 === $count ) : ?>
										<?php echo esc_html__( 'listing', 'listing-manager' ); ?>
									<?php else : ?>
										<?php echo esc_html__( 'listings', 'listing-manager' ); ?>
									<?php endif; ?>
								</td>

								<td>
									<?php echo ListingManager\Product\PackageProduct::get_expiration_formatted( $package['order_id'], $package['product_id'] ); ?>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php else : ?>
				<p>
					<?php echo esc_html__( 'No packages purchased.', 'listing-manager' ); ?>
				</p>
			<?php endif; ?>
		<?php endif; ?>
	<?php endif; ?>

	<?php
	$all = new WP_Query( [
		'post_type'         => 'product',
		'post_status'       => 'any',
		'posts_per_page'    => -1,
		'tax_query'         => [
			[
				'taxonomy'  => 'product_type',
				'field'     => 'slug',
				'terms'     => 'listing',
			],
		],
	] );

	$draft = new WP_Query( [
		'post_type'         => 'product',
		'post_status'       => 'draft',
		'posts_per_page'    => -1,
		'tax_query'         => [
			[
				'taxonomy'  => 'product_type',
				'field'     => 'slug',
				'terms'     => 'listing',
			],
		],
	] );

	$publish = new WP_Query( [
		'post_type'         => 'product',
		'post_status'       => 'publish',
		'posts_per_page'    => -1,
		'tax_query'         => [
			[
				'taxonomy'  => 'product_type',
				'field'     => 'slug',
				'terms'     => 'listing',
			],
		],
	] );

	$private = new WP_Query( [
		'post_type'         => 'product',
		'post_status'       => 'private',
		'posts_per_page'    => -1,
		'tax_query'         => [
			[
				'taxonomy'  => 'product_type',
				'field'     => 'slug',
				'terms'     => 'listing',
			],
		],
	] );

	$featured = new WP_Query( [
		'post_type'         => 'product',
		'post_status'       => 'publish',
		'posts_per_page'    => -1,
		'meta_query'        => [
			[
				'key'       => '_featured',
				'value'     => 'yes',
				'compare'   => '=',
			],
		],
		'tax_query'         => [
			[
				'taxonomy'  => 'product_type',
				'field'     => 'slug',
				'terms'     => 'listing',
			],
		],
	] );

	$pending = new WP_Query( [
		'post_type'         => 'product',
		'post_status'       => 'pending',
		'posts_per_page'    => -1,
		'tax_query'         => [
			[
				'taxonomy'  => 'product_type',
				'field'     => 'slug',
				'terms'     => 'listing',
			],
		],
	] );
	?>

	<h2><?php echo esc_html__( 'Listings Overview', 'listing-manager' ); ?></h2>

	<table class="table listing-manager-dashboard-listings">	
		<thead>
			<tr>
				<th><?php echo esc_html__( 'All', 'listing-manager' ); ?></th>
				<th><?php echo esc_html__( 'Published', 'listing-manager' ); ?></th>
	            <th><?php echo esc_html__( 'Pending', 'listing-manager' ); ?></th>
				<th><?php echo esc_html__( 'Draft', 'listing-manager' ); ?></th>
				<th><?php echo esc_html__( 'Private', 'listing-manager' ); ?></th>
				<th><?php echo esc_html__( 'Featured', 'listing-manager' ); ?></th>
			</tr>
		</thead>

		<tbody>
			<tr>
				<td><?php echo count( $all->posts ); ?></td>
				<td><?php echo count( $publish->posts ); ?></td>
	            <td><?php echo count( $pending->posts ); ?></td>
				<td><?php echo count( $draft->posts ); ?></td>
				<td><?php echo count( $private->posts ); ?></td>
				<td><?php echo count( $featured->posts ); ?></td>
			</tr>
		</tbody>
	</table>
</div><!-- /.listing-manager-dashboard -->