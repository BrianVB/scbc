<?php get_header(); ?>
<div class="container">
	<div class="row">
		<div class="col-xs-12 col-sm-9">
			<?php the_post(); ?>
			<?php the_content(); ?>
		</div>
		<div class="col-sm-3">
			<div id="about-menu-container" class="sidebar">
				<ul id="about-menu" class="nav">
					<li><a href="#origin-heading">The Origin</a></li>
					<li><a href="#mission-heading">The Statement of Universal Intent</a></li>
				</ul>
			</div>
		</div>
	</div>
</div><!-- #primary -->
<?php get_footer(); ?>
<script type="text/javascript">
jQuery(document).ready(function($){
	$('body').scrollspy({ target: '#about-menu-container' });
	$(window).on('load', function () {
		$("body").scrollspy('refresh')
	});
	$('#about-menu-container').affix({
		offset: {
			top: 74
		}
	});
});
</script>
