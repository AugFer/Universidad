<?php
    require_once '../clases/conexion.php';
    require_once '../clases/pelicula.php';
    require_once '../clases/funcion.php';
    require_once '../clases/entrada.php';
    require_once '../clases/transaccion.php';
    $conexion = Conexion::establecer();
    if($conexion->connect_error){
        echo '<div class="container">';
        echo '<div class="alert alert-danger" style="padding: 10px;">';
        echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        echo '<strong>ERROR: '.$conexion->connect_error.'</strong>';
        echo '</div>';
        echo '</div>';
    }
    else{
        $usuario = (filter_input(INPUT_POST,"usuario",FILTER_SANITIZE_STRING));
        $id_transaccion = (filter_input(INPUT_POST,"id_transaccion",FILTER_VALIDATE_INT));
        $transaccion = new Transaccion();
        $transaccion->cargar($conexion, $id_transaccion);
        
        $listadoEntradas = Entrada::listarPorTransaccion($conexion, $id_transaccion);
        $cantidad_entradas = mysqli_num_rows($listadoEntradas);
        
        $reg = $listadoEntradas->fetch_object();
        $entrada = new Entrada();
        $entrada->cargar($conexion, $reg->id_entrada);
        
        $funcion = new Funcion();
        $funcion->cargar($conexion, $entrada->getId_funcion());
        
        $pelicula = new Pelicula();
        $pelicula->cargar($conexion, $funcion->getPelicula());

        $fecha_T = DateTime::createFromFormat('Y-m-d H:i:s',$transaccion->getFecha());
        $fecha_F = DateTime::createFromFormat('Y-m-d H:i:s',$funcion->getFecha());
        
        $conexion->close();
        
        require_once ('../../lib/dompdf/dompdf_config.inc.php');
        $dompdf = new DOMPDF();

        $textoHTML = '<!DOCTYPE html>';
        $textoHTML .= '<html>';
        $textoHTML .=   '<head>';
        $textoHTML .=       '<meta charset="UTF-8">';
        $textoHTML .=       '<link rel="stylesheet" type="text/css" href="estilo_transaccion.css"/>';
        $textoHTML .=   '</head>';
        $textoHTML .=   '<body>';
        $textoHTML .=       '<table>';
        $textoHTML .=           '<thead>';
        $textoHTML .=               '<tr>';
        $textoHTML .=                   '<th colspan="2" class="th-logo"><img src="../../img/logo.png"/></th>';
        $textoHTML .=               '</tr>';
        $textoHTML .=               '<tr>';
        $textoHTML .=                   '<th colspan="2" class="th-nombre">Asociación amigos del arte</th>';
        $textoHTML .=               '</tr>';
        $textoHTML .=               '<tr>';
        $textoHTML .=                   '<th colspan="2"></th>';
        $textoHTML .=               '</tr>';
        $textoHTML .=               '<tr>';
        $textoHTML .=                   '<th colspan="2" class="th-titulo">Comprobante de transacción</th>';
        $textoHTML .=               '</tr>';
        $textoHTML .=           '</thead>';
        $textoHTML .=           '<tbody>';
        $textoHTML .=               '<tr>';
        $textoHTML .=                   '<td>Número de transacción</td>';
        $textoHTML .=                   '<td>'.$id_transaccion.'</td>';
        $textoHTML .=               '</tr>';
        $textoHTML .=               '<tr>';
        $textoHTML .=                   '<td>Fecha de transacción</td>';
        $textoHTML .=                   '<td>'.$fecha_T->format('d/m/Y H:i').'</td>';
        $textoHTML .=               '</tr>';
        $textoHTML .=               '<tr>';
        $textoHTML .=                   '<td>Usuario</td>';
        $textoHTML .=                   '<td>'.$usuario.'</td>';
        $textoHTML .=               '</tr>';
        $textoHTML .=               '<tr>';
        $textoHTML .=                   '<td>Película</td>';
        $textoHTML .=                   '<td>'.$pelicula->getNombre().'</td>';
        $textoHTML .=               '</tr>';
        $textoHTML .=               '<tr>';
        $textoHTML .=                   '<td>Función</td>';
        $textoHTML .=                   '<td>'.$fecha_F->format('d/m/Y H:i').'</td>';
        $textoHTML .=               '</tr>';
        $textoHTML .=               '<tr>';
        $textoHTML .=                   '<td>Sala</td>';
        $textoHTML .=                   '<td>'.$funcion->getSala().'</td>';
        $textoHTML .=               '</tr>';
        $textoHTML .=               '<tr>';
        $textoHTML .=                   '<td>Cantidad de entradas</td>';
        $textoHTML .=                   '<td>'.$cantidad_entradas.'</td>';
        $textoHTML .=               '</tr>';
        $textoHTML .=               '<tr>';
        $textoHTML .=                   '<td>Monto total</td>';
        $textoHTML .=                   '<td>$'.$transaccion->getMonto_total().'</td>';
        $textoHTML .=               '</tr>';
        $textoHTML .=           '</tbody>';
        $textoHTML .=       '</table>';
        $textoHTML .=   '</body>';
        $textoHTML .= '</html>';

        
        $dompdf->load_html($textoHTML);
        ini_set("memory_limit", "32M");
        ini_set("max_execution_time", "30");
        $dompdf->set_paper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('Reporte_Clientes.pdf', array("Attachment"=>0));
    }
?>