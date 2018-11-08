<?php $facebook = get_post_meta( get_the_ID(), LISTING_MANAGER_AGENT_PREFIX . 'social_facebook', true ); ?>
<?php $twitter = get_post_meta( get_the_ID(), LISTING_MANAGER_AGENT_PREFIX . 'social_twitter', true ); ?>
<?php $linkedin = get_post_meta( get_the_ID(), LISTING_MANAGER_AGENT_PREFIX . 'social_linkedin', true ); ?>
<?php $google = get_post_meta( get_the_ID(), LISTING_MANAGER_AGENT_PREFIX . 'social_google', true ); ?>

<?php if ( ! empty( $facebook ) || ! empty( $twitter ) || ! empty( $linkedin ) || ! empty( $google ) ) : ?>
    <div class="post-social">
        <ul>            
            <?php if ( ! empty( $facebook ) ) : ?>
                <li class="post-social-facebook">
                    <a href="<?php echo esc_attr( $facebook ); ?>">
                        <span><?php echo esc_html__( 'Facebook', 'listing-manager' ); ?></span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if ( ! empty( $twitter ) ) : ?>
                <li class="post-social-twitter">
                    <a href="<?php echo esc_attr( $twitter ); ?>">
                        <span><?php echo esc_html__( 'Twitter', 'listing-manager' ); ?></span>                               
                    </a>
                </li>
            <?php endif; ?>  

            <?php if ( ! empty( $linkedin ) ) : ?>
                <li class="post-social-linkedin">
                    <a href="<?php echo esc_attr( $linkedin ); ?>">
                        <span><?php echo esc_html__( 'LinkedIn', 'listing-manager' ); ?></span>                               
                    </a>
                </li>
            <?php endif; ?>      

            <?php if ( ! empty( $google ) ) : ?>
                <li class="post-social-google">
                    <a href="<?php echo esc_attr( $google ); ?>">
                        <span><?php echo esc_html__( 'Google', 'listing-manager' ); ?></span>                               
                    </a>
                </li>
            <?php endif; ?>                                                            
        </ul>
    </div><!-- /.post-social -->
<?php endif; ?>