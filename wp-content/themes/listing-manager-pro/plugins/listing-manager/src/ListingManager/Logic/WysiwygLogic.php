<?php

namespace ListingManager\Logic;

use ListingManager\Annotation\Action;

class WysiwygLogic {
    /**
     * @Action(name="admin_footer")
     */
    public static function shortcodes() {
        global $shortcode_tags;
        $count = 0;
        ?>

        <script type="text/javascript">
            var shortcodes_button = [];
            <?php foreach( $shortcode_tags as $tag => $code ) : ?>
                <?php if ( false !== strrpos( $tag, 'listing_manager_', -strlen( $tag ) ) ) : ?>
                    <?php echo "shortcodes_button[{$count}] = '{$tag}';"; ?>
                    <?php $count++; ?>
                <?php endif; ?>
            <?php endforeach; ?>
        </script><?php
    }

    /**
     * @Action(name="admin_init")
     */
    public static function button() {
        if ( current_user_can('edit_posts') &&  current_user_can('edit_pages') ) {
            add_filter( 'mce_external_plugins', [ __CLASS__, 'button_add' ] );
            add_filter( 'mce_buttons', [ __CLASS__, 'button_register' ] );
        }
    }

    public static function button_add( $plugin_array ) {
        $plugin_array['listing_manager_shortcodes'] = plugins_url( 'listing-manager' ) . '/assets/js/listing-manager-shortcodes.js';
        return $plugin_array;
    }

    public static function button_register( $buttons ) {
        array_push( $buttons, 'separator', 'listing_manager_shortcodes' );
        return $buttons;
    }
}