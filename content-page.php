<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Superhero
 * @package Superhero Child Meggan Green
 * edited 2017-03-03
 *
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
    <?php
    $maaa_thetitle = the_title('','',false);
    if ( fnmatch('* Gallery',$maaa_thetitle) ) {
        $maaa_galcountry = strtolower(str_replace(' Gallery','',$maaa_thetitle));
        $maaa_galcountry_id = get_cat_ID($maaa_galcountry);
        $maaa_galcountry_info = get_category($maaa_galcountry_id);
        $maaa_galcountry_count = $maaa_galcountry_info->category_count;
        if ($maaa_galcountry_count == 0) {
            $maaa_h1text = $maaa_thetitle;
        } else {
            $maaa_galcountry_url = esc_url(get_category_link($maaa_galcountry_id));
            $maaa_galcountry_url = '<a href="' . $maaa_galcountry_url . '" title="Posts">Posts</a>';
            $maaa_h1text = $maaa_thetitle . ' &nbsp; | &nbsp; ' . $maaa_galcountry_url;
        } //endif
    } else {
        $maaa_h1text = $maaa_thetitle;
    } //endif
    ?>

    <?php
    if ( '' != get_the_post_thumbnail() ) :
        $image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'feat-img' );
        if ( $image[1] >= 645 ) : // show the image if it is greater than or equal to 645
            the_post_thumbnail( 'feat-img' );
        endif;
    endif;
    ?>

    <header class="entry-header">
        <h1 class="entry-title"><?php echo $maaa_h1text; ?></h1>
    </header><!-- .entry-header -->

    <div class="entry-content">
        <?php the_content(); ?>
        <?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'superhero' ), 'after' => '</div>' ) ); ?>
    </div><!-- .entry-content -->

    <?php edit_post_link( __( 'Edit', 'superhero' ), '<footer class="entry-meta"><span class="edit-link">', '</span></footer>' ); ?>
</article><!-- #post-## -->