<?php get_header(); ?>
<div class="container" id="news-container">
	<div class="row">
		<div class="col-xs-12 col-sm-9">
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); $the_permalink = get_permalink();?>
			<div class="row bottom-sep">
				<div class="col-xs-12">
					<div class="row post" class="clearfix">
						<div class="col-xs-12 col-sm-8">
							<h2 class="post-title"><a href="<?php echo $the_permalink; ?>"><?php the_title(); ?></a></h2>
							<small><?php the_time('F j, Y'); ?> at <?php the_time('g:i a'); ?></small>
							<?php the_excerpt(); ?>
						</div>
						<div class="col-xs-12 col-sm-4">
							<a href="<?php echo $the_permalink; ?>"><?php the_post_thumbnail('news-thumb', array('class'=>'img-responsive'));
							/* Make these images 225px that's the biggest they should ever be*/
							?></a>
						</div>
					</div>
				</div>
			</div>
		<?php endwhile; ?>
	<?php else : ?>
		Nothingness.
	<?php endif; ?>
		</div>
		<div class="col-sm-3">
			<?php dynamic_sidebar('Blog Sidebar'); ?>
			<div class="like-container">
				<div class="fb-like" data-href="https://www.facebook.com/SpaceCraftBrewing" data-layout="button" data-show-faces="true" data-action="like" data-share="true"></div>
			</div>
		</div>
	</div>
</div><!-- #primary -->
<?php get_footer(); ?>