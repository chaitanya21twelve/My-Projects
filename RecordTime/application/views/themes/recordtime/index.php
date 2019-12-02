<?php
echo $head;
if($use_navigation == true){
	get_template_part('navigation');
}
?>

<div class="hamburger-container" style="display:none;">
		<div class="col-sm-6 text-center mt-50">
			<img src="<?= site_url().template_assets_path(); ?>/images/artist-menu-icon.png" alt="Artists" />
			<h4>Artists</h4>
			<ul>
				<li><a href="<?= site_url('artists/overview')?>">Overview</a></li>
				<li><a href="<?= site_url('artists/how-it-works')?>">How it work</a></li>
				<li><a href="<?= site_url('artists/signup')?>">Sign Up</a></li>
			</ul>
		</div>
		<div class="col-sm-6 text-center mt-50">
			<img src="<?= site_url().template_assets_path(); ?>/images/producer-menu-icon.png" alt="Artists" />
			<h4>Producer</h4>
			<ul>
				<li><a href="<?= site_url('producers/overview')?>">Overview</a></li>
				<li><a href="<?= site_url('producers/how-it-works')?>">How it work</a></li>
				<li><a href="#">Sign Up</a></li>
			</ul>
		</div>
	 </div>

<?php echo $view; ?>
		<?php
		echo $footer;
//		echo $scripts;
		?>

</body>
</html>
