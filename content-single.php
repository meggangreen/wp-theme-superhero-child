<?php
/**
 * Displays one post
 *
 * @package Superhero
 * @package Superhero Child Meggan Green
 * edited 2017-03-03
 *
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php
    if ( '' != get_the_post_thumbnail() ) :
        $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'feat-img' );

        // If the image is greater than or equal to 645, show it
        if ( $image[1] >= 645 ) :
            the_post_thumbnail( 'feat-img' );
        endif;
    endif;
    ?>

    <header class="entry-header">
        <h1 class="entry-title"><?php the_title(); ?></h1>

        <div class="entry-meta">
            <?php superhero_posted_on(); ?>
        </div><!-- .entry-meta -->
    </header><!-- .entry-header -->

    <div class="entry-content">
        <?php the_content(); ?>
        <?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'superhero' ), 'after' => '</div>' ) ); ?>
    </div><!-- .entry-content -->

    <footer class="entry-meta">
        <?php maaa_content_footer(); ?>
    </footer><!-- .entry-meta -->
</article><!-- #post-## -->
