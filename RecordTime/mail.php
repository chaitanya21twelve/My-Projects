<?php

	if(!empty($_POST['submit'])){

			$msg = $_POST['message'];
			$mailto = 'chaitanya@21twelveinteractive.com';
    		$subject = 'Recordtimes Chat';
		
			// $filename = $attach;
			// $path = 'http://develop.zaghop.com/~zagdev/recordtime/assets/themes/recordtime/messagefiles/';
		
			// $file = $path.$filename;
			// $content = file_get_contents( $file);
			// $content = chunk_split(base64_encode($content));
			// $uid = md5(uniqid(time()));
			// $name = basename($file);

			// header
			$header = "From: Recordtime <chaitanya.21twelve@gmail.com>\r\n";
			//$header .= "Reply-To: ".$replyto."\r\n";
			$header .= "MIME-Version: 1.0\r\n";
			//$header .= "Content-Type: multipart/mixed; boundary=\"".$uid."\"\r\n\r\n";

			// message & attachment
			//$nmessage = "--".$uid."\r\n";
			$nmessage .= "Content-type:text/plain; charset=iso-8859-1\r\n";
			$nmessage .= "Content-Transfer-Encoding: 7bit\r\n\r\n";
			$nmessage .= $msg."\r\n\r\n";
			//$nmessage .= "--".$uid."\r\n";
			//$nmessage .= "Content-Type: application/octet-stream; name=\"".$filename."\"\r\n";
			$nmessage .= "Content-Transfer-Encoding: base64\r\n";
			//$nmessage .= "Content-Disposition: attachment; filename=\"".$filename."\"\r\n\r\n";
			//$nmessage .= $content."\r\n\r\n";
			//$nmessage .= "--".$uid."--";

			if (mail($mailto, $subject, $nmessage, $header)) {
				
				echo "success";

				//return true; // Or do something here
				
			} else {
				
			 // return false;
			  echo "Decline";
			}

	}


?>

<div class="work-with-text">
	<div class="container">
		<div class="col-md-12" id="msg_block">
			<div class="input-group">
				<form method="post" id="chatform" action="" enctype="multipart/form-data">
					<input type="hidden" id="to_id" name="to_id" value="">
					<input type="hidden" id="thread_id" name="thread_id" value="">
					<input type="hidden" id="from_id" name="from_id" value="">
				
					<input id="message" name="message" type="text" class="form-control input-sm" placeholder="Type your message here..."/>
					<span class="input-group-btn"><input type="submit" name="submit" value="SEND" class="btn btn-warning btn-sm" id="submit"></span>
				</form>
			</div>
		</div>
	</div>
</div>