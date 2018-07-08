<!DOCTYPE html>
<!--
Cree una página HTML llamada “Ej04 – Fondo pagina.html”, que contenga un formulario con
tres controles: una lista de tipo menú y dos botones. El propósito del formulario es permitir al
usuario cambiar el color de fondo de la página. La lista deberá mostrar 4 opciones de colores. Un
botón deberá permitir resetear el formulario y restablecer el color de página a blanco, y el otro
botón deberá setear el color de fondo de página dependiendo de lo que haya seleccionado el
usuario en la lista.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Formularios con HTML</title>
        <base href="http://localhost/Ej04_FondoPagina/"/>
        <script type="text/javascript" src="js/script.js"></script>
    </head>
    <body id="body">
        <h1>Cambiando color de fondo de pagina</h1>
        <form id="formSuma" name="formSuma" autocomplete="off">
            <label>Seleccione un color:</label>
            <select id="colorFondo" name="colorFondo">
                <option value="red">Rojo</option>
                <option value="green">Verde</option>
                <option value="blue">Azul</option>
                <option value="yellow">Amarillo</option>
            </select>
            <button id="limpiar" name="limpiar" onclick="limpiarFondo()">Limpiar</button>
            <button id="cambiar" name="cambiar" onclick="cambiarFondo()">Cambiar</button>
        </form>
    </body>
</html>