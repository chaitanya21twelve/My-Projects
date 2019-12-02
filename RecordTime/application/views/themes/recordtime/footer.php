<footer class="footer">
	<div class="text-center"><img src="<?= site_url().template_assets_path(); ?>/images/footer_logo.png" alt="Footer Logo" /></div>
    <div class="footer-menu">
    	<ul>
    		<li><a href="<?= site_url()?>">Home</a></li>
            <li><a href="<?= site_url('artists/overview')?>">Artists</a></li>
            <li><a href="<?= site_url('producers/overview')?>">Producers</a></li>

            <?php if(isset($this->session->userdata['userid'])!= '') {  ?>
                  
                <li><a href="<?= site_url('logout')?>" >Logout</a></li>
                <li><a href="https://recordtime.zendesk.com/hc/en-us/requests/new">Help</a></li>
            <?php } else { ?>
                <li><a href="<?= site_url('login')?>" >Sign in</a></li>
                <li><a href="<?php echo site_url(); ?>contact">Contact</a></li>
                <li><a href="<?php echo site_url(); ?>terms">Terms</a></li>
                <li><a href="<?php echo site_url(); ?>privacy">Privacy</a></li>
                <li><a href="https://recordtime.zendesk.com/hc/en-us/requests/new">Help</a></li>
            <?php } ?>

        </ul>
    </div>
</footer>
<?php //echo date('Y'); ?><?php //echo _l('clients_copyright',get_option('companyname')); ?>
