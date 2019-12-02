<?php 
/*
Template Name: Contact Template
*/
get_header();
?>


<section id="payinfo" style="background-color: #f5f5f5 !important;">
  <div class="middle-content">
    <div class="container">
      <div class="row">
        <div class="col-sm-12 text-left">
          <div class="m-auto content-title">
            <h1><?php echo get_field("title"); ?></h1>
          </div>
        </div>
      </div>
      <div class="profile-wrap-left ">
        <div class="row">
          <div class="col-md-4">
            <h4>Kontakt informationer</h4>
            <div class="address">
              <p><?php echo get_field("address"); ?></p>
              <p><i class="fa fa-phone p-2" style="color: #0e3248;"></i><?php echo get_field("phone"); ?></p>
              <p><i class="fa fa-envelope p-2" style="color: #0e3248;"></i><?php echo get_field("email"); ?></p>
              <p><?php echo get_field("cvr"); ?></p>
              <p><?php echo get_field("copyrights"); ?>
              </p>
            </div>
          </div>
          <div class="profile-text col-md-8 d-flex flex-wrap align-content-center">
            <h4>Send en besked</h4>
            <?php echo do_shortcode('[contact-form-7 id="236" title="Kontakt Form"]'); ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>



<?php get_footer(); ?>