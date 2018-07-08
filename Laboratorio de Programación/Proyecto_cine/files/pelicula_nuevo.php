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
    require_once 'clases/pelicula.php';
    require_once 'clases/genero.php';
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
        $listado = Genero::listar($conexion);
        $accion = filter_input(INPUT_POST,"accion",FILTER_SANITIZE_STRING);
        $pelicula = new Pelicula();
        if($accion=="registrar"){
            $pelicula->setNombre(filter_input(INPUT_POST,"nombre",FILTER_SANITIZE_STRING));
            $pelicula->setAño(filter_input(INPUT_POST,"año",FILTER_VALIDATE_INT));
            $pelicula->setNacionalidad(filter_input(INPUT_POST,"nacionalidad",FILTER_SANITIZE_STRING));
            $pelicula->setDirector(filter_input(INPUT_POST,"director",FILTER_SANITIZE_STRING));
            $pelicula->setActores_pri(filter_input(INPUT_POST,"actores_pri",FILTER_SANITIZE_STRING));
            $pelicula->setActores_sec(filter_input(INPUT_POST,"actores_sec",FILTER_SANITIZE_STRING));
            $pelicula->setWeb(filter_input(INPUT_POST,"web",FILTER_SANITIZE_STRING));
            $pelicula->setSinopsis(filter_input(INPUT_POST,"sinopsis",FILTER_SANITIZE_STRING));
            $pelicula->setGenero(filter_input(INPUT_POST,"genero",FILTER_VALIDATE_INT));
            $pelicula->setDuracion(filter_input(INPUT_POST,"duracion",FILTER_SANITIZE_STRING));
            $pelicula->setImagen("");
            if($pelicula->guardar($conexion)){
                $info = pathinfo($_FILES['imagen']['name']);
                $ext = $info['extension'];
                $dateTime = new DateTime('NOW');
                $newname = $pelicula->getId()."_".$dateTime->format('d-m-Y_H-i-s').".".$ext;
                $target = '../img/peliculas/'.$newname;
                $pelicula->setImagen($newname);
                
                if($pelicula->actualizar($conexion)){
                    move_uploaded_file($_FILES['imagen']['tmp_name'], $target);
                    echo '<div class="container">';
                    echo '<div class="alert alert-success" style="padding: 10px;">';
                    echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                    echo '<strong>Se creó un nuevo registro en la base de datos.</strong>';
                    echo '</div>';
                    echo '</div>';
                    $pelicula->resetear();
                }
                else{
                    echo '<div class="container">';
                    echo '<div class="alert alert-danger" style="padding: 10px;">';
                    echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                    echo '<strong>ERROR: '.$pelicula->getError().'</strong>';
                    echo '</div>';
                    echo '</div>';
                }
            }
            else{
                echo '<div class="container">';
                echo '<div class="alert alert-danger" style="padding: 10px;">';
                echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                echo '<strong>ERROR: '.$pelicula->getError().'</strong>';
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
                <h2>Nueva película</h2>
            </div>
            <div class="col-xs-1 col-sm-3 col-md-4 col-lg-4"></div>
        </div>
        <div class="row">
            <div class="col-xs-1 col-sm-3 col-md-3 col-lg-3"></div>
            <div class="container-fluid col-xs-10 col-sm-6 col-md-6 col-lg-6">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">Datos</h3>
                    </div>
                    <div class="panel-body">
                        <form id="form" autocomplete="off" method="post" enctype='multipart/form-data' action="files/pelicula_nuevo.php" onSubmit="return validarPelicula()" class="form">
                            <div class="form-group">
                                <input id="nombre" name="nombre" type="text" maxlength="80" value="<?php echo $pelicula->getNombre();?>" tabindex="1" class="form-control" placeholder="Nombre" autofocus/>
                            </div>
                            <div class="form-group">
                                <select id="año" name="año" tabindex="2" class="form-control">
                                    <option value="0" disabled selected hidden>Año</option>
                                    <?php
                                    $inicio = 1900;
                                    $fin = date("Y");
                                    for($i = $fin; $i >= $inicio; $i--){
                                        if($pelicula->getAño()==$i){
                                            echo '<option value="'.$i.'" selected>'.$i.'</option>';
                                        }
                                        else{
                                            echo '<option value="'.$i.'">'.$i.'</option>';
                                        }  
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <input id="nacionalidad" name="nacionalidad" type="text" maxlength="45" value="<?php echo $pelicula->getNacionalidad();?>" tabindex="3" class="form-control" placeholder="Nacionalidad"/>
                            </div>
                            <div class="form-group"> 
                                <input id="director" name="director" type="text" maxlength="45" value="<?php echo $pelicula->getDirector();?>" tabindex="4" class="form-control" placeholder="Director"/>
                            </div>
                            <div class="form-group"> 
                                <input id="actores_pri" name="actores_pri" type="text" maxlength="150" value="<?php echo $pelicula->getActores_pri();?>" tabindex="5" class="form-control" placeholder="Actores principales"/>
                            </div>
                            <div class="form-group"> 
                                <input id="actores_sec" name="actores_sec" type="text" maxlength="150" value="<?php echo $pelicula->getActores_sec();?>" tabindex="6" class="form-control" placeholder="Actores secundarios"/>
                            </div>
                            <div class="form-group"> 
                                <input id="web" name="web" type="text" maxlength="80" value="<?php echo $pelicula->getWeb();?>" tabindex="7" class="form-control" placeholder="Web oficial"/>
                            </div>
                            <div class="form-group"> 
                                <textarea id="sinopsis" name="sinopsis" maxlength="700" rows="5" tabindex="8" class="form-control" placeholder="Sinopsis"><?php echo $pelicula->getSinopsis();?></textarea>
                            </div>
                            <div class="form-group">
                                <select id="genero" name="genero" tabindex="9" class="form-control">
                                    <option value="0" disabled selected hidden>Género</option>
                                    <?php
                                        if($listado != null){
                                            if($listado->num_rows == 0) echo '<option value="0">Error en la carga de datos</option>';
                                            else{
                                                while($reg = $listado->fetch_object()){
                                                    if($pelicula->getGenero()==$reg->id_genero){
                                                        echo '<option value="'.$reg->id_genero.'" selected>'.$reg->gen_nombre.'</option>';
                                                    }
                                                    else{
                                                        echo '<option value="'.$reg->id_genero.'">'.$reg->gen_nombre.'</option>';
                                                    }
                                                }
                                                $listado->free_result();
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <input id="duracion" name="duracion" type="text" maxlength="3" onkeypress="return esNumero(event)" value="<?php echo $pelicula->getDuracion();?>" tabindex="10" class="form-control" placeholder="Duración"/>
                                    <span class="input-group-addon">minutos</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Imagen</span>
                                    <input id="imagen" name="imagen" type="file" accept="image/png, image/jpg, image/jpeg" onchange="previsualizarImagen(this)" tabindex="11" class="form-control input-img input-file-alineacion"/>
                                    <div id="contenedor-previsualizacion" class="contenedor-img">
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button id="registrar" name="registrar" type="submit" class="btn btn-primary" tabindex="12">Registrar</button>
                                <input type="hidden" name="accion" value="registrar"/>
                                <button id="limpiar" name="limpiar" type="reset" class="btn btn-default" tabindex="13" onclick="eliminarImagen()">Limpiar</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-xs-1 col-sm-3 col-md-3 col-lg-3"></div>
        </div>
        <div class="row row-centrada">
                <a href="index.php" id="btn-inicio"><img src="img/botones/regresar-negro.svg" class="link-img"></a>
        </div>
    </body>
</html>