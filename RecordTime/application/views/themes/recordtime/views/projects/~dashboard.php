<style>

    .start {
        padding: 15px 55px 15px 54px;
        background: #337ab7;
        color: #fff;
        font-size: 20px;
        border: 2px solid white;
    }

    .ProjectItem .details h3 {
        color: #fff !important;
        margin-bottom: 25px;
        font-size: 32px;
        font-weight: bold;
    }

    .ProjectItem .details h5 {
        color: #fff !important;
        /*margin-bottom: 25px;*/
        /*font-size: 32px;*/
        /*font-weight: bold;*/
        padding: 17px;
    }

    .ProjectItem .details img {
        margin: 13px 0px 0px 0px;
        width: 33px;
        height: auto;
    }
    
    .new-project-title .btn {
		padding: 15px 30px;
		border: 2px solid #fff;
		top: 3em;
		width: 12%;
	}
	
	.middle-part .ProjectList {
		width: 95%;
	}
	
	.middle-part .ProjectItem {
		height: 16em;
		width: 94vw;
		padding: 35px;
		background: #FFFFFF;
	}
	
	.middle-part .ProjectList .started {
		margin-top: 2em;
	}
	
	.middle-part .ProjectItem__Details {
		position: static;
	}
	
	.middle-part .first-part img {
		height: 11em;
		margin: 0;
	}
	
	.middle-part .second-part h3 {
		font-size: 45px;
		margin-top: 10px;
	}
	
	.middle-part .third-part h4 {
		font-size: 24px;
	}
	
	.four-part button {
		width: 145px;
		height: 4em;
		border: 2px solid #707070;
	}
	
	@media (max-width:1224px) {
		.new-project-title .btn {
			width: auto;
		}
	}
	
	@media (min-width:768px) and (max-width:991px) {
		.middle-part .first-part img {
			height: auto;
		}
	}
	
	@media (max-width:767px) {
		.middle-part .ProjectItem {
			height: auto;
		}
	}
</style>

<div class="middle-container">
  <div class="banner-image">
     <div class="banner-content">
        <img src="<?= site_url().template_assets_path(); ?>/images/Big Logo-White.png">
     </div>
  </div>
  <div class="page-title box-shadow ProjectsDashboard__Title">
     <div class="container-fluid">
        <h1>Projects</h1>
        <a  class="btn" href="<?= site_url(); ?>project/create">
            New Project
            <span class="fas fa-arrow-right fa-w-14"></span>
        </a>
     </div>
  </div>
</div>

<div class="modal fade" tabindex="-1" role="dialog" id="paymentModal">
  <form action="/charge" method="post" id="payment-form">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3>Add Credits</h3>
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

<div class="ProjectsDashboard container">
    <div class="ProjectList">
        <?php if (!empty($projects)){ ?>
        <?php foreach ($projects as $project): ?>

        <?php if (isset($project['start_date'])): ?>
        <p class="started">Started
            <?php echo $project['start_date']; ?>
        <p>
        <div class="ProjectItem" style="max-width: 100%;">

            <?php else: ?>
            <div class="ProjectItem" style="max-width: 100%;">
                <!--              <div class="ProjectItem--overlay">-->
                <!--                <div class="details">-->
                <!--                  <h3>--><?php //echo $project['name']; ?><!--</h3>-->
                <!--                    <a class="start" href="-->
                <? //= site_url(); ?><!--index.php/project/start/-->
                <?php //echo $project['project_id']; ?><!--">Start</a>-->
                <!--                </div>-->
                <!--              </div>-->
                <?php endif; ?>
                
                


                <div class="ProjectItem__Details row">
                    <div class="col-sm-2">
                        <?php if (!empty($project['profile_pic']) && isset($project['profile_pic'])) { ?>
                            <img src="<?= site_url() . template_assets_path(); ?>/users/<?php echo $project['profile_pic']; ?>">
                        <?php } else { ?>
                            <img src="<?= site_url(); ?>assets/images/user-placeholder.jpg"/>
                        <?php } ?>
                    </div>
                    <div class="col-sm-3">
                        <h3><?php echo $project['name']; ?></h3>
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
              <div class="col-sm-3">
                <h4>Basic Overview<h4>
                <p class="name">- <?php echo $project['songs']; echo " songs"; ?></p>
                <p class="name">- <?php echo $project['name']; ?></p>
              </div>
              <div class="col-sm--3 pdf-change">
                <button data-toggle="modal" data-target="#paymentModal">Add Credits</button>
                <button>Change</button>
              </div> 
            </div>
        </div>


        <?php endforeach; ?>
        <?php } ?>
            <div class="ProjectItem" style="max-width: 100%; height: 13em;">
              <div class="ProjectItem--overlay">
                <div class="details">
                    <img src="<?= site_url() . template_assets_path(); ?>/images/plus.jpg">
                  <h3><?php echo "New Project"; ?></h3>
                    <a class="start" href="<?php echo site_url(); ?>project/create">Start</a>
                    <h5><?php echo "Payment Pending"; ?></h5>
                </div>
              </div>
            </div>
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
    error: function(){
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