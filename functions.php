<?php

// edited 2018-01-25

/****************************
  *** DASHBOARD COLUMNS ***
****************************/
function wpse126301_dashboard_columns() {
    // Make dashboard only 1 column for developing on netbook - 2014
    // Updated to two when I had a bigger screen again - 2018
    // https://wordpress.stackexchange.com/questions/126301/wordpress-3-8-dashboard-1-column-screen-options

    add_screen_option(
        'layout_columns',
        array(
            'max'     => 2,
            'default' => 2
        )
    );
}
add_action( 'admin_head-index.php', 'wpse126301_dashboard_columns' );


/****************************
  *** ENQUEUE CUSTOM JS ***
****************************/
function childmg_js() {
    // add custom js file

    wp_enqueue_script( 'childmg_script', get_stylesheet_directory_uri() . '/javascript.js', array( 'jquery' ) );
}
add_action( 'wp_enqueue_scripts', 'childmg_js' );


/******************************
  *** ENQUEUE STYLESHEETS ***
******************************/
function childmg_stylesheet() {
    // add custom css file

    wp_enqueue_style( 'style', get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'superhero-child', get_stylesheet_directory_uri() . '/style.css', array('style') );
}
add_action( 'wp_enqueue_scripts', 'childmg_stylesheet' );


/************************************************
  *** STRIP MANY NON-ALPHANUMERIC CHARACTERS ***
************************************************/
function maaa_filterinput($maaa_input) {
    // Strips some characters from input to help mitigate unwanted SQL injection
    // used for db input to maaa plugin; relies on WP to protect posts, comments, etc.

    $maaa_pattern = "/[^A-Za-z0-9 &!(),-.:=\'?$;]/";
    $maaa_replacement = "";
    return preg_replace($maaa_pattern, $maaa_replacement, $maaa_input, -1);
}


/**************************************
  *** REMOVE MORE-LINK PAGE SCROLL ***
***************************************/
function remove_more_link_jump( $link ) {
    // https://codex.wordpress.org/Customizing_the_Read_More#Prevent_Page_Scroll_When_Clicking_the_More_Link

    $link = preg_replace( '|#more-[0-9]+|', '', $link );
    return $link;
}
add_filter( 'the_content_more_link', 'remove_more_link_jump' );


/***************************************
  *** CHANGE 'SELECT CATEGORY' TEXT ***
****************************************/
function _category_dropdown_filter( $cat_args ) {
    // Changes the text in the category filter
    // https://stackoverflow.com/questions/14079259/change-default-select-category-text-in-categories-dropdown-widget-in-wordpress

        $cat_args['show_option_none'] = __('Select Country');
        return $cat_args;
}
add_filter( 'widget_categories_dropdown_args', '_category_dropdown_filter' );


/**********************************
  *** CONVERT NUMBERS TO WORDS ***
***********************************/
function num_to_word($num) {
    // Converts an integer to a spelled-out string
    // simplified from http://www.karlrixon.co.uk/writing/convert-numbers-to-words-with-php/

    $words  = array(
        0 => 'zero',
        1 => 'one',
        2 => 'two',
        3 => 'three',
        4 => 'four',
        5 => 'five',
        6 => 'six',
        7 => 'seven',
        8 => 'eight',
        9 => 'nine'
    );

    return (array_key_exists($num, $words) ? $words[$num] : $num);
}


/*******************
  *** PLURALIZE ***
********************/
function pluralize($qty, $unit) {
    // https://www.php.net/manual/en/dateinterval.format.php#96768

    return ($qty != 1 ? $unit . 's' : $unit);
}


