<?php
    session_start();
    $perfil = "Visitante";
    if(isset($_SESSION['logueado'])&&($_SESSION['logueado']=2017))
    {
        $perfil = $_SESSION['perfil'];
    }
    $_SESSION['paginaAnterior'] = $_SERVER['REQUEST_URI'];//Al parecer no es un buen metodo para un boton de "pagina anterior", investigar despues
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

    require_once 'clases/conexion.php';
    require_once 'clases/Pelicula.php';
    require_once 'clases/Genero.php';
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
        $condiciones = array();
        $columnas = array();
        $por_nombre = filter_input(INPUT_POST,"por_nombre",FILTER_SANITIZE_STRING);
        $por_año = filter_input(INPUT_POST,"por_año",FILTER_SANITIZE_NUMBER_INT);
        $por_nacionalidad = filter_input(INPUT_POST,"por_nacionalidad",FILTER_SANITIZE_STRING);
        $por_genero = filter_input(INPUT_POST,"por_genero",FILTER_SANITIZE_NUMBER_INT);

        if($por_nombre!=""){
            $condiciones[] = $por_nombre;
            $columnas[] = "pel_nombre";
        }
        if($por_año!=0){
            $condiciones[] = $por_año;
            $columnas[] = "pel_año";
        }
        if($por_nacionalidad!=""){
            $condiciones[] = $por_nacionalidad;
            $columnas[] = "pel_nacionalidad";
        }
        if($por_genero!=0){
            $condiciones[] = $por_genero;
            $columnas[] = "pel_genero";
        }

        function filtrarPeliculas($conexion, $query){
            $filter_Result = mysqli_query($conexion, $query);
            return $filter_Result;
        }

        $query = "SELECT * FROM peliculas";
        if(count($condiciones)>0){
            $query .= " WHERE ";
            for($i=0; $i<count($condiciones);$i++){
                if($i>0){
                    $query .= " AND ";
                }
                if($columnas[$i]=="pel_nombre" || $columnas[$i]=="pel_nacionalidad"){
                    $query .= $columnas[$i]." LIKE '%".$condiciones[$i]."%'";
                }
                else{
                    if($columnas[$i]=="pel_año" || $columnas[$i]=="pel_genero"){
                        $query .= $columnas[$i]."=".$condiciones[$i];
                    }
                }
            }
            $search_result = filtrarPeliculas($conexion, $query);
        }
        else{
            //$search_result = filtrarPeliculas($conexion, $query);
        }
    }
    $conexion->close();
