<?php
global $featured_image_data, $post;

// --- Get SRC of image for img tag
$featured_image_src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'medium' );
$featured_image_url = $featured_image_src['0']; 

// --- Save in variable to avoid using function twice
$title = get_the_title();
get_header(); 
?>

<div class="container">
    <div class="row row-offcanvas">
        <div class="col-xs-12 col-sm-9 post">
            <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
                <h1><?php echo $title; ?></h1>
                <figure class="right">
                    <img src="<?php echo $featured_image_url; ?>" alt="<?php echo $title; ?>" class="img-responsive"/>
                    <figcaption><?php echo $featured_image_data->post_excerpt; ?></figcaption>
                </figure>
                <?php the_content('<p class="serif">Read the rest of this page &raquo;</p>'); ?>
                <div class="fb-like" data-href="<?php echo get_permalink(); ?>" data-share="true"></div>
            <?php endwhile; endif; ?>
        </div>
        <div class="col-sm-3 sidebar-offcanvas">
            <div class="sidebar archive-sidebar">
                <?php get_search_form(); ?>
                <div class="nav-container">
                    <div class="nav">
                        <?php dynamic_sidebar('Post Sidebar'); ?>
                    </div>
                </div>
                <div class="like-container">
                    <div class="clearfix">
                        <a target="_blank" href="http://www.facebook.com/SpaceCraftBrewing"><img class="facebook-icon" src="<?php echo get_facebook_icon_url(); ?>" alt="Space Craft Brewing Facebook Icon"/></a>
                        <div>
                            <a target="_blank" href="http://www.facebook.com/SpaceCraftBrewing"><strong>Space Craft Brewing Company</strong></a><br />
                            <div class="fb-like" data-href="https://www.facebook.com/SpaceCraftBrewing" data-layout="button" data-show-faces="true" data-action="like" data-share="true"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	<?php get_footer(); ?>