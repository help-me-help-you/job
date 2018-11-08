<?php $listing_add_page_id = get_theme_mod( 'listing_manager_pages_listing_add', null ); ?>

<?php if ( ! empty( $listing_add_page_id ) ) : ?>
	<a href="<?php echo get_permalink( $listing_add_page_id ); ?>" class="button listing-manager-listing-add">
		<?php echo get_the_title( $listing_add_page_id ); ?>
	</a>
<?php endif; ?>

<?php if ( have_posts() ) : ?>
	<table class="table listing-manager-table-list">
		<thead>
			<tr>
				<th class="thumbnail-wrapper">
					<?php echo esc_html__( 'Image', 'listing-manager' ); ?>
				</th>

				<th class="title-wrapper">
					<?php echo esc_html__( 'Title', 'listing-manager' ); ?>
				</th>

				<?php if ( 'memberships' === get_theme_mod( 'listing_manager_submission_type', 'free' ) ) : ?>
                    <th class="membership-wrapper">
						<?php echo esc_html__( 'Membership', 'listing-manager' ); ?>
                    </th>
				<?php endif; ?>

				<?php if ( 'packages' === get_theme_mod( 'listing_manager_submission_type', 'free' ) ) : ?>
					<th class="package-wrapper">
						<?php echo esc_html__( 'Package', 'listing-manager' ); ?>
					</th>
				<?php endif; ?>

				<th class="status-wrapper">
					<?php echo esc_html__( 'Status', 'listing-manager' ); ?>
				</th>

				<th class="featured-wrapper">
					<?php echo esc_html__( 'Featured', 'listing-manager' ); ?>
				</th>

				<th class="actions-wrapper">
					<?php echo esc_html__( 'Actions', 'listing-manager' ); ?>
				</th>
			</tr>
		</thead>

		<tbody>
			<?php while ( have_posts() ): the_post(); ?>
				<tr>
					<td class="thumbnail-wrapper">
						<a href="<?php the_permalink(); ?>">
							<?php if ( has_post_thumbnail() ) : ?>
								<?php the_post_thumbnail( 'shop_thumbnail' ); ?>
							<?php else: ?>
								<?php echo wc_placeholder_img(); ?>
							<?php endif; ?>
						</a>
					</td><!-- /.thumbnail-wrapper -->

					<td class="title-wrapper">
						<h3>
							<a href="<?php the_permalink(); ?>">
								<?php the_title(); ?>
							</a>
						</h3>
					</td><!-- /.title-wrapper -->

					<?php if ( 'memberships' === get_theme_mod( 'listing_manager_submission_type', 'free' ) ) : ?>
                        <td class="membership-wrapper">
                            <?php $membership_id = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'membership', true ); ?>
	                        <?php $membership = wc_memberships_get_user_membership( $membership_id ); ?>

							<?php if ( ! empty( $membership ) ) : ?>
                                <?php echo esc_html( $membership->plan->name ); ?>
							<?php else : ?>
                                -
							<?php endif; ?>
                        </td><!-- /.package-wrapper -->
					<?php endif; ?>

					<?php if ( 'packages' === get_theme_mod( 'listing_manager_submission_type', 'free' ) ) : ?>
						<td class="package-wrapper">
							<?php $package_id = get_post_meta( get_the_ID(), LISTING_MANAGER_LISTING_PREFIX . 'package', true ); ?>
							<?php if ( ! empty( $package_id ) ) : ?>
								<?php echo get_the_title( $package_id ); ?>
							<?php else : ?>
								-
							<?php endif; ?>
						</td><!-- /.package-wrapper -->
					<?php endif; ?>

					<td class="status-wrapper">
						<?php $post_status = get_post_status( get_the_ID() ); ?>

                        <span class="<?php echo esc_attr( $post_status ); ?>">
                            <?php if ( 'pending' === $post_status ) : ?>
                                <span title="<?php echo esc_attr__( 'Waiting for admin approval.', 'listing-manager'); ?>">
                                    <?php echo esc_html__( 'Pending', 'listing-manager' ); ?>
                                </span>
                            <?php elseif ( 'draft' === $post_status ) : ?>
                                <span title="<?php echo esc_attr__( 'Package not assigned or expired.', 'listing-manager'); ?>">
                                    <?php echo esc_html__( 'Draft', 'listing-manager' ); ?>
                                </span>
                            <?php elseif ( 'publish' === $post_status ) : ?>
                                <span title="<?php echo esc_attr__( 'Listing is published.', 'listing-manager'); ?>">
                                    <?php echo esc_html__( 'Published', 'listing-manager' ); ?>
                                </span>
                            <?php elseif ( 'private' === $post_status ) : ?>
                                <span title="<?php echo esc_attr__( 'Listing date has expired (e.g. event date).', 'listing-manager'); ?>">
                                    <?php echo esc_html__( 'Private', 'listing-manager' ); ?>
                                </span>
                            <?php endif; ?>
                        </span>
					</td><!-- /.status-wrapper -->

					<td class="featured-wrapper">
						<?php $featured = get_post_meta( get_the_ID(), '_featured', true ); ?>
						<?php if ( 'yes' === $featured ) : ?>
							<div class="featured yes">
								<?php echo esc_attr__( 'Yes', 'listing-manager' ); ?>
							</div><!-- /.featured -->
						<?php else : ?>
							<div class="featured no">
								<?php echo esc_attr__( 'No', 'listing-manager' ); ?>
							</div><!-- /.featured -->
						<?php endif; ?>
					</td><!-- /.featured-wrapper -->

					<td class="actions-wrapper">
						<?php $already_featured = get_post_meta( get_the_ID(), '_featured', true ); ?>
						<?php $feature = get_theme_mod( 'listing_manager_micropayments_feature', null ); ?>

						<?php if ( ! empty( $feature ) && 'no' === $already_featured ) : ?>
							<?php $feature_product = new WC_Product( $feature ); ?>
							<a class="button feature" href="?action=feature-listing&id=<?php echo get_the_ID(); ?>" class="button">
                                <span>
                                    <?php echo esc_attr( 'Feature', 'listing-manager' ); ?>
                                    <?php echo wp_kses( wc_price( $feature_product->get_price() ), wp_kses_allowed_html( 'post') ); ?>
                                </span>
							</a>
						<?php endif; ?>

						<?php $status = get_post_status( get_the_ID() ); ?>
						<?php $publish = get_theme_mod( 'listing_manager_micropayments_publish', null ); ?>

						<?php if ( ! empty( $publish ) && 'publish' !== $status ) : ?>
							<?php $publish_product = new WC_Product( $publish ); ?>
							<a class="button publish" href="?action=publish-listing&id=<?php echo get_the_ID(); ?>">
                                <span>
                                    <?php echo esc_attr( 'Publish', 'listing-manager' ); ?>
                                    <?php echo wp_kses( wc_price( $publish_product->get_price() ), wp_kses_allowed_html( 'post') ); ?>
                                </span>
							</a>
						<?php endif; ?>

						<?php $edit_listing = get_theme_mod( 'listing_manager_pages_listing_edit', null );?>
						<?php if ( ! empty( $edit_listing ) ) : ?>
                            <?php $args = [
                               'id' => get_the_ID(),
                            ]; ?>

                            <?php $form = get_post_meta( get_the_ID(), 'form', true ); ?>
                            <?php if ( ! empty( $form ) ) : ?>
                                <?php $args['form'] = $form; ?>
                            <?php endif; ?>

                            <?php $query = http_build_query( $args ); ?>
							<a class="button edit" href="<?php echo get_permalink( $edit_listing ); ?>?<?php echo $query; ?>">
                                <span>
								    <?php echo get_the_title( $edit_listing ); ?>
                                </span>
							</a>
						<?php endif; ?>
						
						<?php $remove_listing = get_theme_mod( 'listing_manager_pages_listing_remove', null );?>
						<?php if ( ! empty( $remove_listing ) ) : ?>
							<a class="button delete" href="<?php echo get_permalink( $remove_listing ); ?>?id=<?php echo esc_attr( get_the_ID() ); ?>">
                                <span>
								    <?php echo get_the_title( $remove_listing ); ?>
                                </span>
							</a>
						<?php endif; ?>
					</td><!-- /.actions-wrapper -->
				</tr>
			<?php endwhile; ?>
		</tbody>
	</table>

    <?php woocommerce_pagination(); ?>
<?php else : ?>
	<div class="listing-manager-no-listings">
		<?php $create = get_theme_mod( 'listing_manager_pages_listing_add', null ); ?>

		<?php if ( ! empty( $create ) ) : ?>
			<?php echo wp_kses( __( 'No listings found. You can start by <a href="' . get_permalink( $create) . '">creating one here</a>.', 'listing-manager' ), wp_kses_allowed_html('post') ); ?>
		<?php else : ?>
			<?php echo esc_html__( 'No listings found.', 'listing-manager' ); ?>
		<?php endif; ?>
	</div><!-- /.listing-manager-no-listings -->
<?php endif; ?>
