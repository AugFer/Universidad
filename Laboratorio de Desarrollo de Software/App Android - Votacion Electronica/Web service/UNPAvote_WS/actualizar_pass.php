<?php
include('operaciones.php');
$legajo=$_POST["ele_legajo"];
$actualPass=$_POST["actual_pass"];
$nuevaPass=$_POST["nueva_pass"];

if($resultset=getSQLResultSet("SELECT ele_id FROM `electores` WHERE ele_legajo='".$legajo."' AND ele_pass='".$actualPass."'"))
{
	$row_cont = $resultset->num_rows;
	if($row_cont>0)
	{
		ejecutarSQLCommand("UPDATE `electores` SET ele_pass='".$nuevaPass."' WHERE ele_legajo='".$legajo."' AND ele_pass='".$actualPass."'");
		$arr = array('Ok');
		echo json_encode($arr);
	}
	else
	{
		$arr = array('Error');
		echo json_encode($arr);
	}
}
 ?>