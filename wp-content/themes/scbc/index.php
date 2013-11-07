<?php get_header(); ?>

	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-4">
				<?php
				$featured_post_query = new WP_Query((array('posts_per_page'=>1)));
				$featured_post_query->the_post();
				the_title();
				the_excerpt();
				?>
			</div>
			<div class="col-xs-12 col-sm-4">
				<?php if($instagram_photo_data = get_latest_instagram()): ?>
				<img class="img-responsive" src="<?php echo $instagram_photo_data['images']['low_resolution']['url']; ?>" alt="" />
				<p><?php echo $instagram_photo_data['caption']; ?></p>
				<?php else: ?>
				<img class="img-responsive" src="/wp-content/themes/scbc/img/home-instagram-default.jpg" alt="Space Craft Brewing Company" />
				<p>Default shit if no instagram picture is available</p>
				<?php endif; ?>
			</div>
			<div class="col-xs-12 col-sm-4">
				<div class="row">
					<h3>Next Event:</h1>
					<?php
					$next_event_query = new WP_Query((array('post_type'=>'event','posts_per_page'=>1)));
					$next_event_query->the_post();
					the_title();
					the_excerpt();
					?>
				</div>
				<div id="latest-facebook">
					<?php if($latest_facebook_post = get_latest_facebook()): ?>
					<?php print_r($latest_facebook_post); ?>
					<?php else: ?>
					Our latest facebook post is not available. Please cry about it.
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div><!-- #primary -->

<?php get_footer(); ?>

