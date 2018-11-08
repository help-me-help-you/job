<?php if ( have_posts() ) : ?>
	<div class="agents-medium-wrapper agents-columns-<?php echo esc_attr( $columns )?>">
		<?php while( have_posts() ) : the_post(); ?>
			<div class="agent-medium">
				<?php if ( has_post_thumbnail() ) : ?>
					<div class="agent-medium-thumbnail">
						<a href="<?php the_permalink(); ?>">
							<?php the_post_thumbnail( 'medium' ); ?>
						</a>
					</div><!-- /.agent-medium-thumbnail -->
				<?php endif; ?>

				<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>

		        <?php $companies = get_post_meta( get_the_ID(), LISTING_MANAGER_AGENT_PREFIX . 'companies', true ); ?>
		        <?php if ( ! empty( $companies ) && is_array( $companies ) && count( $companies ) > 0 ) : ?>
		            <?php $company_id = array_shift( $companies ); ?>
		            <?php $company = get_post( $company_id ); ?>
		            <h4><?php echo esc_attr( $company->post_title ); ?></h4>
		        <?php endif; ?>
		        
				<div class="agent-medium-overview">
				    <dl>
				        <?php $email = get_post_meta( get_the_ID(), LISTING_MANAGER_AGENT_PREFIX . 'email', true ); ?>
				        <?php if ( ! empty( $email ) ) : ?>
				            <dt class="email"><span><?php echo esc_html__( 'E-mail', 'listing-manager' ); ?></span></dt>
				            <dd><a href="mailto:<?php echo esc_attr( $email ); ?>"><?php echo esc_attr( $email ); ?></a></dd>
				        <?php endif; ?>

				        <?php $web = get_post_meta( get_the_ID(), LISTING_MANAGER_AGENT_PREFIX . 'web', true ); ?>
				        <?php if ( ! empty( $web ) ) : ?>
				            <dt class="web"><span><?php echo esc_html__( 'Web', 'listing-manager' ); ?></span></dt>
				            <dd><a href="<?php echo esc_attr( $web ); ?>"><?php echo esc_attr( $web ); ?></a></dd>
				        <?php endif; ?>

				        <?php $phone = get_post_meta( get_the_ID(), LISTING_MANAGER_AGENT_PREFIX . 'phone', true ); ?>
				        <?php if ( ! empty( $phone ) ) : ?>
				            <dt class="phone"><span><?php echo esc_html__( 'Phone', 'listing-manager' ); ?></span></dt><dd><?php echo esc_attr( $phone ); ?></dd>
				        <?php endif; ?>
				    </dl>
				</div><!-- /.agent-medium-overview --> 

				<?php $facebook = get_post_meta( get_the_ID(), LISTING_MANAGER_AGENT_PREFIX . 'social_facebook', true ); ?>
				<?php $twitter = get_post_meta( get_the_ID(), LISTING_MANAGER_AGENT_PREFIX . 'social_twitter', true ); ?>
				<?php $linkedin = get_post_meta( get_the_ID(), LISTING_MANAGER_AGENT_PREFIX . 'social_linkedin', true ); ?>
				<?php $google = get_post_meta( get_the_ID(), LISTING_MANAGER_AGENT_PREFIX . 'social_google', true ); ?>

				<?php if ( ! empty( $facebook ) || ! empty( $twitter ) || ! empty( $linkedin ) || ! empty( $google ) ) : ?>
				    <div class="agent-medium-social">
				        <ul>            
				            <?php if ( ! empty( $facebook ) ) : ?>
				                <li class="post-social-facebook">
				                    <a href="<?php echo esc_attr( $facebook ); ?>">
				                        <?php echo esc_html__( 'Facebook', 'listing-manager' ); ?>                                
				                    </a>
				                </li>
				            <?php endif; ?>

				            <?php if ( ! empty( $twitter ) ) : ?>
				                <li class="post-social-twitter">
				                    <a href="<?php echo esc_attr( $twitter ); ?>">
				                        <?php echo esc_html__( 'Twitter', 'listing-manager' ); ?>                                
				                    </a>
				                </li>
				            <?php endif; ?>  

				            <?php if ( ! empty( $linkedin ) ) : ?>
				                <li class="post-social-linkedin">
				                    <a href="<?php echo esc_attr( $linkedin ); ?>">
				                        <?php echo esc_html__( 'LinkedIn', 'listing-manager' ); ?>                                
				                    </a>
				                </li>
				            <?php endif; ?>      

				            <?php if ( ! empty( $google ) ) : ?>
				                <li class="post-social-google">
				                    <a href="<?php echo esc_attr( $google ); ?>">
				                        <?php echo esc_html__( 'Google', 'listing-manager' ); ?>                                
				                    </a>
				                </li>
				            <?php endif; ?>                                                            
				        </ul>
				    </div><!-- /.agent-medium-social -->
				<?php endif; ?>				
			</div><!-- /.agent-medium -->
		<?php endwhile; ?>
	</div><!-- /.agents-medium-wrapper -->
<?php endif; ?>