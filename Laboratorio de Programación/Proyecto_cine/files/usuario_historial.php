<?php
    require_once 'autenticacion.php';
    $_SESSION['paginaAnterior'] = $_SERVER['REQUEST_URI'];//Al parecer no es un buen metodo para un boton de "pagina anterior", investigar despues
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
    require_once 'clases/transaccion.php';
    
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
        $condiciones = array();
        $columnas = array();
        $por_numero = filter_input(INPUT_POST,"por_numero",FILTER_VALIDATE_INT);
        $por_fecha = filter_input(INPUT_POST,"por_fecha");
        
        if($por_numero!=""){
            $condiciones[] = $por_numero;
            $columnas[] = "id_transaccion";
        }
        if($por_fecha!=""){
            $condiciones[] = $por_fecha;
            $columnas[] = "tra_fecha";
        }
        
        function filtrar($conexion, $query){
            $filter_Result = mysqli_query($conexion, $query);
            return $filter_Result;
        }
        
        $query = "SELECT * FROM transacciones WHERE tra_id_usuario=".$_SESSION['id'];
        if(count($condiciones)>0){
            for($i=0; $i<count($condiciones);$i++){
                $query .= " AND ";
                if($columnas[$i]=="id_transaccion"){
                    $query .= $columnas[$i]."=".$condiciones[$i];
                }
                else{
                    if($columnas[$i]=="tra_fecha"){
                        $fecha = DateTime::createFromFormat('d/m/Y', $condiciones[$i]);
                        $query .= "DATE(".$columnas[$i].")=DATE('".$fecha->format('Y-m-d')."')";
                    }
                }
            }
            $query .= " ORDER BY id_transaccion ASC";
            $search_result = filtrar($conexion, $query);
        }
        else{
            $query .= " ORDER BY id_transaccion ASC";
            $search_result = filtrar($conexion, $query);
        }
    }
    $conexion->close();
?>
    <div class="row">
        <div class="container thumbnail" style="padding: 20px">
            <div class="row">
                <div class="col-xs-1 col-sm-2 col-md-3 col-lg-3"></div>
                <div class="text-center col-xs-10 col-sm-8 col-md-6 col-lg-6">
                    <h2>Historial de transacciones</h2>
                    <hr/>
                    <p>Aquí puedes revisar todas tus transacciones realizadas en Mechenien.</p>
                </div>
                <div class="col-xs-1 col-sm-2 col-md-3 col-lg-3"></div>
            </div>
            <div class="row">
                <div class="container-fluid">
                    <form method="post" action="files/usuario_historial.php" class="form">
                        <table class="table table-bordered table-hover table-responsive tabla-filtros">
                            <tr>
                                <td>
                                    <input id="por_numero" name="por_numero" type="text" onkeypress="return esNumero(event)" <?php if($por_numero!=""){echo "value=".$por_numero;}?> class="form-control" tabindex="3" placeholder="Nro. transaccón"/>
                                </td>
                                <td>
                                    <div class="input-group-btn">
                                        <input id="por_fecha" name="por_fecha" type="text" <?php if($por_fecha!=""){echo "value=".$por_fecha;} ?> class="form-control" tabindex="1" placeholder="Fecha"/>
                                    </div>
                                </td>
                                <td>
                                    <span class="input-group-btn">
                                        <button id="submit" name="submit" type="submit" class="btn btn-primary" tabindex="5" style="width: 50%">Filtrar</button>
                                        <button id="limpiar" name="limpiar" <?php if($por_numero!="" || $por_fecha!=""){echo 'type="submit" onclick="limpiarFiltrosHistorial()"';}else{echo 'type="reset"';} ?> class="btn btn-default" tabindex="6" style="width: 50%">Resetear</button>
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
                    <div class="table-responsive">
                        <table id="table" class="table table-hover table-bordered table-horarios">
                            <thead class="alert-info">
                                <tr>
                                    <th>Número de transacción</th>
                                    <th>Fecha</th>                    
                                    <th>Monto total</th>
                                    <th>Comprobante</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    if($search_result->num_rows > 0){
                                        $conexion = Conexion::establecer();
                                        $transaccion = new Transaccion();
                                        while($row = mysqli_fetch_array($search_result)){
                                            $transaccion->cargar($conexion, $row['id_transaccion']);
                                            $fecha = DateTime::createFromFormat('Y-m-d H:i:s', $row['tra_fecha']);
                                            echo '<tr class="text-center">';
                                            echo '<td>'.$row['id_transaccion'].'</td>';
                                            echo '<td>'.$fecha->format('d/m/Y H:i').'</td>';
                                            echo '<td>$'.$row['tra_monto_total'].'</td>';
                                            echo '<td>
                                                    <div class="text-center">
                                                        <form id="imprimir" name="imprimir" method="post" action="files/reportes/reporte_transaccion.php" target="_blank" class="form-horizontal"> 
                                                            <input type="hidden" id="id_transaccion" name="id_transaccion" value="'.$row['id_transaccion'].'"/>
                                                            <input type="hidden" id="usuario" name="usuario" value="'.$_SESSION['usuario'].'"/>
                                                            <button type="submit" class="btn btn-danger text-uppercase"><img src="img/varios/pdf.svg" style="max-width: 40px;"/></button>
                                                        </form>
                                                    </div>
                                                </td>';
                                            echo '</tr>';
                                        }
                                        $conexion->close();
                                    }
                                    else{
                                        echo '<tr class="text-center">';
                                        if($por_numero!="" || $por_fecha!=""){
                                            echo '<td colspan="6">No existen registros que cumplan con los filtros aplicados</td>';
                                        }
                                        else{
                                            echo '<td colspan="6">Parece que aún no has realizado ninguna transacción</td>';
                                        }
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
            
        </div>   
    </div>
    <div class="row row-centrada">
        <a href="index.php" id="btn-inicio"><img src="img/botones/regresar.svg" class="link-img link-left"></a>
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