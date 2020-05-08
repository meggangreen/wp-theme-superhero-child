<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Superhero
 * @package Superhero Child Meggan Green
 * edited 2017-03-03
 */

get_header(); ?>
    <section id="primary" class="content-area">
        <div id="content" class="site-content" role="main">

        <?php if ( have_posts() ) : ?>

            <?php //format header text by archive type
            //Catg/Tag/Auth
            if ( is_category() ) :
                $maaa_catgal = single_cat_title( '', false );
                $maaa_headtext = sprintf( __( '%s', 'superhero' ), '<span>' . single_cat_title( '', false ) . ' Posts' . maaa_country_gallery($maaa_catgal) . '</span>' );
                if ( maaa_country_featimg($maaa_catgal) !== '0' ) :
                    $maaa_galleryid = maaa_country_featimg($maaa_catgal);
                    $maaa_featimg = wp_get_attachment_image_src( get_post_thumbnail_id($maaa_galleryid), 'feat-img' );
                    if ( $maaa_featimg[1] >= 645 ) : // show the image if it is greater than or equal to 645
                        $maaa_featimg = get_the_post_thumbnail( $maaa_galleryid, 'feat-img' );
                    endif;
                endif; //end if maaa_country_featimg

            elseif ( is_tag() ) :
                $maaa_headtext = sprintf( __( '%s', 'superhero' ), '<span>' . single_tag_title( '', false ) . '</span>' );
                if ( single_tag_title( '', false ) == 'Week-End Wrap-Up' ) :
                    $maaa_galleryid = 1053;
                    $maaa_featimg = get_the_post_thumbnail( $maaa_galleryid, 'feat-img' );
                endif; //end if tag is wewu

            elseif ( is_author() ) :
                the_post(); //Queue the first post to find author
                $maaa_headtext = sprintf( __( 'By %s', 'superhero' ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' );
                rewind_posts(); //Since we called the_post() above, we need to rewind the loop back to the beginning that way we can run the loop properly, in full.

            //Time-based
            elseif ( is_day() ) :
                $maaa_headtext = sprintf( __( 'Daily Archive: %s', 'superhero' ), '<span>' . get_the_date() . '</span>' );
            elseif ( is_month() ) :
                $maaa_headtext = sprintf( __( 'Monthly Archive: %s', 'superhero' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );
            elseif ( is_year() ) :
                $maaa_headtext = sprintf( __( 'Yearly Archive: %s', 'superhero' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

            //Post formats
            elseif ( is_tax( 'post_format', 'post-format-aside' ) ) :
                $maaa_headtext = __( 'Asides', 'superhero' );
            elseif ( is_tax( 'post_format', 'post-format-image' ) ) :
                $maaa_headtext = __( 'Images', 'superhero');
            elseif ( is_tax( 'post_format', 'post-format-video' ) ) :
                $maaa_headtext = __( 'Videos', 'superhero' );
            elseif ( is_tax( 'post_format', 'post-format-quote' ) ) :
                $maaa_headtext = __( 'Quotes', 'superhero' );
            elseif ( is_tax( 'post_format', 'post-format-link' ) ) :
                $maaa_headtext = __( 'Links', 'superhero' );

            //Else
            else :
                $maaa_headtext = __( 'Archives', 'superhero' );
            endif;
            ?>

            <header class="page-header">
            <?php
            if ( $maaa_galleryid > '0' ) : ?>
                <article id="post-<?php echo $maaa_galleryid ?>" class="post-<?php echo $maaa_galleryid ?> page type-page status-publish has-post-thumbnail hentry">
                <?php
                echo $maaa_featimg;
                echo '<h1 class="entry-title">' . $maaa_headtext . '</h1>';
            else :
                echo '<h1 class="page-title">' . $maaa_headtext . '</h1>';
            endif;
            ?>

            <?php
            /*
            if ( is_category() ) :
                //Show the optional category description
                $category_description = category_description();
                if ( ! empty( $category_description ) ) :
                    echo apply_filters( 'category_archive_meta', '<div class="taxonomy-description">' . $category_description . '</div>' );
                endif;
            elseif ( is_tag() ) :
                //Show the optional tag description
                $tag_description = tag_description();
                if ( ! empty( $tag_description ) ) :
                    echo apply_filters( 'tag_archive_meta', '<div class="taxonomy-description">' . $tag_description . '</div>' );
                endif;
            endif;
            */
            ?>

            </header><!-- .page-header -->
            <?php if ( $maaa_galleryid > '0' ) : ?>
                </article>
            <?php endif; ?>

            <?php if ( $maaa_galleryid == '1053' ) : //Do loop without featured images for WEWU ?>
                <?php while ( have_posts() ) : the_post(); ?>
                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="entry-header">
                <h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
                <?php if ( 'post' == get_post_type() ) : ?>
                    <div class="entry-meta">
                    <?php superhero_posted_on(); ?>
                    </div><!-- .entry-meta -->
                <?php endif; ?>
                </header><!-- .entry-header -->
                <div class="entry-content">
                <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'superhero' ) ); ?>
                <?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'superhero' ), 'after' => '</div>' ) ); ?>
                </div><!-- .entry-content -->
                <footer class="entry-meta">
                <?php if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) : ?>
                    <span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'superhero' ), __( '1 Comment', 'superhero' ), __( '% Comments', 'superhero' ) ); ?></span>
                <?php endif; ?>
                <?php edit_post_link( __( 'Edit', 'superhero' ), '<span class="sep"> | </span><span class="edit-link">', '</span>' ); ?>
                </footer><!-- .entry-meta -->
                </article><!-- #post-## -->
                <?php endwhile; ?>
            <?php else : // Start the Loop ?>
                <?php while ( have_posts() ) : the_post();
                //Include the Post-Format-specific template for the content.
                //If you want to overload this in a child theme then include a file called content-___.php (where ___ is the Post Format name) and that will be used instead.
                get_template_part( 'content', get_post_format() );
                endwhile; ?>
            <?php endif; //endif gallid 1053 ?>

            <?php
            superhero_content_nav( 'nav-below' );

        else :
            get_template_part( 'no-results', 'archive' );

        endif;
        ?>

        </div><!-- #content -->
    </section><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>