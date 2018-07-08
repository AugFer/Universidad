<?php
    require_once '../clases/conexion.php';
    require_once '../clases/pelicula.php';
    require_once '../clases/genero.php';
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
        $pelicula = new Pelicula();
        $id_pelicula = (filter_input(INPUT_POST,"id_pelicula",FILTER_VALIDATE_INT));
        $pelicula->cargar($conexion, $id_pelicula);
        $genero = new Genero();
        $genero->cargar($conexion, $pelicula->getGenero());
        
        $conexion->close();
        
        require_once ('../../lib/dompdf/dompdf_config.inc.php');
        $dompdf = new DOMPDF();

        $textoHTML = '<!DOCTYPE html>';
        $textoHTML .= '<html>';
        $textoHTML .=   '<head>';
        $textoHTML .=       '<meta charset="UTF-8">';
        $textoHTML .=       '<link type="text/css" rel="stylesheet" href="../../lib/bootstrap/css/bootstrap.min.css"/>';
        $textoHTML .=       '<link rel="stylesheet" type="text/css" href="../../css/estilo.css"/>';
        $textoHTML .=       '<link rel="stylesheet" type="text/css" href="estilo_pelicula.css"/>';
        $textoHTML .=   '</head>';
        $textoHTML .=   '<body>';
        $textoHTML .=   '    <div class="row">';
        $textoHTML .=   '        <div class="thumbnail">';
        $textoHTML .=   '            <div>';
        $textoHTML .=   '                <h1>'.$pelicula->getNombre().'</h1>';
        $textoHTML .=   '                <hr>';
        $textoHTML .=   '            </div>';
        $textoHTML .=   '            <table>';
        $textoHTML .=   '               <tr>';
        $textoHTML .=   '                   <td class="imagen"><img src="../../img/peliculas/'.$pelicula->getImagen().'"></td>';
        $textoHTML .=   '                   <td class="info">';
        $textoHTML .=   '                       <div>';
        $textoHTML .=   '                           <h4>';
        $textoHTML .=   '                               Año:';
        $textoHTML .=   '                               <small class="text-muted">'.$pelicula->getAño().'</small>';
        $textoHTML .=   '                           </h4>';
        $textoHTML .=   '                           <h4>';
        $textoHTML .=   '                               Nacionalidad:';
        $textoHTML .=   '                               <small class="text-muted">'.$pelicula->getNacionalidad().'</small>';
        $textoHTML .=   '                           </h4>';
        $textoHTML .=   '                           <h4>';
        $textoHTML .=   '                               Director:';
        $textoHTML .=   '                               <small class="text-muted">'.$pelicula->getDirector().'</small>';
        $textoHTML .=   '                           </h4>';
        $textoHTML .=   '                           <h4>';
        $textoHTML .=   '                               Actores principales:';
        $textoHTML .=   '                               <small class="text-muted">'.$pelicula->getActores_pri().'</small>';
        $textoHTML .=   '                           </h4>';
        $textoHTML .=   '                           <h4>';
        $textoHTML .=   '                               Actores secundarios:';
        $textoHTML .=   '                               <small class="text-muted">'.$pelicula->getActores_sec().'</small>';
        $textoHTML .=   '                           </h4>';
        $textoHTML .=   '                           <h4>';
        $textoHTML .=   '                               Web oficial:';
        $textoHTML .=   '                               <small class="text-muted"><a class="link-to-OW" target="_blank" href="http://'.$pelicula->getWeb().'">'.$pelicula->getWeb().'</a></small>';
        $textoHTML .=   '                           </h4>';
        $textoHTML .=   '                           <h4>';
        $textoHTML .=   '                               Genero:';
        $textoHTML .=   '                               <small class="text-muted">'.$genero->getNombre().'</small>';
        $textoHTML .=   '                           </h4>';
        $textoHTML .=   '                           <h4>';
        $textoHTML .=   '                               Duración:';
        $textoHTML .=   '                               <small class="text-muted">'.$pelicula->getDuracion().' minutos</small>';
        $textoHTML .=   '                           </h4>';
        $textoHTML .=   '                       </div>';
        $textoHTML .=   '                   </td>';
        $textoHTML .=   '               </tr>';
        $textoHTML .=   '            </table>';
        $textoHTML .=   '            <div>';
        $textoHTML .=   '               <hr>';
        $textoHTML .=   '               <h4>';
        $textoHTML .=   '                    Sinópsis';
        $textoHTML .=   '               </h4>';
        $textoHTML .=   '               <p class="text-muted" style="text-indent: 25px">'.$pelicula->getSinopsis().'</p>';
        $textoHTML .=   '            </div>';
        $textoHTML .=   '        </div>';
        $textoHTML .=   '    </div>';
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