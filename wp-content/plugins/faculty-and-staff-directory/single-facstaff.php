<?php
/**
 * The Template for displaying all Single Faculty Staff Profile posts.
 *
 * @package WordPress
 * @subpackage Laurel Streng
 * @since Laurel Streng 2.0
 */

get_header(); ?>

<div id="primary" class="site-content">
<div id="content" role="main">

<?php while ( have_posts() ) : the_post(); ?>

<?php get_template_part( 'content', get_post_format() ); ?>

<nav class="nav-single">
<h3 class="assistive-text"><?php _e( 'Post navigation', 'twentytwelve' ); ?></h3>
<span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'twentytwelve' ) . '</span> %title' ); ?></span>
<span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'twentytwelve' ) . '</span>' ); ?></span>
</nav><!-- .nav-single -->

<?php comments_template( '', true ); ?>

<?php endwhile; // end of the loop. ?>

</div><!-- #content -->
</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>