<?php
// the E-Mail address that you want to recieve the message on.
//$to_email = 'info@clearcutwebdesign.co.uk';
$to_email = 'marat.shaidulatov@entellsolutions.com';
if (isset($_POST)) {
	// recieve the form variables and secure them
	//$email = trim(strip_tags(addslashes($_POST['email'])));
	$email = 'info@intelligentmerchantservices.co.uk';
	$subject = "You have a new website enquiry\r\n\r\n";
	foreach ($_POST as $key => $value) {
		$field_name = $key;
		$field_value = trim(strip_tags(addslashes($value)));
		$content .= "$field_name = $field_value \r\n";
		$content .= "<br>";
	}
	// validate the form
	if (empty($email)) {
		echo 0;
	} else {
		// the message headers
		$headers = "From: " . strip_tags($email) . "\r\n";
		$headers .= "Reply-To: ". strip_tags($email) . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=UTF-8\r\n";
		// submitting the message using PHP mail() function
		$send = mail($to_email, $subject, $content, $headers);
			if ($send) {
				echo 1;
			} else {
				echo 0;
			}
	}
}
?>