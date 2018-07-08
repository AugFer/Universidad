<?php
include('operaciones.php');
include('email_comprobante.php');
$legajo=$_POST['ele_legajo'];
$claustro=$_POST['ele_claustro'];
$voto=$_POST['voto'];
(int)$pin=(int)$_POST['pin'];

date_default_timezone_set ('America/Argentina/Buenos_Aires');
$fechaActual = date('Y-m-d H:i:s');

if($resultset=getSQLResultSet("SELECT pro_fecha_fin FROM proceso_eleccionario")){
	$row_cont = $resultset->num_rows;
	if($row_cont>0){
		$proceso = $resultset->fetch_assoc();
		if ($fechaActual <= $proceso['pro_fecha_fin']){
			if($resultset=getSQLResultSet("SELECT ele_voto, ele_pin, ele_dni, ele_id FROM `electores` WHERE ele_legajo='".$legajo."'")){
				$row_cont = $resultset->num_rows;
				if($row_cont>0){//esto creo que esta de mas porque la persona SIEMPRE va a existir
					$array = mysqli_fetch_row($resultset);
					$ele_voto = $array[0];
					(int)$ele_pin = (int)$array[1];
					if(empty($ele_voto)){ //Si está vacio es porque aún no votó
						if($ele_pin !== 0){ //Si es igual a 0 es porque aún no generó su pin
							if($ele_pin === $pin){ //Si no son iguales es porque ingreso mal su pin
								$transaccion = $array[2];
								$transaccion .= $array[3]; //El nro de transaccion se arma concatenando el DNI y el ID del elector
								ejecutarSQLCommand("INSERT INTO `votos` (voto_transaccion, voto_fecha) VALUES ('".$transaccion."','".$fechaActual."')");
								
								if($resultset=getSQLResultSet("SELECT voto_id FROM `votos` WHERE voto_transaccion='".$transaccion."'")){
									$row_cont = $resultset->num_rows;
									if($row_cont>0){
										$array = mysqli_fetch_row($resultset);
										$voto_id = $array[0];
										ejecutarSQLCommand("UPDATE `electores` SET ele_voto='".$voto_id."' WHERE ele_legajo='".$legajo."'");
										
										$md5transaccion = md5($transaccion);
										$md5fechaActual = md5($fechaActual);
										ejecutarSQLCommand("INSERT INTO `transacciones` (tran_identificador, tran_lista) VALUES ('".$md5transaccion."','".$md5fechaActual."')");
								
										if($voto==='Nulo' || $voto==='Blanco'){
											$claustro = str_replace(' ', '', $claustro);
											$claustro .= $voto;
											$nombreVoto = $claustro;
											
											// Opcion bizarra que funciona
											ejecutarSQLCommand("UPDATE `otros_votos` SET otros_votos_cant = otros_votos_cant + 1 WHERE otros_votos_nombre='".$nombreVoto."'");
											
											//Opcion normal mas tradicional y larga que tambien funciona
											/*
											if($resultset=getSQLResultSet("SELECT otros_votos_cant FROM `otros_votos` WHERE otros_votos_nombre='".$nombreVoto."'")){
												$row_cont = $resultset->num_rows;
												if($row_cont>0){
													$array = mysqli_fetch_row($resultset);
													$otros_votos_cant = $array[0];
													$otros_votos_cant = ++$otros_votos_cant;
													ejecutarSQLCommand("UPDATE `otros_votos` SET otros_votos_cant='".$otros_votos_cant."' WHERE otros_votos_nombre='".$nombreVoto."'");
												}
											}
											*/
										}
										else{
											$voto = str_replace('%20', ' ', $voto);
											// Opcion bizarra que funciona
											ejecutarSQLCommand("UPDATE `listas_candidatos` SET lis_cant_votos = lis_cant_votos + 1 WHERE lis_nombre='".$voto."'");
											
											//Opcion normal mas tradicional y larga que tambien funciona
											/*
											if($resultset=getSQLResultSet("SELECT lis_cant_votos FROM `listas_candidatos` WHERE lis_nombre='".$voto."'")){
												$row_cont = $resultset->num_rows;
												if($row_cont>0){
													$array = mysqli_fetch_row($resultset);
													$lis_cant_votos = $array[0];
													$lis_cant_votos = ++$lis_cant_votos;
													ejecutarSQLCommand("UPDATE `listas_candidatos` SET lis_cant_votos='".$lis_cant_votos."' WHERE lis_nombre='".$voto."'");
												}
											}
											*/
										}
										generarComprobante($legajo); //funcion de email_comprobante.php
									}
								}
								else{
									$arr = array('Error de conexion');
									echo json_encode($arr);
								}
							}	
							else{
								$arr = array('El PIN ingresado es incorrecto');
								echo json_encode($arr);
							}
						}
						else{
							$arr = array('Aun no has generado tu PIN');
							echo json_encode($arr);
						}
					}
					else{
						$arr = array('Ya has emitido tu voto en estas elecciones');
						echo json_encode($arr);
					}
				}
			}
			else{
				$arr = array('Error de conexion');
				echo json_encode($arr);
			}
		}
		else{
			$arr = array('El acto eleccionario ya ha finalizado', $proceso['pro_fecha_fin']);
			echo json_encode($arr);
		}
	}
	else{
		$arr = array('No hay ningun acto eleccionario');
		echo json_encode($arr);
	}
}
else{
	$arr = array('Error de conexion');
	echo json_encode($arr);
}
?>