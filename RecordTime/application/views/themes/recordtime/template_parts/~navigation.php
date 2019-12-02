<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
		<div class="mobile-top-menu">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
			<div class="mobile-show topmenu-items-container">
				<a href="##">Help</a>
				<a href="<?= site_url('artists/login')?>">Sign In</a>
			</div>
		</div>
      <a class="navbar-brand" href="<?= site_url()?>"><img src="<?= site_url().template_assets_path(); ?>/images/logo.png" alt="Login" /></a> </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav artist-menu-section">
            <li class="menu-items menu-items-has-childrens"><a href="javascript:void(0);">Artists</a>
                <ul class="child-items" style="display:none">
                    <li><a href="<?= site_url('artists/overview')?>">Overview</a></li>
                    <li><a href="<?= site_url('artists/how-it-works')?>">How it Works</a></li>
                    <li><a href="<?= site_url('artists/signup')?>">Sign Up</a></li>
                </ul>
            </li>
            <li class="menu-items menu-items-has-childrens"><a href="javascript:void(0)">Producers</a>
                <ul class="child-items" style="display:none">
                    <li><a href="<?= site_url('producers/overview')?>">Overview</a></li>
                    <li><a href="<?= site_url('producers/how-it-works')?>">How it Works</a></li>
                    <li><a href="<?= site_url('producers/signup')?>">Sign Up</a></li>
                </ul>
            </li>
            <?php if(isset($this->session->userdata['userid'])!= '') {  ?>
                <li class="menu-items"><a href="<?php echo site_url(); ?>/project/dashboard">Projects</a></li>
            <?php } ?>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <?php if(isset($this->session->userdata['userid'])!= '') {  ?>
					<?php if($this->session->userdata['type'] == 1){?>
						<li><a href="<?= site_url('artists/profile')?>" class="txt-upper mobile-hide"><strong>My Profile</strong></a></li>
            <li><a href="<?= site_url('project/dashboard')?>" class="txt-upper mobile-hide"><strong>My Projects</strong></a></li>
            <li><a href="<?= site_url('search')?>" class="txt-upper mobile-hide"><strong>Find a Producer</strong></a></li>
					 <?php }elseif($this->session->userdata['type'] == 2) { ?>
            <li><a href="<?= site_url('producer/profile')?>" class="txt-upper mobile-hide"><strong>My Profile</strong></a></li>
            <li><a href="<?= site_url('project/dashboard')?>" class="txt-upper mobile-hide"><strong>My Projects</strong></a></li>
            <li><a href="<?= site_url('search')?>" class="txt-upper mobile-hide"><strong>Find a Project</strong></a></li>
           <?php }?>
            <li class="active mobile-hide" ><a href="<?php echo site_url(); ?>/search">Start Recording</a></li>
    	<?php } else { ?>
        <li><a href="https://recordtime.zendesk.com/" class="txt-upper">Help</a></li>
    		<li><a href="<?= site_url('login')?>" class="txt-upper mobile-hide"><strong>SIGN IN</strong></a></li>
        <li class="active mobile-hide" ><a href="#">Start Recording</a></li>
    	<?php } ?>

        <!-- li class="menu-icon mobile-hide"><a href="javascript:void(0);"><img src="<?= site_url().template_assets_path(); ?>/images/menu_icon.png" style="max-width:26px;" /></a></li -->
      </ul>
    </div>
  </div>
</nav>
