<!DOCTYPE html>
<!--
En dicha página diseñe un formulario que contenga 3 controles: dos entradas de texto y un botón. 
El objetivo del formulario es permitir al usuario ingresar dos números enteros y devolver como 
resultado la suma de los mismos. Debe tener en cuenta que el formulario debe realizar dos 
validaciones antes de calcular la suma, una validación que controle que los campos no estén 
vacíos y otra validación que solo permita el ingreso de números enteros.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Formulario de suma</title>
        <base href="http://localhost/Ej03_FormularioSuma/"/>
        <link href="css/estilo.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="js/script.js"></script>
    </head>
    <body id="body">
        <div id="contenedor">
            <form id="formSuma" name="formSuma" autocomplete="off">
                <fieldset>
                    <legend>Forulario de Suma</legend>
                    <div><label for="valorX">Valor de X:</label><input id="valorX" type="text" name="valorX"></div>
                    <div><label for="valorY">Valor de Y:</label><input id="valorY" type="text" name="valorY"></div>
                    <div><button id="sumar" name="sumar" type="button" onclick="validar()">Sumar</button></div>
                </fieldset>
            </form>
        </div>
    </body>
</html>