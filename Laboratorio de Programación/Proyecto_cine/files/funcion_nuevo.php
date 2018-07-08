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
    
    require_once 'clases/conexion.php';
    require_once 'clases/Funcion.php';
    require_once 'clases/Pelicula.php';
    require_once 'clases/Sala.php';
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
        $listadoPeliculas = Pelicula::listar($conexion);
        $listadoSalas = Sala::listar($conexion);
        
        $accion = filter_input(INPUT_POST,"accion",FILTER_SANITIZE_STRING);
        $funcion = new Funcion();
        $nroFunciones = array();
        $fechaHoraFunciones = array();
        
        function recuperarValor($inputID, $nroFunciones, $fechaHoraFunciones){
            for($i=0; $i<count($nroFunciones); $i++){
                if("H".$nroFunciones[$i]==$inputID){
                    $valor = $fechaHoraFunciones[$i];
                    echo "value=".$valor->format('H:i');
                    break;
                }
            }
        }
        
        if($accion=="registrar"){
            $funcion->setPelicula(filter_input(INPUT_POST,"pelicula",FILTER_VALIDATE_INT));
            $funcion->setSala(filter_input(INPUT_POST,"sala",FILTER_VALIDATE_INT));
            $funcion->setFecha(filter_input(INPUT_POST,"fecha"));
            $fecha = $funcion->getFecha();
            $pelicula = new Pelicula();
            $pelicula->cargar($conexion, $funcion->getPelicula());
            $duracionPelicula = $pelicula->getDuracion();
            
            //Se cargan los arrays con los numeros de las funciones y las horas especificadas
            for($i=1;$i<=6;$i++){
                $hora = filter_input(INPUT_POST,"H".$i);
                if($hora!=""){
                    $nroFunciones[] = $i;
                    $fechaCompleta = DateTime::createFromFormat('d/m/Y H:i', $fecha.' '.$hora);
                    $fechaHoraFunciones[] = $fechaCompleta;
                }
            }
            if($funcion->guardar($conexion, $fechaHoraFunciones, $nroFunciones, $duracionPelicula)){
                echo '<div class="container">';
                echo '<div class="alert alert-success" style="padding: 10px;">';
                echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                echo '<strong>Se creó un nuevo registro en la base de datos.</strong>';
                echo '</div>';
                echo '</div>';
                $funcion->resetear();
                $nroFunciones = array();
                $fechaHoraFunciones = array();
            }
            else{
                echo '<div class="container">';
                echo '<div class="alert alert-danger" style="padding: 10px;">';
                echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                echo '<strong>ERROR: '.$funcion->getError().'</strong>';
                echo '</div>';
                echo '</div>';
            }
        }
    }
    $conexion->close();
