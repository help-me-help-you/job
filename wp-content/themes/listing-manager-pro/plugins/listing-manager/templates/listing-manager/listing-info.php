<?php $agent_id = get_post_meta( $id, LISTING_MANAGER_LISTING_PREFIX . 'agent', true ); ?>
<?php $agent_url = get_the_post_thumbnail_url( $agent_id, 'medium' );  ?>

<div class="listing-manager-listing-info">
	<?php if ( ! empty( $agent_id) ) : ?>
		<?php if ( ! empty( $agent_url ) ) : ?>
			<a href="<?php echo get_the_permalink( $agent_id ); ?>"
			   class="listing-manager-listing-info-image"
			   style="background-image: url('<?php echo esc_attr( $agent_url ); ?>');"></a>
		<?php endif; ?>

		<h2 class="listing-manager-listing-info-title"><a href="<?php echo get_the_permalink( $agent_id ); ?>"><?php echo get_the_title( $agent_id ); ?></a></h2>

		<?php $facebook = get_post_meta( $agent_id, LISTING_MANAGER_AGENT_PREFIX . 'social_facebook', true ); ?>
		<?php $twitter = get_post_meta( $agent_id, LISTING_MANAGER_AGENT_PREFIX . 'social_twitter', true ); ?>
		<?php $linkedin = get_post_meta( $agent_id, LISTING_MANAGER_AGENT_PREFIX . 'social_linkedin', true ); ?>
		<?php $google = get_post_meta( $agent_id, LISTING_MANAGER_AGENT_PREFIX . 'social_google', true ); ?>

		<?php if ( ! empty( $facebook ) || ! empty( $twitter ) || ! empty( $linkedin ) || ! empty( $google ) ) : ?>
			<div class="listing-manager-listing-info-social">
				<ul>
					<?php if ( ! empty( $facebook ) ) : ?>
						<li>
							<a href="<?php echo esc_attr( $facebook ); ?>" class="facebook">
								<span><?php echo esc_html__( 'Facebook', 'listing-manager' ); ?></span>
							</a>
						</li>
					<?php endif; ?>

					<?php if ( ! empty( $twitter ) ) : ?>
						<li>
							<a href="<?php echo esc_attr( $twitter ); ?>" class="twitter">
								<span><?php echo esc_html__( 'Twitter', 'listing-manager' ); ?></span>
							</a>
						</li>
					<?php endif; ?>

					<?php if ( ! empty( $linkedin ) ) : ?>
						<li>
							<a href="<?php echo esc_attr( $linkedin ); ?>" class="linkedin">
								<span><?php echo esc_html__( 'LinkedIn', 'listing-manager' ); ?></span>
							</a>
						</li>
					<?php endif; ?>

					<?php if ( ! empty( $google ) ) : ?>
						<li>
							<a href="<?php echo esc_attr( $google ); ?>" class="google">
								<span><?php echo esc_html__( 'Google', 'listing-manager' ); ?></span>
							</a>
						</li>
					<?php endif; ?>
				</ul>
			</div><!-- /.post-social -->
		<?php endif; ?>
	<?php endif; ?>

	<div class="listing-manager-listing-info-actions">
		<?php ListingManager\Logic\ReportLogic::render_button( $id ); ?>
		<?php ListingManager\Logic\ClaimLogic::render_button( $id ); ?>
		<?php ListingManager\Logic\FavoriteLogic::render_button( $id ); ?>
	</div><!-- /.listing-manager-listing-info-actions -->
</div><!-- /.listing-manager-listing-info -->
