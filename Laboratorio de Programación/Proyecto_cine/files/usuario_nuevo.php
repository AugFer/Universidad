<?php
    session_start();
    $perfil = "Visitante";
    if(isset($_SESSION['logueado'])&&($_SESSION['logueado']=2017))
    {
        $perfil = $_SESSION['perfil'];
    }
    if($perfil == "Cliente")
    {
        header("Location:../index.php");
        die();
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
            require_once 'secciones/head.php';
        ?>
    </head>
    <body <?php if($perfil != "Administrador"){echo 'class="background"';}?>>
<?php
    require_once 'secciones/navbar.php';
    require_once 'secciones/modalError.php';
    
    require_once 'clases/conexion.php';
    require_once 'clases/usuario.php';
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
        $usuario = new Usuario();
        if($accion=="registrar"){
            $usuario->setTipo(filter_input(INPUT_POST,"tipo",FILTER_SANITIZE_STRING));
            if($perfil == "Visitante"){
                $usuario->setTipo("Cliente");
            }
            $usuario->setApellido(filter_input(INPUT_POST,"apellido",FILTER_SANITIZE_STRING));
            $usuario->setNombre(filter_input(INPUT_POST,"nombre",FILTER_SANITIZE_STRING));
            $usuario->setCuenta(filter_input(INPUT_POST,"cuenta",FILTER_SANITIZE_STRING));
            $usuario->setClave(filter_input(INPUT_POST,"clave",FILTER_SANITIZE_STRING));
            $correo = filter_input(INPUT_POST,"correo");
            $clean_email = filter_var($correo,FILTER_SANITIZE_EMAIL);
            if($correo == $clean_email && filter_var($correo,FILTER_VALIDATE_EMAIL)){
                $usuario->setCorreo($correo);
                if($usuario->guardar($conexion)){
                    if($perfil == "Visitante"){
                        $_SESSION['logueado'] = 2017;
                        $_SESSION['usuario'] = $usuario->getApellido().", ".$usuario->getNombre();
                        $_SESSION['cuenta'] = $usuario->getCuenta();
                        $_SESSION['id'] = $usuario->getId();
                        $_SESSION['perfil'] = $usuario->getTipo();
                        $_SESSION['nuevoUsuario'] = "¡Te damos la bienvenida a la comunidad!";
                        $conexion->close();
                        unset($usuario);
                        header("Location:../index.php");
                    }
                    echo '<div class="container">';
                    echo '<div class="alert alert-success" style="padding: 10px;">';
                    echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                    echo '<strong>Se creó un nuevo registro en la base de datos.</strong>';
                    echo '</div>';
                    echo '</div>';
                    $usuario->resetear();
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
                echo '<strong>Atención: el correo electrónico no posee un formato válido.</strong>';
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
            <?php                
                if($perfil=="Administrador"){
            ?>
                    <h2>Alta de usuario</h2>
            <?php 
                }
                else{
            ?>
                    <h2 class="texto-blanco">Regístrate en Mechenien</h2>
            <?php
                }
            ?>   
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
                        <form autocomplete="off" method="post" action="files/usuario_nuevo.php" onSubmit="return validarUsuario()" class="form">
                        <?php
                            if($perfil=="Administrador"){
                        ?>
                            <div class="form-group">
                                <select id="tipo" name="tipo" class="form-control" tabindex="1">
                                    <option value="" disabled selected hidden>Tipo</option>
                                    <option value="Cliente" <?php if($usuario->getTipo() == "Cliente") echo 'selected';?>>Cliente</option>
                                    <option value="Administrador" <?php if($usuario->getTipo() == "Administrador") echo 'selected';?>>Administrador</option>
                                  </select>
                            </div>
                        <?php
                            }
                            else{
                        ?>
                            <div class="form-group" hidden>
                                <input id="tipo" name="tipo" type="text" value="dummy" tabindex="-1" hidden disabled/>
                            </div>
                        <?php
                            }
                        ?>
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
                                <input id="clave" name="clave" type="password" maxlength="32" value="<?php echo $usuario->getClave();?>" tabindex="5" class="form-control" placeholder="Contraseña"/>
                            </div>
                            <div class="form-group"> 
                                <input id="correo" name="correo" type="text" maxlength="80" value="<?php echo $usuario->getCorreo();?>" tabindex="6" class="form-control" placeholder="Correo electrónico"/>
                            </div>
                            <div class="text-center">
                                <button id="registrar" name="registrar" type="submit" class="btn btn-primary" tabindex="7">Registrar</button>
                                <input type="hidden" name="accion" value="registrar"/>
                                <button id="limpiar" name="limpiar" type="reset" class="btn btn-default" tabindex="8">Limpiar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xs-1 col-sm-3 col-md-3 col-lg-4"></div>
        </div>
        <div class="row row-centrada">
        <?php                
            if($perfil=="Administrador"){
        ?>
                <a href="index.php" id="btn-inicio"><img src="img/botones/regresar-negro.svg" class="link-img"></a>
        <?php 
            }
            else{
        ?>
                <a href="index.php" id="btn-inicio"><img src="img/botones/regresar.svg" class="link-img"></a>
        <?php
            }
        ?>
        </div>
    </body>
</html>