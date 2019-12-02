<style type="text/css">
	.customp a{ color: #000; text-decoration: underline !important; }
</style>

<?php $user_id = $this->session->userdata['userid'];
 //echo "<pre>"; print_r($recipients_details); ?>
<section id="msg_mod">
	<div class="header-section-how-artist">
		<div class="how-it-work-banner why-artist-banner">
		</div>
		<h2>Messages </h2>
		<?php
			echo $this->session->flashdata('email_sent');
		?>
	</div>

	<div class="">
		<div class="row white-bg">
			<div class="clearfix"></div>
			<div class="col-sm-12 how-it-work-process-section">
				<div class="row process-section">
					<div class="col-sm-2 white-space-div"></div>
					<div class="col-sm-12 process-how-it-work process-why-artist">
						<div class="col-sm-3 work-with-text1">
							<h2>All Conversations</h2>
							<?php //foreach( $recipients_details as $index => $msg ) {
							if(!empty($recipients_details)){
								foreach($recipients_details as $recipients_detail){
									//echo "<pre>"; print_r($details); exit;
							
							?>
							
								<a href="message?recipient_id=<?php echo $recipients_detail[0]['id']; ?>">
									<div class="container">
										<img src="<?php echo site_url(); ?>assets/themes/recordtime/messagefiles/avatar.png" alt="Avatar" style="width:100%;">
										<a href="message?recipient_id=<?php echo $recipients_detail[0]['id']; ?>"><h4><?php echo $recipients_detail[0]['firstname'].' '.$recipients_detail[0]['lastname']; ?></h4></a>
										<p><?php //echo $msg[0]['id']; ?></p>
										<!-- <span class="time-right">11:00</span>-->
									</div>
								</a>
							
							<?php } 
							}else{ ?>
								<div class="container">No conversation found</div>
							
							<?php } ?>
							<?php /* ?>
							<h2>All Recipients</h2>

							<?php 
							if(!empty($all_recipients)){
								foreach($all_recipients as $all_recipient){
							?>
							
								<a href="message?recipient_id=<?php echo $all_recipient['id']; ?>">
									<div class="container">
										<img src="<?php echo site_url(); ?>assets/themes/recordtime/messagefiles/avatar.png" alt="Avatar" style="width:100%;">
										<a href="message?recipient_id=<?php echo $all_recipient['id']; ?>"><h4><?php echo $all_recipient['firstname'].' '.$all_recipient['lastname']; ?></h4></a>
									</div>
								</a>
							
							<?php } }else{ ?>
								<div class="container">No User found</div>
							
							<?php } */ ?>
							
						</div>
						<?php //echo "<pre>"; print_r($messages); ?>
						<div class="col-sm-8">
							<div class="work-with-text">
								<?php //echo "<pre>"; print_r($messages);
									foreach($messages as $message){
										$getTimeStamp = $message['sent'];
										$date = new \DateTime($getTimeStamp);
										$hourString = $date->format('H:i');
										$msg = $message['message'];
										$project = $message['project'];
										//echo "<pre>"; print_r($message);
										//if(substr($message['thread_id'], 0, 2) == $user_id){
										if($message['from_id'] == $user_id){
								?>
										<div class="container">
											<div class="pull-right darker">
												<!-- <img src="https://www.w3schools.com/w3images/bandmember.jpg" alt="Avatar" class="right" style="width:100%;"> -->
												<?php if(!empty($message['attachments'])){
												$filename = $message['attachments'];
												$ext = pathinfo($filename, PATHINFO_EXTENSION);
												if($ext == 'jpg' || $ext == 'png' || $ext == 'gif'){
												?>
												<div class="attach" style="width: 300px; height: auto">
													<img src="<?php echo site_url(); ?>assets/themes/recordtime/messagefiles/<?php echo $message['attachments']; ?>" style="max-width: none; border-radius: 0; height: auto; float: none;">
												</div>
												<?php }elseif($ext == 'pdf' || $ext == 'txt' || $ext == 'doc' || $ext == 'csv'){ ?>
												<div class="attach" style="width: auto; height: auto">
													<a href="<?php echo site_url(); ?>assets/themes/recordtime/messagefiles/<?php echo $message['attachments']; ?>">PDF</a>
												</div>
												<?php } } ?>
												
												<p class="msgtext-right">
													<?php if(!empty($project)){ ?><span class="customp">Click Here: <a href="<?php echo $message['project']?>"><?php echo $message['project']?></a></span><br><?php } ?> <?php if(!empty($msg)){ ?><?php echo $message['message']; ?><?php } ?>
												</p>
												
												<span class="time-right">
													<?php echo $hourString; ?>
												</span>
											</div>
										</div>
								<?php } else { ?>
										<div class="container">
											<img src="<?php echo site_url(); ?>assets/themes/recordtime/messagefiles/avatar.png" alt="Avatar" style="width:100%;">
											<div class="pull-left lighter">
												<?php if(!empty($message['attachments'])){
												$filename = $message['attachments'];
												$ext = pathinfo($filename, PATHINFO_EXTENSION);
												if($ext == 'jpg' || $ext == 'png' || $ext == 'gif'){
												?>
												<div class="attach" style="width: 300px; height: auto">
													<img src="<?php echo site_url(); ?>assets/themes/recordtime/messagefiles/<?php echo $message['attachments']; ?>" style="max-width: none; border-radius: 0; height: auto; float: none;">
												</div>
												<?php }elseif($ext == 'pdf' || $ext == 'txt' || $ext == 'doc' || $ext == 'csv'){ ?>
												<div class="attach" style="width: auto; height: auto">
													<a href="<?php echo site_url(); ?>assets/themes/recordtime/messagefiles/<?php echo $message['attachments']; ?>">PDF</a>
												</div>
												<?php } } ?>
												<?php ?>
												
												<p class="msgtext-right">
													<?php if(!empty($project)){ ?><span class="customp">Click Here: <a href="<?php echo $message['project']?>"><?php echo $message['project']?></a></span><br><?php } ?> <?php if(!empty($msg)){ ?><?php echo $message['message']; ?><?php } ?>
												</p>
												
												<span class="time-left">
													<?php echo $hourString; ?>
												</span>
											</div>
										</div>
								<?php } } ?>
							</div>
						
							<?php if($user_id == $_GET['recipient_id']){ ?>
								<div class="container">No Recipient selected</div>
							<?php }else{ ?>
								<div class="work-with-text">
									<div class="container">
										<div class="col-md-12" id="msg_block">
											<div class="input-group">
												<form method="post" id="chatform" action="" enctype="multipart/form-data">
													<input type="hidden" id="to_id" name="to_id" value="<?php echo $recipient_id; ?>">
													<input type="hidden" id="thread_id" name="thread_id" value="<?php echo $user_id.$recipient_id; ?>">
													<input type="hidden" id="from_id" name="from_id" value="<?php echo $user_id; ?>">
													
													<?php foreach($getrecipientdetail as $getrecipient){ ?>
														<input type="hidden" id="uemail" name="uemail" value="<?php echo $getrecipient['email']; ?>">
													<?php } ?>
													
													<!-- <input id="attachments" name="file" type="file" /> -->
													<div class="image-upload filebutton">
														<label class="">
															<i class="fa fa-camera" aria-hidden="true"></i>
															<span style=""><input id="attachments" name="attachments" type="file" /></span>
														</label>
														
													</div>
													<div class="image-upload filebutton">
														<label class="">
															<i class="fa fa-file-image" aria-hidden="true"></i>
															<span style=""><input id="attachments1" name="attachments" type="file" /></span>
														</label>
													</div>

													<?php //if($select_type[0] == 2){ 
														if (in_array("2", $select_type[0])){
														//echo $select_type[0]; ?>
													<div class="image-upload">
														<span>
															<select name="project" id="project">
																<option value="">Invite producer</option>
																<?php foreach($all_projects as $all_project){ ?>
																<?php /*	<option value="Click here: <a href='<?php echo site_url(); ?>project/my_projects?user_id=<?php echo $all_project['user_id']; ?>&project_id=<?php echo $all_project['project_id']; ?>'><?php echo $all_project['name']; ?></a>"><?php echo $all_project['name']; ?></option> */ ?>
																<option value="<?php echo site_url(); ?>project/my_projects?user_id=<?php echo $all_project['user_id']; ?>&project_id=<?php echo $all_project['project_id']; ?>"><?php echo $all_project['name']; ?></option>
																<?php } ?>
															</select>
														</span>
													</div>
													<?php } ?>

													<input id="message" name="message" type="text" class="form-control input-sm" placeholder="Type your message here..."/>
													<span class="input-group-btn"><input type="submit" value="SEND" class="btn btn-warning btn-sm" id="submit"></span>
												</form>
											</div>
										</div>
									</div>
								</div>
							<?php } ?>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<script>
	$( document ).ready( function () {

		$( "#attachments" ).change( function () {
			$( "#submit" ).trigger( 'click' );
		} );

		$( "#attachments1" ).change( function () {
			$( "#submit" ).trigger( 'click' );
		} );


		$( "#chatform" ).submit( function ( e ) {
			e.preventDefault();
			var to_id = $( "#to_id" ).val();;
			var thread_id = $( "#thread_id" ).val();
			var from_id = $( "#from_id" ).val();
			var project = $( "#project" ).val();
			var message = $( "#message" ).val();
			var attachments = $( "#attachments" ).val();
			//alert(message); exit;
			var formData = new FormData( $( "#chatform" )[ 0 ] );
			//alert(formData); exit;
			 //console.log("hello"); exit;
			//var formData = new FormData(this);

			$.ajax( {
				type: "POST",
				url: '<?php echo base_url() ?>message/add_message',
				data: formData,
				processData: false,
				contentType: false,
				cache: false,
				beforeSend: function () {
					$( '#submit' ).html( 'Sending......' );
				},
				//data: {to_id:to_id,thread_id:thread_id,from_id:from_id,message:message,attachments:attachments},
				success: function ( data ) {
					location.reload();
				},
				error: function () {
					alert( 'Fail' );
				}
			} );
		} );
	} );
</script>