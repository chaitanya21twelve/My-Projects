<?php if(!is_checkout()){ ?>
<section class="form-row">

  <div class="container">

    <div class="row">

      <div class="col-xs-12">

        <div class="page-title">

          <h2>Gå ikke glip af vores tilbud</h2>

        </div>

      </div>

    </div>

    <div class="form-box-col">

      <div class="row"> <?php echo do_shortcode('[mc4wp_form id="26"]');?> </div>

    </div>

  </div>

</section>
<?php } ?>
<?php $flogo = of_get_option('fsite_logo');



if(!empty($flogo)){



	$flogo = IMAGES_URL.'/footer-logo.png';



}



?>

<footer class="footer">

  <div class="container">

    <div class="footer-box">

      <div class="row">

        <div class="col-xs-12">

          <div class="footer-logo"> <img src="<?php echo $flogo;?>" alt=""/> </div>

        </div>

      </div>

      <div class="footer-content">

        <div class="row">

          <?php if ( is_active_sidebar( 'footer_column_1' ) ) : ?>

          <div class="item col-md-3 col-sm-6 col-xs-12">

            <div class="footer-bar">

              <?php dynamic_sidebar( 'footer_column_1' ); ?>

            </div>

          </div>

          <?php endif; ?>

          <?php if ( is_active_sidebar( 'footer_column_2' ) ) : ?>

          <div class="item col-md-3 col-sm-6 col-xs-12">

            <div class="footer-bar">

              <?php dynamic_sidebar( 'footer_column_2' ); ?>

            </div>

          </div>

          <?php endif; ?>

          <?php 



					$fb_url = of_get_option('fb_url');



					$insta_url = of_get_option('insta_url');



					$go_url = of_get_option('go_url');



					?>

          <div class="item col-md-3 col-sm-6 col-xs-12">

            <div class="footer-bar">

              <h3>Forbind med os</h3>

              <div class="footer-social">

                <ul>

                  <?php if(!empty($fb_url)){?>

                  <li><a href="<?php echo $fb_url;?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>

                  <?php }?>

                  <?php if(!empty($insta_url)){?>

                  <li><a href="<?php echo $insta_url;?>" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>

                  <?php }?>

                  <?php if(!empty($go_url)){?>

                  <li><a href="<?php echo $go_url;?>" target="_blank"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>

                  <?php }?>

                </ul>

              </div>

            </div>

          </div>

          <?php 



					$footer_email = of_get_option('footer_email');



					$footer_phone = of_get_option('footer_phone');



					$office_time = of_get_option('office_time');



					$footer_desc = of_get_option('footer_desc');



					$fsite_image = of_get_option('fsite_image');



					?>

          <div class="item col-md-3 col-sm-6 col-xs-12">

            <div class="footer-bar">

              <h3>Kontakt os</h3>

              <div class="footer-call">

                <?php if(!empty($footer_phone)){?>

                <a href="tel:<?php echo str_replace(' ', '', $footer_phone);?>"><?php echo $footer_phone;?></a>

                <?php }?>

                <p><?php echo $office_time;?></p>

              </div>

              <div class="footer-call">

                <?php if(!empty($footer_email)){?>

                <a href="mailto:<?php echo $footer_email;?>"><?php echo $footer_email;?></a>

                <?php }?>

                <p><?php echo $footer_desc;?></p>

              </div>

              <?php if(!empty($fsite_image)){?>

              <div class="card-details"> <img src="<?php echo $fsite_image;?>" alt=""/> </div>

              <?php }?>

            </div>

          </div>

        </div>

      </div>

    </div>

    <div class="copy-right">

      <?php 



			$copyRight = of_get_option('footer_copyrights');



			if(!empty($copyRight)){



				$copyRight = '<li>'.$copyRight.'</li>';



			}



			wp_nav_menu( array(



				'theme_location'    => 'footer-menu',



				'container'         => false,



				'menu_class'        => '',



				'items_wrap' => '<ul id="%1$s" class="%2$s">'.$copyRight.'%3$s</ul>'



				)



			);



			?>

    </div>

  </div>

</footer>

