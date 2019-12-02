<?php $user_id = $this->session->userdata['userid']; ?>
<div id="rt-profile">
	<div class="middle-container">
		<div class="banner-image">
			<div class="banner-content">
				<img src="<?= site_url().template_assets_path(); ?>/images/Big Logo-White.png">
			</div>
		</div>
		<div class="page-title box-shadow">
			<div class="container-fluid">
				<h1>Edit Soundcloud Links</h1>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="container">
					
					<form method="post" action="" enctype="multipart/form-data">
						<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
						
						<div class="col-sm-12">
							
							
							<input type="text" id="song1" name="song1" value="<?php echo $user_details[0]['song1']; ?>" placeholder="Add SoundCloud Link..">
							
							
							<input type="text" id="song2" name="song2" value="<?php echo $user_details[0]['song2']; ?>" placeholder="Add SoundCloud Link..">
							
							
							<input type="text" id="song3" name="song3" value="<?php echo $user_details[0]['song3']; ?>" placeholder="Add SoundCloud Link..">

							
							<input type="text" id="song4" name="song4" value="<?php echo $user_details[0]['song4']; ?>" placeholder="Add SoundCloud Link..">
							
							
							<input type="text" id="song5" name="song5" value="<?php echo $user_details[0]['song5']; ?>" placeholder="Add SoundCloud Link..">
							
						</div>
						
						<div class="col-sm-12 text-center">
							<input type="submit" name="submitreview" value="Submit">
						</div>
				</div>
				</form>
			</div>
		</div>
	</div>
</div>
</div>
</div>
</div>