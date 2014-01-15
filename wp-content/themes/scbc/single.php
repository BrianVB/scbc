<?php
global $featured_image_data;
get_header(); 
?>
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-9 post">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <figure>
                    <?php the_post_thumbnail('medium'); ?>
                    <figcaption><?php echo $featured_image_data->post_excerpt; ?></figcaption>
                </figure>
                <h1><?php the_title(); ?></h1>
                <?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
                <div class="fb-like" data-href="<?php echo get_permalink(); ?>" data-share="true"></div>
            
            <?php endwhile; endif; ?>
        </div>
        <div class="col-sm-3">
            <?php dynamic_sidebar('Post Sidebar'); ?>
        </div>
    </div>
	<?php get_footer(); ?>