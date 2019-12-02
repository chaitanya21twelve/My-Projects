<?php $user_id = $this->session->userdata['userid']; 

if(isset($user_details[0]['creative'])){ $creative = $user_details[0]['creative']; }

if(isset($user_details[0]['candor'])){ $candor = $user_details[0]['candor']; }

if(isset($user_details[0]['workload'])){ $workload = $user_details[0]['workload']; }

if(isset($user_details[0]['flexibility'])){ $flexibility = $user_details[0]['flexibility']; }

?>
<style>
	.error {
	    color: orangered;
	    font-weight: 700;
	}
</style>
<div id="rt-profile">
	<div class="middle-container">
		<div class="banner-image">
			<div class="banner-content">
				<img src="<?= site_url().template_assets_path(); ?>/images/Big Logo-White.png">
			</div>
		</div>
		<div class="page-title box-shadow">
			<div class="container-fluid">
				<h1>Edit Profile</h1>
			</div>
		</div>
		<div class="container">
			<div class="row">
				<div class="container">
					<div class="col-sm-12 producer-profile-img-container">
						<div class="producer-profile-img">
							<?php if(!empty($user_details[0]['profile_pic']) && isset($user_details[0]['profile_pic'])){ ?>
							<img src="<?= site_url().template_assets_path(); ?>/users/<?php echo $user_details[0]['profile_pic']; ?>">
							<?php } else{ ?>
							<img src="<?= site_url().template_assets_path(); ?>/images/profucer-profile-image.png">
							<?php } ?>
						</div>
					</div>
					<?php //echo "<pre>"; print_r($user_details); ?>
					<form method="post" action="" enctype="multipart/form-data">
						<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
						<div class="profile-change">
							<label for="profile" class="profile-title">Profile Image</label>
							<input type="file" id="profile_pic" name="profile_pic">
						</div>
						<div class="col-sm-6">
							<label for="fname">First Name</label>
							<input type="text" id="fname" name="fname" value="<?php echo $user_details[0]['firstname']; ?>" placeholder="Your First Name..">
							<div class="error"><?php echo form_error('fname');  ?></div>

							<label for="country">State</label>
							<input type="text" id="state" value="<?php echo $user_details[0]['state']; ?>" name="state" placeholder="Your State..">
							<div class="error"><?php echo form_error('state');  ?></div>

							<label for="city">City</label>
							<input type="text" id="city" value="<?php echo $user_details[0]['city']; ?>" name="city" placeholder="Your City..">
							<div class="error"><?php echo form_error('city');  ?></div>

							<label for="genre">Genres</label>
							<input type="text" id="genre" name="genre" value="<?php echo $user_details[0]['genre']; ?>" placeholder="Your Genres..">
							<div class="error"><?php echo form_error('genre');  ?></div>


							

							<label for="credits">Credits</label>
							<textarea id="credits" name="credits" style="height:200px"><?php echo $user_details[0]['credits']; ?></textarea>
							<div class="error"><?php echo form_error('credits');  ?></div>
							
						</div>
						<div class="col-sm-6">
							
							<label for="lname">Last Name</label>
							<input type="text" id="lname" name="lname" value="<?php echo $user_details[0]['lastname']; ?>" placeholder="Your Last Name..">
							<div class="error"><?php echo form_error('lname');  ?></div>
							
							
							<label for="philosphy">Production Philosphy</label>
							<textarea id="philosphy" name="philosphy" style="height:200px"><?php echo $user_details[0]['philosphy']; ?></textarea>
							<div class="error"><?php echo form_error('philosphy');  ?></div>

							<label for="skills">Skills and Specialties</label>
							<textarea id="skills" name="skills" style="height:245px"><?php echo $user_details[0]['skills']; ?></textarea>
							<div class="error"><?php echo form_error('skills');  ?></div>

							<!-- <label for="city">Reviews</label>
							<div class="producer-review">
								<div class="inner-review">
					            
					                <div class="row">
					                  <div class="col-sm-4">
					                  </div>
					                  <div class="col-sm-8 text-center low-high-image-container">
					                    <img src="<?= site_url().template_assets_path(); ?>/images/low-high-image.png">
					                  </div>
					                </div>
						             
						            <?php if(isset($creative)){ ?>  
						                <div class="row">
						                  <div class="col-sm-4 pop-left">
						                    <h4>Creative</h4>
						                  </div>
						                  <div class="col-sm-8 low-high-image-container">
						                    <label class="creatinv-rating"><input type="radio" name="creative" value="1" <?php echo ($creative== '1') ?  "checked" : "" ;  ?>><span>1</span></label>
						                    <label class="creatinv-rating"><input type="radio" name="creative" value="2" <?php echo ($creative== '2') ?  "checked" : "" ;  ?>> <span>2</span></label>
						                    <label class="creatinv-rating"><input type="radio" name="creative" value="3" <?php echo ($creative== '3') ?  "checked" : "" ;  ?>><span>3</span></label>
						                    <label class="creatinv-rating"><input type="radio" name="creative" value="4" <?php echo ($creative== '4') ?  "checked" : "" ;  ?>><span>4</span></label>
						                    <label class="creatinv-rating"><input type="radio" name="creative" value="5" <?php echo ($creative== '5') ?  "checked" : "" ;  ?>><span>5</span></label>
						                  </div>
						                </div>
					            	<?php } ?>
					            	<?php if(isset($candor)){ ?> 
						                <div class="row">
						                  <div class="col-sm-4 pop-left">
						                    <h4>Candor</h4>
						                  </div>
						                  <div class="col-sm-8 low-high-image-container">
						                    <label class="creatinv-rating"><input type="radio" name="candor" value="1" <?php echo ($candor== '1') ?  "checked" : "" ;  ?>><span>1</span></label>
						                    <label class="creatinv-rating"><input type="radio" name="candor" value="2" <?php echo ($candor== '2') ?  "checked" : "" ;  ?>> <span>2</span></label>
						                    <label class="creatinv-rating"><input type="radio" name="candor" value="3" <?php echo ($candor== '3') ?  "checked" : "" ;  ?>><span>3</span></label>
						                    <label class="creatinv-rating"><input type="radio" name="candor" value="4" <?php echo ($candor== '4') ?  "checked" : "" ;  ?>><span>4</span></label>
						                    <label class="creatinv-rating"><input type="radio" name="candor" value="5" <?php echo ($candor== '5') ?  "checked" : "" ;  ?>><span>5</span></label>
						                  </div>
						                </div>
					                <?php } ?>
					            	<?php if(isset($workload)){ ?> 
						                <div class="row">
						                  <div class="col-sm-4 pop-left">
						                    <h4>Workload</h4>
						                  </div>
						                  <div class="col-sm-8 low-high-image-container">
						                    <label class="creatinv-rating"><input type="radio" name="workload" value="1" <?php echo ($workload== '1') ?  "checked" : "" ;  ?>><span>1</span></label>
						                    <label class="creatinv-rating"><input type="radio" name="workload" value="2" <?php echo ($workload== '2') ?  "checked" : "" ;  ?>> <span>2</span></label>
						                    <label class="creatinv-rating"><input type="radio" name="workload" value="3" <?php echo ($workload== '3') ?  "checked" : "" ;  ?>><span>3</span></label>
						                    <label class="creatinv-rating"><input type="radio" name="workload" value="4" <?php echo ($workload== '4') ?  "checked" : "" ;  ?>><span>4</span></label>
						                    <label class="creatinv-rating"><input type="radio" name="workload" value="5" <?php echo ($workload== '5') ?  "checked" : "" ;  ?>><span>5</span></label>
						                  </div>
						                </div>
					                <?php } ?>
					            	<?php if(isset($flexibility)){ ?> 
						                <div class="row">
						                  <div class="col-sm-4 pop-left">
						                    <h4>Flexibility</h4>
						                  </div>
						                  <div class="col-sm-8 low-high-image-container">
						                    <label class="creatinv-rating"><input type="radio" name="flexibility" value="1" <?php echo ($flexibility== '1') ?  "checked" : "" ;  ?>><span>1</span></label>
						                    <label class="creatinv-rating"><input type="radio" name="flexibility" value="2" <?php echo ($flexibility== '2') ?  "checked" : "" ;  ?>> <span>2</span></label>
						                    <label class="creatinv-rating"><input type="radio" name="flexibility" value="3" <?php echo ($flexibility== '3') ?  "checked" : "" ;  ?>><span>3</span></label>
						                    <label class="creatinv-rating"><input type="radio" name="flexibility" value="4" <?php echo ($flexibility== '4') ?  "checked" : "" ;  ?>><span>4</span></label>
						                    <label class="creatinv-rating"><input type="radio" name="flexibility" value="5" <?php echo ($flexibility== '5') ?  "checked" : "" ;  ?>><span>5</span></label>
						                  </div>
						                </div>
					            	<?php } ?>
					            </div>
				            </div> -->
							
							
							
						</div>
						
						<!-- <div class="col-sm-12">
							<label for="skills">Skills and Specialties</label>
							<textarea id="skills" name="skills" style="height:200px"><?php echo $user_details[0]['skills']; ?></textarea>
							<div class="error"><?php echo form_error('skills');  ?></div>

						</div> -->
						
						<div class="col-sm-12 text-center">
							<input type="submit" name="submit" value="Submit">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>