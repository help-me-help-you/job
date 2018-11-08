<div class="map-wrapper" <?php if ( ! empty( $height ) ) : ?>style="height: <?php echo esc_attr( $height ); ?>px"<?php endif; ?>>
    <div class="map">
        <div class="map-inner">
            <?php $style = ( ! empty( $style ) ) ? $style : null; ?>
            <?php $style = ListingManager\Logic\GoogleMapLogic::get_style( $style ); ?>

            <?php do_action( 'listing_manager_google_map_before' ); ?>
            <div class="map-container-wrapper">
                <div id="map-object" class="map-container <?php if ( ! empty( $filter_live ) ) : ?>filter-live<?php endif; ?>"
                    <?php if ( ! empty( $height ) ) : ?>style="height: <?php echo esc_attr( $height ); ?>px"<?php endif; ?>
                     data-zoom="<?php echo ! empty( $zoom ) ? $zoom : '13'; ?>"
                     data-latitude="<?php echo ! empty( $latitude ) ? $latitude : '40.74'; ?>"
                     data-longitude="<?php echo ! empty( $longitude ) ? $longitude : '-74.00'; ?>"
                     <?php if ( ! empty( $ids ) ) : ?>data-ids="<?php echo esc_attr( $ids ); ?>"<?php endif; ?>
                     <?php if ( ! empty( $show_all_markers ) ) : ?>data-show-all-markers="<?php echo esc_attr( $show_all_markers ); ?>"<?php endif; ?>
                     <?php if ( ! empty( $marker_style ) ) : ?>data-marker-style="<?php echo esc_attr( $marker_style ); ?>"<?php endif; ?>
                     <?php if ( ! empty( $max_pins ) ) : ?>data-max-pins="<?php echo esc_attr( $max_pins ); ?>"<?php endif; ?>
                     <?php if ( ! empty( $orderby ) ) : ?>data-orderby="<?php echo esc_attr( $orderby ); ?>"<?php endif; ?>
                     <?php if ( ! empty( $grid_size ) ) : ?>data-grid-size="<?php echo esc_attr( $grid_size ); ?>"<?php endif; ?>
                     <?php if ( ! empty( $geolocation ) ) : ?>data-geolocation="<?php echo esc_attr( $geolocation ); ?>"<?php endif; ?>
                     <?php if ( ! empty( $style ) ) : ?>data-styles='<?php echo esc_attr( $style ); ?>'<?php endif;?>
                     data-ajax-action="<?php echo admin_url( 'admin-ajax.php' ); ?>">

                     <?php $api_key = get_theme_mod( 'listing_manager_google_maps_api_key', null ); ?>
                     <?php if ( empty( $api_key) ) : ?>
                        <div class="map-message">
                            <?php echo esc_html__( 'Google Maps API key missing.', 'listing-manager' ); ?>
                        </div>
                     <?php endif; ?>
                </div><!-- /.map-container -->

	            <?php if ( ! empty( $map_types) || ! empty( $map_zoom ) || ! empty( $map_geolocation ) ) : ?>
                    <div class="map-content">
                        <div class="map-content-inner">
                            <div class="map-actions-wrapper">
                                <div class="map-actions">
						            <?php if ( ! empty( $map_types ) ) : ?>
                                        <div class="map-actions-group map-actions-group-types">
                                            <a id="map-control-type-roadmap"><span><?php echo esc_html__( 'Roadmap', 'listing-manager-front' ); ?></span></a>
                                            <a id="map-control-type-terrain"><span><?php echo esc_html__( 'Terrain', 'listing-manager-front' ); ?></span></a>
                                            <a id="map-control-type-satellite"><span><?php echo esc_html__( 'Satellite', 'listing-manager-front' ); ?></span></a>
                                        </div><!-- /.map-actions-group -->
						            <?php endif; ?>

						            <?php if ( ! empty( $map_zoom ) ) : ?>
                                        <div class="map-actions-group map-actions-group-zoom">
                                            <a id="map-control-zoom-in"><span><?php echo esc_html__( 'Zoom In', 'listing-manager-front' ); ?></span></a>
                                            <a id="map-control-zoom-out"><span><?php echo esc_html__( 'Zoom Out', 'listing-manager-front' ); ?></span></a>
                                        </div><!-- /.map-actions-group -->
						            <?php endif; ?>

						            <?php if ( ! empty( $map_geolocation ) ) : ?>
                                        <div class="map-actions-group">
                                            <a id="map-control-current-position"><span><?php echo esc_html__( 'Current Position', 'listing-manager-front' ); ?></span></a>
                                        </div><!-- /.map-actions-group -->
						            <?php endif; ?>
                                </div><!-- /.map-actions -->
                            </div><!-- /.map-actions-wrapper -->
                        </div><!-- /.map-content-inner-->
                    </div><!-- /.map-content -->
	            <?php endif; ?>
            </div><!-- /.map-container-wrapper -->

            <?php if ( ! empty( $filter ) ) : ?>
	            <?php $shortcode_title = ! empty( $title ) ? "title=\"{$title}\"" : ''; ?>
	            <?php $shortcode_sort = ! empty( $sort ) ? "sort=\"{$sort}\"" : ''; ?>
	            <?php $shortcode_button_text = ! empty( $button_text ) ? "button_title=\"{$button_text}\"" : ''; ?>
	            <?php $shortcode_input_titles = ! empty( $input_titles ) ? "input_titles=\"{$input_titles}\"" : ''; ?>
	            <?php $shortcode_return_url = ! empty( $return_url ) ? "return_url=\"{$return_url}\"" : ''; ?>
	            <?php $shortcode_autosubmit = ! empty( $autosubmit ) ? "autosubmit=\"{$autosubmit}\"" : ''; ?>
                <?php $shortcode_hide_filter_form = ! empty( $hide_filter_form ) ? "hide_filter_form=\"{$hide_filter_form}\"" : ''; ?>
                <?php $shortcode_hidden_fields = ''; ?>

                <?php $fields = ListingManager\Logic\FilterLogic::get_fields(); ?>
                <?php if ( ! empty( $fields ) ) : ?>
                    <?php foreach ( $fields as $key => $value ) : ?>
                        <?php if ( ! empty( ${"hide_" . $key } ) ) : ?>
                            <?php $shortcode_hidden_fields .= 'hide_' . $key . '="on" '; ?>
                        <?php endif; ?>
                    <?php endforeach ?>
                <?php endif; ?>

                <?php $shortcode = "[listing_manager_filter
                    {$shortcode_hide_filter_form}
                    {$shortcode_title}
                    {$shortcode_button_text}
                    {$shortcode_input_titles}
                    {$shortcode_return_url}
                    {$shortcode_sort}
                    {$shortcode_autosubmit}
                    {$shortcode_hidden_fields}]"; ?>

                <?php echo do_shortcode( $shortcode ); ?>
            <?php endif; ?>

            <?php do_action( 'listing_manager_google_map_after' ); ?>
        </div><!-- /.map-inner -->
    </div><!-- /.map -->
</div><!-- /.map-wrapper -->
