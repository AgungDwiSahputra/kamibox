<?php
require "classes/class.phpmailer.php";

function send_otp_via_email($email, $nama, $otp)
{

	$mail = new PHPMailer;
	$mail->IsSMTP();
	$mail->SMTPSecure = 'ssl';
	// $mail->Host = "mail.decreativeart.com"; //host masing2 provider email
	$mail->Host = "smtp.gmail.com"; //host masing2 provider email
	$mail->SMTPDebug = 2;
	$mail->Port = 465;
	$mail->SMTPAuth = true;
	$mail->Username = "ikamibox@gmail.com"; //user email
    // $mail->Password = "kamibox.decreativeart"; //password email 
	$mail->Password = "flgjywflhxgngccd"; //password email 
	$mail->SetFrom("ikamibox@gmail.com", "OTP | Kamibox"); //set email pengirim
	$mail->addReplyTo("ikamibox@gmail.com", "noreply"); //Set an alternative reply-to address
	$mail->Subject = "Kode OTP Kamibox Anda"; //subyek email
	$mail->AddAddress($email, $nama);  //tujuan email
	$mail->MsgHTML("Kode OTP Anda : <b> " . $otp . "</b>");

	if ($mail->Send()) {
		echo "Mail has been sent successfully!";
		return true;
	} else {
		echo "Failed to sending message";
		return false;
	}
}
