<?php
header('Content-Type: text/html;charset=utf-8');
include('operaciones.php');
$legajo=$_POST["ele_legajo"];
$pass=$_POST["ele_pass"];
$dni = substr($legajo, 2, 8);

if($resultset=getSQLResultSet("SELECT e.ele_voto, e.ele_pin, e.ele_legajo, e.ele_claustro, e.ele_cargo_carrera, p.per_nombres, p.per_apellidos, p.per_email FROM `electores` e INNER JOIN `personas` p ON (e.ele_dni=p.per_dni) WHERE e.ele_legajo='".$legajo."' AND e.ele_pass='".$pass."' AND e.ele_dni='".$dni."'"))
{
	$row_cont = $resultset->num_rows;
	if($row_cont>0)
	{
		$array = array();
		while ($row = $resultset->fetch_assoc())
		{
			$array[] = $row;
		}
		
		$ele_voto = $array[0]['ele_voto'];
		$voto = 'No';
		if(!empty($ele_voto)){
			$voto = 'Si';								
		}
		$array[0]['ele_voto']=$voto;
		
		(int)$ele_pin =(int)$array[0]['ele_pin'];
		$pin = 'No';
		if($ele_pin!==0){
			$pin = 'Si';								
		}
		$array[0]['ele_pin']=$pin;
		
		$json = json_encode($array);
		echo $json;
	}
	else{
		$arr = array('Datos inválidos');
		echo json_encode($arr);
	}
}
?>



