<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Nineteen
 * @since 1.0.0
 */

?>

	<footer id="footer">
  <div class="container">
    <div class="row">
      <div class="content-inner col-md-3 text-white"> <a href="<?php echo site_url(); ?>"><img src="<?php echo get_template_directory_uri(); ?>/image/footer-logo.png" width="195" height="35" alt="Skattesag"/></a>
        <?php dynamic_sidebar( 'sidebar-2' ); ?>
      </div>
      <div class="content-inner col-md-3 text-white">
        <h6>Menu</h6>
        <?php
        
          wp_nav_menu( array(
            'theme_location'  => 'footer',
            'menu_class'      => 'discription-text',
          ) );
        ?>
        
      </div>
      <div class="content-inner col-md-3 text-white">
        <?php dynamic_sidebar( 'sidebar-3' ); ?> 
      </div>
      <div class="content-inner col-md-3 text-white">
        <?php dynamic_sidebar( 'sidebar-4' ); ?> 
      </div>
    </div>
  </div>
</footer> 
<?php wp_footer(); ?>

</body>
</html>
