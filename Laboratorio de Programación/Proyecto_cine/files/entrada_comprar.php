<?php
    require_once 'autenticacion.php';
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
    require_once 'secciones/modalError.php';
    
    require_once 'clases/conexion.php';
    require_once 'clases/funcion.php';
    require_once 'clases/pelicula.php';
    require_once 'clases/sala.php';
    require_once 'clases/entrada.php';
    require_once 'clases/configuracion.php';
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
        $id = filter_input(INPUT_GET,"id",FILTER_VALIDATE_INT);
        if(!$id) $id = filter_input(INPUT_POST,"id",FILTER_VALIDATE_INT);
        if(!$id){
            echo '<div class="container">';
            echo '<div class="alert alert-danger" style="padding: 10px;">';
            echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
            echo '<strong>ERROR: no se encontró el ID de la pelicula.</strong>';
            echo '</div>';
            echo '</div>';
            echo '<div class="link-to-home"><a href="index.php" class="btn btn-link">Volver a la página principal</a></div>';
            die();
        }
        else{
            $estado="";
            $funcion = new Funcion();
            if(!$funcion->cargar($conexion, $id)){
                echo '<div class="container">';
                echo '<div class="alert alert-danger" style="padding: 10px;">';
                echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                echo '<strong>ERROR: '.$funcion->getError().'</strong>';
                echo '</div>';
                echo '</div>';
                echo '<div class="link-to-home"><a href="index.php" class="btn btn-link">Volver a la página principal</a></div>';
                die();
            }
            $pelicula = new Pelicula();
            $pelicula->cargar($conexion, $funcion->getPelicula());
            $sala = new Sala();
            $sala->cargar($conexion, $funcion->getSala());
            
            $costoEntrada = 0;
            $listadoDias = Configuracion::listar($conexion);
            setlocale(LC_ALL,'es_RA','spanish');
            $hoy = DateTime::createFromFormat('Y-m-d H:i:s',$funcion->getFecha());//Datetime con la fecha de la funcion seleccionada
            $dia = ucfirst(utf8_encode(strftime("%A",$hoy->getTimestamp())));//se saca el nombre del dia
            while($reg = $listadoDias->fetch_object()){
                if($dia==$reg->con_dia){//se busca el dia en el listado de dias
                    $costoEntrada = $reg->con_costo;//se guarda el costo de las entradas de ese dia
                }
            }
            $listadoDias->free_result();
            
            $entradasVendidas = mysqli_num_rows(Entrada::contarPorFuncion($conexion, $funcion->getId()));
            $asientosLibres = $sala->getCapacidad()-$entradasVendidas;
            
            $accion = filter_input(INPUT_POST,"accion",FILTER_SANITIZE_STRING);
            if($accion=="pagar"){
                $transaccion = new Transaccion();
                
                $entradasNuevas = (filter_input(INPUT_POST,"cantidad",FILTER_VALIDATE_INT));
                $montoTotal = $entradasNuevas*$costoEntrada;
                $fecha = new DateTime('NOW');
                $transaccion->setMonto_total($montoTotal);
                $transaccion->setFecha($fecha->format('Y-m-d H:i:s'));
                
                if($transaccion->guardar($conexion, $funcion->getId(), $asientosLibres, $entradasNuevas, $costoEntrada, $_SESSION['id'])){
                    echo '<div class="container">';
                    echo '<div class="alert alert-success text-center" style="padding: 10px;">';
                    echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                    echo '<strong>Tu compra fue efectuada satisfactoriamente.</strong>';
                    echo '</div>';
                    echo '</div>';
                    $estado="exito";
                }
                else{
                    echo '<div class="container">';
                    echo '<div class="alert alert-danger" style="padding: 10px;">';
                    echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
                    echo '<strong>ERROR: '.$transaccion->getError().'</strong>';
                    echo '</div>';
                    echo '</div>';
                }
            }
        }
    }
    $conexion->close();
?>
        <div class="container">
            <div class="col-xs-0 col-sm-1 col-md-2 col-lg-2"></div>
            <div class="thumbnail background2 col-xs-12 col-sm-10 col-md-8 col-lg-8" style="padding: 20px">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 ">
                        <h1 class="text-center texto-blanco">PROCESO DE COMPRA</h1>
                    </div>
                </div>
                
                <hr/>
                <br/>
                
