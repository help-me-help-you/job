<?php get_header(); ?>

    <?php
        /**
         * woocommerce_before_main_content hook.
         *
         * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
         * @hooked woocommerce_breadcrumb - 20
         */
        do_action( 'woocommerce_before_main_content' );
    ?>

    <?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

        <h1 class="page-title"><?php woocommerce_page_title(); ?></h1>

    <?php endif; ?>


    <?php while ( have_posts() ) : the_post(); ?>
        <?php wc_get_template( 'listing-manager/company/social.php', [], '', LISTING_MANAGER_DIR . 'templates/' ); ?>

        <div class="post-content">

            <?php if ( has_post_thumbnail() ) : ?>
                <div class="post-thumbnail">
                    <a href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail( 'large' ); ?>
                    </a>
                </div><!-- /.post-thumbnail -->
            <?php endif; ?>    
            
            <div class="post-body">
                <?php the_content(); ?>
            </div><!-- /.post-body -->

            <?php wc_get_template( 'listing-manager/company/overview.php', [], '', LISTING_MANAGER_DIR . 'templates/' ); ?>
        </div><!-- /.post-content -->
            
        <?php wc_get_template( 'listing-manager/company/assigned.php', [], '', LISTING_MANAGER_DIR . 'templates/' ); ?>
    <?php endwhile; // end of the loop. ?>

    <?php
		/**
		 * woocommerce_after_main_content hook.
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>

	<?php
		/**
		 * woocommerce_sidebar hook.
		 *
		 * @hooked woocommerce_get_sidebar - 10
		 */
		do_action( 'woocommerce_sidebar' );
	?>
<?php get_footer(); ?>
