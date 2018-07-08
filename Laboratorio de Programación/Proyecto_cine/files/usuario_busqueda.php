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
    require_once 'clases/Usuario.php';
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
        $query = "SELECT * FROM usuarios";
        $condiciones = array();
        $columnas = array();
        $por_nombre = filter_input(INPUT_POST,"por_nombre",FILTER_SANITIZE_STRING);
        $por_apellido = filter_input(INPUT_POST,"por_apellido",FILTER_SANITIZE_STRING);
        $por_cuenta = filter_input(INPUT_POST,"por_cuenta",FILTER_SANITIZE_STRING);
        $por_correo = filter_input(INPUT_POST,"por_correo");
        
        if($por_nombre!=""){
            $condiciones[] = $por_nombre;
            $columnas[] = "usu_nombre";
        }
        if($por_apellido!=""){
            $condiciones[] = $por_apellido;
            $columnas[] = "usu_apellido";
        }
        if($por_cuenta!=""){
            $condiciones[] = $por_cuenta;
            $columnas[] = "usu_cuenta";
        }
        if($por_correo!=""){
            $clean_email = filter_var($por_correo,FILTER_SANITIZE_EMAIL);
            if($por_correo == $clean_email && filter_var($por_correo,FILTER_VALIDATE_EMAIL)){
                $condiciones[] = $por_correo;
                $columnas[] = "usu_correo";
            }
            else{
                echo '<div class="container">';
                echo '<div class="alert alert-warning" style="padding: 10px;">';
                echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                echo '<strong>Atención: el correo electrónico especificado no posee un formato válido, por lo que no fue incluido en la consulta.</strong>';
                echo '</div>';
                echo '</div>';
            }
        }
        
        function filtrarUsuarios($conexion, $query){
            $filter_Result = mysqli_query($conexion, $query);
            return $filter_Result;
        }
        
        if(count($condiciones)>0){
            $query .= " WHERE ".$columnas[0]." LIKE '%".$condiciones[0]."%'";
            for($i=1; $i<count($condiciones);$i++){
                $query .= " AND ".$columnas[$i]." LIKE '%".$condiciones[$i]."%'";
            }
            $search_result = filtrarUsuarios($conexion, $query);
        }
        else{
            //$search_result = filtrarPeliculas($conexion, $query);
        }
    }
    $conexion->close();
?>
     
        <div class="row">
            <div class="col-xs-1 col-sm-3 col-md-4 col-lg-4"></div>
            <div class="page-header text-center col-xs-10 col-sm-6 col-md-4 col-lg-4">
                <h2>Búsqueda y listado de usuarios</h2>
            </div>
            <div class="col-xs-1 col-sm-3 col-md-4 col-lg-4"></div>
        </div>
        <div class="row">
            <div class="container">
                <form method="post" action="files/usuario_busqueda.php" class="form">
                    <table class="table table-bordered table-striped table-responsive text-center tabla-filtros">
                        <tr>
                            <td><input id="por_nombre" name="por_nombre" type="text" value="<?php echo $por_nombre;?>" class="form-control" tabindex="1" placeholder="Nombre"/></td>
                            <td><input id="por_apellido" name="por_apellido" type="text" value="<?php echo $por_apellido;?>" class="form-control" tabindex="2" placeholder="Apellido"/></td>
                            <td><input id="por_cuenta" name="por_cuenta" type="text" value="<?php echo $por_cuenta;?>" class="form-control" tabindex="3" placeholder="Cuenta"/></td>
                            <td><input id="por_correo" name="por_correo" type="text" value="<?php echo $por_correo;?>" class="form-control" tabindex="4" placeholder="Correo"/></td>
                            <td>
                                <span class="input-group-btn">
                                    <button id="submit" name="submit" type="submit" class="btn btn-primary" tabindex="5" style="width: 50%">Filtrar</button>
                                    <button id="limpiar" name="limpiar" <?php if($por_nombre!="" || $por_apellido!="" || $por_cuenta!="" || $por_correo!=""){echo 'type="submit" onclick="limpiarFiltrosUsuario()"';}else{echo 'type="reset"';} ?> class="btn btn-default" tabindex="6" style="width: 50%">Resetear</button>
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
                            <th>Tipo</th>
                            <th>Nombre</th>                    
                            <th>Apellido</th>
                            <th>Cuenta</th>
                            <th>Correo</th>
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
                                echo '<td>'.$row['id_usuario'].'</td>';
                                echo '<td>'.$row['usu_tipo'].'</td>';
                                echo '<td>'.$row['usu_nombre'].'</td>';
                                echo '<td>'.$row['usu_apellido'].'</td>';
                                echo '<td>'.$row['usu_cuenta'].'</td>';
                                echo '<td>'.$row['usu_correo'].'</td>';
                                echo '<td class="text-center"><a href="files/usuario_modificar.php?id='.$row['id_usuario'].'">Modificar</a> | <a href="files/usuario_eliminar.php?id='.$row['id_usuario'].'"">Eliminar</a></td>';
                                echo '</tr>';
                            }
                            $conexion->close();
                        }
                        else{
                            echo '<tr class="text-center">';
                            echo '<td colspan="7">No existen registros que cumplan con los filtros aplicados</td>';
                            echo '<td style="display: none;"></td>';
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
                        echo '<td colspan="7">Aplique al menos un filtro de búsqueda</td>';
                        echo '<td style="display: none;"></td>';
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
            <a id="btn-inicio" href="index.php"><img src="img/botones/regresar-negro.svg" class="link-img"></a>
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