?>
    <div class="row">
            <?php
                if($perfil!="Administrador"){
                    echo'<div class="container thumbnail" style="padding: 20px">';
                }
            ?>
                <div class="row">
                        <?php                
                        if($perfil=="Administrador"){
                        ?>
                            <div class="col-xs-1 col-sm-3 col-md-4 col-lg-4"></div>
                            <div class="page-header text-center col-xs-10 col-sm-6 col-md-4 col-lg-4">
                                <h2>Búsqueda y listado de películas</h2>
                            </div>
                            <div class="col-xs-1 col-sm-3 col-md-4 col-lg-4"></div>
                        <?php 
                            }
                            else{
                        ?>
                            <div class="col-xs-1 col-sm-2 col-md-3 col-lg-3"></div>
                            <div class="text-center col-xs-10 col-sm-8 col-md-6 col-lg-6">
                                <h2>Búsqueda de películas</h2>
                                <hr/>
                                <p>Aquí puedes buscar películas que han pasado por las salas de Mechenien.</p>
                            </div>
                            <div class="col-xs-1 col-sm-2 col-md-3 col-lg-3"></div>
                        <?php
                            }
                        ?>
                </div>
                <div class="row">
                    <div class="container-fluid">
                        <form method="post" action="files/pelicula_busqueda.php" class="form">
                            <table class="table table-bordered table-hover table-responsive tabla-filtros">
                                <tr>
                                    <td><input id="por_nombre" name="por_nombre" type="text" <?php if($por_nombre!=""){echo "value=".$por_nombre;} ?> class="form-control" tabindex="1" placeholder="Nombre"/></td>
                                    <td><select id="por_año" name="por_año" tabindex="2" class="form-control">
                                            <option value="0" selected>Año</option>
                                            <?php
                                            $inicio = 1900;
                                            $fin = date("Y");
                                            for($i = $fin; $i >= $inicio; $i--){
                                                if($por_año==$i){
                                                    echo '<option value="'.$i.'" selected>'.$i.'</option>';
                                                }
                                                else{
                                                    echo '<option value="'.$i.'">'.$i.'</option>';
                                                }  
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td><input id="por_nacionalidad" name="por_nacionalidad" type="text" <?php if($por_nacionalidad!=""){echo "value=".$por_nacionalidad;} ?> class="form-control" tabindex="3" placeholder="Nacionalidad"/></td>
                                    <td><select id="por_genero" name="por_genero" class="form-control" tabindex="4">
                                            <option value="0" selected>Género</option>
                                            <?php
                                                if($listado != null){
                                                    if($listado->num_rows == 0) echo '<option value="0">Error en la carga de datos</option>';
                                                    else{
                                                        while($reg = $listado->fetch_object()){
                                                            if($por_genero==$reg->id_genero){
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
                                    </td>
                                    <td>
                                        <span class="input-group-btn">
                                            <button id="submit" name="submit" type="submit" class="btn btn-primary" tabindex="5" style="width: 50%">Filtrar</button>
                                            <button id="limpiar" name="limpiar" <?php if($por_nombre!="" || $por_año!=0 || $por_nacionalidad!="" || $por_genero!=0){echo 'type="submit" onclick="limpiarFiltrosPelicula()"';}else{echo 'type="reset"';} ?> class="btn btn-default" tabindex="6" style="width: 50%">Resetear</button>
                                        </span>                                                      
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
                <br/>
<?php
if($perfil=="Administrador"){
?>
                <div class="row">
                    <div class="container-fluid">
                        <div class="table-responsive">
                            <table id="table" class="table table-hover table-bordered table-horarios">
                                <thead class="alert-info">
                                    <tr>
                                        <th>ID</th> 
                                        <th>Nombre</th>                    
                                        <th>Año</th>
                                        <th>Nacionalidad</th>
                                        <th>Género</th>
                                        <th>Duración (minutos)</th>
                                        <th>Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(isset($search_result)){
                                    if($search_result->num_rows > 0){
                                        $conexion = Conexion::establecer();
                                        while($row = mysqli_fetch_array($search_result)){
                                            echo '<tr class="text-center">';
                                            echo '<td>'.$row['id_pelicula'].'</td>';
                                            echo '<td>'.$row['pel_nombre'].'</td>';
                                            echo '<td>'.$row['pel_año'].'</td>';
                                            echo '<td>'.$row['pel_nacionalidad'].'</td>';
                                            $genero = new Genero();
                                            $genero->cargar($conexion, $row['pel_genero']);
                                            echo '<td>'.$genero->getNombre().'</td>';
                                            echo '<td>'.$row['pel_duracion'].'</td>';
                                            echo '<td class="text-center"><a href="files/pelicula_detalles.php?id='.$row['id_pelicula'].'">Detalles</a> | <a href="files/pelicula_modificar.php?id='.$row['id_pelicula'].'">Modificar</a> | <a href="files/pelicula_eliminar.php?id='.$row['id_pelicula'].'"">Eliminar</a></td>';
                                            echo '</tr>';
                                        }
                                        $conexion->close();
                                    }
                                    else{
                                        echo '<tr class="text-center">';
                                        echo '<td colspan="7">No existen registros que cumplan con los filtros aplicados</td>';
                                        echo '</tr>';
                                    }
                                }
                                else{
                                    echo '<tr class="text-center">';
                                    echo '<td colspan="7">Aplique al menos un filtro de búsqueda</td>';
                                    echo '</tr>';
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>  
                </div>
<?php
}
else{
?>        
                <div class="row">
                    <div class="container-fluid">
                        <div class="table-responsive">
                            <table id="table" class="table table-hover table-bordered table-horarios">
                                <thead class="alert-info">
                                    <tr>
                                        <th>Nombre</th>                    
                                        <th>Año</th>
                                        <th>Nacionalidad</th>
                                        <th>Genero</th>
                                        <th>Duración (minutos)</th>
                                        <th>Ver en detalle</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(isset($search_result)){
                                    if($search_result->num_rows > 0){
                                        $conexion = Conexion::establecer();
                                        while($row = mysqli_fetch_array($search_result)){
                                            echo '<tr class="text-center">';
                                            echo '<td>'.$row['pel_nombre'].'</td>';
                                            echo '<td>'.$row['pel_año'].'</td>';
                                            echo '<td>'.$row['pel_nacionalidad'].'</td>';
                                            $genero = new Genero();
                                            $genero->cargar($conexion, $row['pel_genero']);
                                            echo '<td>'.$genero->getNombre().'</td>';
                                            echo '<td>'.$row['pel_duracion'].'</td>';
                                            echo '<td class="text-center"><a href="files/pelicula_detalles.php?id='.$row['id_pelicula'].'">Detalles</a></td>';
                                            echo '</tr>';
                                        }
                                        $conexion->close();
                                    }
                                    else{
                                        echo '<tr class="text-center">';
                                        echo '<td colspan="6">No existen registros que cumplan con los filtros aplicados</td>';
                                        echo '<td style="display: none;"></td>';
                                        echo '<td style="display: none;"></td>';
                                        echo '<td style="display: none;"></td>';
                                        echo '<td style="display: none;"></td>';
                                        echo '<td style="display: none;"></td>';
                                        echo '</tr>';
                                    }
                                }
                                else{
                                    echo '<tr class="text-center">';
                                    echo '<td colspan="6">Aplique al menos un filtro de búsqueda</td>';
                                    echo '<td style="display: none;"></td>';
                                    echo '<td style="display: none;"></td>';
                                    echo '<td style="display: none;"></td>';
                                    echo '<td style="display: none;"></td>';
                                    echo '<td style="display: none;"></td>';
                                    echo '</tr>';
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>  
                </div>
<?php
}
        if($perfil!="Administrador"){
            echo'</div>';
        }
?>     
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
                    <a href="index.php" id="btn-inicio"><img src="img/botones/regresar.svg" class="link-img link-left"></a>
            <?php
                }
            ?>
        </div>
        <script>
            $(function(){
                $('#table').DataTable({
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
            });
        </script>
    </body>
</html>