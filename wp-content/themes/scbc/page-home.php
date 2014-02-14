<?php get_header(); ?>

	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-4 bottom-sep" id="latest-post-container">
				<?php $featured_post_query = new WP_Query((array('posts_per_page'=>1))); $featured_post_query->the_post();?>				
				<h1><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h1>
				<small><?php the_time('F j, Y'); ?> at <?php the_time('g:i a'); ?></small>
				<p><?php echo get_the_excerpt(); ?></p>
				<div class="visible-xs"></div>
			</div>
			<div class="col-xs-12 col-sm-4 bottom-sep" id="latest-instagram-container">
				<?php if($instagram_photo_data = get_latest_instagram()): ?>
				<figure style="max-width:<?php echo $instagram_photo_data['images']['low_resolution']['width']; ?>px;">
					<a href="<?php echo $instagram_photo_data['link']; ?>"><img class="img-responsive" src="<?php echo $instagram_photo_data['images']['low_resolution']['url']; ?>" alt="" /></a>
					<figcaption>
						<div class="clearfix">
							<span class="instagram-likes"><?php echo $instagram_photo_data['likes']['count']; ?></span>
							<span class="instagram-comments"><?php echo $instagram_photo_data['comments']['count']; ?></span> 
							<span class="ig-follow" data-id="cd71c1a4eb" data-count="true" data-size="small" data-username="true"></span>
						</div>
						<?php echo $instagram_photo_data['caption']['text']; ?>
					</figcaption>
				</figure>
				<?php else: ?>
				<img class="img-responsive" src="/wp-content/themes/scbc/img/home-instagram-default.jpg" alt="Space Craft Brewing Company" />
				<span class="ig-follow" data-id="cd71c1a4eb" data-count="true" data-size="small" data-username="true"></span> <br />
				<span>Instagram is having a problem, so enjoy this!</span>
				<?php endif; ?>
				<div class="visible-xs"></div>
			</div>
			<div class="col-xs-12 col-sm-4" id="social-container">
				<div class="row bottom-sep" id="next-event">
					<div class="col-xs-12">
						<h2>Upcoming Events</h2>
<?php
						$next_event_query = new WP_Query((array('post_type'=>'event','posts_per_page'=>1)));
						if ( $next_event_query->have_posts() ) :
						$next_event_query->the_post();
						$next_event_meta = get_post_meta(get_the_id());
?>
						<h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
						<small><?php echo date('F j, Y', mktime($next_event_meta['_event_date'][0])); ?> at <?php echo $next_event_meta['_event_time'][0];?> at <?php echo $next_event_meta['_event_location'][0]; ?></small>
						<p><?php echo get_the_excerpt(); ?></p>
<?php					else: ?>
						<p>Our schedule is free... any ideas? <a href="/contact-us/">Contact us</a> with them!</p>
<?php 					endif; ?>
					</div>
				</div>
				<div class="row" id="latest-facebook">
					<div class="like-container col-xs-12">
						<div class="clearfix">
							<a target="_blank" href="http://www.facebook.com/SpaceCraftBrewing"><img class="facebook-icon" src="<?php echo get_facebook_icon_url(); ?>" alt="Space Craft Brewing Facebook Icon"/></a>
							<div>
								<a target="_blank" href="http://www.facebook.com/SpaceCraftBrewing"><strong>Space Craft Brewing Company</strong></a><br />
								<div class="fb-like" data-href="https://www.facebook.com/SpaceCraftBrewing" data-layout="button" data-show-faces="true" data-action="like" data-share="true"></div>
							</div>
						</div>
						<div class="bottom">
						<?php
						if($latest_facebook_post = get_latest_facebook()){
							echo $latest_facebook_post;
						} else{
							echo 'Our latest facebook post is not available. Please cry about it.';
						}
						?>
						</div>
					<div>
				</div>
			</div>
		</div>
	</div><!-- #primary -->
<?php get_footer(); ?>