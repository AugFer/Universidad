<?php
    require_once 'autenticacion_admin.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
            require_once 'secciones/head.php';
        ?>
    </head>
    <body>
<?php
    require_once 'secciones/navbar.php';
    require_once 'secciones/modalError.php';
    
    require_once 'clases/Conexion.php';
    require_once 'clases/Configuracion.php';
    $conexion = Conexion::establecer();
    if($conexion->connect_error){
        echo '<div class="container" style="padding: 5px;">';
        echo '<div class="alert alert-danger" style="padding: 10px;">';
        echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
        echo '<strong>ERROR: '.$conexion->connect_error.'</strong>';
        echo '</div>';
        echo '</div>';
    }
    else{
        
        function asd($nro, $arrayPrecios, $dias){
            if(!empty($arrayPrecios)){
                echo 'value="'.$arrayPrecios[$nro].'"';
            }
            else{
                echo 'value="'.$dias[$nro].'"';
            }
        }
        
        $listado = Configuracion::listar($conexion);
        $arrayPrecios = array();
        $dias = array();
        $i=0;
        while($row = mysqli_fetch_array($listado)){
            $dias[$i]= $row['con_costo'];
            $i++;
        }
        mysqli_data_seek($listado, 0);
        
        $accion = filter_input(INPUT_POST,"accion",FILTER_SANITIZE_STRING);
        if($accion=="actualizar"){
            
            $diaEstrenos = filter_input(INPUT_POST,"dia_estrenos",FILTER_SANITIZE_STRING);
            $arrayDias = array("Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo");
            
            for($i=0;$i<7;$i++){
                $precio = filter_input(INPUT_POST,$arrayDias[$i]);
                $arrayPrecios[] = $precio;
            }
            
            if(Configuracion::actualizar($conexion, $arrayDias, $arrayPrecios, $diaEstrenos)){
                echo '<div class="container">';
                echo '<div class="alert alert-info" style="padding: 10px;">';
                echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                echo '<strong>Se actualizaron los datos en la base de datos.</strong>';
                echo '</div>';
                echo '</div>';
                
            }
            else{
                echo '<div class="container">';
                echo '<div class="alert alert-danger" style="padding: 10px;">';
                echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                echo '<strong>ERROR: ocurrió un problema al intentar actualizar los datos.</strong>';
                echo '</div>';
                echo '</div>';
            }
        }
        $conexion->close();
    }
?>
        <div class="row">
            <div class="col-xs-1 col-sm-3 col-md-4 col-lg-4"></div>
            <div id="titulo" class="page-header text-center col-xs-10 col-sm-6 col-md-4 col-lg-4">
                <h2>Configuración de precios y día de estrenos</h2>
            </div>
            <div class="col-xs-1 col-sm-3 col-md-4 col-lg-4"></div>
        </div>
        <div class="row">
            <div class="col-xs-1 col-sm-3 col-md-3 col-lg-4"></div>
            <div class="container-fluid col-xs-10 col-sm-6 col-md-6 col-lg-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Información</h3>
                    </div>
                    <div class="panel-body">
                        <form autocomplete="off" method="post" action="files/configurar_precios_estrenos.php" onsubmit="return validarConfiguracion()" class="form">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Día de estrenos</span>
                                    <select id="dia_estrenos" name="dia_estrenos" class="form-control" tabindex="1">
                                        <option value="" disabled selected hidden>Día de estrenos</option>
                                        <?php
                                            if($listado != null){
                                                if($listado->num_rows == 0) echo '<option value="0">Error en la carga de datos</option>';
                                                else{
                                                    while($reg = $listado->fetch_object()){
                                                        if(!isset($diaEstrenos)){
                                                            if($reg->con_actualiza_cartelera==1){
                                                                echo '<option value="'.$reg->id_configuracion.'" selected>'.$reg->con_dia.'</option>';
                                                            }
                                                            else{
                                                                echo '<option value="'.$reg->id_configuracion.'">'.$reg->con_dia.'</option>';
                                                            }
                                                        }
                                                        else{
                                                            if($reg->id_configuracion==$diaEstrenos){
                                                                echo '<option value="'.$reg->id_configuracion.'" selected>'.$reg->con_dia.'</option>';
                                                            }
                                                            else{
                                                                echo '<option value="'.$reg->id_configuracion.'">'.$reg->con_dia.'</option>';
                                                            }
                                                        }
                                                    }
                                                    $listado->free_result();
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <table class="table table-bordered table-hover table-condensed">
                                    <thead class="text-info h4">
                                        <tr>
                                            <th class="input-group-addon">Día</th><th>Valor de entrada</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="input-group-addon">Lunes</td>
                                            <td><input id="Lunes" name="Lunes" type="number" min="0" class="form-control" tabindex="2" <?PHP asd(0, $arrayPrecios, $dias); ?>/></td>
                                        </tr>
                                        <tr>
                                            <td class="input-group-addon">Martes</td>
                                            <td><input id="Martes" name="Martes" type="number" min="0" class="form-control" tabindex="3" <?PHP asd(1, $arrayPrecios, $dias); ?>/></td>
                                        </tr>
                                        <tr>
                                            <td class="input-group-addon">Miércoles</td>
                                            <td><input id="Miércoles" name="Miércoles" type="number" min="0" class="form-control" tabindex="4" <?PHP asd(2, $arrayPrecios, $dias); ?>/></td>
                                        </tr>
                                        <tr>
                                            <td class="input-group-addon">Jueves</td>
                                            <td><input id="Jueves" name="Jueves" type="number" min="0" class="form-control" tabindex="5" <?PHP asd(3, $arrayPrecios, $dias); ?>/></td>
                                        </tr>
                                        <tr>
                                            <td class="input-group-addon">Viernes</td>
                                            <td><input id="Viernes" name="Viernes" type="number" min="0" class="form-control" tabindex="6" <?PHP asd(4, $arrayPrecios, $dias); ?>/></td>
                                        </tr>
                                        <tr>
                                            <td class="input-group-addon">Sábado</td>
                                            <td><input id="Sábado" name="Sábado" type="number" min="0" class="form-control" tabindex="7" <?PHP asd(5, $arrayPrecios, $dias); ?>/></td>
                                        </tr>
                                        <tr>
                                            <td class="input-group-addon">Domingo</td>
                                            <td><input id="Domingo" name="Domingo" type="number" min="0" class="form-control" tabindex="8" <?PHP asd(6, $arrayPrecios, $dias); ?>/></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center">
                                <button id="registrar" name="registrar" type="submit" class="btn btn-primary" tabindex="9">Actualizar</button>
                                <input type="hidden" name="accion" value="actualizar"/>
                                <button id="limpiar" name="limpiar" type="reset" class="btn btn-default" tabindex="10">Limpiar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xs-1 col-sm-3 col-md-3 col-lg-4"></div>
        </div>
        <div class="row row-centrada">
            <a href="index.php" id="btn-inicio"><img src="img/botones/regresar-negro.svg" class="link-img"></a>
        </div>
    </body>
</html>