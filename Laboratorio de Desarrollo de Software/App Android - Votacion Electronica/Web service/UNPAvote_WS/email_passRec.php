<?php
include('operaciones.php');
require_once('librerias/PHPMailer/class.phpmailer.php');
$email=$_POST['correo'];

//abcdefghijklmnopqrstuvwxyz
//ABCDEFGHIJKLMNOPQRSTUVWXYZ
$characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
$max = strlen($characters) - 1;

do{
	$nuevaPass = '';
	for ($i = 0; $i < 10; $i++){
      $nuevaPass .= $characters[mt_rand(0, $max)];
	}
	$md5nuevaPass = md5($nuevaPass);
	$resultset=getSQLResultSet("SELECT e.ele_legajo FROM `electores` e INNER JOIN `personas` p ON (e.ele_dni=p.per_dni) WHERE e.ele_pass='".$md5nuevaPass."'");
	$row_cont = $resultset->num_rows;
}while($row_cont>0);

if($resultset=getSQLResultSet("SELECT e.ele_dni FROM `electores` e INNER JOIN `personas` p ON (e.ele_dni=p.per_dni) WHERE p.per_email='".$email."'"))
{
	$row_cont = $resultset->num_rows;
	if($row_cont>0)
	{
		$array = mysqli_fetch_row($resultset);
		$dni = $array[0];
		ejecutarSQLCommand("UPDATE `electores` SET ele_pass='".$md5nuevaPass."' WHERE ele_dni='".$dni."'");

		
		function SendMail($email, $nuevaPass) {
			$mail = new PHPMailer();
			$mail->Host = 'smtp.gmail.com';
			$mail->Port	  = 587;
			$mail->From      = 'unpa.vote@gmail.com';
			$mail->Password    = 'UNPAvote_app';
			$mail->From        = 'unpa.vote@gmail.com';
			$mail->FromName  = 'UNPAvote';
			$mail->Subject   = 'UNPAvote: Restablecimiento de contraseña';
			$mail->Body      = 'Se ha generado una nueva contraseña para su cuenta: <b>'.$nuevaPass.'</b><br/><br/>Recomendamos que cambie la contraseña una vez obtenga acceso a su cuenta.';
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
		
		$Send = SendMail($email, $nuevaPass);
		if ($Send) {
			$arr = array('Ok');
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
}
 ?>