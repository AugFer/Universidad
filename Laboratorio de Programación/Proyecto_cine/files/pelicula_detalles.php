<?php
    session_start();
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
    require_once 'secciones/navbar.php';
    
    require_once 'clases/conexion.php';
    require_once 'clases/pelicula.php';
    require_once 'clases/genero.php';
    require_once 'clases/funcion.php';
    require_once 'clases/configuracion.php';
    require_once 'clases/Comentario.php';
    
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
        $listado = genero::listar($conexion);
        $pelicula = new Pelicula();
        $id = filter_input(INPUT_GET,"id",FILTER_SANITIZE_STRING);
        if(!$id) $id = filter_input(INPUT_POST,"id",FILTER_SANITIZE_STRING);
        if(!$id){
            echo '<div class="container">';
            echo '<div class="alert alert-danger" style="padding: 10px;">';
            echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
            echo '<strong>ERROR: no se encontró el nombre de la película.</strong>';
            echo '</div>';
            echo '</div>';
            echo '<div class="link-to-home"><a href="index.php" class="btn btn-link">Volver a la página principal</a></div>';
            die();
        }
        else{
            if(!$pelicula->cargar($conexion, $id)){
                echo '<div class="container">';
                echo '<div class="alert alert-danger" style="padding: 10px;">';
                echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                echo '<strong>ERROR: '.$pelicula->getError().'</strong>';
                echo '</div>';
                echo '</div>';
                echo '<div class="link-to-home"><a href="index.php" class="btn btn-link">Volver a la página principal</a></div>';
                die();
            }
            
            $accion = filter_input(INPUT_POST,"accion",FILTER_SANITIZE_STRING);
            $comentario = new Comentario();
            if($accion=="comentar"){
                
                $comentario->setId_usuario($_SESSION['id']);
                $comentario->setId_pelicula($id);
                $fecha = new DateTime('NOW');
                $comentario->setFecha($fecha->format('Y-m-d H:i:s'));
                $comentario->setComentario(filter_input(INPUT_POST,"comentario",FILTER_SANITIZE_STRING));
                
                if($comentario->guardar($conexion)){
                    echo '<div class="container">';
                    echo '<div class="alert alert-success" style="padding: 10px;">';
                    echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                    echo '<strong>Comentario publicado.</strong>';
                    echo '</div>';
                    echo '</div>';
                    $comentario->resetear();
                }
                else{
                    echo '<div class="container">';
                    echo '<div class="alert alert-danger" style="padding: 10px;">';
                    echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                    echo '<strong>ERROR: '.$comentario->getError().'</strong>';
                    echo '</div>';
                    echo '</div>';
                }
            }
        }
       $conexion->close(); 
    }
    
    if(isset($_SESSION['perfil']) && ($_SESSION['perfil']=="Administrador")){
?>
        <div class="row">
            <div class="col-xs-1 col-sm-3 col-md-4 col-lg-4"></div>
            <div id="titulo" class="page-header text-center texto-blanco col-xs-10 col-sm-6 col-md-4 col-lg-4">
                <h2>Detalles de película</h2>
            </div>
            <div class="col-xs-1 col-sm-3 col-md-4 col-lg-4"></div>
        </div>
<?php
    }
