  <div class="middle-container">
    <div class="banner-image">
      <div class="banner-content">
        <img src="<?= site_url().template_assets_path(); ?>/images/Big Logo-White.png">
      </div>
    </div>
    <div class="page-title box-shadow ProjectsDashboard__Title">
      <div class="container-fluid">
        <h1>Projects</h1>
        <?php if($userdatas['type'] == 1){ ?>
          <a  class="btn" href="<?= site_url(); ?>project/artist_create">
            New Project
            <span class="fas fa-arrow-right fa-w-14"></span>
          </a>
        <?php }else{ ?>
          <!-- <a  class="btn" href="<?= site_url(); ?>project/producer_create">
          New Project
            <span class="fas fa-arrow-right fa-w-14"></span>
          </a> -->
        <?php } ?>     
              
      </div>
    </div>
  </div>

  <div class="modal fade" tabindex="-1" role="dialog" id="paymentModal">
    <form action="/charge" method="post" id="payment-form">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h3>Add Funds</h3>
          </div>
          <div class="modal-body">
            <div class='row'>
              <div class='col-md-12'>
                <script src="https://js.stripe.com/v3/"></script>
                <form action="/charge" method="post" id="payment-form">
                  <div class="form-row inline">
                    <div class='form-group cvc required'>
                      <label for="amount">
                        Payment Amount
                      </label>
                      <input id="paymentAmount" name="amount" placeholder="$" required>
                    </div>
                  </div>
                  <div class="form-row">
                    <label for="card-element">
                      Credit or debit card
                    </label>
                    <div id="card-element">
                      <!-- A Stripe Element will be inserted here. -->
                    </div>
                
                    <!-- Used to display form errors. -->
                    <div id="card-errors" role="alert"></div>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button id="showConfirm">Confirm Payment</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModal">Close</button>
          </div>
        </div>
      </div>
    </form>
  </div>

  <div class="modal fade" tabindex="-1" role="dialog" id="confirmModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h3>Payment Confirmation</h3>
          </div>
          <div class="modal-body">
            You are about to submit a payment in the amount of <span id="payConfirmAmount"></span> using credit card ending in <span id="payConfirmLast4"></span> Press "Submit Payment" below to submit your payment.
          </div>
          <div class="modal-footer">
            <button id="completePayment">Submit Payment</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal" id="closeModal">Cancel</button>
          </div>
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

  <div class="modal fade" tabindex="-1" role="dialog" id="markedModal"> 
    <form action="" method="post" id="marked-form">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h3>Congratulations!</h3>
          </div>
          <div class="modal-body">
            <div class='row'>
              <div class='col-md-12'>
                <p>You’ve finished your project! Before
                    getting your work out there, take a
                    moment to give your feedback on
                    Producer One’s style in the studio.
                </p>
                <div class="rating-container">
                <div class="row">
                  <div class="col-sm-4">
                  </div>
                  <div class="col-sm-8 text-center low-high-image-container">
                    <img src="<?= site_url().template_assets_path(); ?>/images/low-high-image.png">
                  </div>
                </div>
                <input type="hidden" name="project_id" id="project_id" value="">
                <input type="hidden" name="status" id="status" value="1">
                <div class="row">
                  <div class="col-sm-4 pop-left">
                    <h4>Creative</h4>
                  </div>
                  <div class="col-sm-8 low-high-image-container">
                    <label class="creatinv-rating"><input type="radio" name="creative" value="1"><span>1</span></label>
                    <label class="creatinv-rating"><input type="radio" name="creative" value="2"> <span>2</span></label>
                    <label class="creatinv-rating"><input type="radio" name="creative" value="3"><span>3</span></label>
                    <label class="creatinv-rating"><input type="radio" name="creative" value="4"><span>4</span></label>
                    <label class="creatinv-rating"><input type="radio" name="creative" value="5"><span>5</span></label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-4 pop-left">
                    <h4>Candor</h4>
                  </div>
                  <div class="col-sm-8 low-high-image-container">
                    <label class="creatinv-rating"><input type="radio" name="candor" value="1"><span>1</span></label>
                    <label class="creatinv-rating"><input type="radio" name="candor" value="2"> <span>2</span></label>
                    <label class="creatinv-rating"><input type="radio" name="candor" value="3"><span>3</span></label>
                    <label class="creatinv-rating"><input type="radio" name="candor" value="4"><span>4</span></label>
                    <label class="creatinv-rating"><input type="radio" name="candor" value="5"><span>5</span></label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-4 pop-left">
                    <h4>Workload</h4>
                  </div>
                  <div class="col-sm-8 low-high-image-container">
                    <label class="creatinv-rating"><input type="radio" name="workload" value="1"><span>1</span></label>
                    <label class="creatinv-rating"><input type="radio" name="workload" value="2"> <span>2</span></label>
                    <label class="creatinv-rating"><input type="radio" name="workload" value="3"><span>3</span></label>
                    <label class="creatinv-rating"><input type="radio" name="workload" value="4"><span>4</span></label>
                    <label class="creatinv-rating"><input type="radio" name="workload" value="5"><span>5</span></label>
                  </div>
                </div>
                <div class="row">
                  <div class="col-sm-4 pop-left">
                    <h4>Flexibility</h4>
                  </div>
                  <div class="col-sm-8 low-high-image-container">
                    <label class="creatinv-rating"><input type="radio" name="flexibility" value="1"><span>1</span></label>
                    <label class="creatinv-rating"><input type="radio" name="flexibility" value="2"> <span>2</span></label>
                    <label class="creatinv-rating"><input type="radio" name="flexibility" value="3"><span>3</span></label>
                    <label class="creatinv-rating"><input type="radio" name="flexibility" value="4"><span>4</span></label>
                    <label class="creatinv-rating"><input type="radio" name="flexibility" value="5"><span>5</span></label>
                  </div>
                </div>
              </div>
               <textarea rows="5" cols="5" name="feedback"></textarea> 
                                    
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <input type="submit" class="start" name="accept" value="Accept">
            
          </div>
        </div>
      </div>
    </form>
  </div>


