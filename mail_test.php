<?php
	/**
	 * Created by PhpStorm.
	 * User: Chronos
	 * Date: 20.12.2017
	 * Time: 07:42
	 */

	// Import PHPMailer classes into the global namespace
	// These must be at the top of your script, not inside a function
	use PHPMailer;
	use Exception;

	//Load composer's autoloader
	require 'vendor/autoload.php';

	$mail = new PHPMailer(true);                   // Passing `true` enables exceptions
	try {
		//Server settings
		$mail->SMTPDebug = 2;                               // Enable verbose debug output
		$mail->isSMTP();                                    // Set mailer to use SMTP
		$mail->Host = 'ecamps.ch';                          // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                             // Enable SMTP authentication
		$mail->Username = 'mailbot@ecamps.ch';              // SMTP username
		$mail->Password = '!6cMv3u3';                       // SMTP password
		$mail->SMTPSecure = 'tls';                          // Enable TLS encryption, `ssl` also accepted
		//Custom connection options
		//Note that these settings are INSECURE
		$mail->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			),
		);


		$mail->Port = 587;                                    // TCP port to connect to

		//Recipients
		$mail->setFrom('mailbot@ecamps.ch', 'eCamp Mailbot');
		$mail->addAddress('caspar.brenneisen@protonmail.ch');     // Add a recipient

		//Content
		$mail->isHTML(true);                                  // Set email format to HTML
		$mail->Subject = 'Here is the subject';
		$mail->Body    = 'This is the HTML message body <b>in bold!</b>';
		$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

		$mail->send();
		echo 'Message has been sent';
	} catch (Exception $e) {
		echo 'Message could not be sent.';
		echo 'Mailer Error: ' . $mail->ErrorInfo;
	}