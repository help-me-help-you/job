<div class="wrap">
	<h1><?php echo esc_html__( 'Statistics', 'listing-manager' ); ?></h1>

    <?php $query_enabled = get_theme_mod( 'listing_manager_statistics_enable_listing_logging', false ); ?>

    <?php if ( empty( $query_enabled ) ) : ?>
        <div class="notice warning">
            <p><?php echo esc_html__( 'Listing views logging is disabled. If you want to collect stats, plase enable under "Appearance - Customize - Listing Manager Statistics".', 'listing-manager' ); ?></p>
        </div><!-- /.notice -->
    <?php endif; ?>

	<div class="statistics-wrapper">
		<div class="statistics-items">
			<div class="statistics-item">
				<strong><?php echo esc_html__( 'Total Views', 'listing-manager' ); ?></strong>
				<span><?php echo esc_html( $views ); ?></span>
			</div><!-- /.statistics-item -->

			<div class="statistics-item">
				<strong><?php echo esc_html__( 'Total Searches', 'listing-manager' ); ?></strong>
				<span><?php echo esc_html( $searches ); ?></span>
			</div><!-- /.statistics-item -->

			<div class="statistics-item">
				<strong><?php echo esc_html__( 'Listings', 'listing-manager' ); ?></strong>
				<span><?php echo esc_html( $listings ); ?></span>
			</div><!-- /.statistics-item -->		

			<div class="statistics-item">
				<strong><?php echo esc_html__( 'Packages', 'listing-manager' ); ?></strong>
				<span><?php echo esc_html( $packages ); ?></span>
			</div><!-- /.statistics-item -->		

			<div class="statistics-item">
				<strong><?php echo esc_html__( 'Registered Users', 'listing-manager' ); ?></strong>
				<span><?php echo esc_html( $users ); ?></span>
			</div><!-- /.statistics-item -->							
		</div><!-- /.statistics-items -->

		<div class="statistics-tables">
			<?php if ( ! empty( $popular_listings ) ) : ?>
				<div class="statistics-table">
					<table>
		                <thead>
			                <th colspan="2" class="center">
			                    <?php echo esc_html__( '10 most popular listings', 'listing-manager' ); ?>
			                </th>
		                </thead>

		                <tbody>
		                	<?php foreach( $popular_listings as $listing ) : ?>
			                    <tr>
			                        <td><a href="<?php echo get_the_permalink( $listing->key ); ?>"><?php echo get_the_title( $listing->key ); ?><a></td>

			                        <td class="min-width"><?php echo esc_attr( $listing->count ); ?> <?php echo esc_html__( 'views', 'listing-manager' ); ?></td>
			                    </tr>                                     
		                	<?php endforeach; ?>
		                </tbody>
		            </table>
	            </div><!-- /.statistics-table -->   
            <?php endif; ?>     

			<?php if ( ! empty( $popular_locations ) ) : ?>
				<div class="statistics-table">
					<table>
		                <thead>
			                <th colspan="2" class="center">
			                    <?php echo esc_html__( '10 most popular locations', 'listing-manager' ); ?>
			                </th>
		                </thead>

		                <tbody>
		                	<?php foreach( $popular_locations as $category_id => $views ) : ?>
			                    <tr>
			                        <td>
			                        	<?php $term = get_term( $category_id, 'locations' ); ?>
                                        <?php if ( ! empty( $term ) ) : ?>
			                        	    <a href="<?php echo get_term_link( $term->term_taxonomy_id, 'locations' ); ?>">
                                                <?php echo esc_attr( $term->name ); ?>
                                            </a>
                                        <?php endif; ?>
			                        </td>

			                        <td class="min-width"><?php echo esc_attr( $views ); ?> <?php echo esc_html__( 'views', 'listing-manager' ); ?></td>
			                    </tr>                                     
		                	<?php endforeach; ?>
		                </tbody>
		            </table>
	            </div><!-- /.statistics-table -->   
            <?php endif; ?>   
			
			<?php if ( ! empty( $popular_categories ) ) : ?>				
				<div class="statistics-table">
					<table>
		                <thead>
			                <th colspan="2" class="center">
			                    <?php echo esc_html__( '10 most popular categories', 'listing-manager' ); ?>
			                </th>
		                </thead>

		                <tbody>		                	
		                	<?php foreach ( $popular_categories as $category_id => $views ) : ?>
			                    <tr>
			                        <td>
			                        	<?php $term = get_term( $category_id, 'product_cat' ); ?>
			                        	<?php if ( ! empty( $term ) ) : ?>
				                        	<a href="<?php echo get_term_link( $term->term_taxonomy_id, 'product_cat' ); ?>">
				                        		<?php echo esc_attr( $term->name ); ?>
				                        	</a>
			                        	<?php endif; ?>
			                        </td>

			                        <td class="min-width"><?php echo esc_attr( $views ); ?> <?php echo esc_html__( 'views', 'listing-manager' ); ?></td>
			                    </tr>                                     
		                	<?php endforeach; ?>
		                </tbody>
		            </table>
	            </div><!-- /.statistics-table -->   
            <?php endif; ?>              
		</div><!-- /.statistics-tables -->
	</div><!-- /.statistics-wrapper -->
</div><!-- /.wrap -->