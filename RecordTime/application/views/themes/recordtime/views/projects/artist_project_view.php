<?php 	$user_id = $this->session->userdata['userid']; 
		$project_id = $_GET['project_id'];

		//echo "<pre>"; print_r($projectdetails); 
?>
<div class="middle-container">
	<div class="banner-image">
		<div class="banner-content">
			<img src="<?= site_url().template_assets_path(); ?>/images/Big Logo-White.png">
		</div>
	</div>
	<div class="page-title box-shadow">
		<div class="container-fluid">
			<div id="title-1"><h1><?php echo $projectdetails['name']; ?></h1></div>
            <div id="title-4" style="display:none;"><h1>Project―Summary</h1></div>
		</div>
	</div>
</div>

<div class="FormErrors">
	<?php echo validation_errors(); ?>
</div>

<?php //echo form_open('index.php/project/create'); ?>
	<form action="" method="post" enctype="multipart/form-data">
		<div id="project-artist">
			<div class="container new-project-container-padding" id="step-1">
				<div class="row project-inner-section">
					<div class="col-md-4">
						<div class="project-details-container">
							<div class="new-project-section-title box-shadow white-bg same-height">
								<h3>What will this project be called?</h3>
								<p>Don’t worry—this isn’t official. </p>
								<p>It’ll just help you identify it on RecordTime.</p>
							</div>
							<div class="project-section-input-box">
								<input type="text" name="project_name" value="<?php echo $projectdetails['name']; ?>" readonly />
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="project-details-container">
							<div class="new-project-section-title box-shadow white-bg same-height">
								<h3>What's your budget per song?</h3>
								<p>This will help us find you producers in your price range.</p>
							</div>
					      	<div class="project-section-input-box doller-sign-textbox">
					        	<input type="text" name="budget" value="$<?php echo $projectdetails['budget']; ?>" readonly />
					      	</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="project-details-container">
							<div class="new-project-section-title box-shadow white-bg same-height">
								<h3>How many songs would you like to record.? </h3>
								<p>You can always change this number later on. </p>
							</div>
							<div class="project-section-dropdown-box">
								<div class="custom-select">
									<input type="text" value="<?php echo $projectdetails['songs']; ?>" readonly />
									
									<!-- <select name="songs" style="display: block;">
										<option value="1">1</option>
										<option value="2">2</option>
										<option value="3">3</option>
										<option value="4">4</option>
										<option value="5">5</option>
										<option value="6">6</option>
										<option value="7">7</option>
										<option value="8">8</option>
										<option value="9">9</option>
										<option value="10">10</option>
										<option value="11">11</option>
										<option value="12">12</option>
										<option value="13">13</option>
										<option value="14">14</option>
										<option value="15">15</option>
										<option value="16">16</option>
										<option value="17">17</option>
										<option value="18">18</option>
										<option value="19">19</option>
										<option value="20">20</option>
										<option value="21">21</option>
										<option value="22">22</option>
										<option value="23">23</option>
										<option value="24">24</option>
										<option value="25">25</option>
									</select> -->
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="container new-project-container-padding" id="step-2">
				<div class="row project-inner-section">
					<div class="col-md-4">
						<div class="project-details-container">
							<div class="new-project-section-title box-shadow white-bg same-height">
								<h3>When do you want it done?</h3>
								<p>Note that projects lasting more than 90 days will need to be completed in sections.</p>
							</div>
							<div class="project-section-input-box doller-sign-textbox" style="position: relative;">
								<input type="text" name="complete_time" class="date" id="datepicker1" value="<?php echo $projectdetails['complete_time']; ?>" readonly />
								<!-- <input type="date" name="complete_time">
								<i class="fa fa-calendar" style="font-size:24px; position: absolute; top: 0; right: 28%; margin-top:11px;"></i> -->
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="project-details-container">
							<div class="new-project-section-title upload-file-height-auto box-shadow white-bg same-height">
								<h3>Show us what you've got.</h3>
								<p>Upload Mp3 files of demos you plan to record. These will only be shared with producers you
								select</p>
							</div>
				            <div class="project-section-upload">
				              <?php if(!empty($projectdetails['doc_name'])){ ?>
				              <div class="btn btn-default">
				                <a href="<?php echo site_url(); ?>assets/themes/recordtime/project_files/<?php echo $projectdetails['doc_name']; ?>" target="_blank"><span><b><?php echo $projectdetails['doc_name']; ?></b></span></a>

				              </div>
				              <?php }else{ ?>
				               	No Files found.
				               <?php } ?>

				            </div>
						</div>
					</div>
					<div class="col-md-4">
						<?php $criteria = explode(",", $projectdetails['criteria']);
						
//print_r($projectdetails['criteria']);
						 ?>
						<div class="project-details-container">
							<div class="input_fields_wrap_player new-project-section-title new-project-section-checkbox same-height" style="overflow-y: auto; height: 300px;">
								<div class="box-shadow white-bg player-inner">
						            <ul>
						            	<?php foreach ($criteria as $cr) { ?>
						            		<?php if($cr == 1){?>
								                <li>
								                  <div class="checkbox-text">
								                    <p>Are you willing to travel to work with producers?</p>
								                  </div>
								                  <div class="input_wrapper">
								                    	<input class="switch_4" type="checkbox" checked="checked" value="1" name="criteria[]" disabled="disabled">
								                	
								                    <i class="fa fa-check is_checked" aria-hidden="true"></i>
								                    <i class="fa fa-times is_unchecked" aria-hidden="true"></i>
								                  </div>
								                </li>
								            <?php } ?>
								            <?php if($cr == 2){?>
								                <li>
								                  <div class="checkbox-text">
								                    <p>Do you want to record any cover songs?</p>
								                  </div>
								                  <div class="input_wrapper">
								                    <!-- <input class="switch_4" type="checkbox" value="2" name="criteria[]"> -->
								                    <input class="switch_4" type="checkbox" checked="checked" value="2" name="criteria[]" disabled="disabled">
								                    <i class="fa fa-check is_checked" aria-hidden="true"></i>
								                    <i class="fa fa-times is_unchecked" aria-hidden="true"></i>
								                  </div>
								                </li>
							                <?php } ?>
							                <?php if($cr == 3){?>
								                <li>
								                  <div class="checkbox-text">
								                    <p>Do you want to collaborate with songwriters?</p>
								                  </div>
								                  <div class="input_wrapper">
								                  	<input class="switch_4" type="checkbox" checked="checked" value="3" name="criteria[]" disabled="disabled">
								                    <!-- <input class="switch_4" type="checkbox" value="3" name="criteria[]"> -->
								                    <i class="fa fa-check is_checked" aria-hidden="true"></i>
								                    <i class="fa fa-times is_unchecked" aria-hidden="true"></i>
								                  </div>
								                </li>
							                <?php } ?>
						            	<?php } ?>
						            </ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
