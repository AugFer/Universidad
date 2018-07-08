<!DOCTYPE html>
<html>
    <head>
        <?php
            require_once 'files/secciones/head.php';
        ?>
    </head>
    <body>
        <div class="main">
            <br/>
            <div class="container-fluid">
                <h1 class="display-4 text-center">Minerva</h1>
                <h3 class="text-center text-muted lead">Autómata reconocedor de números romanos</h3>
                <br/>
                <div class="row">
                    <div class="col col-1 col-xs-1 col-sm-2 col-md-3 col-lg-4 col-xl-4"></div>
                    <div class="col col-10 col-xs-10 col-sm-8 col-md-6 col-lg-4 col-xl-4">
                        <div class="card card-body">
                            <div class="form-group">
                                <label for="romano">Número romano</label>
                                <input id="romano" class="form-control" type="text" maxlength="20" tabindex="1" placeholder="Ejemplo: XVII" autofocus>
                                <small class="form-text text-muted">Alfabeto: I, V, X, L, C, D, M</small>
                            </div>
                            <div class="text-center">
                                <button id="analizar" name="analizar" type="button" tabindex="2" class="btn btn-primary col-5" onclick="analizar();">Analizar</button>
                                <button id="reset" name="reset" type="button" tabindex="3" class="btn btn-light col-5" onclick="reset();">Reset</button>
                            </div>
                        </div>
                    </div>
                    <div class="col col-1 col-xs-1 col-sm-2 col-md-3 col-lg-4 col-xl-4"></div>
                </div>
            </div>
            <br/>
            <div id="div_resultados" class="container-fluid table-responsive" style="display: none;">
                <table class="table table-bordered table-hover">
                    <tbody>
                        <tr class="row m-0">
                            <td class="d-inline-block col-2"><b>Número romano: </b></td>
                            <td id="numeroRomano" class="d-inline-block col-10"></td>
                        </tr>
                        <tr class="row m-0">
                            <td class="d-inline-block col-2"><b>Resultado: </b></td>
                            <td id="resultado" class="d-inline-block col-10"></td>
                        </tr>
                        <tr class="row m-0">
                            <td class="d-inline-block col-2"><b>Estado final: </b></td>
                            <td id="estadoFinal" class="d-inline-block col-10"></td>
                        </tr>
                        <tr class="row m-0">
                            <td class="d-inline-block col-2"><b>Recorrido: </b></td>
                            <td id="recorrido" class="d-inline-block col-10"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
       <?php
            require_once 'files/secciones/footbar.php';
        ?>
        <script type="text/javascript" src="js/script.js"></script>
    </body>
</html>