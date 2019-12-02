<form action="" method="post">


<div class="row">
   <div class="col-sm-1"></div>
   <div class="col-sm-4 mt-130 sign-up-form-containr">
        <div class="col-sm-12  text-center">
         <p class="text-center">Login</p>
            <div class="mt-50"></div>
         <div class="col-sm-12 signup-form">
          <?php
            echo ($this->session->error) ? $this->session->error : '';
            echo ($this->session->success) ? $this->session->success : '';
          ?>
               <div class="form-group">
                  <input type="email" class="form-control" id="email" placeholder="Email" name="email">
                </div>
                <div class="form-group">
                  <input type="password" class="form-control" id="pwd" placeholder="Enter Password" name="password">
                </div>
                <div class="form-group">
                  <input type="submit" class="btn btn-block btn-recording" name="submit">
                </div>
            </div>
        </div>

    </div>
    <div class="col-sm-7 ftr-guy-img"><img src="<?= site_url().template_assets_path(); ?>/images/sign_up_right_img.jpg" alt="Right Image Sign Up" /></div>
  </div>
</div>
</form>
