<?php get_header(); ?>

<?php if ( have_posts() ) : ?>
	<div class="posts">
		<?php while ( have_posts() ) : the_post(); ?>
			<?php if ( is_search() ) : ?>
				<?php get_template_part( 'templates/content', 'post' );?>
			<?php else : ?>
			    <?php get_template_part( 'templates/content', get_post_type() );?>
            <?php endif; ?>
		<?php endwhile; ?>
	</div><!-- /.posts -->

    <?php listing_manager_pro_pagination(); ?>
<?php else : ?>
    <?php get_template_part( 'templates/content', 'none' ); ?>
<?php endif; ?>

<?php get_footer(); ?>
