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

    <?php
        /**
         * woocommerce_archive_description hook.
         *
         * @hooked woocommerce_taxonomy_archive_description - 10
         * @hooked woocommerce_product_archive_description - 10
         */
        do_action( 'woocommerce_archive_description' );
    ?>

    <?php if ( have_posts() ) : ?>
        <?php
        /**
         * woocommerce_before_shop_loop hook.
         *
         * @hooked woocommerce_result_count - 20
         * @hooked woocommerce_catalog_ordering - 30
         */
        do_action( 'woocommerce_before_shop_loop' );
        ?>

        <?php while ( have_posts() ) : the_post(); ?>

            <?php echo wc_get_template_html( 'listing-manager/content-company.php', [], '', LISTING_MANAGER_DIR . 'templates/' ); ?>

        <?php endwhile; // end of the loop. ?>

        <?php
        /**
         * woocommerce_after_shop_loop hook.
         *
         * @hooked woocommerce_pagination - 10
         */
        do_action( 'woocommerce_after_shop_loop' );
        ?>
    <?php endif; ?>

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
