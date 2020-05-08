<?php
/**
 * The template for displaying Comments.
 *
 * The area of the page that contains both current comments
 * and the comment form. The actual display of comments is
 * handled by a callback to superhero_comment() which is
 * located in the functions.php file.
 *
 * @package Superhero
 * @package Superhero Child Meggan Green
 * edited 2017-03-03
 *
 */

//Return early without loading the comments if pword required and not validated.
if ( post_password_required() )
    return;
?>

<div id="comments" class="comments-area">

    <?php if ( have_comments() ) : ?>

        <h2 class="comments-title">
            <?php
            if ( get_comments_number() > 9 ) :
                printf( 'There are %1$s comments on &ldquo;%2$s&rdquo;', number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
            else :
                printf( _n( 'There is one comment on &ldquo;%2$s&rdquo;', 'There are %1$s comments on &ldquo;%2$s&rdquo;', get_comments_number(), 'superhero' ),
                    childmg_n2w( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
            endif;
            ?>
        </h2>

        <ol class="commentlist">
            <?php wp_list_comments( array( 'callback' => 'superhero_comment' ) ); //redefine callback function ?>
        </ol><!-- .commentlist -->

        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
        <nav role="navigation" id="comment-nav-below" class="site-navigation comment-navigation">
            <h1 class="assistive-text"><?php _e( 'Comment navigation', 'superhero' ); ?></h1>
            <div class="nav-previous"><?php previous_comments_link( __( '&larr; Older Comments', 'superhero' ) ); ?></div>
            <div class="nav-next"><?php next_comments_link( __( 'Newer Comments &rarr;', 'superhero' ) ); ?></div>
        </nav><!-- #comment-nav-below .site-navigation .comment-navigation -->
        <?php endif; // check for comment navigation ?>

    <?php endif; // have_comments() ?>

    <?php
        // If comments are closed and there are comments, let's leave a little note, shall we?
        if ( ! comments_open() && '0' != get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
    ?>
        <p class="nocomments"><?php _e( 'Comments are closed.', 'superhero' ); ?></p>
    <?php endif; ?>

    <?php comment_form(); //display the comment form ?>

</div><!-- #comments .comments-area -->