/**************************
  *** CUSTOM DATE_DIFF ***
***************************/
function maaa_date_diff($date1, $date2, $daysum) {
    // Calculates the time delta and returns both the interval and a formatted string
    
    $diff_seconds = $daysum * 86400 + (strtotime($date2) - strtotime($date1));
    $diff_days = $diff_seconds / 86400;
  
    $y_diff = floor($diff_seconds / (365 * 86400));
    $d_diff = floor(($diff_seconds - $y_diff * 365 * 86400) / 86400);
    
    $diff_str = '';
    if ( $y_diff > 0 ) {
        $diff_str = $diff_str . ' ' . num_to_word($y_diff) . pluralize($y_diff, ' year');
    }
    if ( $d_diff > 0 ) {
        $diff_str = $diff_str . ' ' . num_to_word($d_diff) . pluralize($d_diff, ' day');
    }
    
    return array($diff_str, $diff_days);
}


/***************************************
  *** PRESENT DAYS & COUNTRY HEADER ***
****************************************/
function maaa_stats_header(){
    // Returns formatted current country & number of days in country for site header

    global $wpdb;
    $wpdb->show_errors();

    //Retrieve number of days and present country
    $maaa_table = $wpdb->prefix . "maaa_days";

    $maaa_day1 = $wpdb->get_var( "SELECT entry_ts FROM $maaa_table ORDER BY entry_ts ASC LIMIT 0 , 1" );
    $maaa_day2 = $wpdb->get_var( "SELECT exit_ts FROM $maaa_table ORDER BY entry_ts DESC LIMIT 0 , 1" );
    if ($maaa_day2 == "0000-00-00 00:00:00") { $maaa_day2 = date('Y-m-d H:i:s', time()-21600); }
    $maaa_daytotal = maaa_date_diff($maaa_day1,$maaa_day2,0)[0];

    $maaa_prescountry = $wpdb->get_var( "SELECT country FROM $maaa_table ORDER BY entry_ts DESC LIMIT 0 , 1" );
    $maaa_prescountry_id = get_cat_ID($maaa_prescountry);
    $maaa_prescountry_info = get_category($maaa_prescountry_id);
    $maaa_prescountry_count = $maaa_prescountry_info->category_count;
    if ($maaa_prescountry == "USA") { $maaa_prescountry = "the USA"; }
    if ($maaa_prescountry_count == 0) {
        $maaa_prescountry_url = $maaa_prescountry;
    } else {
        $maaa_prescountry_url = esc_url(get_category_link($maaa_prescountry_id));
        $maaa_prescountry_url = '<a href="' . $maaa_prescountry_url . '" title="' . $maaa_prescountry . '">' . $maaa_prescountry . '</a>';
    } //end if
    return array($maaa_daytotal, $maaa_prescountry_url);
}


/************************
  *** COMMENTS LOOP ***
************************/
/**
 * Template for comments and pingbacks.
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since superhero 1.0
 * @child Meggan Green
 */
function superhero_comment( $comment, $args, $depth ) {
    // REMOVE
    // Over-writing in order to use custom avatars, but the project never happened
    $GLOBALS['comment'] = $comment;
    switch ( $comment->comment_type ) :
        case 'pingback' :
        case 'trackback' :
    ?>
    <li class="post pingback">
    <p><?php _e( 'Pingback:', 'superhero' ); ?> <?php comment_author_link(); ?><?php edit_comment_link( __( '(Edit)', 'superhero' ), ' ' ); ?></p>
    <?php
    break;
    default :
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
    <article id="comment-<?php comment_ID(); ?>" class="comment">

    <footer>

    <div class="comment-author vcard">
    <?php //echo maaa_megatar( get_comment_author_email() ); ?>
    <?php echo get_avatar( $comment, 48 ); ?>
    <?php printf( __( 'At %1$s %2$s, %3$s said:', 'superhero' ), get_comment_time(), get_comment_date(), sprintf( '<span class="fn">%s</span>', ucwords(get_comment_author_link()) ) ); ?>
    </div><!-- .comment-author .vcard -->

    <?php if ( $comment->comment_approved == '0' ) : ?>
        <em><?php _e( 'Your comment is awaiting moderation.', 'superhero' ); ?></em>
        <br />
    <?php endif; ?>

    <div class="comment-meta commentmetadata">
    <?php edit_comment_link( __( '(Edit)', 'superhero' ), ' ' ); ?>
    </div><!-- .comment-meta .commentmetadata -->

    </footer>

    <div class="comment-content"><?php comment_text(); ?></div>
    <div class="reply">
    <?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
    </div><!-- .reply -->
    </article><!-- #comment-## -->
    <?php
    break;
    endswitch;
}


