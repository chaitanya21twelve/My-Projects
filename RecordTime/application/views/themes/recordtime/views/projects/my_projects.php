<style>
  .ProjectItem .pdf-change .acpt {
      display: block;
      background-color: white;
      width: 160px;
      margin-top: 1em;
      height: 4em;
  }
</style> 


<?php $user_id = $this->session->userdata['userid']; ?>

<div class="middle-container">
  <div class="banner-image">
    <div class="banner-content">
      <img src="<?= site_url().template_assets_path(); ?>/images/Big Logo-White.png">
    </div>
  </div>
</div>
<div class="modal fade" tabindex="-1" role="dialog" id="completeModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3>Payment Received</h3>
      </div>
      <div class="modal-body">
        Your credit card transaction was successful. A credit of <strong><span id="creditAmount"></span></strong> has been added to your account.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="ProjectsDashboard">
  <div class="ProjectList">
    <?php if (!empty($projects)){ ?>
    <?php foreach ($projects as $project){ ?>
    
    <div class="ProjectItem" style="max-width: 100%;">
      
      <div class="ProjectItem__Details row">
        <div class="col-sm-3" style="display: none;">
          <?php if (!empty($project['profile_pic']) && isset($project['profile_pic'])) { ?>
          <img class="responsive-img" src="<?= site_url() . template_assets_path(); ?>/users/<?php echo $project['profile_pic']; ?>">
          <?php } else { ?>
          <img class="responsive-img" src="<?= site_url(); ?>assets/images/user-placeholder.jpg"/>
          <?php } ?>
        </div>
        <div id="mod" style="display: none;"><?php echo $project['project_id']; ?></div>
        <div class="col-sm-4">
          <?php if($userdatas['type'] == 1){ ?>
          <a href="<?php echo site_url(); ?>project/artist_project_view?project_id=<?php echo $project['project_id']; ?>"><h3><?php echo $project['name']; ?></h3></a>
          <?php }else{ ?>
          <a href="<?php echo site_url(); ?>project/producer_project_view?project_id=<?php echo $project['project_id']; ?>"><h3><?php echo $project['name']; ?></h3></a>
          <?php } ?>
          
          <p class="end_date">
            <?php echo "Ends " ?>
            <?php echo date($project['end_date']);?>
          </p>
          <p class="producer">
            <?php echo $project['firstname'];
            echo " ";
            echo $project['lastname'];
            ?>
          </p>
          <p class="cost">
            <?php
            echo $project['project_cost'];
            ?>
          </p>
          
        </div>
        <div class="col-sm-4">
          <h4>Basic Overview<h4>
          <p class="name">- <?php echo $project['songs']; echo " songs"; ?></p>
          <p class="name">- <?php echo $project['name']; ?></p>
        </div>
        <div class="col-sm-4 pdf-change">
          <form method="post" id="accept">
            <input type="hidden" name="project_id" value="<?php echo $project['project_id']; ?>">
            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
            <input type="submit" class="acpt" name="acceptproject" value="Accept">
          </form>
        </div>
      </div>
    </div>
    <?php }} ?>
  </div>
<div>