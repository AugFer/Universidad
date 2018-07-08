<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Multiplicador de Matrices</title>
        <base href="http://localhost/Ej05_MultiplicarMatrices/"/>
        <link href="css/estilo.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="js/script.js"></script>
    </head>
    <body id="body">
        <div id="contenedor">
            <div id="contenedorGenerador">
                <form id="crearMatrices" name="crearMatrices" autocomplete="off">
                    <fieldset>
                        <legend>Generador de matrices</legend>
                        <table>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td><label>Filas</label></td>
                                    <td><label>Columnas</label></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td><label>Matriz A</label></td>
                                    <td><input id="filasA" type="text" name="filasA"></td>
                                    <td><input id="columnasA" type="text" name="columnasA"></td>
                                    <td><button id="generar" name="generar" type="button" onclick="generarMatrices()">Generar</button></td>
                                </tr>
                                <tr>
                                    <td><label>Matriz B</label></td>
                                    <td><input id="filasB" type="text" name="filasB"></td>
                                    <td><input id="columnasB" type="text" name="columnasB"></td>
                                    <td><button id="calcular" name="calcular" type="button" onclick="calcularMultiplicacion()" disabled>Calcular</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </fieldset>
                </form>
            </div>
        </div>
    </body>
</html>