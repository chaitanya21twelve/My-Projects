<div class="home-hero-banner">
	<div class="row">
    <div class="col-sm-8"></div>
    <div class="col-sm-4 text-center"><img src="<?= site_url().template_assets_path(); ?>/images/footer_logo.png" alt="White Logo" /></div>
	<div class="col-sm-4 text-center sign-in-option"><a href="" class="signi-in-mobile sign-ing">Sign in</a><a href="" class="sign-ing signi-ul-mobile">Sign up</a></div>
    <div class="text-left mt-50 col-sm-12">Simple.<br /> Transparent.<br> A little <span>rebellious.</span>.</div>
    </div>
</div>
<div class="container">

  <div class="row white-bg">
  	<div class="title-work-with col-md-8">
    	Work with great Producers.
    </div>
    <div class="create-profile-form col-md-4">
    	<div class="col-sm-12 signup-form">
        		<h3 class="title">Create a profile and start recording</h3>
            <form action="<?php echo base_url(); ?>artists/signup" method="post">
        		<div class="form-group">
                  <div class="col-sm-6 row">
                  <input type="text" class="form-control" id="fname" placeholder="First Name" name="firstname">
                  </div>
                  <div class="col-sm-6 row">
                  <input type="text" class="form-control" id="lname" placeholder="Last Name" name="lastname">
                  </div>
                </div>
            	<div class="form-group">
                  <input type="email" class="form-control" id="email" placeholder="Email" name="email">
                </div>

                <div class="form-group">
                  <input type="password" class="form-control" id="pwd" placeholder="Create Password" name="password">
                </div>
                <div class="form-group">
                  <input type="text" class="form-control" id="city" placeholder="City" name="city">
                </div>
                <div class="form-group">
                  <div class="col-sm-6 row">
                  <input type="text" class="form-control" id="state" placeholder="State" name="state">
                  </div>
                  <div class="col-sm-6 row">
                  <input type="text" class="form-control" id="zip" placeholder="Zip" name="zip">
                  </div>
                </div>

                <div class="col-sm-12 form-button-container">
				        <input type="submit" name="submit" value="Sign up to record" class="orange signup-btn" style="padding: 0px;" /><span class="align-right" ><i class="fa fa-arrow-right"></i></span>
                </div>

                <div class="col-sm-12 form-button-container">
                    <span>Already have an account? Login <a href="<?php echo site_url(); ?>/login"> Here!</a></span>
                </div>
            </form>
            </div>
    </div>

    <div class="clearfix"></div>
    <div class="col-sm-12 mt-50">
    	<div class="row process-section">
        <div class="col-sm-2"></div>
        <div class="col-sm-8 process-contain-section">
        	<div class="col-sm-4 work-with-text">
				<div class="work-with-inner-text">
					<img src="<?= site_url().template_assets_path(); ?>/images/transparent.png" alt="Transparent" />
					<h4 class="title">Transparent</h4>
					<p>Search and compare pricing, reviews, and portfolios, and samples for all recording professionals. Quit guessing. Get the best pros at the best prices. </p>
				</div>
            </div>
            <div class="col-sm-4 work-with-text">
				<div class="work-with-inner-text">
					<img src="<?= site_url().template_assets_path(); ?>/images/tailored.png" alt="Tailored" />
					<h4 class="title">Tailored</h4>
					<p>Record songs unlike anything heard before. Endless producers, songwriters, and studio pros are at your fingertips ready to help you create your signature sound. </p>
				</div>
            </div>
            <div class="col-sm-4 work-with-text">
				<div class="work-with-inner-text">
					<img src="<?= site_url().template_assets_path(); ?>/images/Secure.png" alt="Secure" />
					<h4 class="title">Secure</h4>
					<p>Recording should be worry-free. That�s why we hold all funds until Artists mark the work as done, while providing legal framework to protect every project�s collaborators. </p>
				</div>
            </div>
            <!-- div class="col-sm-12 mt-30 text-center process-vertical-line">
            	<img src="<?= site_url().template_assets_path(); ?>/images/home_page_process.png" alt="Process" />
            </div -->

        </div>
        <div class="col-sm-2 process-horig-line">  <img src="<?= site_url().template_assets_path(); ?>/images/mobile-interaction-img.png" alt="Process" /></div>
        </div>
    </div>
    <div class="col-sm-12 mt-50 text-right">
    	<div class="col-sm-8"></div>
        <div class="col-sm-4">
        <button class="orange signup-btn margin-bottom-minus-25" onclick="window.location.href='<?= site_url('artists/overview')?>'">Reason to record <span class="align-right" ><i class="fa fa-arrow-right"></i></span></button>
        </div>
    </div>
   </div>
   <div class="row">
  	<div class="col-sm-12 mt-50">
        <div class="col-sm-12 row text-center">
        	<p class="text-center producer-heading">Featured Producers</p>
            <div class="mt-20"></div>
            <div class="responsive">
				<div>
					<div  class="featured-producers-text">
					<img src="<?= site_url().template_assets_path(); ?>/images/Anthony Johns.png" alt="Anthony Johns" />
					<h4 class="title">Anthony Johns</h4>
					<p>Lady Gaga, Taylor Swift, Kesha, Paramore </p>
					</div>
				</div>
				<div class="featured-producers-text">
					<img src="<?= site_url().template_assets_path(); ?>/images/Kylie Glen.png" alt="Kylie Glen" />
					<h4 class="title">Kylie Glen</h4>
					<p>Lady Gaga, Taylor Swift, Kesha, Paramore </p>
				</div>
				<div class="featured-producers-text">
					<img src="<?= site_url().template_assets_path(); ?>/images/Andy Banks.png" alt="Andy Banks" />
					<h4 class="title">Andy Banks</h4>
					<p>Lady Gaga, Taylor Swift, Kesha, Paramore </p>
				</div>
			</div>
        </div>
        <div class="clearfix"></div>
        <div class="mt-50"></div>
    </div>
  </div>
  <div class="row">
  	<div class="col-sm-6 artist-producer-section left-artist-section">
    	<div class="artist-producer-block">
        	<h3 class="title">Artists</h3>
            <div class="double-border"></div>
            <p><span>Performing artists wanting to record new material</span></p>
            <ul>
            	<li>+ Search for great producers</li>
                <li>+ Compare production rates</li>
                <li>+ Record your songs </li>
            </ul>
            <a href="#">Sign Up</a>
            <a href="<?= site_url('artists/overview')?>">Learn More</a>
        </div>
    </div>
    <div class="col-sm-6 artist-producer-section right-producers-section">
    	<div class="artist-producer-block">
        	<h3 class="title">Producers</h3>
            <div class="double-border"></div>
            <p><span>Producers searching for new talent</span></p>
            <ul>
            	<li>+ List your services for free</li>
                <li>+ Record new artists</li>
                <li>+ Build your portfolio </li>
            </ul>
            <a href="#">Sign Up</a>
            <a href="<?= site_url('producers/overview')?>">Learn More</a>
        </div>
    </div>

    <div class="col-sm-12 artist-producer-section" style="background:url(<?= site_url().template_assets_path(); ?>/images/intrection1.png);padding:350px 0 0;">
    	<div class="col-sm-8">
        	<p>Get experience.<br />Get more work. <br />Make iconic music.</p>
        </div>
        <div class="col-sm-4 text-right">
        	<button class="orange signup-btn margin-bottom-minus-25" onclick="window.location.href='<?= site_url('producers/overview')?>'">Reasons to Produce <span class="align-right" ><i class="fa fa-arrow-right"></i></span></button>
        </div>
    </div>

  </div>
</div>
