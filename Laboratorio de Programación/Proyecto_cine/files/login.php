<?php
    session_start();
    if(isset($_SESSION['logueado'])&&($_SESSION['logueado']=2017)){
        header("Location:../index.php");
        die();
    }
//--------PROYECTO CINE---------//
    $accion = filter_input(INPUT_POST, "accion", FILTER_SANITIZE_STRING);
    if($accion=="login"){
        require_once 'clases/conexion.php';
        require_once 'clases/usuario.php';
        
        $cuenta = filter_input(INPUT_POST, "cuenta", FILTER_SANITIZE_STRING);
        $clave = filter_input(INPUT_POST, "clave", FILTER_SANITIZE_STRING);
        
        if((strlen($cuenta)<=20) && ((strlen($clave)>=6) && (strlen($clave)<=32))){
            $conexion = Conexion::establecer();
            if(!$conexion->connect_error){
                if(Usuario::validarAcceso($conexion, $cuenta, md5($clave))){
                    $usuario = new Usuario();
                    $usuario->cargarPorCuenta($conexion, $cuenta);
                    $_SESSION['logueado'] = 2017;
                    $_SESSION['usuario'] = $usuario->getApellido().", ".$usuario->getNombre();
                    $_SESSION['cuenta'] = $usuario->getCuenta();
                    $_SESSION['id'] = $usuario->getId();
                    $_SESSION['perfil'] = $usuario->getTipo();
                    $conexion->close();
                    unset($usuario);
                    header("Location:../index.php");
                }
                else{
                    echo '<div class="container" style="padding: 5px;">';
                    echo '<div class="alert alert-danger" style="padding: 10px;">';
                    echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                    echo '<strong>ERROR: los datos ingresados son incorrectos.</strong>';
                    echo '</div>';
                    echo '</div>';
                    $conexion->close();
                }
            }
        }
        else{
            echo '<div class="container" style="padding: 5px;">';
            echo '<div class="alert alert-danger" style="padding: 10px;">';
            echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
            echo '<strong>ERROR: los datos ingresados son incorrectos.</strong>';
            echo '</div>';
            echo '</div>';
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
            require_once 'secciones/head.php';
        ?>
    </head>
    <body class="background">
        <div class="container">
            <div class="row">
                <div class="row page-header">
                    <h1 class="texto-titulo text-center texto-blanco">Inicio de sesión</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1 col-sm-3 col-md-3 col-lg-4"></div>
                <div class="col-xs-10 col-sm-6 col-md-6 col-lg-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Datos de usuario</h3>
                        </div>
                        <div class="panel-body">
                            <form id="formulario" name="formulario" autocomplete="off" method="post" action="files/login.php" class="form">
                                <div class="form-group">
                                    <input id="cuenta" name="cuenta" type="text" maxlength="20" tabindex="1" class="form-control" placeholder="Usuario" autofocus/>
                                </div>
                                <div class="form-group"> 
                                    <input id="clave" name="clave" type="password" maxlength="32" tabindex="2" class="form-control" placeholder="Contraseña"/>   
                                </div>
                                <div class="text-center">
                                    <button id="submit" name="submit" type="submit" class="btn btn-primary">Iniciar sesión</button>
                                    <input type="hidden" name="accion" value="login"/>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="link-to-home">
                        <a href="files/clave_recuperacion.php" class="btn btn-link texto-blanco">¿Olvidó su contraseña?</a>
                    </div>
                </div>
                <div class="col-xs-1 col-sm-3 col-md-3 col-lg-4"></div>
            </div>
            <div class="row row-centrada">
                <a href="index.php" id="btn-inicio"><img src="img/botones/inicio.svg" class="link-img"></a>
            </div>
        </div>
    </body>
</html>