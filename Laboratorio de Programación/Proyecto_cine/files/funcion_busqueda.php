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
    require_once 'clases/Funcion.php';
    require_once 'clases/Pelicula.php';
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
        $listadoSalas = Sala::listar($conexion);
        $condiciones = array();
        $columnas = array();
        
        $por_fecha = filter_input(INPUT_POST,"por_fecha");
        $por_id = filter_input(INPUT_POST,"por_id",FILTER_VALIDATE_INT);
        $por_sala = filter_input(INPUT_POST,"por_sala",FILTER_VALIDATE_INT);
        
        if($por_fecha!=""){
            $condiciones[] = $por_fecha;
            $columnas[] = "fun_fecha";
        }
        if($por_sala!=0){
            $condiciones[] = $por_sala;
            $columnas[] = "fun_id_sala";
        }
        if($por_id!=""){
            $condiciones[] = $por_id;
            $columnas[] = "id_funcion";
        }
        
        function filtrar($conexion, $query){
            $filter_Result = mysqli_query($conexion, $query);
            return $filter_Result;
        }

        $query = "SELECT * FROM funciones";
        if(count($condiciones)>0){
            $query .= " WHERE ";
            for($i=0; $i<count($condiciones);$i++){
                if($i>0){
                    $query .= " AND ";
                }
                if($columnas[$i]=="fun_fecha"){
                    $fecha = DateTime::createFromFormat('d/m/Y', $condiciones[$i]);
                    $query .= "DATE(".$columnas[$i].") = DATE('".$fecha->format('Y-m-d')."')";
                }
                else{
                    if($columnas[$i]=="fun_id_sala"){
                        $query .= $columnas[$i]." = ".$condiciones[$i];
                    }
                    else{
                        if($columnas[$i]=="id_funcion"){
                            $query .= $columnas[$i]." = ".$condiciones[$i];
                        }
                    }
                }
            }
            $search_result = filtrar($conexion, $query);
        }
        else{
            //$search_result = filtrar($conexion, $query);
        }
        $conexion->close();
    }
?>
     
        <div class="row">
            <div class="col-xs-1 col-sm-3 col-md-3 col-lg-3"></div>
            <div class="page-header text-center col-xs-10 col-sm-6 col-md-6 col-lg-6">
                <h2>Búsqueda y listado de funciones</h2>
            </div>
            <div class="col-xs-1 col-sm-3 col-md-3 col-lg-3"></div>
        </div>
        <div class="row">
            <div class="container">
                <form method="post" action="files/funcion_busqueda.php" class="form">
                    <table class="table table-bordered table-striped table-responsive text-center tabla-filtros">
                        <tr>
                            <td>
                                <div class="input-group-btn">
                                    <input id="por_fecha" name="por_fecha" type="text" <?php if($por_fecha!=""){echo "value=".$por_fecha;} ?> class="form-control" tabindex="1" placeholder="Fecha"/>
                                </div>
                            </td>
                            <td><select id="por_sala" name="por_sala" class="form-control" tabindex="2">
                                    <option value="0" selected>Sala</option>
                                    <?php
                                        if($listadoSalas != null){
                                            if($listadoSalas->num_rows == 0) echo '<option value="0">Error en la carga de datos</option>';
                                            else{
                                                while($reg = $listadoSalas->fetch_object()){
                                                    if($reg->sal_disponibilidad=="Habilitada"){
                                                        if($por_sala==$reg->id_sala){
                                                            echo '<option value="'.$reg->id_sala.'" selected>Sala '.$reg->id_sala.'</option>';
                                                        }
                                                        else{
                                                            echo '<option value="'.$reg->id_sala.'">Sala '.$reg->id_sala.'</option>';
                                                        }
                                                    }
                                                }
                                                $listadoSalas->free_result();
                                            }
                                        }
                                    ?>
                                </select>
                            </td>
                            <td><input id="por_id" name="por_id" type="text" onkeypress="return esNumero(event)" <?php if($por_id!=""){echo "value=".$por_id;}?> class="form-control" tabindex="3" placeholder="ID de funcion"/></td>
                            <td>
                                <span class="input-group-btn">
                                    <button id="submit" name="submit" type="submit" class="btn btn-primary" tabindex="4" style="width: 50%">Filtrar</button>
                                    <button id="limpiar" name="limpiar" <?php if($por_fecha!="" || $por_sala!="" || $por_id!=""){echo 'type="submit" onclick="limpiarFiltrosFuncion()"';}else{echo 'type="reset"';} ?> class="btn btn-default" tabindex="5" style="width: 50%">Resetear</button>
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
                            <th>Película</th>                    
                            <th>Sala</th>
                            <th>Fecha</th>
                            <th>Horario</th>
                            <th>Opciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    if(isset($search_result)){
                        if($search_result->num_rows > 0){
                            $conexion = Conexion::establecer();
                            while($row = mysqli_fetch_array($search_result)){
                                $pelicula = new Pelicula();
                                $pelicula->cargar($conexion, $row['fun_id_pelicula']);
                                
                                $fechaFuncion = DateTime::createFromFormat('Y-m-d H:i:s', $row['fun_fecha']);
                                
                                echo '<tr class="text-center">';
                                echo '<td>'.$row['id_funcion'].'</td>';
                                echo '<td>'.$pelicula->getNombre().'</td>';
                                echo '<td>'.$row['fun_id_sala'].'</td>';
                                echo '<td>'.$fechaFuncion->format('d/m/Y').'</td>';
                                echo '<td>'.$fechaFuncion->format('H:i').'</td>';
                                echo '<td class="text-center"><a href="files/funcion_modificar.php?id='.$row['id_funcion'].'">Modificar</a> | <a href="files/funcion_eliminar.php?id='.$row['id_funcion'].'"">Eliminar</a></td>';
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
        <div class="row row-centrada">
                <a href="index.php" id="btn-inicio"><img src="img/botones/regresar-negro.svg" class="link-img"></a>
        </div>
        <script type="text/javascript">
            $(function(){
                $('#por_fecha').datetimepicker({
                    format: 'L'
                });
            });
        </script>
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