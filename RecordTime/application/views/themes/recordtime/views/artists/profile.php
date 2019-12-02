<?php $user_id = $this->session->userdata['userid'];
$ID = $user_details[0]['user_id'];
//$base_production_expenses = ($user_details[0]['mix_engineer_rate'] + $user_details[0]['mastering_engineer_rate'] + $user_details[0]['programmer_rate']);

//$base_rate_per_song = ($user_details[0]['base_production_rate'] + $base_production_expenses);

$expense_name = explode(",", $production_rates[0]['expensename']);
$expense_value = explode(",", $production_rates[0]['expensevalue']);
$combine = array_combine($expense_name, $expense_value);

//print_r($user_details);

?>  


<div class="middle-container art-profile">
  <div class="banner-image">
    <div class="banner-content">
      <img src="<?php echo site_url().template_assets_path(); ?>/images/Big Logo-White.png">
    </div>
  </div>
  <div class="page-title box-shadow">
    <div class="container-fluid">
      <h1>My Profile</h1>
    </div>
  </div>
  <div class="producer-contact-details-container box-shadow">
    <div class="container">
      <div class="row desktop-section">
        <div class="col-sm-1"></div>
        <div class="col-sm-4 producer-profile-img-container">
          <div class="producer-profile-img">
            <?php if(!empty($user_details[0]['profile_pic']) && isset($user_details[0]['profile_pic'])){ ?>
            <img src="<?php echo site_url().template_assets_path(); ?>/users/<?php echo $user_details[0]['profile_pic']; ?>">
            <?php } else{ ?>
            <img src="<?php echo site_url().template_assets_path(); ?>/images/profucer-profile-image.png">
            <?php } ?>
          </div>
        </div>
        <div class="col-sm-7 producer-profile-contact-details-container">
          <div class="producer-name">
            <h1><?php echo $user_details[0]['firstname'].' '.$user_details[0]['lastname']; ?></h1>
          </div>
          <div class="producer-type">
            <p><?php echo $user_details[0]['genre']; ?></p>
          </div>
          <div class="producer-city">
            <p><?php echo $user_details[0]['city']; ?>, <?php echo $user_details[0]['state']; ?></p>
          </div>
          <div class="producer-base-rate">
            <p>Base Rate: $<?php echo $production_rates[0]['base_rate']; ?></p>
          </div>
          <div>
            <p><strong>Your current credits: $<?php echo $credits; ?></strong></p>
          </div>
          <div class="producer-email-container">
            <?php if($ID == $user_id){ ?>
            <a href="<?php echo site_url(); ?>message?recipient_id=<?php echo $user_id; ?>" class="email-icon">
              <img src="<?php echo site_url().template_assets_path(); ?>/images/big-mail-icon.png">
            </a>
            <?php }else{ ?>
            <a href="<?php echo site_url(); ?>message?recipient_id=<?php echo $user_id; ?>" class="email-icon">
              <img src="<?php echo site_url().template_assets_path(); ?>/images/big-mail-icon.png">
            </a>
            <?php } ?>
            <a href="<?php echo site_url('artists/editprofile')?>" class="check-box-icon1" style="display: none;">
              <img src="https://img.icons8.com/ios/50/000000/pencil.png">
              <!--                <img src="<?php //echo site_url().template_assets_path(); ?>/images/Checkbox.png">-->
            </a>
          </div>
        </div>
        </div>  <!----------desktop-------->
      </div>
    </div>
    <div class="container" style="display: none;">
      <div class="row">
        <div class="col-sm-12">
          <div class="col-sm-6">
            <div class="production-philosphy-container profile-card box-shadow">
              <h3>Production Philosphy</h3>
              <p><?php if(!empty($user_details[0]['philosphy'])){ echo nl2br($user_details[0]['philosphy']); } ?></p>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="credits-container profile-card box-shadow">
              <h3>Credits</h3>
              <p><?php if(!empty($user_details[0]['credits'])){ echo nl2br($user_details[0]['credits']); } ?></p>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-12">
          <div class="col-sm-6">
            <div class="">
              <div class="skill-container profile-card box-shadow">
                <h3>Skills and Specialties</h3>
                <p><?php if(!empty($user_details[0]['skills'])){ echo nl2br($user_details[0]['skills']); } ?></p>
              </div>
              <div class="base-rate-container profile-card box-shadow" style="display: none;">
                <a href="<?= site_url('artists/editproductionrates')?>" class="" style="float: right; width: 6%; text-align: right;">
                  <img src="https://img.icons8.com/ios/50/000000/pencil.png" style="width: 40%;">
                </a>
                <h3>Base Rates Per Song</h3>
                <p>This is the minimum rate per song for this producer. Rates may change with the addition of other studio professionals or musicians. Contact this producer to lock in your rate. </p>
                <div class="rate-table-container">
                  <table>
                    <tr>
                      <td>
                        <h4>Base Production Rate</h4>
                      </td>
                      <td>
                        <h4>$<?php echo $production_rates[0]['base_rate']; ?></h4>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <h4>Base Production Expenses</h4>
                      </td>
                      <td>
                        <h4>$<?php echo $production_rates[0]['project_expenses']; ?></h4>
                      </td>
                    </tr>
                    <tr>
                      <table class="small-text-table">
                        <?php foreach ($combine as $key=>$value) { ?>
                        <tr>
                          <td>
                            <h5><?php echo $key; ?></h5>
                          </td>
                          <td>
                            <h5>$<?php echo $value; ?></h5>
                          </td>
                        </tr>
                        <?php } ?>
                      </table>
                    </tr>
                    <tr>
                      <td colspan="2">
                        <div class="table-double-line"></div>
                      </td>
                    </tr>
                  </table>
                  <?php $base_rate = $production_rates[0]['base_rate'] + $production_rates[0]['project_expenses']; ?>
                  <table class="base-rate-total-table">
                    <tr>
                      <td>
                        <h4><b>Base Rate Per Song</b></h4>
                      </td>
                      <td>
                        <p><span>$<?php echo $base_rate; ?></span></p>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <h4><b>Recordtime service fee</b></h4>
                      </td>
                      <td>
                        <p><span>($70)</span></p>
                      </td>
                    </tr>
                  </table>
                  <div class="table-single-line"></div>
                  <table class="base-rate-total-table">
                    <tr>
                      <td>
                        <h4><b>Your base budget</b></h4>
                      </td>
                      <td>
                        <p><span>$<?php echo $base_rate- 70; ?></span></p>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="reviews-container profile-card box-shadow" >
              <?php if(!empty($user_details[0]['song1'])){ ?>
                <a href="<?= site_url('artists/editsound')?>" class="" style="float: right; width: 6%; text-align: right;">
                  <img src="https://img.icons8.com/ios/50/000000/pencil.png" style="width: 40%;">
                </a>
              <?php } ?>
              
              <h3>Reviews</h3>

              <div class="song-track-container">
                <div class="song-track-block">
                  <?php
                    if(!empty($user_details[0]['song1'])){
                      $url= $user_details[0]['song1'];
                      $getValues=file_get_contents('http://soundcloud.com/oembed?format=js&url='.$url.'&iframe=true');
                      $decodeiFrame=substr($getValues, 1, -2);
                      $jsonObj = json_decode($decodeiFrame);
                      echo str_replace('height="400"', 'height="140"', $jsonObj->html);
                    }
                  ?>
               
                </div>
                <div class="song-track-block">
                  <?php
                    if(!empty($user_details[0]['song2'])){
                      $url1= $user_details[0]['song2'];
                      $getValues1=file_get_contents('http://soundcloud.com/oembed?format=js&url='.$url1.'&iframe=true');
                      $decodeiFrame1=substr($getValues1, 1, -2);
                      $jsonObj1 = json_decode($decodeiFrame1);
                      echo str_replace('height="400"', 'height="140"', $jsonObj1->html);
                    }
                  ?>
                </div>
                <div class="song-track-block">
                  <?php
                    if(!empty($user_details[0]['song3'])){
                      $url1= $user_details[0]['song3'];
                      $getValues1=file_get_contents('http://soundcloud.com/oembed?format=js&url='.$url1.'&iframe=true');
                      $decodeiFrame1=substr($getValues1, 1, -2);
                      $jsonObj1 = json_decode($decodeiFrame1);
                      echo str_replace('height="400"', 'height="140"', $jsonObj1->html);
                    }
                  ?>
                </div>
                <div class="song-track-block">
                  <?php
                    if(!empty($user_details[0]['song4'])){
                      $url1= $user_details[0]['song4'];
                      $getValues1=file_get_contents('http://soundcloud.com/oembed?format=js&url='.$url1.'&iframe=true');
                      $decodeiFrame1=substr($getValues1, 1, -2);
                      $jsonObj1 = json_decode($decodeiFrame1);
                      echo str_replace('height="400"', 'height="140"', $jsonObj1->html);
                    }
                  ?>
                </div>
                <div class="song-track-block">
                  <?php
                    if(!empty($user_details[0]['song5'])){
                      $url1= $user_details[0]['song5'];
                      $getValues1=file_get_contents('http://soundcloud.com/oembed?format=js&url='.$url1.'&iframe=true');
                      $decodeiFrame1=substr($getValues1, 1, -2);
                      $jsonObj1 = json_decode($decodeiFrame1);
                      echo str_replace('height="400"', 'height="140"', $jsonObj1->html);
                    }
                   ?>
                </div>
              
              </div>
              <!-- class = rating-container -->
              <div class="">
                <div class="row">
                  <div class="col-md-4">
                  </div>
                  <div class="col-md-8 low-high-image-container">
                    <img src="<?= site_url().template_assets_path(); ?>/images/low-high-image.png">
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                  	<div class="row">
	                    <h4>Creative 
	                    	<span class="help-tip">
	                    		<p><b>1 is Low Involvement</b><br> 
								Producer primarily keeps musicians on task but allows the artist to call most shots. Best for artists with a good deal of studio experience.
								<br><br>
								<b>5 is High Involvement</b><br>
								Producer has creative control over virtually all aspects of production. Best for artists who want to push their song in a new direction and those with little studio experience. 
								</p>
	                    	</span>
	                	</h4>
	                </div>
                    <?php if(!empty($user_details[0]['creative'])){ $creative = $user_details[0]['creative']; }else{ $creative = 0; };
                          if(!empty($user_details[0]['candor'])){ $candor = $user_details[0]['candor']; }else{ $candor = 0; };
                          if(!empty($user_details[0]['workload'])){ $workload = $user_details[0]['workload']; }else{ $workload = 0; };
                          if(!empty($user_details[0]['flexibility'])){ $flexibility = $user_details[0]['flexibility']; }else{ $flexibility = 0; };
                     ?>
                  </div>
                  <div class="col-md-8 low-high-image-container">
                    <span class="rating-circles creatinv-rating <?php if($creative == 1){ echo "circle-bg-rd"; } ?>">1</span>
                    <span class="rating-circles creatinv-rating <?php if($creative == 2){ echo "circle-bg-rd"; } ?>">2</span>
                    <span class="rating-circles creatinv-rating <?php if($creative == 3){ echo "circle-bg-rd"; } ?>">3</span>
                    <span class="rating-circles creatinv-rating <?php if($creative == 4){ echo "circle-bg-rd"; } ?>">4</span>
                    <span class="rating-circles creatinv-rating <?php if($creative == 5){ echo "circle-bg-rd"; } ?>">5</span>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                  		<div class="row">
		                    <h4>Assertion 
		                    	<span class="help-tip">
		                    		<p><b>1 is Low Assertiveness</b><br> 
									Producer is very sensitive to the feelings of an artist and asks for corrections delicately.
									<br><br>
									<b>5 is High Assertiveness</b><br>
									Producer is very direct with the Artist and asks for corrections with emphasis on honest direction. 
									</p>
		                    	</span>
		                    </h4>
		                </div>
                  	</div>
                  <div class="col-md-8 low-high-image-container">
                    <span class="rating-circles candor-rating <?php if($candor == 1){ echo "circle-bg-rd"; } ?>">1</span>
                    <span class="rating-circles candor-rating <?php if($candor == 2){ echo "circle-bg-rd"; } ?>">2</span>
                    <span class="rating-circles candor-rating <?php if($candor == 3){ echo "circle-bg-rd"; } ?>">3</span>
                    <span class="rating-circles candor-rating <?php if($candor == 4){ echo "circle-bg-rd"; } ?>">4</span>
                    <span class="rating-circles candor-rating <?php if($candor == 5){ echo "circle-bg-rd"; } ?>">5</span>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-4">
                    	<div class="row">
		                    <h4>Workload
		                    	<span class="help-tip">
		                    		<p><b>1 is Small Workload</b><br> 
									Producer only makes Artist come in for parts in which the Artist is to contribute directly to the song. Producers on this end of the spectrum also require fewer takes typically.
									<br><br>
									<b>5 is Large Workload</b><br>
									Producer requires Artist to attend virtually all stages of the recording process and requests many takes for all of the Artist’s contributions. 
									</p>
		                    	</span>
		                    </h4>
		                </div>
                  </div>
                  <div class="col-md-8 low-high-image-container">
                    <span class="rating-circles workload-rating <?php if($workload == 1){ echo "circle-bg-rd"; } ?>">1</span>
                    <span class="rating-circles workload-rating <?php if($workload == 2){ echo "circle-bg-rd"; } ?>">2</span>
                    <span class="rating-circles workload-rating <?php if($workload == 3){ echo "circle-bg-rd"; } ?>">3</span>
                    <span class="rating-circles workload-rating <?php if($workload == 4){ echo "circle-bg-rd"; } ?>">4</span>
                    <span class="rating-circles workload-rating <?php if($workload == 5){ echo "circle-bg-rd"; } ?>">5</span>
                  </div>
                </div>
                <div class="row">
                  	<div class="col-md-4">
	                  	<div class="row">
		                    <h4>Flexibility
		                    	<span class="help-tip">
		                    		<p><b>1 is Low Flexibility</b><br> 
									Producer sticks to the terms of the recording contract and the agreed upon production and artistic styles requested by the Artist. These producers are best for Artists wishing to finish on time and under budget.
									<br><br>
									<b>5 is High Flexibility</b><br>
									Producer is open to changes in creative direction during the recording and is open to amending the recording terms to push back deadlines, adjust pricing, or change session style as needed. These Producers are best for Artists who want to explore different approaches and styles with less regard for time of completion or additional costs. 
									</p>
		                    	</span>
		                    </h4>
		                </div>
                  	</div>
                  	<div class="col-md-8 low-high-image-container">
                    	<span class="rating-circles flexibility-rating <?php if($flexibility == 1){ echo "circle-bg-rd"; } ?>">1</span>
                    	<span class="rating-circles flexibility-rating <?php if($flexibility == 2){ echo "circle-bg-rd"; } ?>">2</span>
                    	<span class="rating-circles flexibility-rating <?php if($flexibility == 3){ echo "circle-bg-rd"; } ?>">3</span>
                    	<span class="rating-circles flexibility-rating <?php if($flexibility == 4){ echo "circle-bg-rd"; } ?>">4</span>
                    	<span class="rating-circles flexibility-rating <?php if($flexibility == 5){ echo "circle-bg-rd"; } ?>">5</span>
                  	</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
