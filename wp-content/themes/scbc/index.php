<?php get_header(); ?>

	<div class="container">
		<div class="col-xs-12 col-sm-4">
			Latest News
		</div>
		<div class="col-xs-12 col-sm-4">
<?php 		$instagram_photo_data = get_latest_instagram(); ?>
			<img class="img-responsive" src="<?php echo $instagram_photo_data['images']['low_resolution']['url']; ?>" alt="<?php echo $instagram_photo_data['caption']; ?>" />
		</div>
		<div class="col-xs-12 col-sm-4">
			Events
		</div>
	</div><!-- #primary -->

<?php get_footer(); ?>