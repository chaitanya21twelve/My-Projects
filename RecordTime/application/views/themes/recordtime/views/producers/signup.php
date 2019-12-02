<form action="" method="post">
  <div class="row" id="step-1">
    <div class="col-sm-1"></div>
    <div class="col-sm-1"></div>
    <div class="col-sm-4 mt-130 whats-kind-account">
      <div class="col-sm-12 row text-center">
        <p class="text-center sigup-heading">What kind of accounts would you like to create?</p>
        <div class="mt-50"></div>
        <div class="col-sm-6 text-center account-block"><div class="round-white-border row"><img src="<?= site_url().template_assets_path(); ?>/images/Artist-icon.png" alt="Artist Icon" class="user-type" id="1" /></div> <p class="text-center">Artist</p></div>
        <div class="col-sm-6 text-center account-block"><div class="round-white-border row"><img src="<?= site_url().template_assets_path(); ?>/images/Producer Icon.png" alt="Producer Icon"  class="user-type" id="2" /></div> <p class="text-center">Producer</p></div>
        <img src="<?= site_url().template_assets_path(); ?>/images/sign-up-1d-process.png" alt="Prcess" class="mt-30"  />
        <input type="hidden" name="type" id="type" value="" />
      </div>
      <div class="col-sm-12 mt-20 recording-btn-container" style="display:none"><a href="javascript:void()" id="step-1-submit" class="btn btn-block btn-recording">Start Recording</a></div>
    </div>
    <div class="col-sm-6 ftr-guy-img"><img src="<?= site_url().template_assets_path(); ?>/images/ftr_guy.png" alt="Gitar Gys" /></a></div>
  </div>

  <div class="row" id="step-2" style="display:none;">
    <div class="col-sm-1"></div>
    <div class="col-sm-4 mt-130 sign-up-form-containr">
      <div class="col-sm-12  text-center">
        <p class="text-center">Let’s set up your account.<br>
        We’ll ask you for the rest later.</p>
        <div class="mt-50"></div>
        <div class="col-sm-12 signup-form">
          <div class="form-group">
            <input type="email" class="form-control" id="email" placeholder="Email" name="email">
            <input type="hidden" class="form-control" id="email1" name="email1">
          </div>
          <div class="form-group">
            <div class="col-sm-6 row">
              <input type="text" class="form-control" id="fname" placeholder="First Name" name="firstname">
            </div>
            <div class="col-sm-6 row">
              <input type="text" class="form-control" id="lname" placeholder="Last Name" name="lastname">
            </div>
          </div>
          <div class="form-group">
            <input type="password" class="form-control" id="pwd" placeholder="Create Password" name="password">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" id="city" placeholder="City" name="city">
          </div>
        </div>
        <div id="msg"></div>
        <img src="<?= site_url().template_assets_path(); ?>/images/info2.jpg" alt="info" class="process-img" />
        <button class="btn btn-block btn-recording" id="next">Continue</button>
        <button class="btn btn-block btn-recording" id="step-2-submit" disabled="" style="display: none;">Continue</button>
      </div>
    </div>
    <div class="col-sm-7 ftr-guy-img"><img src="<?= site_url().template_assets_path(); ?>/images/sign_up_right_img.jpg" alt="Right Image Sign Up" /></div>
  </div>

  <div class="row" id="step-3" style="display:none;">
    <div class="col-sm-1"></div>
    <div class="col-sm-4 mt-130 sign-up-form-containr">
      <div class="col-sm-12  text-center">
        <p class="text-center">Tell us about your sound. Don’t worry—we don’t like labels either. </p>
        <div class="mt-50"></div>
        <div class="col-sm-12 signup-form">
          <input type="text" class="form-control" id="genresSound" placeholder="Genres I sound like…" name="genre" style="height:66px;">
          <input type="text" class="form-control" id="artistWorkWith" placeholder="Artists I’ve worked with …" name="artist_work" style="height:66px;">
          <input type="text" class="form-control" id="soundCloudLink" placeholder="SoundCloud Link" name="soundcloud_link" style="height:45px;">
        </div>
        <img src="<?= site_url().template_assets_path(); ?>/images/sign-up-3.png" alt="info"  class="process-img"/>
        <input type="submit" name="submit" class="btn btn-block btn-recording" value="Finish" />
      </div>
    </div>
    <div class="col-sm-7 ftr-guy-img"><img src="<?= site_url().template_assets_path(); ?>/images/sign_up_right_img.jpg" alt="Right Image Sign Up" /></div>
  </div>
  
</form>

<style>
  .error{
    color: red;
    font-weight: bold;
  }
</style>

<script type="text/javascript">
  $(document).ready(function(){
     $('#step-1-submit').click(function(){
        $('#step-1').hide();
        $('#step-2').show();
        var id = $('.round-white-border.active .user-type').attr("id");
        $('#type').val(id);
     });
     $('#step-2-submit').click(function(){
        $('#step-2').hide();
        $('#step-3').show();
     });
  });


  function check_if_exists() {

    var email = $("#email").val();

    $.ajax(
    {
        type:"post",
        url: '<?php echo base_url(); ?>user/email_exists',
        data:{ email:email},
        success:function(response)
        {
            if (response == true) 
            {
                $('#msg').html('<span style="color: red;">Email Id exists.</span>');
            }else{
                $('#msg').remove();
                $('#step-2-submit').removeAttr('disabled');
            }
        }
    });
  }


  $(document).ready(function() {

    $('#next').click(function(e) {

      e.preventDefault();
      var first_name = $('#fname').val();
      var last_name = $('#lname').val();
      var password = $('#pwd').val();

      var email = $("#email").val();
      var cnfp = $("#cnfp").val();
      var city = $("#city").val();
     
      $.ajax(
      {
          type:"post",
          url: '<?php echo base_url(); ?>user/email_exists',
          data:{ email:email},
          success:function(response)
          {
              if (response == true) 
              {
                  //$('#msg').html('<span style="color: red;">Email Id exists.</span>');
                  $('#email').after('<span class="error">This Email is already exists.</span>');
              }else{
                  $('#email1').val("2");
              }
          }
      });

        var email1 = $("#email1").val();
      
        $(".error").remove();
      
        if (email.length < 1) {
          $('#email').after('<span class="error">Email Id is required</span>');
        }

        if (first_name.length < 1) {
          $('#fname').after('<span class="error">First Name is required</span>');
        }
        if (last_name.length < 1) {
          $('#lname').after('<span class="error">Last Name is required</span>');
        }

        if (password.length < 5) {
          $('#pwd').after('<span class="error">Min 6 character Password is required</span>');
        }

        if (cnfp.length != password.length) {
          $('#cnfp').after('<span class="error">Please Enter Same Password</span>');
        }

        if (city.length < 1) {
          $('#city').after('<span class="error">City is required</span>');
        }

        if(first_name.length > 1 && last_name.length > 1 && email1 > 1 && password.length > 5 && cnfp.length == password.length && city.length > 1){
         
          $("#step-2-submit").trigger("click");
          
        }
     
    });

  });
  
</script>
