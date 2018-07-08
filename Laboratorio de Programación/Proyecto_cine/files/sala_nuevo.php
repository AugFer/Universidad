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
        $accion = filter_input(INPUT_POST,"accion",FILTER_SANITIZE_STRING);
        $sala = new Sala();
        if($accion=="registrar"){
            $sala->setCapacidad(filter_input(INPUT_POST,"capacidad",FILTER_VALIDATE_INT));
            $sala->setDisponibilidad(filter_input(INPUT_POST,"disponibilidad",FILTER_SANITIZE_STRING));
            if($sala->guardar($conexion)){
                echo '<div class="container">';
                echo '<div class="alert alert-success" style="padding: 10px;">';
                echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                echo '<strong>Se creó un nuevo registro en la base de datos.</strong>';
                echo '</div>';
                echo '</div>';
                $sala->resetear();
            }
            else{
                echo '<div class="container">';
                echo '<div class="alert alert-danger" style="padding: 10px;">';
                echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                echo '<strong>ERROR: '.$sala->getError().'</strong>';
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
                <h2>Nueva sala</h2>
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
                        <form autocomplete="off" method="post" action="files/sala_nuevo.php" onSubmit="return validarSala()" class="form">
                            <div class="form-group">
                                <input id="capacidad" name="capacidad" type="text" onkeypress="return esNumero(event)" <?php if($sala->getCapacidad()!=""){echo "value=".$sala->getCapacidad();}?> tabindex="1" class="form-control" placeholder="Capacidad" autofocus/>
                            </div>
                            <div class="form-group">
                                <select id="disponibilidad" name="disponibilidad" class="form-control" tabindex="2">
                                    <option value="" disabled selected hidden>Disponibilidad</option>
                                    <option value="Habilitada" <?php if($sala->getDisponibilidad() == "Habilitada") echo 'selected';?>>Habilitada</option>
                                    <option value="Deshabilitada" <?php if($sala->getDisponibilidad() == "Deshabilitada") echo 'selected';?>>Deshabilitada</option>
                                </select>
                            </div>
                            <div class="text-center">
                                <button id="registrar" name="registrar" type="submit" class="btn btn-primary" tabindex="3">Registrar</button>
                                <input type="hidden" name="accion" value="registrar"/>
                                <button id="limpiar" name="limpiar" type="reset" class="btn btn-default" tabindex="4">Limpiar</button>
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