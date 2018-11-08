<?php query_posts( $query ); ?>

<?php if ( have_posts() ) : ?>
	<div class="listing-manager-tiles">
		<?php $index = 0; ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<div class="listing-manager-tile <?php echo esc_attr( $structure[ $index ]['class'] ); ?> col-<?php echo esc_attr( $structure[ $index ]['count'] ); ?>-<?php echo esc_attr( $structure[ $index ]['cols'] ); ?>">
                <div class="listing-manager-tile-inner">
                    <a href="<?php the_permalink(); ?>" class="listing-manager-image" style="background-image: url('<?php the_post_thumbnail_url( 'large' ); ?>'); ">

                    </a><!-- /.listing-manager-image -->

                    <div class="listing-manager-tile-content">
                        <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

                        <?php $location = ListingManager\Product\ListingProduct::get_location_name(); ?>
                        <?php if ( ! empty( $location ) ) : ?>
                            <h3><?php echo wp_kses( $location, wp_kses_allowed_html( 'post' ) ); ?></h3>
                        <?php endif; ?>
                    </div><!-- /.listing-manager-tile-content -->

                    <?php $price = get_post_meta( get_the_ID(), '_regular_price', true ); ?>
                    <?php if ( ! empty( $price ) ) : ?>
                        <div class="listing-manager-tile-price">
                            <?php wc_get_template( 'loop/price.php' ); ?>
                        </div><!-- /.listing-manager-tile-price -->
                    <?php endif; ?>

                    <?php ListingManager\Logic\FavoriteLogic::render_button(); ?>
                </div><!-- /.listing-manager-title-inner -->
			</div><!-- /.listing-manager-tile -->

			<?php $index++; ?>
		<?php endwhile; ?>
	</div><!-- /.listing-manager-tiles -->
<?php endif; ?>

<?php wp_reset_query(); ?>