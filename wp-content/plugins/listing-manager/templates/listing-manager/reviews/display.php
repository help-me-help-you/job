<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $comment; ?>


<?php if ( ! empty( $fields ) ) : ?>
    <?php if ( ListingManager\Logic\ReviewLogic::has_rating( $comment->comment_ID ) ) : ?>
        <div class="listing-manager-ratings">
            <?php foreach ( $fields as $field ) : ?>
                <?php $field = (array) $field; ?>
                <?php $rating = get_comment_meta( $comment->comment_ID, LISTING_MANAGER_REVIEW_PREFIX . $field['id'], true ); ?>

                <?php if ( ! empty( $rating ) ) : ?>
                    <div class="listing-manager-ratings-rating">
                        <label class="title"><?php echo esc_html( $field['title'] ); ?></label>
                        <span class="rating">
                            <select name="<?php echo LISTING_MANAGER_REVIEW_PREFIX . esc_attr( $field['id'] ); ?>"
                                    id="listing-manager-ratings-<?php echo esc_attr( $field['id'] ); ?>"
                                    class="listing-manager-rating"
                                    readonly="readonly">
                                <option value=""><?php esc_html__( 'Rate&hellip;', 'listing-manager' ); ?></option>

                                <?php for ( $i = 1; $i <= $field['stars']; $i++ ) : ?>
                                    <option value="<?php echo esc_html( $i ); ?>" <?php if ( $rating == $i ) : ?>selected="selected"<?php endif; ?>>
                                        <?php echo esc_html( $i ); ?>
                                    </option>
                                <?php endfor; ?>
                            </select>
                        </span>
                    </div><!-- /.listing-manager-ratings -->
                <?php endif; ?>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
<?php endif; ?>
