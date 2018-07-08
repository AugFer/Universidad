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
            if(!isset($_SESSION['logueado'])||($_SESSION['logueado']!=2017)){
                header('Refresh:3;URL=../index.php');
                echo '<div class="container text-center">';
                echo '  <div class="alert alert-danger" style="padding: 10px;">';
                echo '      <strong><h2 class="page-header">Acceso no autorizado</h2></strong>';
                echo '      <p>Serás redireccionado a la página de inicio en 3 segundos.</p>';
                echo '  </div>';
                echo '  <div class="row row-centrada">';
                echo '      <a href="index.php" id="btn-inicio"><img src="img/botones/inicio.svg" class="link-img"></a>';
                echo '  </div>';
                echo '</div>';
                die();
            }
        ?>
    </body>
</html>