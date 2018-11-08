<?php
/**
 * Template name: Simple
 */

get_header( 'simple' ); ?>

<div class="page-wrapper-simple">
	<div class="page-wrapper-simple-content">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ): the_post(); ?>
				<h1><?php the_title(); ?></h1>
				<?php the_content(); ?>
			<?php endwhile; ?>
		<?php endif; ?>
	</div><!-- /.page-wrapper-simple-content -->
</div><!-- /.page-wrapper-simple -->

<?php get_footer( 'simple' ); ?>
