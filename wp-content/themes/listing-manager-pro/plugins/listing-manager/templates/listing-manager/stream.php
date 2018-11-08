<?php query_posts( $query ); ?>

<?php if ( have_posts() ) : ?>
	<div class="listing-manager-stream-wrapper">
		<ul class="listing-manager-stream">
			<?php while ( have_posts() ) : the_post(); ?>
				<li class="listing-manager-stream-item">
					<div class="listing-manager-stream-item-inner">
						<div class="listing-manager-stream-meta">
							<?php $event_date = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'event_date', true ); ?>
							<?php $event_time = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'event_time', true ); ?>

							<?php if ( ! empty( $event_date ) ) : ?>
								<div class="listing-manager-stream-item-cell date">								
									<?php echo date_i18n( get_option( 'date_format' ), strtotime( $event_date ) ); ?>

									<?php if ( ! empty( $event_time ) ) : ?>
										<span><?php echo $event_time; ?></span>
									<?php endif; ?>
								</div><!-- /.listing-manager-stream-item-cell -->
							<?php endif; ?>

							<div class="listing-manager-stream-item-cell title">
								<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>				
							</div><!-- /.listing-manager-stream-item-cell -->

							<?php $price = get_post_meta( get_the_ID(), '_regular_price', true ); ?>
							<?php if ( ! empty( $price ) ) : ?>
								<div class="listing-manager-stream-item-cell price">
									<?php wc_get_template( 'loop/price.php' ); ?>						
								</div><!-- /.listing-manager-stream-item-cell -->					
							<?php endif; ?>
						</div><!-- /.listing-manager-stream-meta -->

						<div class="listing-manager-stream-item-content">
                            <?php do_action( 'listing_manager_stream_item_content_before' );  ?>


                            <div class="listing-manager-stream-item-thumbnail" >
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <a href="<?php the_permalink(); ?>" style="background-image: url('<?php the_post_thumbnail_url( 'thumbnail' ); ?>'"></a>
                                <?php else : ?>
                                    <a href="<?php the_permalink(); ?>" style="background-image: url('<?php echo wc_placeholder_img_src(); ?>');"></a>
                                <?php endif; ?>
                            </div><!-- /.listing-manager-stream-item-thumbnail -->

							<?php $excerpt = get_the_excerpt(); ?>
                            <?php if ( ! empty( $excerpt ) ) : ?>
                                <div class="listing-manager-stream-item-excerpt">
                                    <?php echo wp_kses( $excerpt, wp_kses_allowed_html( 'post' ) ); ?>
                                </div><!-- /.listing-manager-stream-item-excerpt -->
                            <?php endif; ?>

							<?php do_action( 'listing_manager_stream_item_content_after' );  ?>
						</div><!-- /.listing-manager-stream-item-content -->
					</div><!-- /.listing-manager-strea-item-inner -->
				</li>
			<?php endwhile; ?>
		</ul>
	</div><!-- /.listing-manager-stream-wrapper -->
<?php endif; ?>

<?php wp_reset_query(); ?>