<?php
include('operaciones.php');
date_default_timezone_set ('America/Argentina/Buenos_Aires');
$fechaActual = date('Y-m-d H:i:s');

if($resultset=getSQLResultSet("SELECT pro_nombre, pro_fecha_inicio, pro_fecha_fin FROM proceso_eleccionario"))
{
    $row_cont = $resultset->num_rows;
    if($row_cont>0)
    {
        $proceso = $resultset->fetch_assoc(); //informacion del proceso eleccionario
        if ($fechaActual >= $proceso['pro_fecha_inicio'])
        {
            if($resultset=getSQLResultSet("SELECT lis_nombre, lis_cant_votos, lis_claustro FROM `listas_candidatos`"))
            {
                $listas = array(); //array con datos de las listas
                while ($row = $resultset->fetch_assoc()){
                        $listas[] = $row;
                }

                if($resultset=getSQLResultSet("SELECT otros_votos_nombre, otros_votos_cant FROM `otros_votos`"))
                {
                    $otros_votos = array(); //array con datos de otros votos
                    while ($row = $resultset->fetch_assoc()){
                            $otros_votos[] = $row;
                    }
/*
                    $votos_nulos=0;
                    $votos_blancos=0;
                    for($i=0; $i<count($otros_votos);$i++){
                            $string = $otros_votos[$i]['otros_votos_nombre'];
                            if (strpos($string, 'Nulo') !== false) {
                                    $votos_nulos += $otros_votos[$i]['otros_votos_cant'];
                            }
                            if (strpos($string, 'Blanco') !== false) {
                                    $votos_blancos += $otros_votos[$i]['otros_votos_cant'];
                            }
                    }

                    $otros_votos = array();
                    $otros_votos['Blanco'] = (String)$votos_blancos;
                    $otros_votos['Nulo'] = (String)$votos_nulos;
*/

                    $resultado = array(); //Va a ser un array de arrays de objetos json
                    $arrayAux = array(); //Va a ser usado para generar los arrays internos con la informacion de las consultas

                    $tipoResultado = "Parcial";
                    if ($fechaActual >= $proceso['pro_fecha_fin'])
                    {
                            $tipoResultado = "Final";
                    }
                    $arrayAux[] = $tipoResultado;
                    $resultado[] = $arrayAux; //Agrega al resultado si es resultado parcial o final
                    $arrayAux = array();

                    $arrayAux[] = $proceso; 
                    $resultado[] = $arrayAux; //Agrega al resultado el acto eleccionario
                    $arrayAux = array();

                    $resultado[] = $listas; //Agrega al resultado las listas y sus votos

                    $arrayAux[] = $otros_votos; 
                    $resultado[] = $otros_votos; //Agrega al resultado los votos Blancos y Nulos
                    $arrayAux = array();

                    if ($tipoResultado === "Final")
                    {
                        $plazas = array();
                        if($resultset=getSQLResultSet("SELECT r.res_claustro, r.res_lista, r.res_cargo, p.per_apellidos, p.per_nombres FROM `resultados_elecciones` r INNER JOIN `personas` p ON (r.res_dni=p.per_dni) ORDER BY r.res_claustro ASC, r.res_cargo ASC"))
                        {
                            $row_cont = $resultset->num_rows;
                            if($row_cont>0)
                            {
                                while ($row = $resultset->fetch_assoc()){
                                        $plazas[] = $row;
                                }
                                $resultado[] = $plazas;
                            }
                            else{
                                $plazas['Plazas'] = "Resultados no disponibles";
                                $arrayAux[] = $plazas; 
                                $resultado[] = $arrayAux;
                            }
                            $json = json_encode($resultado);
                            echo $json;
                        }
                        else{
                                $arr = array('Error de conexion');
                                echo json_encode($arr);
                        }
                    }
                    else{
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