?>
        <div class="row">
            <div class="col-xs-1 col-sm-3 col-md-4 col-lg-4"></div>
            <div class="page-header text-center col-xs-10 col-sm-6 col-md-4 col-lg-4">
                <h2>Nueva función</h2>
            </div>
            <div class="col-xs-1 col-sm-3 col-md-4 col-lg-4"></div>
        </div>
        <div class="row">
            <div class="col-xs-1 col-sm-3 col-md-3 col-lg-4"></div>
            <div class="container-fluid col-xs-10 col-sm-6 col-md-6 col-lg-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Datos</h3>
                    </div>
                    <div class="panel-body">
                        <form autocomplete="off" method="post" action="files/funcion_nuevo.php" onSubmit="return validarFuncion()" class="form">
                            <div class="form-group">
                                <select id="pelicula" name="pelicula" class="form-control" tabindex="1" autofocus>
                                    <option value="0" disabled selected hidden>Película</option>
                                    <?php
                                        if($listadoPeliculas != null){
                                            if($listadoPeliculas->num_rows == 0) echo '<option value="0">Error en la carga de datos</option>';
                                            else{
                                                while($reg = $listadoPeliculas->fetch_object()){
                                                    if($funcion->getPelicula()==$reg->id_pelicula){
                                                        echo '<option value="'.$reg->id_pelicula.'" selected>'.$reg->pel_nombre.' ('.$reg->pel_duracion.' min)</option>';
                                                    }
                                                    else{
                                                        echo '<option value="'.$reg->id_pelicula.'">'.$reg->pel_nombre.' ('.$reg->pel_duracion.' min)</option>';
                                                    }
                                                }
                                                $listadoPeliculas->free_result();
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <select id="sala" name="sala" class="form-control" tabindex="2">
                                    <option value="0" disabled selected hidden>Sala</option>
                                    <?php
                                        if($listadoSalas != null){
                                            if($listadoSalas->num_rows == 0) echo '<option value="0">Error en la carga de datos</option>';
                                            else{
                                                while($reg = $listadoSalas->fetch_object()){
                                                    if($reg->sal_disponibilidad=="Habilitada"){
                                                        if($funcion->getSala()==$reg->id_sala){
                                                            echo '<option value="'.$reg->id_sala.'" selected>Sala '.$reg->id_sala.'</option>';
                                                        }
                                                        else{
                                                            echo '<option value="'.$reg->id_sala.'">Sala '.$reg->id_sala.'</option>';
                                                        }
                                                    }
                                                }
                                                $listadoSalas->free_result();
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Fecha</span>
                                    <input id="fecha" name="fecha" type="text" <?php if($funcion->getFecha()!=""){echo "value=".$funcion->getFecha();} ?> class="form-control" tabindex="3"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <table class="table table-bordered table-hover table-condensed">
                                    <thead class="text-info h4">
                                        <tr>
                                            <th class="input-group-addon">Función</th><th>Horario</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="input-group-addon">1</td><td><input id="H1" name="H1" type="text" <?php recuperarValor('H1', $nroFunciones, $fechaHoraFunciones); ?> class="form-control" tabindex="4"/></td>
                                        </tr>
                                        <tr>
                                            <td class="input-group-addon">2</td><td><input id="H2" name="H2" type="text" <?php recuperarValor('H2', $nroFunciones, $fechaHoraFunciones); ?> class="form-control" tabindex="5"/></td>
                                        </tr>
                                        <tr>
                                            <td class="input-group-addon">3</td><td><input id="H3" name="H3" type="text" <?php recuperarValor('H3', $nroFunciones, $fechaHoraFunciones); ?> class="form-control" tabindex="6"/></td>
                                        </tr>
                                        <tr>
                                            <td class="input-group-addon">4</td><td><input id="H4" name="H4" type="text" <?php recuperarValor('H4', $nroFunciones, $fechaHoraFunciones); ?> class="form-control" tabindex="7"/></td>
                                        </tr>
                                        <tr>
                                            <td class="input-group-addon">5</td><td><input id="H5" name="H5" type="text" <?php recuperarValor('H5', $nroFunciones, $fechaHoraFunciones); ?> class="form-control" tabindex="8"/></td>
                                        </tr>
                                        <tr>
                                            <td class="input-group-addon">6</td><td><input id="H6" name="H6" type="text" <?php recuperarValor('H6', $nroFunciones, $fechaHoraFunciones); ?> class="form-control" tabindex="9"/></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-center">
                                <button id="registrar" name="registrar" type="submit" class="btn btn-primary" tabindex="10">Registrar</button>
                                <input type="hidden" name="accion" value="registrar"/>
                                <button id="limpiar" name="limpiar" type="reset" class="btn btn-default" tabindex="11">Limpiar</button>
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
        <script type="text/javascript">
            $(function(){
                $('#fecha').datetimepicker({
                    format: 'L'
                });
                for(var i=1; i<=6; i++){
                    $('#H'+i).datetimepicker({
                        format: 'LT'
                    });
                }
            });
        </script>
    </body>
</html>