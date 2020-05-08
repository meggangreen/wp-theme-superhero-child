<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package Superhero
 * @since Superhero 1.0
 * @child Meggan Green
 * edited 2017-03-03
 */
?>

    </div><!-- #main .site-main -->

    <div id="colophon-wrap">
    <footer id="colophon" class="site-footer" role="contentinfo">
        <div class="site-info">
            <?php do_action( 'superhero_credits' ); ?>
            <a href="http://wordpress.org/" title="<?php esc_attr_e( 'A Semantic Personal Publishing Platform', 'superhero' ); ?>" rel="generator"><?php printf( __( '%s', 'superhero' ), 'WordPress' ); ?></a>
            <span class="sep"> | </span>
            <?php printf( __( '%1$s theme by %2$s', 'superhero' ), '<a href="http://theme.wordpress.com/themes/superhero/" rel="designer">Superhero</a>', '<a href="http://automattic.com/" rel="designer">Automattic</a>' ); ?>
            <span class="sep"> | </span>
            <?php printf( __( 'Mods by %s', 'superhero' ), '<a href="http://meggangreen.com" rel="designer">Meggan</a>' ); ?>
            <span class="sep"> &nbsp; </span>
            <span class="maaalogin">
            <?php printf( __( '%s', 'superhero' ), '<a href="http://meggangreen.com/maaa/wpf/wp-admin/" rel="designer">Login</a>' ); ?>
            </span>
        </div><!-- .site-info -->
    </footer><!-- #colophon .site-footer -->
    </div><!-- #colophon-wrap -->
</div><!-- #page .hfeed .site -->

<?php wp_footer(); ?>
</body>
</html>