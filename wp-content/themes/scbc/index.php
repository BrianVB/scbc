<?php get_header(); ?>

	<div class="container">
		<div id="content" class="site-content" role="main">
		<?php if ( have_posts() ) : ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php the_permalink( 'content', get_post_format() ); ?>
			<?php endwhile; ?>
		<?php endif; ?>
		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>