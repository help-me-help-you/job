<?php query_posts( [
    'post_type'         => 'product',
    'posts_per_page'    => -1,
    'meta_query'        => [
        [
            'key'       => LISTING_MANAGER_LISTING_PREFIX . 'agent',
            'value'     => ListingManager\Utilities::get_company_agent_ids( get_the_ID() ),
        ],
    ],
    'tax_query'     => [
        [
            'taxonomy' => 'product_type',
            'field'    => 'slug',
            'terms'    => 'listing',
        ],
    ],
] ); ?>

<?php if ( have_posts() ) : ?>
    <h2 class="created-items">
        <?php echo esc_html__( 'Created Items', 'listing-manager' ); ?>                    
    </h2>
        
    <?php woocommerce_product_loop_start(); ?>

    <?php while ( have_posts() ): the_post(); ?>
        <?php wc_get_template_part( 'content', 'product' ); ?>
    <?php endwhile; ?>

    <?php woocommerce_product_loop_end(); ?>
<?php endif; ?>

<?php wp_reset_query(); ?>