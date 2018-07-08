<?php
//--------PROYECTO CINE---------//
    session_start();
    $usuario = "Visitante";
    $cuenta = "Visitante";
    $perfil = "Visitante";
    $_SESSION['paginaAnterior'] = $_SERVER['REQUEST_URI']; //Al parecer no es un buen metodo para un boton de "pagina anterior", investigar despues
    if(isset($_SESSION['logueado'])&&($_SESSION['logueado']=2017))
    {
        $usuario = $_SESSION['usuario'];
        $cuenta = $_SESSION['cuenta'];
        $perfil = $_SESSION['perfil'];
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <?php
            require_once 'files/secciones/head.php';
        ?>
    </head>
    <body class="background">
        <?php
            require_once 'files/secciones/navbar.php';
            
            if(isset($_SESSION['nuevoUsuario'])){
                echo '<div class="container">';
                echo '<div class="alert alert-success text-center" style="padding: 10px;">';
                echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                echo '<strong>'.$_SESSION['nuevoUsuario'].'</strong>';
                echo '</div>';
                echo '</div>';
                unset($_SESSION['nuevoUsuario']);
            }
            if($perfil=="Administrador"){
        ?>
        <div class="menu-admin">
            <div class="container">
                <div class="row">
                    <div class="col col-md-5 col-lg-5">
                        <div class="row page-header">
                            <h2>Usuarios</h2>
                        </div>
                        <div class="row">
                            <a href="files/usuario_nuevo.php" class="btn btn-primary btn-block">Nuevo usuario</a>
                            <a href="files/usuario_busqueda.php" class="btn btn-primary btn-block">Búsqueda y listado de usuarios</a>
                        </div>
                        <hr/>
                    </div>
                    <div class="col col-md-2 col-lg-2"></div>
                    <div class="col col-md-5 col-lg-5">
                        <div class="row page-header">
                            <h2>Películas</h2>
                        </div>
                        <div class="row">
                            <a href="files/pelicula_nuevo.php" class="btn btn-primary btn-block">Nueva pelicula</a>
                            <a href="files/pelicula_busqueda.php" class="btn btn-primary btn-block">Búsqueda y listado de peliculas</a>
                        </div>
                        <hr/>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-5 col-lg-5">
                        <div class="row page-header">
                            <h2>Salas</h2>
                        </div>
                        <div class="row">
                            <a href="files/sala_nuevo.php" class="btn btn-primary btn-block">Nueva sala</a>
                            <a href="files/sala_busqueda.php" class="btn btn-primary btn-block">Búsqueda y listado de salas</a>
                        </div>
                        <hr/>
                    </div>
                    <div class="col col-md-2 col-lg-2"></div>
                    <div class="col col-md-5 col-lg-5">
                        <div class="row page-header">
                            <h2>Funciones</h2>
                        </div>
                        <div class="row">
                            <a href="files/funcion_nuevo.php" class="btn btn-primary btn-block">Nueva función</a>
                            <a href="files/funcion_busqueda.php" class="btn btn-primary btn-block">Búsqueda y listado de funciones</a>
                            </div>
                        <hr/>
                    </div>
                </div>
                <div class="row">
                    <div class="col col-md-3 col-lg-3"></div>
                    <div class="col col-md-6 col-lg-6">
                        <div class="row page-header">
                            <h2>Configuración</h2>
                        </div>
                        <div class="row">
                            <a href="files/configurar_precios_estrenos.php" class="btn btn-primary btn-block">Precio de entradas y día de estrenos</a>
                        </div>
                        <hr/>
                    </div>
                    <div class="col col-md-3 col-lg-3"></div>
                </div>
                <br/>
                <br/>
            </div>
        </div>
                
        <?php
            }
            require_once 'files/clases/conexion.php';
            require_once 'files/clases/Pelicula.php';
            require_once 'files/clases/configuracion.php';
            
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
                
                $diaActualizaCartelera = new Configuracion();
                $diaActualizaCartelera->cargarDiaEstrenos($conexion);
                
                $listadoEstrenos = Pelicula::listarEstrenos($conexion, $diaActualizaCartelera->getDia());
                $listadoProximas = Pelicula::listarProximas($conexion, $diaActualizaCartelera->getDia());
        ?>
        
        <div class="row">
            <div class="container">  
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h1 class="texto-titulo text-center texto-blanco">Cartelera semanal</h1>
                    <hr/>
                </div>
                <div class="row-centrada">
                    <?php
                        if($listadoEstrenos != null){
                            if($listadoEstrenos->num_rows == 0){
                                echo '<h4 class="text-center texto-blanco">No hay funciones progrmadas para esta semana.</h2>';
                            }
                            else{
                                while($reg = $listadoEstrenos->fetch_object()){
                                    echo '<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-centrada">';
                                    echo '  <div class="contenedor-centrado">';
                                    echo '    <a class="a-cartelera" href="files/pelicula_detalles.php?id='.$reg->id_pelicula.'">';
                                    echo '      <div class="thumbnail">';
                                    echo '          <div class="image">';
                                    echo '              <img src="img/peliculas/'.$reg->pel_imagen.'" class="img-responsive img-cartelera"/>';
                                    echo '          </div>';
                                    echo '          <div class="caption text-center h3">'.$reg->pel_nombre.'</div>';
                                    echo '      </div>';
                                    echo '    </a>';
                                    echo '  </div>';
                                    echo '</div>';
                                }
                                $listadoEstrenos->free_result();
                            }
                        }
                    ?>
                </div>
                <br/>
                <br/>
                <br/>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h1 class="texto-titulo text-center texto-blanco">Próximos estrenos</h1>
                    <hr/>
                </div>
                <div class="row-centrada">
                    <?php
                        if($listadoProximas != null){
                            if($listadoProximas->num_rows == 0){
                                echo '<h4 class="text-center texto-blanco">No hay peliculas definidas para la proxima semana.</h2>';
                            }
                            else{
                                while($reg = $listadoProximas->fetch_object()){
                                    echo '<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-centrada">';
                                    echo '  <div class="contenedor-centrado">';
                                    echo '    <a class="a-cartelera" href="files/pelicula_detalles.php?id='.$reg->id_pelicula.'">';
                                    echo '      <div class="thumbnail">';
                                    echo '          <div class="image">';
                                    echo '              <img src="img/peliculas/'.$reg->pel_imagen.'" class="img-responsive img-cartelera"/>';
                                    echo '          </div>';
                                    echo '          <div class="caption text-center h3">'.$reg->pel_nombre.'</div>';
                                    echo '      </div>';
                                    echo '    </a>';
                                    echo '  </div>';
                                    echo '</div>';
                                }
                                $listadoProximas->free_result();
                            }
                        }
                    ?>
                </div>
                <br/>
            </div>
        </div>
        
        <div class="row">
            <a id="btn-arriba" class="link-right"><img src="img/botones/arriba.svg" class="link-img"></a>
        </div>
    <?php
        }
        require_once 'files/secciones/footbar.php';
    ?>
        <script>
            $(function(){
                $('#btn-arriba').click(function(){
                    $("html, body").animate({ scrollTop: 0 }, 1000);
                    return false;
                });
            });
        </script>
        <script>
            function igualarAltura(group){    
                var masAlto = 0;
                group.each(function(){       
                    var alturaActual = $(this).height();
                    if(alturaActual > masAlto){
                        masAlto = alturaActual;       
                    }
                });
                group.each(function(){
                    $(this).height(masAlto);
                });
            }
            function igualarAncho(group){    
                var masAncho = 0;
                group.each(function(){       
                    var anchoActual = $(this).width();
                    if(anchoActual > masAncho){
                        masAncho = anchoActual;       
                    }
                });
                group.each(function(){
                    $(this).width(masAncho);
                });
            }

            $(function(){
                igualarAltura($(".thumbnail"));
                igualarAltura($(".img-cartelera"));
                igualarAltura($(".caption"));
                igualarAncho($(".thumbnail"));
                igualarAncho($(".caption"));
            });
        </script>
    </body>
</html>