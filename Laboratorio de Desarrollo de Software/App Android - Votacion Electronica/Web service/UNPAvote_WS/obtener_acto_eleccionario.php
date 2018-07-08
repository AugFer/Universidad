<?php
header('Content-Type: text/html;charset=utf-8');
include('operaciones.php');
$legajo=$_POST['ele_legajo'];
$claustro=$_POST['ele_claustro'];

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
				if($resultset=getSQLResultSet("SELECT ele_voto, ele_pin, ele_dni, ele_id FROM `electores` WHERE ele_legajo='".$legajo."'")){
					$array = mysqli_fetch_row($resultset);
					$ele_voto = $array[0];
					$voto = 'No';
					if(!empty($ele_voto)){
						$voto = 'Si';								
					}
					(int)$ele_pin =(int)$array[1];
					$pin = 'No';
					if($ele_pin!==0){
						$pin = 'Si';								
					}
					
					$resultado = array(); //Va a ser un array de arrays de objetos json
					$arrayAux = array(); //Va a ser usado para generar los arrays con la informacion de las consultas
					
					$arrayAux[] = $voto;
					$arrayAux[] = $pin;
					$resultado[] = $arrayAux;
					$arrayAux = array();
					
					if($resultset=getSQLResultSet("SELECT l.lis_id, l.lis_nombre, l.lis_claustro, l.lis_apo_dni FROM `listas_candidatos` l WHERE l.lis_claustro='".$claustro."'")){
						$row_cont = $resultset->num_rows;
						if($row_cont>0)
						{
							$arrayAux[] = $proceso; //Se guarda la info del acto eleccionario
							//Se guarda la info de las listas
							while ($row = $resultset->fetch_assoc()){
								$arrayAux[] = $row;
							}
							$resultado[] = $arrayAux; //Se guarda el primer array que tiene el acto eleccionario y las listas
							if($resultset=getSQLResultSet("SELECT c.cand_dni, c.cand_lista, c.cand_cargo, p.per_apellidos, p.per_nombres FROM `candidatos` c INNER JOIN `personas` p INNER JOIN `listas_candidatos` l ON (c.cand_dni=p.per_dni) AND (c.cand_lista=l.lis_nombre) AND (l.lis_claustro='".$claustro."') ORDER BY c.cand_lista ASC, LEFT(c.cand_cargo,1) ASC, RIGHT(c.cand_cargo,1) DESC"))
							{
								$row_cont = $resultset->num_rows;
								if($row_cont>0)
								{
									$arrayAux = array(); //reset del array auxiliar
									while ($row = $resultset->fetch_assoc())
									{
										$arrayAux[] = $row;
									}
									
									$resultado[] = $arrayAux; //Se guarda el segundo array que tiene a los electores de las listas
									$json = json_encode($resultado);
									echo $json;
								}
								else{
									$arr = array('Error de conexion');
									echo json_encode($arr);
								}
							}
							
							
						}
					}
					else{
						$arr = array('Error de conexion');
						echo json_encode($arr);
					}
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