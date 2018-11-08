		<?php do_action( 'listing_manager_pro_after_main' ); ?>

        <div class="footer-wrapper">
            <div class="footer">
                <div class="footer-inner">
                    <?php if ( is_active_sidebar( 'footer-top-first' ) || is_active_sidebar( 'footer-top-second' ) || is_active_sidebar( 'footer-top-third' ) ) : ?>
                        <div class="footer-top">
                            <?php if ( is_active_sidebar( 'footer-top-first' ) ) : ?>
                                <div class="footer-top-first">
                                    <?php dynamic_sidebar( 'footer-top-first' ); ?>
                                </div><!-- /.footer-top-first -->
                            <?php endif; ?>

                            <?php if ( is_active_sidebar( 'footer-top-second' ) ) : ?>
                                <div class="footer-top-second">
                                    <?php dynamic_sidebar( 'footer-top-second' ); ?>
                                </div><!-- /.footer-top-second -->
                            <?php endif; ?>

                            <?php if ( is_active_sidebar( 'footer-top-third' ) ) : ?>
                                <div class="footer-top-third">
                                    <?php dynamic_sidebar( 'footer-top-third' ); ?>
                                </div><!-- /.footer-top-third -->
                            <?php endif; ?>
                        </div><!-- /.footer-top -->
                    <?php endif; ?>

                    <?php if ( is_active_sidebar( 'footer-left') || is_active_sidebar( 'footer-right' ) ) : ?>
                        <div class="footer-bottom">
                            <?php if ( is_active_sidebar( 'footer-left') ) : ?>
                                <div class="footer-left">
                                    <?php dynamic_sidebar( 'footer-left' ); ?>
                                </div><!-- /.footer-left -->
                            <?php endif; ?>

                            <?php if ( is_active_sidebar( 'footer-right') ) : ?>
                                <div class="footer-right">
                                    <?php dynamic_sidebar( 'footer-right' ); ?>
                                </div><!-- /.footer-right -->
                            <?php endif; ?>
                        </div><!-- /.footer-bottom -->
                    <?php endif; ?>
                </div><!-- /.footer-inner -->
            </div><!-- /.footer -->
        </div><!-- /.footer-wrapper -->
	</div><!-- /.page-wrapper -->

	<?php wp_footer(); ?>
</body>
</html>
