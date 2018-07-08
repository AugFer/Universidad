<?php
include('operaciones.php');
$legajo=$_POST['ele_legajo'];

date_default_timezone_set ('America/Argentina/Buenos_Aires');
$fechaActual = date('Y-m-d H:i:s');

if($resultset=getSQLResultSet("SELECT pro_fecha_inicio FROM proceso_eleccionario"))
{
	$row_cont = $resultset->num_rows;
	if($row_cont>0)
	{
		$proceso = $resultset->fetch_assoc();
		
		if ($fechaActual >= $proceso['pro_fecha_inicio'])
		{
			if($resultset=getSQLResultSet("SELECT e.ele_voto, e.ele_id, e.ele_legajo, e.ele_dni, e.ele_claustro, e.ele_cargo_carrera, p.per_apellidos, p.per_nombres FROM `electores` e INNER JOIN `personas` p ON (e.ele_dni=p.per_dni) WHERE e.ele_legajo='".$legajo."'"))
			{
				$row_cont = $resultset->num_rows;
				if($row_cont>0)
				{
					$datosElector = $resultset->fetch_assoc();
					
					$ele_voto = $datosElector['ele_voto'];
					if(!empty($ele_voto)){
						$transaccion = $datosElector['ele_dni'];
						$transaccion .= $datosElector['ele_id'];
						if($resultset=getSQLResultSet("SELECT voto_transaccion FROM `votos` WHERE voto_transaccion='".$transaccion."'"))
						{
							$row_cont = $resultset->num_rows;
							if($row_cont>0)
							{
								$datosTransaccion = $resultset->fetch_assoc();
								
								$resultado = array();
								$resultado[] = $datosElector;
								$resultado[] = $datosTransaccion;
								//$fechaActual = array('fecha' => $fechaActual);
								//$resultado[] = $fechaActual;
								
								$json = json_encode($resultado);
								echo $json;
							}
						}
						else{
							$arr = array('Error de conexion');
							echo json_encode($arr);
						}
					}
					else{
						$arr = array('Aun no has votado');
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
			$arr = array('El acto eleccionario aun no ha comenzado', $proceso['pro_fecha_inicio']);
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