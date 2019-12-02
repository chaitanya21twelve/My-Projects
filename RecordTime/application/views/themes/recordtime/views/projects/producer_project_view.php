<div class="middle-container">
	<div class="banner-image">
		<div class="banner-content">
			<img src="<?php echo site_url().template_assets_path(); ?>/images/Big Logo-White.png">
		</div>
	</div>
	<div class="page-title box-shadow">
		<div class="container-fluid">
			<div id="title-1"><h1><?php echo $projectdetails['name']; ?></h1></div>
		</div>
	</div>
</div>

<?php
	$songs = explode(",", $projectdetails['songs_cost']);
	$players = explode(",", $projectdetails['players']);
 ?>
<form action="" method="post" enctype="multipart/form-data">
	<div id="project-producer">
		<div class="container new-project-container-padding" id="step-1">
			<div class="row project-inner-section">
				<div class="col-md-5">
					<div class="project-details-container">
						<div class="new-project-section-title box-shadow white-bg same-height">
							<h3>What does your client want this
	            project to be called?</h3>
							
						</div>
						<div class="project-section-input-box">
							<input type="text" name="name" value="<?php echo $projectdetails['name']; ?>" readonly/>
						</div>
					</div>
				</div>
				<div class="col-md-5">
					<div class="project-details-container">
						<div class="new-project-section-title box-shadow white-bg same-height">
							<h3>When will you have it done?</h3>
							<p>Note that projects lasting more than 90 days will need to be completed in sections, and completion date will push back with each day without artist payment.</p>
						</div>
						
						<div class="project-section-input-box doller-sign-textbox" style="position: relative;">
							<input type="text" name="complete_time" class="date" id="datepicker1" value="<?php echo $projectdetails['complete_time']; ?>" readonly />
							
						</div>
					</div>
				</div>
				
			</div>
		</div>
		<div class="container new-project-container-padding" id="step-2">
			<div class="row project-inner-section">
				<div class="col-md-5">
					<div class="project-details-container">
						<div class="new-project-section-title box-shadow white-bg same-height">
							<h3>Songs to be recorded </h3>
							<p>List all additional expenses over your rate of $500 per song. You must provide proof of payment to be reimbursed within 48 hours. </p>
						</div>
					</div>
				</div>
				<div class="col-md-5">
					<div class="project-details-container">
						<div class="input_fields_wrap new-project-section-title same-height" style="overflow-y: scroll; height: 300px;">
							<?php $i=1; foreach ($songs as $song) { ?>
								<div class="box-shadow white-bg input_fields_inner">
									<h3>Song<?php echo $i; ?></h3><input type="text" name="songcost[]" value="<?php echo $song; ?>" readonly>
								</div>
							<?php $i++; } ?>
						</div>
						
					</div>
				</div>
				
			</div>
		</div>
		<div class="container new-project-container-padding" id="step-3">
			<div class="row project-inner-section">
				<div class="col-md-5">
					<div class="project-details-container">
						<div class="new-project-section-title upload-file-height-auto box-shadow white-bg same-height">
							<h3>List any additional musicians or
	                  studio professionals</h3>
							<p>This section serves as a roster for credits and to provide documentation for reimbursement.</p>
						</div>
					</div>
				</div>
				<div class="col-md-5">
					<div class="project-details-container">
						<div class="input_fields_wrap_player new-project-section-title new-project-section-checkbox same-height" style="overflow-y: auto; height: 300px;">
							<?php $j=1; foreach ($players as $player) { ?>
								<div class="box-shadow white-bg player-inner">
									<h3>Player<?php echo $j; ?></h3><input type="text" name="players[]" value="<?php echo $player; ?>" readonly>
								</div>
							<?php $j++; } ?>
						</div>
						
					</div>
				</div>
				
			</div>
		</div>

	</div>
</form>