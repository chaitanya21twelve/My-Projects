<?php 
/*
Template Name: Common Template
*/
get_header();
?>
<style type="text/css">
  
  #banner-profile {
    background-color: #0e3248;
  }
  
  .banner-text-white {
    text-align: center;
    padding: 8px 0px;
  }
  
  .banner-text-white h3 {
    color: #fff;
  }

  #um-submit-btn {
    background: #3bb692;
  }
</style>
<section id="banner-profile">
  <div class="img-inner">
    <div class="container">
      <div class="banner-text-white">
        <h3><?php the_title(); ?></h3>
      </div>
    </div>
  </div>
</section>

<?php
    if ( have_posts() ) {
      // Load posts loop.
      while ( have_posts() ) {
        the_post(); ?>


        <?php 
        
        the_content(
          sprintf(
            wp_kses(
              array(
                'span' => array(
                  'class' => array(),
                ),
              )
            ),
            get_the_title()
          )
        );
      }
    } 
    
get_footer(); ?>