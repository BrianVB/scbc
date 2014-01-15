<?php get_header(); ?>
<div class="container">
	<div class="row">
		<div class="col-xs-12 col-sm-9">
			<?php the_post(); ?>
			<div class="row bottom-sep"id="brews-main-content">
				<div class="col-xs-12">
					<?php the_content(); ?>
				</div>
			</div>
<?php 
			$brews_query = new WP_Query(array('post_type'=>'brew','orderby'=>'menu_order')); 
			$x = 0;
			while($brews_query->have_posts()):
				$brews_query->the_post(); 
				$menu_items[$x]['label'] = get_the_title();
				$menu_items[$x]['html-id'] = basename( get_permalink($id) ); // --- get_the_slug()
?>
			<div class="row bottom-sep">
				<div class="col-xs-12">
					<div class="row brew-container" id="<?php echo $menu_items[$x]['html-id'] ?>">
						<div class="col-xs-6">
							<?php echo $menu_items[$x]['label']; ?>
							<?php the_content(); ?>
						</div>
						<div class="col-xs-6">
							<img class="img-responsive" src="http://placehold.it/439/000/fff&text=Label+Coming+Soon!">
						</div>
					</div>
				</div>
			</div>
<?php
			$x++;
			endwhile;
?>
		</div>
		<div class="col-sm-3">
			<div id="brews-menu-container" class="sidebar">
				<ul id="brews-menu" class="nav">
					<li><a href="#brews-main-content">The Spacebrews</a></li>
					<?php foreach($menu_items as $menu_item): ?>
					<li><a href="#<?php echo $menu_item['html-id']; ?>"><?php echo $menu_item['label']; ?></a></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<div class="like-container">
				<div class="fb-like" data-href="https://www.facebook.com/SpaceCraftBrewing" data-layout="button" data-show-faces="true" data-action="like" data-share="true"></div>
			</div>
		</div>
	</div>
</div><!-- #primary -->
<?php get_footer(); ?>
<script type="text/javascript">
jQuery(document).ready(function($){
	$('body').scrollspy({ target: '#brews-menu-container' });
	$(window).on('load', function () {
		$("body").scrollspy('refresh')
	})
	$('#brews-menu-container').affix({
		offset: {
			top: 74
		}
	});
});
</script>