?>
        <div class="row">
            <div class="container thumbnail" style="padding: 20px">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h1 class="text-center">
                        <?php echo $pelicula->getNombre();?>
                    </h1>
                    <hr>
                </div>
                <img class="img-responsive col-xs-12 col-sm-4 col-md-4 col-lg-4" alt="Poster" src="<?php if($pelicula->getImagen()!=""){echo 'img/peliculas/'.$pelicula->getImagen();}else{echo 'img/peliculas/noImage.png';}?>">
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <h4>
                        Año:
                        <small class="text-muted"><?php echo $pelicula->getAño();?></small>
                    </h4>
                    <h4>
                        Nacionalidad:
                        <small class="text-muted"><?php echo $pelicula->getNacionalidad();?></small>
                    </h4>
                    <h4>
                        Director:
                        <small class="text-muted"><?php echo $pelicula->getDirector();?></small>
                    </h4>
                    <h4>
                        Actores principales:
                        <small class="text-muted"><?php echo $pelicula->getActores_pri();?></small>
                    </h4>
                    <h4>
                        Actores secundarios:
                        <small class="text-muted"><?php echo $pelicula->getActores_sec();?></small>
                    </h4>
                    <h4>
                        Web oficial:
                        <small class="text-muted"><a class="link-to-OW" target="_blank" href="http://<?php echo $pelicula->getWeb();?>"><?php echo $pelicula->getWeb();?></a></small>
                    </h4>
                    <h4>
                        Género:
                        <small class="text-muted">
                            <?php
                                while($reg = $listado->fetch_object()){
                                    if($pelicula->getGenero()==$reg->id_genero){
                                        echo $reg->gen_nombre;
                                        break;
                                    }
                                }
                                $listado->free_result();
                            ?>
                        </small>
                    </h4>
                    <h4>
                        Duración:
                        <small class="text-muted"><?php echo $pelicula->getDuracion();?> minutos</small>
                    </h4>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
                    <hr>
                    <h4>
                        Sinopsis
                    </h4>
                     <p class="text-muted" style="text-indent: 25px"><?php echo $pelicula->getSinopsis();?></p>
                </div>
            <?php               
                if(isset($_SESSION['perfil']) && ($_SESSION['perfil']=="Administrador")){
            ?>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="text-right">
                            <form id="imprimir" name="imprimir" method="post" action="files/reportes/reporte_pelicula.php" target="_blank" class="form-horizontal"> 
                                <input type="hidden" id="id_pelicula" name="id_pelicula" value="<?php echo $pelicula->getId(); ?>"/>
                                <button type="submit" class="btn btn-danger text-uppercase"><img src="img/varios/pdf.svg" style="max-width: 50px;"/></button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php
                }
            ?>
            </div>
        </div>
        
        <?php
            $conexion = Conexion::establecer();
            $diaActualizaCartelera = new Configuracion();
            $diaActualizaCartelera->cargarDiaEstrenos($conexion);
            $listadoFunciones = Funcion::listarFuncionesPelicula($conexion, $id, $diaActualizaCartelera->getDia());
            
            if($listadoFunciones != null){
                if($listadoFunciones->num_rows != 0){
                    $lunes = array();
                    $martes = array();
                    $miercoles = array();
                    $jueves = array();
                    $viernes = array();
                    $sabado = array();
                    $domingo = array();
                    
                    setlocale(LC_ALL,'es_RA','spanish');
                    $precioDias = array();
                    $fechasSemana = array();
                    $hoy = new DateTime('NOW');
                    $dia = ucfirst(utf8_encode(strftime("%A",$hoy->getTimestamp())));
                    while($dia!=$diaActualizaCartelera->getDia()){//se busca la fecha del día de estrenos de cartelera
                        $hoy->modify('-1 day');
                        $dia = ucfirst(utf8_encode(strftime("%A",$hoy->getTimestamp())));
                    }
                    for($i=1;$i<=7;$i++){//a partir de la fecha de arriba, se cargan las de los 7 dias de la semana que corresponden a la cartelera actual
                        $fechasSemana[] = $hoy->format('d/m');
                        
                        $dia = ucfirst(utf8_encode(strftime("%A",$hoy->getTimestamp())));
                        $diaActual = Configuracion::cargarPorNombre($conexion,$dia);
                        $reg = $diaActual->fetch_object();
                        $precioDias[] = $reg->con_costo;
                        
                        $hoy->modify('+1 day');
                    }
                    
                    
                    while($reg = $listadoFunciones->fetch_object()){
                        $actual = DateTime::createFromFormat('Y-m-d H:i:s', $reg->fun_fecha);
                        $dia = utf8_encode(strftime("%A",$actual->getTimestamp()));
                        if($dia=="lunes"){
                            $lunes[] = $reg;
                        }
                        else{
                            if($dia=="martes"){
                                $martes[] = $reg;
                            }
                            else{
                                if($dia=="miércoles"){
                                    $miercoles[] = $reg;
                                }
                                else{
                                    if($dia=="jueves"){
                                        $jueves[] = $reg;
                                    }
                                    else{
                                        if($dia=="viernes"){
                                            $viernes[] = $reg;
                                        }
                                        else{
                                            if($dia=="sábado"){
                                            $sabado[] = $reg;
                                            }
                                            else{
                                                $domingo[] = $reg;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $listadoFunciones->free_result();
                    
                    echo '<div class="row">';
                    echo '  <div class="container thumbnail" style="padding: 20px">';
                    echo '      <div class="row">';
                    echo '          <div>';
                    echo '              <h2 class="text-center">';
                    echo '                  Funciones';
                    echo '              </h2>';
                    echo '              <hr>';
                    echo '          </div>';
                    echo '          <div id="container-horarios" class="container-fluid text-center">';
                    echo '              <div class="btn-group btn-group-justified">';
                                            for($i=0;$i<count($fechasSemana); $i++){
                                                $actual = DateTime::createFromFormat('d/m', $fechasSemana[$i]);
                                                $dia = utf8_encode(strftime("%A",$actual->getTimestamp()));
                    echo '                      <div class="btn-group">';
                    echo '                          <button class="btn-dia btn btn-primary" id="'.$dia.'">'.ucfirst($dia).' '.$fechasSemana[$i].'<br/>$'.$precioDias[$i].'</button>';
                    echo '                      </div>';
                                            }
                    echo '              </div>';


                    $diasSemana = array("lunes", "martes", "miércoles", "jueves", "viernes", "sábado", "domingo");
                    $horariosDias = array($lunes, $martes, $miercoles, $jueves, $viernes, $sabado, $domingo);
                    for($i=0;$i<=6;$i++){
                        if(isset($_SESSION['logueado'])&&($_SESSION['logueado']=2017)){
                            echo '              <table id="table-'.$diasSemana[$i].'" class="table table-hover table-bordered table-horarios" style="display:none;">';
                            echo '                  <thead class="alert-info">';
                            echo '                      <tr>';
                            echo '                          <th>Horario</th>';
                            echo '                          <th>Sala</th>';
                            echo '                          <th>Entradas</th>';
                            echo '                      </tr>';
                            echo '                  </thead>';
                            echo '                  <tbody>';
                                                        $dia = $horariosDias[$i];
                                                        if(!empty($dia)){
                                                            for($j=0; $j<count($dia); $j++){
                                                                $funcion = $dia[$j];
                                                                $datetime = DateTime::createFromFormat('Y-m-d H:i:s', $funcion->fun_fecha);
                            echo '                              <tr>';
                            echo '                                  <td>'.$datetime->format('H:i').'</td>';
                            echo '                                  <td>'.$funcion->fun_id_sala.'</td>';
                            echo '                                  <td><a href="files/entrada_comprar.php?id='.$funcion->id_funcion.'"><span><img src="img/varios/comprar.svg" style="max-width: 25px;"/></span> Comprar</a></td>';
                            echo '                              </tr>';
                                                            }
                                                        }
                                                        else {
                            echo '                          <tr class="text-center">';
                            echo '                              <td style="display: none;"></td>';
                            echo '                              <td colspan="3">No hay funciones programadas para este día.</td>';
                            echo '                              <td style="display: none;"></td>';
                            echo '                          </tr>';
                                                        }
                            echo '                  </tbody>';
                            echo '              </table>';
                        }
                        else{
                            echo '              <table id="table-'.$diasSemana[$i].'" class="table table-hover table-bordered table-horarios" style="display:none;">';
                            echo '                  <thead class="alert-info">';
                            echo '                      <tr>';
                            echo '                          <th>Horario</th>';
                            echo '                          <th>Sala</th>';
                            echo '                      </tr>';
                            echo '                  </thead>';
                            echo '                  <tbody>';
                                                        $dia = $horariosDias[$i];
                                                        if(!empty($dia)){
                                                            for($j=0; $j<count($dia); $j++){
                                                                $funcion = $dia[$j];
                                                                $datetime = DateTime::createFromFormat('Y-m-d H:i:s', $funcion->fun_fecha);
                            echo '                              <tr class="text-center">';
                            echo '                                  <td>'.$datetime->format('H:i').'</td>';
                            echo '                                  <td>'.$funcion->fun_id_sala.'</td>';
                            echo '                              </tr>';
                                                            }
                                                        }
                                                        else {
                            echo '                          <tr class="text-center">';
                            echo '                              <td style="display: none;"></td>';
                            echo '                              <td colspan="2">No hay funciones programadas para este día.</td>';
                            echo '                          </tr>';
                                                        }
                            echo '                  </tbody>';
                            echo '              </table>';
                        }
                    }
                    echo '          </div>';
                    echo '      </div>';
                    echo '  </div>';
                    echo '</div>';
                }
            }
            $conexion->close();
        ?>
        
        <div class="row">
            <div class="container thumbnail" style="padding: 20px">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <h2 class="text-center">Comentarios</h2>
                    <hr>
                </div>
        <?php
            if(isset($_SESSION['logueado'])&&($_SESSION['logueado']=2017)){
        ?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <form autocomplete="off" method="post" action="files/pelicula_detalles.php" class="form"> 
                        <div class="form-group">
                            <textarea id="comentario" name="comentario" class="form-control coment-textarea" rows="5" maxlength="300" placeholder="¿Ya viste la película? ¡Comentanos que te pareció y como la pasaste en Mechenien!"></textarea>
                        </div>
                        <div class="form-group">
                            <button id="comentar" name="comentar" type="submit" class="btn btn-success text-uppercase"><span><img src="img/varios/enviar_comentario.svg" style="max-width: 20px;"/></span> Comentar</button>
                            <input type="hidden" name="accion" value="comentar"/>
                            <input id="id" name="id" type="hidden" value="<?php echo $pelicula->getId();?>"/>
                        </div>            
                    </form>
                    <hr>
                </div>
        <?php 
            }
            else{
        ?>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <a href="files/login.php"><button class="btn btn-warning text-uppercase">Inicia sesión para comentar</button></a>
                    <hr>
                </div>
        <?php 
            }
            $conexion = Conexion::establecer();
            $listadoComentarios = Comentario::listar($conexion, $id);

            if($listadoComentarios != null){
                if($listadoComentarios->num_rows == 0){
                    echo'<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 comentario">';
                    echo'   <ul>';
                    echo'       <li class="list-unstyled">';
                    echo'           <p>Nadie ha comentado aún. ¡Vamos! Rompe el hielo y se el primero en decir lo que piensas.</p>';
                    echo'       </li>';
                    echo'   </ul>';
                    echo'   <hr/>';
                    echo'</div>';
                }
                else{
                    while($reg = $listadoComentarios->fetch_object()){
                        $fechaComentario = new DateTime($reg->com_fecha);
                        echo'<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 comentario">';
                        echo'   <div class="text-uppercase">';
                        echo'       <h4>'.$reg->usu_cuenta.' <small class="text-muted h6">'.$fechaComentario->format('d/m/Y H:i').'</small></h4>';
                        echo'   </div>';
                        echo'   <ul>';
                        echo'       <li class="list-unstyled">';
                        echo'           <p>'.$reg->com_comentario.'</p>';
                        echo'       </li>';
                        echo'   </ul>';
                        echo'   <hr/>';
                        echo'</div>';
                    }
                    $listadoComentarios->free_result();
                }

            }
            $conexion->close();
        ?>
            </div>
        </div>
        <div class="row">
            <a id="btn-regresar" href="<?php echo $_SESSION['paginaAnterior']; ?>" class="link-left"><img src="img/botones/regresar.svg" class="link-img"></a>
            <a id="btn-arriba" class="link-right"><img src="img/botones/arriba.svg" class="link-img"></a>
        </div>
        <script>
            $(document).ready(function(){
                $('#btn-arriba').click(function(){
                    $("html, body").animate({ scrollTop: 0 }, 1000);
                    return false;
                });
            });
        </script>
        <script>
            $(document).ready(function(){
                $('.table').DataTable({
                    dom: "<tr>"
                       + "<p>",
                    "paging": true,
                    "language":{
                        "lengthMenu": "_MENU_ por página",
                        "zeroRecords": "No hay funciones.",
                        "info": "Página _PAGE_ de _PAGES_",
                        "infoEmpty": "",
                        "infoFiltered": "(Entre _MAX_ entradas)",
                        "paginate":{
                            "first": "Primera",
                            "last": "Última",
                            "next": "Siguiente",
                            "previous": "Anterior"
                        }
                    }
                });
                $(".dataTables_wrapper").hide();
            });
            
            $(document).ready(function(){
                $(".btn-dia").click(function(){
                    $(".dataTables_wrapper").hide();
                    $("#table-"+this.getAttribute('id')+"_wrapper").show();
                    $("#table-"+this.getAttribute('id')).show();
                });
            });
            
            $(document).mouseup(function (e){
                var container = $("#container-horarios");
                if (!container.is(e.target) && container.has(e.target).length === 0){
                    $(".dataTables_wrapper").hide();
                }
            });
        </script>
        <?php
            require_once 'secciones/footbar.php';
        ?>
    </body>
</html>