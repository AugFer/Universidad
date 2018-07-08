<?php
header('Content-type:application/pdf;charset=utf-8');
require_once('librerias/PHPMailer/class.phpmailer.php');
$legajo=$_POST['ele_legajo'];
$email=$_POST['email'];
$dni = substr($legajo, 2, 8);

$filename = $dni.'.pdf';

function SendMail($email, $filename)
{
	$mail = new PHPMailer();
	$mail->Host = 'smtp.gmail.com';
	$mail->Port	  = 587;
	$mail->From      = 'unpa.vote@gmail.com';
	$mail->Password    = 'UNPAvote_app';
	$mail->From        = 'unpa.vote@gmail.com';
	$mail->FromName  = 'UNPAvote';
	$mail->Subject   = 'UNPAvote: Recuperación - Comprobante de votación';
	$mail->Body      = 'Se ha adjuntado su comprobante de votación, en caso de tener algun problema, dirijase con el mismo a la Oficina de Alumnos.';
	$mail->IsHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->AddAddress($email);
	$file_to_attach = 'PDFs/'.$filename;
	$mail->AddAttachment($file_to_attach , 'Comprobante - '.$filename.'.pdf' );
	$mail->Send();

	if ($mail->IsError())
	{
		return FALSE;
	}
	else {
		return TRUE;
	}
}

$Send = SendMail($email, $filename);
if ($Send) {
	$arr = array('Ok');
	echo json_encode($arr);
}
else {
	$arr = array('Error de conexion durante el envio de su comprobante');
	echo json_encode($arr);
}
?>