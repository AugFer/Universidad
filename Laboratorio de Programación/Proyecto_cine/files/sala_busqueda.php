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

    require_once 'clases/conexion.php';
    require_once 'clases/Sala.php';
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
        $query = "SELECT * FROM salas";
        $condiciones = array();
        $columnas = array();
        $por_id = filter_input(INPUT_POST,"por_id",FILTER_VALIDATE_INT);
        $por_capacidad = filter_input(INPUT_POST,"por_capacidad",FILTER_VALIDATE_INT);
        $por_disponibilidad = filter_input(INPUT_POST,"por_disponibilidad",FILTER_SANITIZE_STRING);
        
        if($por_id!=""){
            $condiciones[] = $por_id;
            $columnas[] = "id_sala";
        }
        if($por_capacidad!=""){
            $condiciones[] = $por_capacidad;
            $columnas[] = "sal_capacidad";
        }
        if($por_disponibilidad!=""){
            $condiciones[] = $por_disponibilidad;
            $columnas[] = "sal_disponibilidad";
        }

        function filtrar($conexion, $query){
            $filter_Result = mysqli_query($conexion, $query);
            return $filter_Result;
        }

        if(count($condiciones)>0){
            $query .= " WHERE ";
            for($i=0; $i<count($condiciones);$i++){
                if($i>0){
                    $query .= " AND ";
                }
                if($columnas[$i]=="id_sala"){
                    $query .= $columnas[$i]."=".$condiciones[$i];
                }
                else{
                    if($columnas[$i]=="sal_capacidad"){
                        $query .= $columnas[$i]."<=".$condiciones[$i];
                    }
                    else{
                        if($columnas[$i]=="sal_disponibilidad"){
                            $query .= $columnas[$i]." LIKE '".$condiciones[$i]."'";
                        }
                    }
                }
            }
            $search_result = filtrar($conexion, $query);
        }
        else{
            //$search_result = filtrar($conexion, $query);
        }
    }
    $conexion->close();
?>
     
        <div class="row">
            <div class="col-xs-1 col-sm-3 col-md-4 col-lg-4"></div>
            <div class="page-header text-center col-xs-10 col-sm-6 col-md-4 col-lg-4">
                <h2>Búsqueda y listado de salas</h2>
            </div>
            <div class="col-xs-1 col-sm-3 col-md-4 col-lg-4"></div>
        </div>
        <div class="row">
            <div class="container">
                <form method="post" action="files/sala_busqueda.php" class="form">
                    <table class="table table-bordered table-striped table-responsive text-center tabla-filtros">
                        <tr>
                            <td><input id="por_id" name="por_id" type="text" onkeypress="return esNumero(event)" <?php if($por_id!=""){echo "value=".$por_id;}?> class="form-control" tabindex="1" placeholder="Número de sala"/></td>
                            <td><input id="por_capacidad" name="por_capacidad" type="text" onkeypress="return esNumero(event)" <?php if($por_capacidad!=""){echo "value=".$por_capacidad;}?> class="form-control" tabindex="2" placeholder="Capacidad máxima"/></td>
                            <td><select id="por_disponibilidad" name="por_disponibilidad" class="form-control" tabindex="3">
                                    <option value="" selected>Disponibilidad</option>
                                    <option value="Habilitada" <?php if($por_disponibilidad == "Habilitada") echo 'selected';?>>Habilitada</option>
                                    <option value="Deshabilitada" <?php if($por_disponibilidad == "Deshabilitada") echo 'selected';?>>Deshabilitada</option>
                                </select>
                            </td>
                            <td>
                                <span class="input-group-btn">
                                    <button id="submit" name="submit" type="submit" class="btn btn-primary" tabindex="4" style="width: 50%">Filtrar</button>
                                    <button id="limpiar" name="limpiar" <?php if($por_id!="" || $por_capacidad!="" || $por_disponibilidad!=""){echo 'type="submit" onclick="limpiarFiltrosSala()"';}else{echo 'type="reset"';} ?> class="btn btn-default" tabindex="5" style="width: 50%">Resetear</button>
                                </span>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
        <br/>
        <div class="row">
            <div class="container-fluid">
                <table id="table" class="table table-hover table-bordered table-horarios">
                    <thead class="alert-info">
                        <tr>
                            <th>ID</th> 
                            <th>Capacidad</th>                    
                            <th>Disponibilidad</th>
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
                                echo '<td>'.$row['id_sala'].'</td>';
                                echo '<td>'.$row['sal_capacidad'].'</td>';
                                echo '<td>'.$row['sal_disponibilidad'].'</td>';
                                echo '<td class="text-center"><a href="files/sala_modificar.php?id='.$row['id_sala'].'">Modificar</a> | <a href="files/sala_eliminar.php?id='.$row['id_sala'].'"">Eliminar</a></td>';
                                echo '</tr>';
                            }
                            $conexion->close();
                        }
                        else{
                            echo '<tr class="text-center">';
                            echo '<td colspan="4">No existen registros que cumplan con los filtros aplicados</td>';
                            echo '<td style="display: none;"></td>';
                            echo '<td style="display: none;"></td>';
                            echo '<td style="display: none;"></td>';
                            echo '</tr>';
                        }
                    }
                    else{
                        echo '<tr class="text-center">';
                        echo '<td colspan="4">Aplique al menos un filtro de búsqueda</td>';
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
        <div class="row row-centrada">
                <a href="index.php" id="btn-inicio"><img src="img/botones/regresar-negro.svg" class="link-img"></a>
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