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
    require_once 'clases/Funcion.php';
    require_once 'clases/Pelicula.php';
    require_once 'clases/Sala.php';
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
        $listadoPeliculas = Pelicula::listar($conexion);
        $listadoSalas = Sala::listar($conexion);
        
        $accion = filter_input(INPUT_POST,"accion",FILTER_SANITIZE_STRING);
        $funcion = new Funcion();
        $id = filter_input(INPUT_GET,"id",FILTER_VALIDATE_INT);
        if(!$id) $id = filter_input(INPUT_POST,"id",FILTER_VALIDATE_INT);
        if(!$id){
            echo '<div class="container">';
            echo '<div class="alert alert-danger" style="padding: 10px;">';
            echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
            echo '<strong>ERROR: no se encontró el ID del usuario.</strong>';
            echo '</div>';
            echo '</div>';
            echo '<div class="link-to-home"><a href="index.php" class="btn btn-link">Volver a la página principal</a></div>';
            die();
        }
        else{
            if(!$funcion->cargar($conexion, $id)){
                echo '<div class="container">';
                echo '<div class="alert alert-danger" style="padding: 10px;">';
                echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                echo '<strong>ERROR: '.$funcion->getError().'</strong>';
                echo '</div>';
                echo '</div>';
            }
            else{
                $fechaYHora = DateTime::createFromFormat('Y-m-d H:i:s', $funcion->getFecha());
                $pelicula = new Pelicula();
                $pelicula->cargar($conexion, $funcion->getPelicula());
                $duracionPelicula = $pelicula->getDuracion();
                
                if($accion=="actualizar"){
                    $funcion->setPelicula(filter_input(INPUT_POST,"pelicula",FILTER_VALIDATE_INT));
                    $funcion->setSala(filter_input(INPUT_POST,"sala",FILTER_VALIDATE_INT));
                    $funcion->setFecha(filter_input(INPUT_POST,"fecha"));
                    $fecha = $funcion->getFecha();
                    $hora = filter_input(INPUT_POST,"horario",FILTER_SANITIZE_STRING);
                    $fechaYHora = DateTime::createFromFormat('d/m/Y H:i', $fecha.' '.$hora);
                    
                    
                    if($funcion->actualizar($conexion, $fechaYHora, $duracionPelicula)){
                        echo '<div class="container">';
                        echo '<div class="alert alert-info" style="padding: 10px;">';
                        echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                        echo '<strong>Se actualizaron los datos de la función en la base de datos.</strong>';
                        echo '</div>';
                        echo '</div>';
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
        }
        $conexion->close();
    }
?>
        <div class="row">
            <div class="col-xs-1 col-sm-3 col-md-4 col-lg-4"></div>
            <div id="titulo" class="page-header text-center col-xs-10 col-sm-6 col-md-4 col-lg-4">
                <h2>Actualización de datos</h2>
            </div>
            <div class="col-xs-1 col-sm-3 col-md-4 col-lg-4"></div>
        </div>
        <div class="row">
            <div class="col-xs-1 col-sm-3 col-md-3 col-lg-4"></div>
            <div class="container-fluid col-xs-10 col-sm-6 col-md-6 col-lg-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Datos de la función</h3>
                    </div>
                    <div class="panel-body">
                        <form autocomplete="off" method="post" action="files/funcion_modificar.php" onsubmit="return validarActualizacionUsuario()" class="form">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">ID</span>
                                    <input id="id" name="id" type="text" value="<?php echo $funcion->getId();?>" tabindex="-1" class="form-control" readonly/>
                                </div>
                            </div>
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
                                    <input id="fecha" name="fecha" type="text" <?php if($funcion->getFecha()!=""){echo "value=".$fechaYHora->format('d/m/Y');} ?> class="form-control" tabindex="3"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Horario</span>
                                    <input id="horario" name="horario" type="text" <?php if($funcion->getFecha()!=""){echo "value=".$fechaYHora->format('H:i');} ?> class="form-control" tabindex="4"/>
                                </div>
                            </div>
                            <div class="text-center">
                                <button id="actualizar" name="actualizar" type="submit" class="btn btn-primary" tabindex="5">Actualizar</button>
                                <input type="hidden" name="accion" value="actualizar"/>
                                <button id="limpiar" name="limpiar" type="reset" class="btn btn-default" tabindex="6">Limpiar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xs-1 col-sm-3 col-md-3 col-lg-4"></div>
        </div>
        <div class="row row-centrada">
                <a href="files/funcion_busqueda.php" id="btn-inicio"><img src="img/botones/regresar-negro.svg" class="link-img"></a>
        </div>
        <script type="text/javascript">
            $(function(){
                $('#fecha').datetimepicker({
                    format: 'L'
                });
                for(var i=1; i<=6; i++){
                    $('#horario').datetimepicker({
                        format: 'LT'
                    });
                }
            });
        </script>
    </body>
</html>