<?php get_header(); ?>
<div class="container">
	<div class="row row-offcanvas">		
		<div class="col-xs-12 col-sm-9">
			<?php the_post(); ?>
			<div class="row bottom-sep"id="brews-main-content">
				<div class="col-xs-12">
					<h1>SpaceBrews</h1>
					<?php the_content(); ?>
				</div>
			</div>
<?php 
			$brews_query = new WP_Query(array('nopaging'=>true,'post_type'=>'brew','orderby'=>'menu_order','order'=>'ASC')); 
			$x = 0;
			while($brews_query->have_posts()):
				$brews_query->the_post(); 
				$menu_items[$x]['label'] = get_the_title();
				$menu_items[$x]['html-id'] = basename( get_permalink($id) ); // --- get_the_slug()
?>
			<div class="row bottom-sep">
				<div class="col-xs-12">
					<div class="row brew-container" id="<?php echo $menu_items[$x]['html-id'] ?>">
						<div class="col-sm-6 col-xs-12">
							<h2><?php echo $menu_items[$x]['label']; ?></h2>
							<?php the_content(); ?>
							<?php echo $brew_meta; ?>
						</div>
						<div class="col-sm-6 col-xs-12">
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
		<div class="col-sm-3 sidebar-offcanvas">
			<div class="sidebar">
				<div id="brews-menu-container" class="nav-container">
					<ul id="brews-menu" class="nav">
						<li><a href="#brews-main-content">The Spacebrews</a></li>
						<?php foreach($menu_items as $menu_item): ?>
						<li><a href="#<?php echo $menu_item['html-id']; ?>"><?php echo $menu_item['label']; ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
<?php include_once $_SERVER['DOCUMENT_ROOT'].'/wp-content/themes/scbc/inc/_facebook.php'; ?>
			</div>
		</div>
	</div>
</div><!-- #primary -->
<?php get_footer(); ?>
<script type="text/javascript">
jQuery(document).ready(function($){
	$('body').scrollspy({ target: '#brews-menu-container' });
	$(window).on('load', function () {
		$("body").scrollspy('refresh');
	});
});
</script>
