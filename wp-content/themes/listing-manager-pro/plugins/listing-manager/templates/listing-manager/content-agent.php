<div id="post-<?php the_ID(); ?>" <?php post_class( 'agent' ); ?>>
    <?php if ( has_post_thumbnail() ) : ?>
        <div class="post-thumbnail">
            <a href="<?php the_permalink(); ?>">
                <?php the_post_thumbnail( 'medium' ); ?>
            </a>
        </div><!-- /.post-thumbnail -->
    <?php endif; ?>

    <div class="post-content">
        <h2 class="post-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>

        <?php $address = get_post_meta( get_the_ID(), LISTING_MANAGER_AGENT_PREFIX . 'address', true ); ?>
        <?php if ( ! empty( $address ) ) : ?>
            <h3 class="post-subtitle">
                <?php echo wp_kses( nl2br( $address ), wp_kses_allowed_html( 'post' ) ); ?>
            </h3>
        <?php endif; ?>

        <?php wc_get_template( 'listing-manager/agent/social.php', [], '', LISTING_MANAGER_DIR . 'templates/' ); ?>
    </div><!-- /.post-content -->

    <?php wc_get_template( 'listing-manager/agent/overview.php', [], '', LISTING_MANAGER_DIR . 'templates/' ); ?>
</div><!-- /.agent -->
