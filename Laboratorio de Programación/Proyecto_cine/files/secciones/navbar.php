<?php
    $usuario = "Visitante";
    if (isset($_SESSION['logueado'])&&($_SESSION['logueado']=2017))
    {
        $usuario = $_SESSION['usuario'];
    }
?>
<nav class="navbar navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar_collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Mechenien</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar_collapse">
            <ul class="nav navbar-nav">
              <li><a href="files/pelicula_busqueda.php" class="navbar-link">Búsqueda</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php
                    if ($usuario == "Visitante"){
                        echo '<li><a href="files/login.php" class="navbar-link">Iniciar sesión</a></li>';
                        echo '<li><a href="files/usuario_nuevo.php" class="navbar-link">Registrarse</a></li>';
                    }
                    else{
                        echo '<li class="dropdown">';
                        echo '  <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"><span><img src="img/varios/usuario.svg" style="max-width: 20px;"/></span> '.$usuario.' <span class="caret"></span></a>';
                        echo '  <ul class="dropdown-menu">';
                        //echo '      <li><a class="navbar-link" href="files/usuario_modificar.php">Modificar datos</a></li>';
                        //echo '      <li><a class="navbar-link" href="files/usuario_eliminar.php">Eliminar cuenta</a></li>';
                        //echo '      <li class="divider"></li>';
                        echo '      <li><a class="navbar-link" href="files/usuario_historial.php">Historial</a></li>';
                        echo '      <li><a class="navbar-link" href="files/loginoff.php?session=off">Cerrar sesión</a></li>';
                        echo '    </ul>';
                        echo '</li>';
                    }
                ?>
            </ul>
        </div>
    </div>
</nav>