<div id="post-<?php the_ID(); ?>" <?php post_class( 'company' ); ?>>    
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="post-thumbnail">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail( 'medium' ); ?>
            </a>
        </div><!-- /.post-thumbnail -->
    <?php endif; ?>    

    <div class="post-content">
        <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

        <h3 class="post-subtitle">
            <?php $agent_ids = ListingManager\Utilities::get_company_agent_ids( get_the_ID() ); ?>

            <?php if ( count( $agent_ids ) > 0 ) : ?>
                <span class="agents-count">
                    <?php echo count( $agent_ids ); ?> 

                    <?php if ( 1 === count( $agent_ids ) ) : ?>
                        <?php echo esc_html__( 'agent', 'listing-manager' ); ?>                    
                    <?php else: ?>
                        <?php echo esc_html__( 'agents', 'listing-manager' ); ?>                    
                    <?php endif; ?>
                </span><!-- /.agents-count -->
            <?php endif; ?>

            <?php $companies = ListingManager\Utilities::get_company_listings( get_the_ID() ); ?>
            <?php if ( count( $companies ) > 0 ): ?>
                <span class="listings-count">
                    <?php echo count( $companies ); ?>
                    <?php if ( 1 === count( $companies ) ) : ?>
                        <?php echo esc_html__( 'listing', 'listing-manager' ); ?>                    
                    <?php else: ?>
                        <?php echo esc_html__( 'listings', 'listing-manager' ); ?>                    
                    <?php endif; ?>
                </span>
            <?php endif; ?>
        </h3>

        <?php wc_get_template( 'listing-manager/company/overview.php', [], '', LISTING_MANAGER_DIR . 'templates/' ); ?>

        <?php wc_get_template( 'listing-manager/company/social.php', [], '', LISTING_MANAGER_DIR . 'templates/' ); ?>
	</div><!-- /.post-content -->
</div><!-- /.company -->
