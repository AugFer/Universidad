<?php
include('operaciones.php');
require_once('librerias/PHPMailer/class.phpmailer.php');
$legajo=$_POST['ele_legajo'];
$email=$_POST['correo'];

if($resultset=getSQLResultSet("SELECT ele_pin FROM `electores` WHERE ele_legajo='".$legajo."'"))
{
	$array = mysqli_fetch_row($resultset);
	$pin = $array[0];
	
	function SendMail($email, $pin) {
		$mail = new PHPMailer();
		$mail->Host = 'smtp.gmail.com';
		$mail->Port	  = 587;
		$mail->From      = 'unpa.vote@gmail.com';
		$mail->Password    = 'UNPAvote_app';
		$mail->From        = 'unpa.vote@gmail.com';
		$mail->FromName  = 'UNPAvote';
		$mail->Subject   = 'UNPAvote: Recuperación - PIN de seguridad';
		$mail->Body      = 'Tu PIN es: <b>'.$pin.'</b><br/><br/>El mismo le será necesario al momento de emitir su voto.';
		$mail->IsHTML(true);
		$mail->CharSet = 'UTF-8';
		$mail->AddAddress($email);
		$mail->Send();
		
		if ($mail->IsError())
		{
			return FALSE;
		}
		else {
			return TRUE;
		}
	}
		
	$Send = SendMail($email, $pin);
	if ($Send) {
		$arr = array('Ok', $pin);
		echo json_encode($arr);
	}
	else {
		$arr = array('Error');
		echo json_encode($arr);
	}
}
else
{
	$arr = array('Error');
	echo json_encode($arr);
}
?>