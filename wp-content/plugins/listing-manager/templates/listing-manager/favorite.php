<div class="listing-manager-favorite">
    <?php if ( ListingManager\Logic\FavoriteLogic::is_my_favorite( $id ) ) : ?>
        <a class="button listing-manager-favorite-add marked" data-listing-id="<?php echo esc_attr( $id ); ?>" data-ajax-url="<?php echo admin_url( 'admin-ajax.php' ); ?>">
            <span data-toggle="<?php if ( ! empty( $content[0] ) ) : ?><?php echo esc_attr( $content[0] ); ?><?php else: ?><?php echo esc_attr__( 'Add to favorites', 'listing-manager' ); ?><?php endif; ?>">
                <?php if ( ! empty( $content[1] ) ) : ?>
                    <?php echo wp_kses( $content[1], wp_kses_allowed_html('post') ); ?>
                <?php else : ?>
                    <?php echo esc_html__( 'Favorited', 'listing-manager' ); ?>
                <?php endif; ?>
            </span>
        </a><!-- /.button -->
    <?php else: ?>
        <a class="button listing-manager-favorite-add" data-listing-id="<?php echo esc_attr( $id ); ?>" data-ajax-url="<?php echo admin_url( 'admin-ajax.php' ); ?>">
            <span data-toggle="<?php if ( ! empty( $content[1] ) ) : ?><?php echo esc_attr( $content[1] ); ?><?php else : ?><?php echo esc_attr__( 'I Love It', 'listing-manager' ); ?><?php endif; ?>">
                <?php if ( ! empty( $content[0] ) ) : ?>
                    <?php echo wp_kses( $content[0], wp_kses_allowed_html('post') ); ?>
                <?php else : ?>
                    <?php echo esc_html__( 'Favorite', 'listing-manager' ); ?>
                <?php endif; ?>
            </span>
        </a><!-- /.button -->
    <?php endif ; ?>
</div><!-- /.listing-manager-favorite -->
