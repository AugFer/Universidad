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
    require_once 'clases/Usuario.php';
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
        $accion = filter_input(INPUT_POST,"accion",FILTER_SANITIZE_STRING);
        $usuario = new Usuario();
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
            if(!$usuario->cargar($conexion, $id)){
                echo '<div class="container">';
                echo '<div class="alert alert-danger" style="padding: 10px;">';
                echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                echo '<strong>ERROR: '.$usuario->getError().'</strong>';
                echo '</div>';
                echo '</div>';
            }
            if($accion=="actualizar"){
                $usuario->setTipo(filter_input(INPUT_POST,"tipo",FILTER_SANITIZE_STRING));
                $usuario->setApellido(filter_input(INPUT_POST,"apellido",FILTER_SANITIZE_STRING));
                $usuario->setNombre(filter_input(INPUT_POST,"nombre",FILTER_SANITIZE_STRING));
                $usuario->setCuenta(filter_input(INPUT_POST,"cuenta",FILTER_SANITIZE_STRING));
                $clave = filter_input(INPUT_POST,"clave",FILTER_SANITIZE_STRING);
                if(is_string($clave) && (strlen($clave)>=6) && (strlen($clave)<=32)){
                    $usuario->setClave($clave);
                }
                else{
                    $usuario->setClave("");
                }
               
                $correo = filter_input(INPUT_POST,"correo");
                $clean_email = filter_var($correo,FILTER_SANITIZE_EMAIL);
                if($correo == $clean_email && filter_var($correo,FILTER_VALIDATE_EMAIL)){
                    $usuario->setCorreo($correo);
                    
                    if($usuario->actualizar($conexion)){
                        echo '<div class="container">';
                        echo '<div class="alert alert-info" style="padding: 10px;">';
                        echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                        echo '<strong>Se actualizaron los datos del usuario en la base de datos.</strong>';
                        echo '</div>';
                        echo '</div>';
                    }
                    else{
                        echo '<div class="container">';
                        echo '<div class="alert alert-danger" style="padding: 10px;">';
                        echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                        echo '<strong>ERROR: '.$usuario->getError().'</strong>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
                else{
                    echo '<div class="container">';
                    echo '<div class="alert alert-warning" style="padding: 10px;">';
                    echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                    echo '<strong>Atención: el correo electronico no posee un formato válido.</strong>';
                    echo '</div>';
                    echo '</div>';
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
                        <h3 class="panel-title">Datos del usuario</h3>
                    </div>
                    <div class="panel-body">
                        <form autocomplete="off" method="post" action="files/usuario_modificar.php" onsubmit="return validarActualizacionUsuario()" class="form">
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">ID</span>
                                    <input id="id" name="id" type="text" value="<?php echo $usuario->getId();?>" tabindex="-1" class="form-control" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <select id="tipo" name="tipo" class="form-control" tabindex="1">
                                    <option value="" disabled hidden>Tipo</option>
                                    <option value="Cliente" <?php if($usuario->getTipo() == "Cliente") echo 'selected';?>>Cliente</option>
                                    <option value="Administrador" <?php if($usuario->getTipo() == "Administrador") echo 'selected';?>>Administrador</option>
                                  </select>
                            </div>
                            <div class="form-group">
                                <input id="apellido" name="apellido" type="text" maxlength="45" value="<?php echo $usuario->getApellido();?>" tabindex="2" class="form-control" placeholder="Apellido/s"/>
                            </div>
                            <div class="form-group"> 
                                <input id="nombre" name="nombre" type="text" maxlength="45" value="<?php echo $usuario->getNombre();?>" tabindex="3" class="form-control" placeholder="Nombre/s"/>
                            </div>
                            <div class="form-group">
                                <input id="cuenta" name="cuenta" type="text" maxlength="20" value="<?php echo $usuario->getCuenta();?>" tabindex="4" class="form-control" placeholder="Usuario"/>
                            </div>
                            <div class="form-group"> 
                                <input id="clave" name="clave" type="password" maxlength="32" value="" tabindex="5" class="form-control" placeholder="Contraseña"/>
                            </div>
                            <div class="form-group"> 
                                <input id="correo" name="correo" type="text" maxlength="80" value="<?php echo $usuario->getCorreo();?>" tabindex="6" class="form-control" placeholder="Correo electronico"/>
                            </div>
                            <div class="text-center">
                                <button id="actualizar" name="actualizar" type="submit" class="btn btn-primary" tabindex="7">Actualizar</button>
                                <input type="hidden" name="accion" value="actualizar"/>
                                <button id="limpiar" name="limpiar" type="reset" class="btn btn-default" tabindex="8">Limpiar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xs-1 col-sm-3 col-md-3 col-lg-4"></div>
        </div>
        <div class="row row-centrada">
                <a href="files/usuario_busqueda.php" id="btn-inicio"><img src="img/botones/regresar-negro.svg" class="link-img"></a>
        </div>
    </body>
</html>