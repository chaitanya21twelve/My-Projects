<?php $user_id = $this->session->userdata['userid']; ?>

<section id="editproduction">
	<div class="middle-container">
		<div class="banner-image">
			<div class="banner-content">
				<img src="<?= site_url().template_assets_path(); ?>/images/Big Logo-White.png">
			</div>
		</div>
		<div class="page-title box-shadow">
			<div class="container-fluid">
				<div id="title-1">
					<h1>Production Rates</h1>
				</div>
			</div>
		</div>
		<br>
		<div class="page-title box-shadow">
			<div class="container-fluid">
				<div class="col-md-5 title">What is your base production rate per song?</div>
				<div class="col-md-3 box"><span>$</span><input type="text" id="baserates" value="" name="base_rates">
				</div>
				<div class="col-md-4 lastext">Recordtime deduct 10% service fees so choose your rates and calculate accordingly.</div>
			</div>
		</div>
	</div>

	<div class="FormErrors">
		<?php echo validation_errors(); ?>
	</div>

	<form action="" method="post" id="pro_rates" enctype="multipart/form-data">
		<input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
		<div id="project-overview">
			<div class="container new-project-container-padding" id="step-2">
				<div class="row project-inner-section">
					<div class="col-md-4">
						<div class="project-details-container">
							<div class="new-project-section-title box-shadow white-bg same-height">
								<h3>Besides production, what else 
									are you willing to contribute at 
									your base production rates?  </h3>
							</div>
							<input type="hidden" value="" id="baseratesnew" name="base_rate">
							<input type="hidden" id="income_sum" value="" name="project_expenses" readonly="readonly">
							<div class="input_fields_wrap new-project-section-title same-height" style="overflow-y: auto; height: 222px;">
								<div class="box-shadow white-bg input_fields_inner">
									<input type="text" name="instruments[]" style="width: 100%; border: none;">
								</div>
							</div>
							<div class="text-center">
								<img class="add_field_button add_field_button_inst" src="<?= site_url() . template_assets_path(); ?>/images/plus.png">
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="project-details-container">
							<div class="new-project-section-title box-shadow white-bg same-height">
								<h3>List any services you require but can not provide personally. </h3>
								<p>Esitmate the base rates of any additional services you'll require to make a song sound great. </p>
							</div>
							<div class="input_fields_wrap_player new-project-section-title same-height" id="whereEntry" style="overflow-y: auto; height: 230px;">
								<div class="box-shadow white-bg input_fields_inner">
									<h3><input type="text" name="expensename[]" style="width: 100%; border: none;"></h3><span>$</span><input type="text" class="income_count" id="dare_price" name="expensevalue[]">
								</div>
							</div>
							<div class="text-center">
								<img class="add_field_button add_field_button_rates" src="<?= site_url() . template_assets_path(); ?>/images/plus.png">
							</div>
						</div>
					</div>
					<div class="col-md-4">
						<div class="project-details-container">
							<div class="arrow right-arrow box-shadow">
								<!-- <b style="color: #fff; font-size: 25px; padding: 18px">Calculate</b> -->
								<input type="submit" name="calculate" value="Calculate" style="color: #fff; font-size: 25px; padding: 18px; background: red; border: none; font-weight: bold;">
								<a href="javascript:void(0)" id="step-2-submit"><i class="fa fa-arrow-right " aria-hidden="true"></i></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</section>


<script type="text/javascript">
	$( document ).ready( function () {
		var max_fields = 10; //maximum input boxes allowed
		var wrapper = $( ".input_fields_wrap" ); //Fields wrapper
		var add_button = $( ".add_field_button_inst" ); //Add button ID
		var x = 1; //initlal text box count
		var y = 5;

		$( add_button ).click( function ( e ) { //on add input button click
			e.preventDefault();
			if ( x < max_fields ) { //max input box allowed
				x++; //text box increment
				//$(wrapper).append('<div><h3>Song1</h3><input type="text" name="mytext[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
				$( wrapper ).append( '<div class="box-shadow white-bg input_fields_inner"><input type="text" name="instruments[]" style="width: 100%; border: none;"></div>' );
				y++;
			}
		} );

		$( wrapper ).on( "click", ".remove_field", function ( e ) { //user click on remove text
			e.preventDefault();
			$( this ).parent( 'div' ).remove();
			x--;
		} )
	} );

	$( document ).ready( function () {
		var max_fields = 10; //maximum input boxes allowed
		var wrapper = $( ".input_fields_wrap_player" ); //Fields wrapper
		var add_button = $( ".add_field_button_rates" ); //Add button ID
		var x = 1; //initlal text box count
		var y = 2;
		$( add_button ).click( function ( e ) { //on add input button click
			e.preventDefault();
			if ( x < max_fields ) { //max input box allowed
				x++; //text box increment
				//$(wrapper).append('<div><h3>Song1</h3><input type="text" name="mytext[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
				$( wrapper ).append( '<div class="box-shadow white-bg input_fields_inner"><h3><input type="text" name="expensename[]" style="width: 100%; border: none;"></h3><span>$</span><input class="income_count" type="text" name="expensevalue[]" id="dare_price" /></div>' );
				y++;
			}
		} );

	} );


	$( '#baserates' ).change( function () {
		$( '#baseratesnew' ).val( $( this ).val() );
	} );
	// $(".income_count").change(function(){
	//     var price = Number($(this).val());
	//     var pricenew = $("#total_price_amount").val();
	//     alert(price);
	//     var total = price + pricenew;
	//     $("#total_price_amount").val(total);
	// });
	//calculation script
	var $form = $( '#whereEntry' ),
		$sumDisplay = $( '#income_sum' );
	$form.delegate( '.income_count', 'change', function () {
		var $summands = $form.find( '.income_count' );
		var sum = 0;
		$summands.each( function () {
			var value = Number( $( this ).val() );
			if ( !isNaN( value ) ) sum += value;
		} );
		$sumDisplay.val( sum );
	} );
</script>