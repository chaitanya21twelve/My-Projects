<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div class="middle-container">
	<div class="banner-image">
		<div class="banner-content">
			<img src="<?= site_url().template_assets_path(); ?>/images/Big Logo-White.png">
		</div>
	</div>
	<div class="page-title box-shadow">
		<div class="container-fluid">
			<div id="title-1"><h1>Project―Overview</h1></div>
            <div id="title-2" style="display:none;"><h1>Project―Songs</h1></div>
            <div id="title-3" style="display:none;"><h1>Project―Musicians</h1></div>
            <div id="title-4" style="display:none;"><h1>Project―Summary</h1></div>
		</div>
	</div>
</div>

<div class="FormErrors">
	<?php echo validation_errors(); ?>
</div>

<?php //echo form_open('index.php/project/create'); ?>
<form action="" method="post" enctype="multipart/form-data">
	<div id="project-producer">
		<div class="container new-project-container-padding" id="step-1">
			<div class="row project-inner-section">
				<div class="col-md-4">
					<div class="project-details-container">
						<div class="new-project-section-title box-shadow white-bg same-height">
							<h3>What does your client want this
	            project to be called?</h3>
							<!--        <p>Don’t worry—this isn’t official. </p>-->
							<!--        <p>It’ll just help you identify it on RecordTime.</p>-->
						</div>
						<div class="project-section-input-box">
							<input type="text" name="name"/>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="project-details-container">
						<div class="new-project-section-title box-shadow white-bg same-height">
							<h3>When will you have it done?</h3>
							<p>Note that projects lasting more than 90 days will need to be completed in sections, and completion date will push back with each day without artist payment.</p>
						</div>
						<!--      <div class="project-section-input-box doller-sign-textbox">-->
						<!--        <input type="text" name="budget" placeholder="$" />-->
						<!--      </div>-->
						<div class="project-section-input-box doller-sign-textbox" style="position: relative;">
							<input type="text" name="complete_time" class="date" id="datepicker1" readonly placeholder="MM/DD/YYYY" />
							<!-- <input type="date" name="complete_time">
							<i class="fa fa-calendar" style="font-size:24px; position: absolute; top: 0; right: 28%; margin-top:11px;"></i> -->
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="project-details-container process-icon-section">
						<div class="process-stetus">
							<ul>
								<li>
									<div class="number-arrow-section active">
										<div class="number">
											1
										</div>
									</div>
								</li>
								<li>
									<div class="number-arrow-section">
										<div class="number">
											2
										</div>
									</div>
								</li>
								<li>
									<div class="number-arrow-section">
										<div class="number">
											3
										</div>
									</div>
								</li>
							</ul>
						</div>
						<div class="arrow-section number-arrow-section">
							<div class="arrow">
								<a href="javascript:void(0)" id="step-1-submit"><i class="fa fa-arrow-right" aria-hidden="true"></i></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container new-project-container-padding" id="step-2" style="display:none;">
			<div class="row project-inner-section">
				<div class="col-md-4">
					<div class="project-details-container">
						<div class="new-project-section-title box-shadow white-bg same-height">
							<h3>Songs to be recorded </h3>
							<p>List all additional expenses over your rate of $500 per song. You must provide proof of payment to be reimbursed within 48 hours. </p>
						</div>
						<div class="project-section-dropdown-box">
							<div class="custom-select" style="">
								<select name="songs">
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
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="project-details-container">
						<div class="input_fields_wrap new-project-section-title same-height" style="overflow-y: scroll; height: 300px;">
							<div class="box-shadow white-bg input_fields_inner">
								<h3>Song1</h3><input type="text" name="songcost[]">
							</div>
							<div class="box-shadow white-bg input_fields_inner">
								<h3>Song2</h3><input type="text" name="songcost[]">
							</div>
							<div class="box-shadow white-bg input_fields_inner">
								<h3>Song3</h3><input type="text" name="songcost[]">
							</div>
							<div class="box-shadow white-bg input_fields_inner">
								<h3>Song4</h3><input type="text" name="songcost[]">
							</div>
						</div>
						<div class="text-center">
							<img class="add_field_button" src="<?= site_url() . template_assets_path(); ?>/images/plus.png">
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="project-details-container process-icon-section">
						<div class="process-stetus">
							<ul>
								<li>
									<div class="number-arrow-section ">
										<div class="number">
											1
										</div>
									</div>
								</li>
								<li>
									<div class="number-arrow-section active">
										<div class="number">
											2
										</div>
									</div>
								</li>
								<li>
									<div class="number-arrow-section">
										<div class="number">
											3
										</div>
									</div>
								</li>
							</ul>
						</div>
						<div class="arrow-section number-arrow-section two-arrow">
							<div class="arrow left-arrow">
								<a href="javascript:void(0)" id="step-1-back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
							</div>
							<div class="arrow right-arrow">
								<a href="javascript:void(0)" id="step-2-submit"><i class="fa fa-arrow-right " aria-hidden="true"></i></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="container new-project-container-padding" id="step-3" style="display:none;">
			<div class="row project-inner-section">
				<div class="col-md-4">
					<div class="project-details-container">
						<div class="new-project-section-title upload-file-height-auto box-shadow white-bg same-height">
							<h3>List any additional musicians or
	                  studio professionals</h3>
							<p>This section serves as a roster for credits and to provide documentation for reimbursement.</p>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="project-details-container">
						<div class="input_fields_wrap_player new-project-section-title new-project-section-checkbox same-height" style="overflow-y: auto; height: 300px;">
							<div class="box-shadow white-bg player-inner">
							<h3>Player1</h3><input type="text" name="players[]">
							</div>

						</div>
						<div class="text-center">
						
						<img class="add_field_button_player add_field_button" src="<?= site_url() . template_assets_path(); ?>/images/plus.png">
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="project-details-container process-icon-section">
						<div class="process-stetus">
							<ul>
								<li>
									<div class="number-arrow-section">
										<div class="number">
											1
										</div>
									</div>
								</li>
								<li>
									<div class="number-arrow-section">
										<div class="number">
											2
										</div>
									</div>
								</li>
								<li>
									<div class="number-arrow-section active">
										<div class="number">
											3
										</div>
									</div>
								</li>
							</ul>
						</div>
						<div class="arrow-section number-arrow-section two-arrow">
							<div class="arrow left-arrow">
								<a href="javascript:void(0)" id="step-2-back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>
							</div>
							<div class="arrow right-arrow">
								<a href="javascript:void(0)" id="step-3-submit"><i class="fa fa-arrow-right " aria-hidden="true"></i></a>
							</div>
						</div>
						<!--            <input type="submit" name="submit" class="btn btn-block btn-recording" value="Finish" />-->
					</div>
				</div>
			</div>
		</div>

	    <div class="container new-project-container-padding" id="step-4" style="display:none;">
	        <div class="row project-inner-section">
	            <div class="col-md-4"></div>
	            <div class="col-md-4">
	                <div class="project-details-container">
	                    <div class="new-project-section-title upload-file-height-auto box-shadow white-bg same-height">
	                        <h1 style="color: #000;">You're all set!</h1>
	                        <p>Search for products that can make our project amazing.</p>
	                    </div>
	                    <div class="arrow-section number-arrow-section two-arrow">
	                       <div class="arrow right-arrow">
										<button><i class="fa fa-arrow-right " aria-hidden="true"></i></button>
		                        	<!--<input type="submit" name="submit" value="">
		                        	<i class="fa fa-arrow-right " aria-hidden="true"></i>-->
		                            <!-- <a href="<?php //echo site_url('search')?>" id="#"><i class="fa fa-arrow-right " aria-hidden="true"></i></a> -->
		                        </div>
	                    </div>
	                </div>
	            </div>
	            <div class="col-md-4"></div>
	        </div>
	    </div>
	</div>
