<?php

include('../../../config.php');
	
	$name = $_POST['name'];
	$email = $_POST['email'];
	$phone = $_POST['phone'];
	$message = $_POST['message'];


// START MAIL
	$to .= $blog_email;
	$subject = 'Dropplax Contact Form';
	$body = '
	Details:<br>
	'.$name.'<br>
	'.$email.' | '.$phone.'<br>
	<br>

	'.$message.'
	
	';
	
	$headers  = 'MIME-Version: 1.0' . "\r\n";
	$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$headers .= 'From: '.$name.' <'.$email.'>' . "\r\n";
	
	mail($to, $subject, $body, $headers);
// EOF EMAIL        
  
?>	
	
	
	