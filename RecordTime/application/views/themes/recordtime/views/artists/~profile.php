<?php $user_id = $this->session->userdata['userid']; 

$base_production_expenses = ($user_details[0]['mix_engineer_rate'] + $user_details[0]['mastering_engineer_rate'] + $user_details[0]['programmer_rate']);

$base_rate_per_song = ($user_details[0]['base_production_rate'] + $base_production_expenses);
?>  
<div class="middle-container">
    <div class="banner-image">
      <div class="banner-content">
        <img src="<?= site_url().template_assets_path(); ?>/images/Big Logo-White.png">
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
              		<img src="<?= site_url().template_assets_path(); ?>/users/<?php echo $user_details[0]['profile_pic']; ?>">
				<?php } else{ ?>
					<img src="<?= site_url().template_assets_path(); ?>/images/profucer-profile-image.png">
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
              <p>$<?php echo $user_details[0]['base_rate']; ?> Base Rate</p>
            </div>
            <div class="producer-email-container">
              <a href="http://develop.zaghop.com/~zagdev/recordtime/message?recipient_id=<?php echo $user_id; ?>" class="email-icon">
                <img src="<?= site_url().template_assets_path(); ?>/images/big-mail-icon.png">
              </a>
              <a href="<?= site_url('artists/editprofile')?>" class="check-box-icon1">
				  <img src="https://img.icons8.com/ios/50/000000/pencil.png">
<!--                <img src="<?= site_url().template_assets_path(); ?>/images/Checkbox.png">-->
              </a>
            </div>
          </div>
        </div>  <!----------desktop-------->

      </div>
    </div>
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <div class="col-sm-6">
            <div class="production-philosphy-container profile-card box-shadow">
              <h3>Production Philosphy</h3>
              <p><?php echo nl2br($user_details[0]['philosphy']); ?></p>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="credits-container profile-card box-shadow">
              <h3>Credits</h3>
              <p><?php echo nl2br($user_details[0]['credits']); ?></p>
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
                <p><?php echo nl2br($user_details[0]['skills']); ?></p>
              </div>
              <div class="base-rate-container profile-card box-shadow">
                <h3>Base Rates Per Song</h3>
                <p><?php echo $user_details[0]['base_rate_text']; ?></p>
                <div class="rate-table-container">
                  <table>
                    <tr>
                      <td>
                        <h4>Base Production Rate</h4>
                      </td>
                      <td>
                        <h4>$<?php echo $user_details[0]['base_production_rate']; ?></h4>
                      </td>
                    </tr>
                    <tr>
                      <td>
                        <h4>Base Production Expenses</h4>
                      </td>
                      <td>
                        <h4>$<?php echo $base_production_expenses; ?></h4>
                      </td>
                    </tr>
                    <tr>
                      <table class="small-text-table">
                        <tr>
                          <td>
                            <h5>Mix Engineer</h5>
                          </td>
                          <td>
                            <h5>$<?php echo $user_details[0]['mix_engineer_rate']; ?></h5>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <h5>Mastering Engineer</h5>
                          </td>
                          <td>
                            <h5>$<?php echo $user_details[0]['mastering_engineer_rate']; ?></h5>
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <h5>Programmer</h5>
                          </td>
                          <td>
                            <h5>$<?php echo $user_details[0]['programmer_rate']; ?></h5>
                          </td>
                        </tr>

                      </table>
                    </tr>
                      <tr>
                          <td colspan="2">
                            <div class="table-double-line"></div>
                          </td>
                        </tr>
                  </table>

                  <table class="base-rate-total-table">
                    <tr>
                      <td>
                        <h4><b>Base Rate Per Song</b></h4>
                      </td>
                      <td>
                        <p><span>$<?php echo $base_rate_per_song; ?></span></p>
                      </td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 ">
            <div class="reviews-container profile-card box-shadow" >
            <h3>Reviews</h3>
            <div class="song-track-container">
              <div class="song-track-block">
                <div class="play-btn-container">
                  <a href="##" class="play-btn"><img src="<?= site_url().template_assets_path(); ?>/images/play-icon.png"></a>
                </div>
                <div class="song-track-container">
                  <div class="song-track-img">
                    <img src="<?= site_url().template_assets_path(); ?>/images/song-track-grid.png">
                  </div>
                  <div class="song-details">
                    <p>Song One by <a href="##">Bob Loblaw</a></p>
                  </div>
                </div>
              </div>
              <div class="song-track-block">
                <div class="play-btn-container">
                  <a href="##" class="play-btn"><img src="<?= site_url().template_assets_path(); ?>/images/play-icon.png"></a>
                </div>
                <div class="song-track-container">
                  <div class="song-track-img">
                    <img src="<?= site_url().template_assets_path(); ?>/images/song-track-grid.png">
                  </div>
                  <div class="song-details">
                    <p>Song One by <a href="##">Bob Loblaw</a></p>
                  </div>
                </div>
              </div>
              <div class="song-track-block">
                <div class="play-btn-container">
                  <a href="##" class="play-btn"><img src="<?= site_url().template_assets_path(); ?>/images/play-icon.png"></a>
                </div>
                <div class="song-track-container">
                  <div class="song-track-img">
                    <img src="<?= site_url().template_assets_path(); ?>/images/song-track-grid.png">
                  </div>
                  <div class="song-details">
                    <p>Song One by <a href="##">Bob Loblaw</a></p>
                  </div>
                </div>
              </div>
              <div class="song-track-block">
                <div class="play-btn-container">
                  <a href="##" class="play-btn"><img src="<?= site_url().template_assets_path(); ?>/images/play-icon.png"></a>
                </div>
                <div class="song-track-container">
                  <div class="song-track-img">
                    <img src="<?= site_url().template_assets_path(); ?>/images/song-track-grid.png">
                  </div>
                  <div class="song-details">
                    <p>Song One by <a href="##">Bob Loblaw</a></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="rating-container">
              <div class="row">
                <div class="col-sm-3">
                </div>
                <div class="col-sm-9 low-high-image-container">
                  <img src="<?= site_url().template_assets_path(); ?>/images/low-high-image.png">
                </div>
              </div>
              <div class="row">
                <div class="col-sm-3">
                  <h4>Creative</h4>
                </div>
                <div class="col-sm-9 low-high-image-container">
                  <span class="rating-circle creatinv-rating">1</span>
                  <span class="rating-circle creatinv-rating">2</span>
                  <span class="rating-circle creatinv-rating">3</span>
                  <span class="rating-circle creatinv-rating circle-bg-rd">4</span>
                  <span class="rating-circle creatinv-rating">5</span>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-3">
                  <h4>Candor</h4>
                </div>
                <div class="col-sm-9 low-high-image-container">
                  <span class="rating-circle candor-rating">1</span>
                  <span class="rating-circle candor-rating">2</span>
                  <span class="rating-circle candor-rating circle-bg-rd">3</span>
                  <span class="rating-circle candor-rating">4</span>
                  <span class="rating-circle candor-rating">5</span>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-3">
                  <h4>Workload</h4>
                </div>
                <div class="col-sm-9 low-high-image-container">
                  <span class="rating-circle workload-rating">1</span>
                  <span class="rating-circle workload-rating circle-bg-rd">2</span>
                  <span class="rating-circle workload-rating">3</span>
                  <span class="rating-circle workload-rating">4</span>
                  <span class="rating-circle workload-rating">5</span>
                </div>
              </div>
              <div class="row">
                <div class="col-sm-3">
                  <h4>Flexibility</h4>
                </div>
                <div class="col-sm-9 low-high-image-container">
                  <span class="rating-circle flexibility-rating circle-bg-rd">1</span>
                  <span class="rating-circle flexibility-rating">2</span>
                  <span class="rating-circle flexibility-rating">3</span>
                  <span class="rating-circle flexibility-rating">4</span>
                  <span class="rating-circle flexibility-rating">5</span>
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
