<?php
include('operaciones.php');
$legajo=$_POST['ele_legajo'];

date_default_timezone_set ('America/Argentina/Buenos_Aires');
$fechaActual = date('Y-m-d H:i:s');

if($resultset=getSQLResultSet("SELECT pro_id, pro_nombre, pro_fecha_inicio, pro_fecha_fin FROM proceso_eleccionario"))
{
	$row_cont = $resultset->num_rows;
	if($row_cont>0)
	{
		$proceso = $resultset->fetch_assoc();
		if ($fechaActual < $proceso['pro_fecha_inicio']){
			$arr = array('El acto eleccionario aun no ha comenzado', $proceso['pro_fecha_inicio']);
			echo json_encode($arr);
		}
		else{
			if ($fechaActual > $proceso['pro_fecha_fin']){
				$arr = array('El acto eleccionario ya ha finalizado', $proceso['pro_fecha_fin']);
				echo json_encode($arr);
			}
			else{
				if($resultset=getSQLResultSet("SELECT ele_id FROM electores WHERE ele_legajo='$legajo' AND ele_pin=0"))
				{
					$row_cont = $resultset->num_rows;
					if($row_cont>0) // Si entra, significa que el elector no tiene su PIN generado
					{
						$arr = array('No tiene');
						echo json_encode($arr);
					}
					else{
						$arr = array('Ya tiene');
						echo json_encode($arr);
					}
					
				}
				else{
					$arr = array('Error de conexion');
					echo json_encode($arr);
				}
			}
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