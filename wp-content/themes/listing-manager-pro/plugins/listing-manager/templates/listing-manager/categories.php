<?php $args = [
	'hide_empty' => false,
	'parent'     => 0,
    'number'     => $parent_count,
    'include'    => ! empty( $include ) ? $include : [],
    'exclude'    => ! empty( $exclude ) ? array_merge( $exclude, [get_option( 'default_product_cat' ), ] ) : array_merge( [], [get_option( 'default_product_cat' ), ] ),    
]; ?>

<?php $terms = get_terms( 'product_cat', $args ); ?>

<?php if ( is_array( $terms ) ) : ?>
	<div class="listing-manager-categories-wrapper">
		<ul class="listing-manager-categories">
			<?php foreach( $terms as $term ) : ?>
				<li>
                    <div class="listing-manager-category">
	                    <?php do_action( 'listing_manager_categories_parent_item_before', $term ); ?>

	                    <?php $attachment_id = get_term_meta( $term->term_id, 'thumbnail_id', true ); ?>

                        <div class="listing-manager-category-header <?php echo ( ! empty( $attachment_id ) ) ? 'has-image' : ''; ?>">
                            <h4>
                                <a href="<?php echo esc_url( get_term_link( $term ) ); ?>">
	                                <?php if ( ! empty( $attachment_id ) ) : ?>
                                        <span class="listing-manager-category-header-image" style="background-image: url('<?php echo wp_get_attachment_image_url( $attachment_id, 'medium' ); ?>');"></span>
	                                <?php endif; ?>

                                    <span class="listing-manager-category-header-title">
                                        <?php echo esc_attr( $term->name ); ?>
                                    </span>
                                </a>

                                <?php do_action( 'listing_manager_categories_parent_item_title_after', $term ); ?>
                            </h4>
                        </div><!-- /.listing-manager-category-header -->

                        <?php $children = get_terms( 'product_cat', [
                            'hide_empty' 	=> false,
                            'parent' 		=> $term->term_id,
                            'number'        => $child_count,
                        ] ); ?>

                        <?php if ( is_array ( $children ) ) : ?>
                            <ul>
                                <?php foreach ( $children as $child_term ) : ?>
                                    <li>
                                        <a href="<?php echo esc_url( get_term_link( $child_term ) ); ?>">
                                            <span><?php echo esc_html( $child_term->name ); ?></span>
                                            <strong><?php echo esc_html( $child_term->count ); ?></strong>
                                        </a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>

                        <?php do_action( 'listing_manager_categories_parent_item_after', $term ); ?>
                    </div><!-- /.listing-manager-category -->
				</li>
			<?php endforeach; ?>
		</ul><!-- /.listing-manager-categories -->
	</div><!-- /.listing-manager-categories-wrapper -->
<?php else : ?>
    <p>
        <?php echo esc_html__( 'No categories found.', 'listing-manager' ); ?>
    </p>
<?php endif; ?>