/*************************
  *** ENTRY META DATA ***
**************************/
/**
 * Prints entry meta data in header (date, time, author, type, category)
 *
 * @since superhero 1.0
 * @child Meggan Green
 */
if ( ! function_exists( 'superhero_posted_on' ) ) :
function superhero_posted_on() {
    printf( __( '<a href="http://www.meggangreen.com/maaa/blog/date/%1$s/%2$s" title="View all posts in %3$s %1$s" rel="bookmark"><time class="entry-date" datetime="%4$s">%5$s</time></a>', 'superhero' ),
        esc_attr( get_the_date( 'Y' ) ),
        esc_attr( get_the_date( 'm' ) ),
        esc_attr( get_the_date( 'F' ) ),
        esc_attr( get_the_date( 'c' ) ),
        esc_html( get_the_date() )
    );
    if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search
        /* translators: used between list items, there is a space after the comma */
        $categories_list = get_the_category_list( __( ', ', 'superhero' ) );
        if ( $categories_list && superhero_categorized_blog() ) :
            echo '<span class="cat-links">';
            printf( __( ' | %1$s', 'superhero' ), $categories_list );
            echo '</span>';
        endif; // End if categories

        /* translators: used between list items, there is a space after the comma */
        $tags_list = get_the_tag_list( '', __( ', ', 'superhero' ) );
        if ( $tags_list ) :
            echo '<span class="tags-links">';
            printf( __( ' | %1$s', 'superhero' ), $tags_list );
            echo '</span>';
        endif; // End if tags

    endif; // End if post type
} //end function
endif;


/*************************
  *** ENTRY META DATA ***
**************************/
/**
 * Prints the permalink and edit links in footer
 *
 * @child Meggan Green
 */
function maaa_content_footer() {
    /* translators: used between list items, there is a space after the comma */
    $meta_text = __( 'Bookmark the <a href="%1$s" title="permalink to %2$s" rel="bookmark">permalink</a>.', 'superhero' );
    printf(
        $meta_text,
        get_permalink(),
        the_title_attribute( 'echo=0' )
    );
    edit_post_link( __( 'Edit', 'superhero' ), '<span class="sep"> | </span><span class="edit-link">', '</span>' );
} //end function


/******************************
  *** COUNTRY GALLERY URL ***
******************************/
function maaa_country_gallery( $maaa_singlecattitle ){
    // Returns the text & link to a country gallery for a country archive page

    global $wpdb;
    $wpdb->show_errors();

    //Get gallery url
    $maaa_pquery = $maaa_singlecattitle . ' Gallery';
    $maaa_pages = get_all_page_ids();
    foreach ($maaa_pages as $maaa_pageid) if (get_the_title($maaa_pageid) == $maaa_pquery) return sprintf( __( '%s', 'superhero' ), ' &nbsp; | &nbsp; <a href="' . get_page_link($maaa_pageid) . '">Gallery</a>' );
    return false;
}


/***********************************
  *** COUNTRY GALLERY FEAT-IMG ***
***********************************/
function maaa_country_featimg( $maaa_singlecattitle ){
    // Returns the feature image from a country gallery page for use in a country archive page

    global $wpdb;
    $wpdb->show_errors();

    //Get gallery url
    $maaa_pquery = $maaa_singlecattitle . ' Gallery';
    $maaa_pages = get_all_page_ids();
    foreach ($maaa_pages as $maaa_pageid) if (get_the_title($maaa_pageid) == $maaa_pquery) if ( '' != get_the_post_thumbnail($maaa_pageid) ) return $maaa_pageid;
    return '0';
}

?>