</form>
<script type="text/javascript"> 

	$(function() {
		$( ".date" ).datepicker({
		 	dateFormat : 'mm/dd/yy',
		 	showOn: "both",
		 	buttonImage: "https://jqueryui.com/resources/demos/datepicker/images/calendar.gif",
		 	buttonImageOnly: true,
		 	buttonText: "Select date",
		 	changeMonth: true,
		 	changeYear: true,
		 	yearRange: "-100:+0"
		}); 
	});

	$( document ).ready( function () {
		var max_fields = 10; //maximum input boxes allowed
		var wrapper = $( ".input_fields_wrap" ); //Fields wrapper
		var add_button = $( ".add_field_button" ); //Add button ID

		var x = 1; //initlal text box count
		var y = 5;
		$( add_button ).click( function ( e ) { //on add input button click
			e.preventDefault();
			if ( x < max_fields ) { //max input box allowed
				x++; //text box increment
				//$(wrapper).append('<div><h3>Song1</h3><input type="text" name="mytext[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
				$( wrapper ).append( '<div class="box-shadow white-bg input_fields_inner"><h3>Song' + y + '</h3><input type="text" name="songcost[]"/></div>' );
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
		var add_button = $( ".add_field_button_player" ); //Add button ID

		var x = 1; //initlal text box count
		var y = 2;
		$( add_button ).click( function ( e ) { //on add input button click
			e.preventDefault();
			if ( x < max_fields ) { //max input box allowed
				x++; //text box increment
				//$(wrapper).append('<div><h3>Song1</h3><input type="text" name="mytext[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
				$( wrapper ).append( '<div class="box-shadow white-bg player-inner"><h3>Player' + y + '</h3><input type="text" name="players[]"/></div>' );
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
		$( '#step-1-submit' ).click( function () {
            $( '#step-1' ).hide();
            $( '#title-1' ).hide();
            $( '#step-2' ).show();
            $( '#title-2' ).show();
            var id = $( '.user-type' ).attr( "id" );
        } );
        $( '#step-2-submit' ).click( function () {
            $( '#step-2' ).hide();
            $( '#step-3' ).show();
            $( '#title-2' ).hide();
            $( '#title-3' ).show();
        } );
        $( '#step-1-back' ).click( function () {
            $( '#step-2' ).hide();
            $( '#step-1' ).show();
            $( '#title-2' ).hide();
            $( '#title-1' ).show();
        } );
        $( '#step-2-back' ).click( function () {
            $( '#step-3' ).hide();
            $( '#step-2' ).show();
            $( '#title-3' ).hide();
            $( '#title-2' ).show();
        } );

        $( '#step-3-submit' ).click( function () {
            $( '#step-3' ).hide();
            $( '#step-4' ).show();
            $( '#title-3' ).hide();
            $( '#title-4' ).show();
        } );


	} )
</script>