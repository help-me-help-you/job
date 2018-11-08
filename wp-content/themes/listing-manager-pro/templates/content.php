<div id="post-<?php the_ID(); ?>" <?php post_class( 'post' ); ?>>
	<div class="page-content">
		<?php the_content(); ?>
	</div><!-- /.page-content -->
</div><!-- /.post -->

<?php if ( comments_open() || get_comments_number() ) : ?>
	<?php comments_template(); ?>
<?php endif; ?>

