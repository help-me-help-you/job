<?php if ( have_posts() ) : ?>
	<div class="companies-medium-wrapper companies-columns-<?php echo esc_attr( $columns )?>">
		<?php while( have_posts() ) : the_post(); ?>
			<div class="company-medium">
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="company-medium-thumbnail">
						<a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail( 'medium' ); ?>
						</a>
					</div><!-- /.company-medium-thumbnail -->
				<?php endif; ?>

				<div class="company-medium-content">
					<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

					<?php $email = get_post_meta( get_the_ID(), LISTING_MANAGER_COMPANY_PREFIX . 'email', true ); ?>
					<?php $web = get_post_meta( get_the_ID(), LISTING_MANAGER_COMPANY_PREFIX . 'web', true ); ?>
					<?php $phone = get_post_meta( get_the_ID(), LISTING_MANAGER_COMPANY_PREFIX . 'phone', true ); ?>
					<?php $address = get_post_meta( get_the_ID(), LISTING_MANAGER_COMPANY_PREFIX . 'address', true ); ?>

                    <?php if ( ! empty( $email ) || ! empty( $web ) || ! empty( $phone ) || ! empty( $address ) ) : ?>
                        <div class="post-overview">
                            <dl>
                                <?php if ( ! empty( $email ) ) : ?>
                                    <dt><?php echo esc_html__( 'Email', 'listing-manager' ); ?></dt>
                                    <dd><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_attr( $email ); ?></a></dd>
                                <?php endif; ?>

                                <?php if ( ! empty( $web ) ) : ?>
                                    <dt><?php echo esc_html__( 'Web', 'listing-manager' ); ?></dt>
                                    <dd><a href="<?php echo esc_attr( $web ); ?>"><?php echo esc_attr( $web ); ?></a></dd>
                                <?php endif; ?>

                                <?php if ( ! empty( $phone ) ) : ?>
                                    <dt><?php echo esc_html__( 'Phone', 'listing-manager' ); ?></dt><dd><?php echo esc_attr( $phone ); ?></dd>
                                <?php endif; ?>

                                <?php if ( ! empty( $address ) ) : ?>
                                    <dt><?php echo esc_html__( 'Address', 'listing-manager' )?></dt><dd><?php echo wp_kses( nl2br( $address ), wp_kses_allowed_html( 'post' ) ); ?></dd>
                                <?php endif; ?>
                            </dl>
                        </div><!-- /.post-overview -->
                    <?php endif; ?>
				</div><!-- /.company-medium-content -->
			</div><!-- /.company-medium -->
		<?php endwhile; ?>
	</div><!-- /.companies-medium-wrapper -->
<?php endif; ?>