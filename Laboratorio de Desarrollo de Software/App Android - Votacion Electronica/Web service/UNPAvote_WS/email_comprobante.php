<?php
header('Content-type:application/pdf;charset=utf-8');
require_once('librerias/PHPMailer/class.phpmailer.php');

function generarComprobante($legajo)
{
	//buscar datos del elector de la tabla elector
	if($resultset=getSQLResultSet("SELECT ele_legajo, ele_dni, ele_claustro, ele_voto, ele_cargo_carrera FROM electores WHERE ele_legajo='".$legajo."'"))
	{
		$row_cont = $resultset->num_rows;
		if($row_cont>0)
		{
			$fila2 = $resultset->fetch_row();
			//buscar nombres y apellidos del elector de la tabla personas
			if($resultset=getSQLResultSet("SELECT per_apellidos, per_nombres, per_email FROM personas WHERE per_dni = '".$fila2[1]."'"))
			{
				$row_cont = $resultset->num_rows;
				if($row_cont>0)
				{
					$fila3 = $resultset->fetch_row();
					//buscar la transaccion del voto de la tabla votos
					if($resultset=getSQLResultSet("SELECT voto_transaccion, voto_fecha FROM votos WHERE voto_id = '".$fila2[3]."'"))
					{
						$row_cont = $resultset->num_rows;
						if($row_cont>0)
						{
							$fila4 = $resultset->fetch_row();
							//buscar la lista elegida desde la transaccion encriptada de la tabla transacciones
							if($resultset=getSQLResultSet("SELECT tran_lista FROM transacciones WHERE tran_identificador = '".(md5($fila4[0]))."'"))
							{
								$row_cont = $resultset->num_rows;
								if($row_cont>0)
								{
									$fila5 = $resultset->fetch_row();

									//Comenzar el PDF mediante buffer de salida
									ob_start();
									echo '<html>';
									echo '<head>';
									echo '<meta http-equiv="content-type" charset="UTF-8"/>';
									echo '<link rel="stylesheet" href="css/generar_comprobante.css" type="text/css">';
									echo '</head>';
									echo '<body>';
									echo '<div id="bloqueContenido">';
									echo '<table id="tablaDatosClaustros">';
									echo '<thead>';
									echo '<tr>';
									echo '<th rowspan="1"><img src="logos/Logo_unpa.jpg"/></th>';
									echo '<th id"achicar">Sistema de Votación<br></br>Electrónica Universitaria<br></br>Version: 1.0 (Primera Versión)</th>';
									echo '</tr>';
									//echo '<tr>';
									//echo '<th id"achicar">Electrónica Universitaria</th>';
									//echo '</tr>';
									echo '<tr>';
									echo '<th colspan="2">Unidad Académica Caleta Olivia - UNPA</th>';
									echo '</tr>';
									echo '<tr>';
									echo '<th colspan="2">Comprobante de VOTO</th>';
									echo '</tr>';
									echo '<tr>';
									echo '<th colspan="2"></th>';
									echo '</tr>';
									echo '</thead>';
									echo '<tbody>';
									echo '<tr>';
									echo '<td id="tdNormal">Legajo</td>';
									echo '<td id="tdColumna2">'.$fila2[0].'</td>';
									echo '</tr>';
									echo '<tr class="trgris">';
									echo '<td id="tdNormal">DNI</td>';
									echo '<td id="tdColumna2">'.$fila2[1].'</td>';
									echo '</tr>';
									echo '<tr>';
									echo '<td id="tdNormal">Nombre</td>';
									echo '<td id="tdColumna2">'.$fila3[0].", ".$fila3[1].'</td>';
									echo '</tr>';
									echo '<tr class="trgris">';
									echo '<td id="tdNormal">Efectuado el</td>';
									$laFecha = date_create($fila4[1]);
									$fechaArreglada = date_format($laFecha, 'd-m-Y H:i:s');
									echo '<td id="tdColumna2">'.$fechaArreglada.'</td>';
									echo '</tr>';
									echo '<tr>';
									echo '<td id="tdNormal">Claustro</td>';
									echo '<td id="tdColumna2">'.$fila2[2].'</td>';
									echo '</tr>';
									echo '<tr class="trgris">';
									echo '<td id="tdNormal">Cargo/Carrera</td>';
									echo '<td id="tdColumna2">'.$fila2[4].'</td>';
									echo '</tr>';
									echo '<tr>';
									echo '<td id="tdNormal">Nº de Transacción</td>';
									echo '<td id="tdColumna2">'.$fila4[0].'</td>';
									echo '</tr>';
									echo '<tr class="trgris">';
									echo '<td id="ultimo" colspan="2">'.(MD5($fila2[3])).'</td>';
									echo '</tr>'; 
									echo '<tr class="trgris">';
									echo '<td id="ultimo" colspan="2"><u>IMPORTANTE:</u> El Nº de transacción es útil para</td>';
									echo '</tr>'; 
									echo '<tr class="trgris">';
									echo '<td id="ultimo2" colspan="2">cualquier reclamo en la Oficina de Alumnos</td>';
									echo '</tr>';
									echo '</tbody>';
									echo '</table>';
									echo '</div>';
									echo '</body>';
									echo '</html>';
									
									require_once("librerias/dompdf/dompdf_config.inc.php");
									$dompdf = new DOMPDF();
									//$dompdf->set_base_path(realpath(APPLICATION_PATH . 'css/'));
									$dompdf->load_html(ob_get_clean());
									$dompdf->set_paper('A4', 'portrait');
									$dompdf->render();
									$pdf = $dompdf->output();
									$filename = $fila2[1].'.pdf';
									file_put_contents('PDFs/'.$filename, $pdf);
									//$dompdf->stream($filename);
									
									function SendMail($email, $filename)
									{
										$mail = new PHPMailer();
										$mail->Host = 'smtp.gmail.com';
										$mail->Port	  = 587;
										$mail->From      = 'unpa.vote@gmail.com';
										$mail->Password    = 'UNPAvote_app';
										$mail->From        = 'unpa.vote@gmail.com';
										$mail->FromName  = 'UNPAvote';
										$mail->Subject   = 'UNPAvote: Comprobante de votación';
										$mail->Body      = 'Se ha generado su comprobante de votación, en caso de tener algun problema, dirijase con el mismo a la Oficina de Alumnos.';
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
									$Send = SendMail($fila3[2], $filename);
									if ($Send) {
										$arr = array('Ok');
										echo json_encode($arr);
									}
									else {
										$arr = array('Error de conexion durante la generacion de su comprobante de votacion');
										echo json_encode($arr);
									}
								}
							}
							else{
								$arr = array('Error de conexion durante la generacion de su comprobante de votacion');
								echo json_encode($arr);
							}
						}
					}
					else{
						$arr = array('Error de conexion durante la generacion de su comprobante de votacion');
						echo json_encode($arr);
					}
				}
			}
			else{
				$arr = array('Error de conexion durante la generacion de su comprobante de votacion');
				echo json_encode($arr);
			}
		}
	}
	else{
		$arr = array('Error de conexion durante la generacion de su comprobante de votacion');
		echo json_encode($arr);
	}
}
?>