<?php
    if($estado==""){
?>
                <div class="row">   
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 img-rounded text-center texto-blanco">
                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 thumbnail border-thin">
                            <div class="image">
                                <img class="img-responsive img-cartelera border-radius-7" src="img/peliculas/<?php echo $pelicula->getImagen();?>"/>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
                            <div class="container-fluid">
                                <h2>Comprando entradas para</h2>
                                <hr>
                                <?php
                                    echo '<h3>'.$pelicula->getNombre().'</h3>';
                                    echo '<br/>';
                                    $fecha = DateTime::createFromFormat('Y-m-d H:i:s', $funcion->getFecha());
                                    echo '<h4>Función programada en la Sala número 3 para el día '.$fecha->format('d/m/Y').' a las '.$fecha->format('H:i').' hs.</h4>';
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <hr/>
                <br/>
                
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h3 class="panel-title"><strong>Información de facturación</strong></h3>
                            </div>
                            <div class="panel-body">
                                <form autocomplete="off" method="post" action="files/entrada_comprar.php" onSubmit="return validarFormularioPago()" class="form">
                                    <div class="form-group" hidden>
                                        <input id="id" name="id" type="text" value="<?php echo $id;?>" tabindex="-1" class="form-control" hidden/>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label>Cantidad de entradas</label>
                                        <div class="input-group">
                                            <select id="cantidad" name="cantidad" class="form-control" tabindex="1">
                                                <option value="0" disabled hidden>Cantidad</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                            </select>
                                            <span id="costoTotal" <?php echo 'name="'.$costoEntrada.'"';?> class="input-group-addon"></span>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label>Propietario</label>
                                        <input id="propietario" name="propietario" type="text" maxlength="80" class="form-control" tabindex="2" placeholder="Nombre"/>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label>Numero de tarjeta</label>
                                        <input id="tarjeta" name="tarjeta" type="text" onkeypress="return esNumero(event)" class="form-control" tabindex="3" placeholder="Número"/>
                                    </div> 
                                    <div class="form-group">
                                        <label class="col-sm-12">Fecha de vencimiento</label>
                                        <div>
                                            <div class="col-sm-6 form-group">
                                                <select id="vencimiento_M" name="vencimiento_M" class="form-control" tabindex="4">
                                                    <option value="0">Mes</option>
                                                    <option value="1">Enero (1)</option>
                                                    <option value="2">Febrero (2)</option>
                                                    <option value="3">Marzo (3)</option>
                                                    <option value="4">Abril (4)</option>
                                                    <option value="5">Mayo (5)</option>
                                                    <option value="6">Junio (6)</option>
                                                    <option value="7">Julo (7)</option>
                                                    <option value="8">Agosto (8)</option>
                                                    <option value="9">Septiembre (9)</option>
                                                    <option value="10">Octubre (10)</option>
                                                    <option value="11">Noviembre (11)</option>
                                                    <option value="12">Diciembre (12)</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-6 form-group">
                                                <select id="vencimiento_A" name="vencimiento_A" class="form-control" tabindex="5">
                                                    <option value="0">Año</option>
                                                    <?php
                                                        $actual = new DateTime('now');
                                                        $fin = clone $actual->modify('+6 year');
                                                        $actual = new DateTime('now');
                                                        for($i = $actual->format('Y'); $i <= $fin->format('Y'); $i++){
                                                            echo '<option value="'.$i.'">'.$i.'</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <label>Código de seguridad</label>
                                        <input id="codigo" name="codigo" type="text" maxlength="4" onkeypress="return esNumero(event)" class="form-control" tabindex="6" placeholder="Código"/>
                                    </div>
                                    <div class="text-center">
                                        <button id="pagar" name="pagar" type="submit" class="btn btn-primary" tabindex="7">Realizar pago</button>
                                        <input type="hidden" name="accion" value="pagar"/>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
<?php
    }
    else{
?>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <h4 class="text-center texto-blanco">El pago se ha realizado correctamente, su número de transacción es: <strong> <?php echo $transaccion->getId();?></strong></h4>
                            <hr/>
                            <h5 class="text-center texto-blanco">
                                No olvides generar el comprobante de la transacción, lo necesitarás para recibir tus entradas antes de ingresar en la sala. Puedes volver a consultar la información de tus transacciones y generar sus comprobantes en la pestaña "Historial" del menú de usuario.
                            </h5>
                        </div>
                        <div class="text-center">
                            <form id="imprimir" name="imprimir" method="post" action="files/reportes/reporte_transaccion.php" target="_blank" class="form-horizontal"> 
                                <input type="hidden" id="id_transaccion" name="id_transaccion" value="<?php echo $transaccion->getId(); ?>"/>
                                <input type="hidden" id="usuario" name="usuario" value="<?php echo $_SESSION['usuario']; ?>"/>
                                <button id="principal" type="submit" class="btn btn-danger text-uppercase">Generar comprobante</button>
                            </form>
                        </div>
                    </div>
                </div>
<?php
    }
?>
            </div>
            <div class="col-xs-0 col-sm-1 col-md-2 col-lg-2"></div>
        </div>
        <div class="row">
            <a id="btn-regresar" href="files/pelicula_detalles.php<?php echo '?id='.$funcion->getPelicula(); ?>" class="link-left"><img src="img/botones/regresar.svg" class="link-img"></a>
            <a id="btn-arriba" class="link-right"><img src="img/botones/arriba.svg" class="link-img"></a>
        </div>
        <?php
            require_once 'secciones/footbar.php';
        ?>
        <script>
            $(document).ready(function(){
                var cantidad = $("#cantidad").val();
                var valor = $("#costoTotal").attr('name');
                $("#costoTotal").text('Total: $'+(cantidad*valor));
                
                $("#cantidad").change(function(){
                    cantidad = $("#cantidad").val();
                    $("#costoTotal").text('Total: $'+(cantidad*valor));
                });
            });
        </script>
        <script>
            $(document).ready(function(){
                $('#btn-arriba').click(function(){
                    $("html, body").animate({ scrollTop: 0 }, 1000);
                    return false;
                });
            });
        </script>
    </body>
</html>