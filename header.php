<?php
/**
 * The Header for the child theme.
 *
 * Displays all of the <head> section and everything up until <div id="main">
 *
 * @package Superhero
 * @since Superhero 1.0
 * @child Meggan Green
 * edited 2017-03-11
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" type="image/x-icon" />
<link rel="icon" href="<?php echo get_stylesheet_directory_uri(); ?>/favicon.ico" type="image/x-icon" />
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site"><a class="anchor-jump" id="ptop"></a>
    <?php do_action( 'before' ); ?>

    <div id="masthead-wrap">
    <header id="masthead" class="site-header" role="banner">
        <hgroup class="masthead-table">

            <!-- no site header img call -->
            <!-- no site logo img call -->

            <table>
              <tr>
                <td width="80px">
                  <img src="http://www.meggangreen.com/maaa/wpf/wp-content/uploads/MA.png" width="70" height="70" class="site-logo" />
                </td>
                <td>
                  <h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>

                <?php   // calls function for number of days and current country
                    $maaa_immedstats = maaa_stats_header(); ?>
                    <h2 class="site-immedstats">Meggan left the USA <?php echo $maaa_immedstats[0]; ?> ago and is currently in <?php echo $maaa_immedstats[1]; ?>.</h2>


                </td>
              </tr>
              <tr>
                <td colspan="2" align="right">

                  <nav class="site-navigation main-navigation" role="navigation">
                      <h1 class="assistive-text"><?php _e( 'Menu', 'superhero' ); ?></h1>
                      <div class="assistive-text skip-link"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'superhero' ); ?>"><?php _e( 'Skip to content', 'superhero' ); ?></a></div>
                      <?php wp_nav_menu( array( 'theme_location' => 'primary' ) ); ?>
                  </nav><!-- .site-navigation .main-navigation -->

                </td>
              </tr>
            </table>

        </hgroup>

        <div class="clearfix"></div>
    </header><!-- #masthead.site-header -->
    </div><!-- #masthead-wrap -->

    <div class="clearfix"></div>

    <?php
    if ( is_front_page() ) :
        get_template_part( 'slider' );
    endif;
    ?>

    <div id="main" class="site-main">