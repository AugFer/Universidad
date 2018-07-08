<?php
include('operaciones.php');
require_once('librerias/PHPMailer/class.phpmailer.php');
$legajo=$_POST['ele_legajo'];
$email=$_POST['correo'];

$characters = '123456789';
$max = strlen($characters) - 1;

do{
	$pin="";
	for ($i = 0; $i < 6; $i++){
	  $pin .= $characters[mt_rand(0, $max)];
	}
	$resultset=getSQLResultSet("SELECT ele_id FROM `electores` WHERE ele_pin='".$pin."'");
	$row_cont = $resultset->num_rows;
}while($row_cont>0);

if($resultset=getSQLResultSet("SELECT ele_dni FROM `electores` WHERE ele_legajo='".$legajo."'"))
{
	ejecutarSQLCommand("UPDATE `electores` SET ele_pin='".$pin."' WHERE ele_legajo='".$legajo."'");
	
	function SendMail($email, $pin) {
			$mail = new PHPMailer();
			$mail->Host = 'smtp.gmail.com';
			$mail->Port	  = 587;
			$mail->From      = 'unpa.vote@gmail.com';
			$mail->Password    = 'UNPAvote_app';
			$mail->From        = 'unpa.vote@gmail.com';
			$mail->FromName  = 'UNPAvote';
			$mail->Subject   = 'UNPAvote: PIN de seguridad';
			$mail->Body      = 'Se ha generado y asociado un PIN numerico a su cuenta: <b>'.$pin.'</b><br/><br/>El mismo le será necesario al momento de emitir su voto.';
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