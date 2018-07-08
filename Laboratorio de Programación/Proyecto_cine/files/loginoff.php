<!DOCTYPE html>
<html>
    <head>
        <?php
            require_once 'secciones/head.php';
        ?>
    </head>
    <body class="background">
        <?php
            session_start();
            if(isset($_GET['session']) && ($_GET['session']=='off')){
                unset($_SESSION['logueado']);
                session_destroy();
                if((session_id()!="") || isset($_COOKIE[session_name()])){
                    if(setcookie(session_name(), '', time()-3600, '/')){
                        header('Refresh:3;URL=../index.php');
                        echo '<div class="container text-center">';
                        echo '  <div class="alert alert-success" style="padding: 10px;">';
                        echo '      <strong><h2 class="page-header">Sesión finalizada con éxito</h2></strong>';
                        echo '      <p>Serás redireccionado a la página de inicio en 3 segundos.</p>';
                        echo '  </div>';
                        echo '  <div class="row row-centrada">';
                        echo '      <a href="index.php" id="btn-inicio"><img src="img/botones/inicio.svg" class="link-img"></a>';
                        echo '  </div>';
                        echo '</div>';
                        die();
                    }
                }
            }
            else{
                header("Location:../index.php");
                die();
            }
        ?>
    </body>
</html>