<div class=" pop">

  <div class="container">

    <div class="Storrelsesguide" > <i class="fa fa-times icon-remove-sign"></i>

      <div class="col-md-4 col-sm-6 col-xs-12">

        <div class="Storrelsesguide-left"> <img src="<?php echo IMAGES_URL;?>/men-profile.png" alt=""/> </div>

      </div>

      <div class="col-md-8 col-sm-6 col-xs-12">

        <div class="Storrelsesguide-right">

          <h2>Størrelsesguide</h2>

          <p>Mål rundt om brystkassen samt rundt om livet. Herefter kan du finde frem til din størrelse ved at bruge nedenstående skema.</p>

          <div class="table-responsive">

            <table class="table">

              <thead class="Storrelsesguide-heading">

                <tr>

                  <th>Størrelse</th>

                  <th>Mål om livet (cm.)</th>

                  <th>Mål om brystkassen (cm.)</th>

                </tr>

              </thead>

              <tbody class="Storrelsesguide-data">

                <tr>

                  <td>S</td>

                  <td>76  -  82</td>

                  <td>91  -  95</td>

                </tr>

              </tbody>

              <tbody class="Storrelsesguide-data">

                <tr>

                  <td>M</td>

                  <td>83  -  86</td>

                  <td>96  -  99</td>

                </tr>

              </tbody>

              <tbody class="Storrelsesguide-data">

                <tr>

                  <td>L</td>

                  <td>87  -  94</td>

                  <td>100  - 104</td>

                </tr>

              </tbody>

              <tbody class="Storrelsesguide-data">

                <tr>

                  <td>XL</td>

                  <td>95  -  101</td>

                  <td>105  - 109</td>

                </tr>

              </tbody>

              <tbody class="Storrelsesguide-data">

                <tr>

                  <td>XXL</td>

                  <td>102  -  107</td>

                  <td>110  -  117</td>

                </tr>

              </tbody>

            </table>

          </div>

        </div>

      </div>

    </div>

  </div>

</div>

<?php wp_footer(); ?>

<script src="<?php echo JS_URL;?>/jquery.min.js"></script>

<script type="text/javascript" src="<?php echo JS_URL;?>/bootstrap.min.js"></script>
<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/magnific-popup.min.js"></script>
<script type="text/javascript">
    jQuery(document).ready(function() {
        jQuery('.popup-with-zoom-anim').magnificPopup({
          type: 'inline',

          fixedContentPos: false,
          fixedBgPos: true,

          overflowY: 'auto',

          closeBtnInside: true,
          preloader: false,
          
          midClick: true,
          removalDelay: 300,
          mainClass: 'my-mfp-zoom-in'
        });
    });
</script>


<!--<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" crossorigin="anonymous"></script>-->
<script>

	$(document).on('click',".icon-plus-sign",function(){

		$(".pop").fadeIn('slow');

    });

	$(".pop i").on('click',function() {   

		$(".pop").fadeOut('fast');

	});


  // $("#filterbtn").click(function () {

  //   $("#filtertext").css("display","none");
  //   $("#filterbar").css("display","block");  
  // });

  $(document).ready(function() {
    $('#filterbtn').click(function() {
      $("#filterbar").toggle();
    });
  });

//Thanks for Iphone titlebar fix http://coding.smashingmagazine.com/2013/05/02/truly-responsive-lightbox/



var getIphoneWindowHeight = function() {

  // Get zoom level of mobile Safari

  // Such zoom detection might not work correctly on other platforms

  // 

  var zoomLevel = document.documentElement.clientWidth / window.innerWidth;



  // window.innerHeight returns height of the visible area. 

  // We multiply it by zoom and get our real height.

  return window.innerHeight * zoomLevel;

};







		</script>

<script>

function currentDiv(n) {

  showDivs(slideIndex = n);

}



function showDivs(n) {

  var i;

  var x = document.getElementsByClassName("mySlides");

  var dots = document.getElementsByClassName("demo");

  if (n > x.length) {slideIndex = 1}

  if (n < 1) {slideIndex = x.length}

  for (i = 0; i < x.length; i++) {

     x[i].style.display = "none";

  }

  for (i = 0; i < dots.length; i++) {

     dots[i].className = dots[i].className.replace(" w3-opacity-off", "");

  }

  x[slideIndex-1].style.display = "block";

  dots[slideIndex-1].className += " w3-opacity-off";

}

</script>

<!-- <script type="text/javascript" src="<?php echo JS_URL;?>/tooltip.min.js"></script> -->

</body></html>