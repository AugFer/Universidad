<?php
    session_start();
    if(isset($_SESSION['logueado'])&&($_SESSION['logueado']=2017))
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
    <body class="background">
<?php
    require_once 'clases/conexion.php';
    require_once 'clases/Usuario.php';
    require_once '../lib/PHPMailer/class.phpmailer.php';
    require_once 'secciones/modalError.php';
    
    $control=false;
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
        if($accion=="recuperar"){
            $correo = filter_input(INPUT_GET,"correo",FILTER_SANITIZE_STRING);
            if(!$correo) $correo = filter_input(INPUT_POST,"correo",FILTER_SANITIZE_STRING);
            if(!$correo){
                echo '<div class="container">';
                echo '<div class="alert alert-danger" style="padding: 10px;">';
                echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                echo '<strong>ERROR: no se encontró el correo electrónico.</strong>';
                echo '</div>';
                echo '</div>';
                echo '<div class="link-to-home"><a href="index.php" class="btn btn-link">Volver a la página de inicio de sesión</a></div>';
                die();
            }
            else{
                $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
                $max = strlen($characters) - 1;
                $nuevaPass = '';
                for ($i = 0; $i < 10; $i++){
                    $nuevaPass .= $characters[mt_rand(0, $max)];
                }
                $md5nuevaPass = md5($nuevaPass);
                if($conexion->multi_query("SELECT id_usuario, usu_cuenta FROM `usuarios` WHERE usu_correo='".$correo."'")){
                    $resultset = $conexion->store_result();
                    $row_cont = $resultset->num_rows;
                    if($row_cont>0){
                        $array = mysqli_fetch_array($resultset);
                        //$array = mysqli_fetch_row($resultset);
                        $id = $array['id_usuario'];
                        $usuario = $array['usu_cuenta'];
                        
                        //$id = $array[0];
                        //$usuario = $array[4];
                        $resultset->free();
                        
                        if($conexion->query("UPDATE `usuarios` SET usu_clave='".$md5nuevaPass."' WHERE id_usuario='".$id."'")){
                            $mail = new PHPMailer();
                            $mail->Host = 'smtp.gmail.com';
                            $mail->Port	  = 587;
                            $mail->Password    = 'Mechenien_2017';
                            $mail->From      = 'MechenienCinema@gmail.com';
                            $mail->FromName  = 'Mechenien';
                            $mail->Subject   = 'Mechenien: Restablecimiento de contraseña';
                            $mail->Body      = '¡Hola! recibimos tu solicitud de recuperacion de contraseña y hemos generado una nueva para que recuperes el acceso a tu cuenta.'
                                                . '<br/>'
                                                . '<br/>'
                                                . 'Tus datos de inicio de sesión son: '
                                                . '<br/>'
                                                . 'Usuario: <b>'.$usuario.'</b>'
                                                . '<br/>'
                                                . 'Contraseña: <b>'.$nuevaPass.'</b>'
                                                . '<br/>'
                                                . '<br/>'
                                                . 'Recomendamos que cambies la contraseña una vez obtengas acceso a tu cuenta.';
                            
                            //$mail->Body      = 'Se ha generado una nueva contraseña para su cuenta: <b>'.$nuevaPass.'</b><br/><br/>Recomendamos que cambie la contraseña una vez obtenga acceso a su cuenta.';
                            $mail->IsHTML(true);
                            $mail->CharSet = 'UTF-8';
                            $mail->AddAddress($correo);
                            $mail->Send();

                            if(!$mail->IsError()){
                                $control=true;
                            }
                            else{
                                echo '<div class="container">';
                                echo '<div class="alert alert-danger" style="padding: 10px;">';
                                echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                                echo '<strong>ERROR: ocurrió un error durante el envío del correo electrónico.</strong>';
                                //echo '<strong>ERROR: '.$mail->ErrorInfo.'</strong>';
                                echo '</div>';
                                echo '</div>';
                            }
                        }
                    }
                    else{
                        echo '<div class="container">';
                        echo '<div class="alert alert-danger" style="padding: 10px;">';
                        echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                        echo '<strong>ERROR: el correo electrónico no está asociado a ninguna cuenta.</strong>';
                        echo '</div>';
                        echo '</div>';
                    }
                }
            }
        }
        $conexion->close();
    }
    if(!$control){
?>
        <div class="container">
            <div class="row">
                <div class="row page-header">
                    <h1 class="texto-titulo text-center texto-blanco">Recuperación de contraseña</h1>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-1 col-sm-1 col-md-3 col-lg-3"></div>
                <div class="col-xs-10 col-sm-10 col-md-6 col-lg-6">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <h3 class="panel-title">Ingrese el correo electrónico asociado a su cuenta</h3>
                        </div>
                        <div class="panel-body">
                            <form autocomplete="off" method="post" action="files/clave_recuperacion.php" onSubmit="return validarRecuperacion()" class="form">
                                <div class="form-group">
                                    <input id="correo" name="correo" type="text" maxlength="80" tabindex="1" class="form-control" placeholder="Correo electrónico" autofocus/>
                                </div>
                                <div class="text-center">
                                    <button id="submit" name="submit" type="submit" class="btn btn-primary">Recuperar</button>
                                    <input type="hidden" name="accion" value="recuperar"/>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="link-to-home">
                        <a href="files/login.php" class="btn btn-link texto-blanco">Volver a la página de inicio de sesión</a>
                    </div>
                </div>
                <div class="col-xs-1 col-sm-1 col-md-3 col-lg-3"></div>
            </div>
<?php
    }
    else{
?>
            <div class="row">
                <div class="col-xs-1 col-sm-4 col-md-3 col-lg-3"></div>
                <div class="container text-center col-xs-10 col-sm-4 col-md-6 col-lg-6">
                    <div class="page-header text-center">
                        <h2>Recuperación de contraseña</h2>
                    </div>
                    <div class="alert alert-success" style="padding: 10px;">
                        <strong>Hemos enviado un correo electrónico con la información necesaria para que puedas acceder a tu cuenta.</strong>
                    </div>
                </div>
                <div class="col-xs-1 col-sm-4 col-md-3 col-lg-3"></div>
            </div>
            <div class="row">
                <div class="col-xs-1 col-sm-3 col-md-3 col-lg-4"></div>
                <div class="container-fluid link-to-home col-xs-10 col-sm-6 col-md-6 col-lg-4">
                    <a href="files/login.php" class="btn btn-link texto-blanco">Volver a la página de inicio de sesión</a>
                </div>
                <div class="col-xs-1 col-sm-3 col-md-3 col-lg-4"></div>
            </div>
            
<?php
    }
?>
            <div class="row row-centrada">
                <a href="index.php" id="btn-inicio"><img src="img/botones/inicio.svg" class="link-img"></a>
            </div>
        </div>
    </body>
</html>