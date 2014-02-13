<?php get_header(); ?>
<div class="container" id="news-container">
	<div class="row">
		<div class="col-xs-9">
		<h1 class="page-title">Search Results for &ldquo;<?php echo get_search_query();  ?>&rdquo;</h1>
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) :
		the_post(); 
		$link = ($post->post_type = 'brew') ? '/beer/#'.$post->post_name : get_the_permalink();
		?>
			<div class="row bottom-sep">
				<div class="col-xs-12">
					<div class="row post" class="clearfix">
						<div class="col-xs-8">
							<h2 class="post-title"><a href="<?php echo $link; ?>"><?php the_title(); ?></a></h2>
							<?php if($post->post_type == 'post'): ?><small><?php the_time('F j, Y'); ?> at <?php the_time('g:i a'); ?></small><?php endif; ?>
							<?php the_excerpt(); ?>
						</div>
						<div class="col-xs-4">
							<?php 
							// --- Get SRC of image for img tag
							$featured_image_src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium' );
							if($featured_image_src){
								$featured_image_url = $featured_image_src['0'];
								echo '<img class="img-responsive" src="'.$featured_image_url.'">';
							} else if($post->post_type == 'brew'){
								echo '<img class="img-responsive" src="http://placehold.it/439/000/fff&text=Label+Coming+Soon!">';
							}
							/* Make these images 225px that's the biggest they should ever be*/
							?>
						</div>
					</div>
				</div>
			</div>
		<?php endwhile; ?>
	<?php else : ?>
		<p>We couldn't find anything in our archives matching your query!</p>
	<?php endif; ?>
		</div>
		<div class="col-xs-3">
			<?php dynamic_sidebar('Blog Sidebar'); ?>
			<div class="like-container">
				<div class="fb-like" data-href="https://www.facebook.com/SpaceCraftBrewing" data-layout="button" data-show-faces="true" data-action="like" data-share="true"></div>
			</div>
		</div>
	</div>
</div><!-- #primary -->
<?php get_footer(); ?>