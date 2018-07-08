<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title>Formulario</title>
        <base href="http://localhost/ejercicio_03/"/>
        <link href="css/estilo.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="js/script.js"></script>
    </head>
    <body>
        <div id="contenedor">
            <div id="encabezado">
                <h1>Contáctenos</h1>
            </div>
            <div id="cuerpo">
                <form id="formulario" action="http://localhost/ejercicio_03/" method="post" onsubmit="return validarFormularioContacto()">
                <div>
                    <label for="nombre">Nombre <span>*</span></label><input id="nombre" name="nombre" type="text" tabindex="1"/>
                    <label for="apellido">Apellido</label><input id="apellido" name="apellido" type="text" tabindex="2"/> 
                </div>
                <div>
                    <label for="eMail">eMail <span>*</span></label><input id="eMail" name="eMail" type="text" tabindex="3"/>
                    <label for="teléfono">Teléfono</label><input id="teléfono" name="teléfono" type="text" tabindex="4"/> 
                </div>
                <div>
                    <label for="mensaje">Mensaje <span>*</span></label><textarea id="mensaje" name="mensaje" tabindex="5"></textarea>
                </div>
                <div>
                    <button id="enviar" name="enviar" type="submit">ENVIAR MENSAJE</button>
                    <label id="advertencia">Los campos marcados con (*) son obligatorios.</label>
                </div>
            </form>
            </div>
        </div>
    </body>
</html>