<?php //echo "<pre>"; print_r($projects); ?>
  <div class="ProjectsDashboard">
    <div class="ProjectList">
      
      <?php if($userdatas['type'] == 1){ ?>
        <?php if (!empty($projects)){ ?>
          <?php foreach ($projects as $project){ ?>
            <?php if (isset($project['start_date'])): ?>
              <p class="started">Started
                  <?php echo $project['start_date']; ?>
              <p>
              <div class="ProjectItem" style="max-width: 100%;">

            <?php else: ?>
              <div class="ProjectItem" style="max-width: 100%;">
                  
            <?php endif; ?>
                  
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
                    <?php if($project['status'] == 1){ ?>
                      <p><img src="<?= site_url() . template_assets_path(); ?>/images/checked1.png"></button></p>
                    <?php } ?>
                  </div>
                  <div class="col-sm-4">
                    <h4>Basic Overview<h4>
                    <p class="name">- <?php echo $project['songs']; echo " songs"; ?></p>
                    <p class="name">- <?php echo $project['name']; ?></p>
                  </div>
                  <div class="col-sm-4 pdf-change">
                    <button data-toggle="modal" data-target="#paymentModal">Add Funds</button>
                    
                    <?php if(empty($project['producer_id'])){ ?>
                        <a href="<?php echo site_url(); ?>search"><button>Find Producer</button></a>
                    <?php } ?>

                    <?php
                    if($project['status'] != 1){ 
                       if($userdatas['type'] == 1){ ?>
                        <a href="<?php echo site_url(); ?>project/artist_project_edit?project_id=<?php echo $project['project_id']; ?>">
                      <?php }else{ ?>
                        <a href="<?php echo site_url(); ?>project/producer_project_edit?project_id=<?php echo $project['project_id']; ?>">
                      <?php } ?>
                        <?php if(!$project['firstname'] && !$project['lastname']){ ?>
                          <button>Change</button>
                        <?php } ?>
                        </a>
                    <?php } ?>


                    
                     <?php if($project['status'] == 1){ ?>
                      <button data-toggle="modal" data-target="#markedModal">End Project</button>
  				          <?php } ?>
                  </div> 
                </div>
              </div>
        <?php }}
          }else{ ?>
            <?php //echo "<pre>"; print_r($producerprojects); ?>
            <?php if (!empty($producerprojects)){ ?>
          <?php foreach ($producerprojects as $project){ ?>
            <?php if (isset($project['start_date'])): ?>
              <p class="started">Started
                  <?php echo $project['start_date']; ?>
              <p>
              <div class="ProjectItem" style="max-width: 100%;">

            <?php else: ?>
              <div class="ProjectItem" style="max-width: 100%;">
                  
            <?php endif; ?>
                  
                <div class="ProjectItem__Details row">
                
                  <div id="mod" style="display: none;"><?php echo $project['project_id']; ?></div>
                  <div class="col-sm-4">
                  
                      <a href="<?php echo site_url(); ?>project/producer_project_view?project_id=<?php echo $project['project_id']; ?>"><h3><?php echo $project['name']; ?></h3></a>
                        

                    
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
                    <?php if($project['status'] == 1){ ?>
                      <p><img src="<?= site_url() . template_assets_path(); ?>/images/checked1.png"></button></p>
                    <?php } ?>
                  </div>
                  <div class="col-sm-4">
                    <h4>Basic Overview<h4>
                    <p class="name">- <?php echo $project['songs']; echo " songs"; ?></p>
                    <p class="name">- <?php echo $project['name']; ?></p>
                  </div>
                  <div class="col-sm-4 pdf-change">
                    <button data-toggle="modal" data-target="#paymentModal">Add Funds</button>
                


                    
                     
                      <button data-toggle="modal" data-target="#markedModal">End Project</button>
                    
                  </div> 
                </div>
              </div>
        <?php }} } ?>

      

      <?php if($userdatas['type'] == 1){ ?>
        <div class="ProjectItem create" style="max-width: 100%;">
          <div class="ProjectItem--overlay">
            <div class="details">
  		        <?php if($userdatas['type'] == 1){ ?>
                <a href="<?= site_url(); ?>project/artist_create"><img src="<?= site_url() . template_assets_path(); ?>/images/plus.jpg"></a>
              <?php }else{ ?>
                <a href="<?= site_url(); ?>project/producer_create"><img src="<?= site_url() . template_assets_path(); ?>/images/plus.jpg"></a>
              <?php } ?>
              <h3><?php echo "New Project"; ?></h3>

              <?php if($userdatas['type'] == 1){ ?>
                  <a  class="start" href="<?= site_url(); ?>project/artist_create">Start</a>
              <?php }else{ ?>
                  <a  class="start" href="<?= site_url(); ?>project/producer_create">Start</a>
              <?php } ?>
                <!-- <a class="start" href="<?php// echo site_url(); ?>project/create">Start</a> -->
              <h5 style="display: none;"><?php echo "Payment Pending"; ?></h5>
            </div>
          </div>
        </div>
      <?php } ?>

    </div>
  <div>
  
  <script>
    var self = this;

  // Create a Stripe client.
  var stripe = Stripe('pk_test_yt3JpiGWmUvIWuAjlDL4c1Tb00lQvTOM5c');

  // Create an instance of Elements.
  var elements = stripe.elements();

  // Custom styling can be passed to options when creating an Element.
  // (Note that this demo uses a wider set of styles than the guide below.)
  var style = {
    base: {
      color: '#32325d',
      fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
      fontSmoothing: 'antialiased',
      fontSize: '16px',
      '::placeholder': {
        color: '#aab7c4'
      }
    },
    invalid: {
      color: '#fa755a',
      iconColor: '#fa755a'
    }
  };

  // Create an instance of the card Element.
  var card = elements.create('card', {style: style});

  // Add an instance of the card Element into the `card-element` <div>.
  card.mount('#card-element');

  // Handle real-time validation errors from the card Element.
  card.addEventListener('change', function(event) {
    var displayError = document.getElementById('card-errors');
    if (event.error) {
      displayError.textContent = event.error.message;
    } else {
      displayError.textContent = '';
    }
  });

  // Handle confirm click.
  var form = document.getElementById('completePayment');
  form.addEventListener('click', function(event) {
    event.preventDefault();
    stripeTokenHandler();
  });


  // Handle form submission.
  var form = document.getElementById('payment-form');
  form.addEventListener('submit', function(event) {
    event.preventDefault();

    stripe.createToken(card).then(function(result) {
      if (result.error) {
        // Inform the user if there was an error.
        var errorElement = document.getElementById('card-errors');
        errorElement.textContent = result.error.message;
      } else {
        // Send the token to your server.
        console.log(result);
        
        self.token = result.token.id;
        self.amount = $('#paymentAmount').val();
        
        var lastFour = result.token.card.last4;
        
        console.log(result);
        
        $('#payConfirmAmount').text('$'+self.amount);
        $('#payConfirmLast4').text(lastFour);
        
        
        $('#confirmModal').modal('show');
        $('#paymentModal').modal('hide');
      }
    });
  });

  // Submit the form with the token ID.
  function stripeTokenHandler() {

    $.ajax({
      type: "POST",
      url: "",
      data: {token: self.token, amount: self.amount},
      success: function(){
        console.log('success');
        $('#creditAmount').text('$'+amount);
        $('#completeModal').modal('show');
        $('#confirmModal').modal('hide');
        $('.InputContainer input, input').val('');
        var elements = stripe.elements();
      },
      error: function(e){
        console.log(e);
        var errorElement = document.getElementById('card-errors');
        $('#confirmModal').modal('hide');
        $('#paymentModal').modal('show');
        errorElement.textContent = "There was an error processing your credit card. Please check your information and try again or contact your credit card company.";
      }
    });
    // Insert the token ID into the form so it gets submitted to the server
    /*
    var form = document.getElementById('payment-form');
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);

    // Submit the form
    form.submit();
    */
  }
    </script>


<script type="text/javascript">
    $(document).ready(function(){
        $("#marked").click(function(){
            var proval = $('#mod').html();
            $("#project_id").val(proval);
        });
    })
</script>


<style>
  /**
* The CSS shown here will not be introduced in the Quickstart guide, but
* shows how you can use CSS to style your Element's container.
*/
input,
.StripeElement {
  height: 40px;
  padding: 10px 12px;

  color: #32325d;
  background-color: white;
  border: 1px solid transparent;
  border-radius: 4px;

  box-shadow: 0 1px 3px 0 #e6ebf1;
  -webkit-transition: box-shadow 150ms ease;
  transition: box-shadow 150ms ease;
}

input:focus,
.StripeElement--focus {
  box-shadow: 0 1px 3px 0 #cfd7df;
}

.StripeElement--invalid {
  border-color: #fa755a;
}

.StripeElement--webkit-autofill {
  background-color: #fefde5 !important;
}

#card-errors{
  margin-top: 5px;
  color: red;
}
</style>