<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Comentarios</title>
        <base href="http://localhost/ejercicio_05/"/>
        <link href="css/estilo.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="js/script.js"></script>
    </head>
    <body>
        <div id="contenedor">
            <h2>Comentarios</h2>
            <hr/>
            <h2>Comentar</h2>
            <hr/>
            <form id="formulario" action="http://localhost/ejercicio_05/" method="post" onsubmit="return validarComentario()">
                <div id="izq">
                    <div class="requisitos">
                        <label for="nombre">Nombre <span>(requerido)</span></label>
                    </div>
                    <div>
                        <input id="nombre" name="nombre" type="text" tabindex="1"/>
                    </div>
                    <div class="requisitos">
                        <label for="eMail">eMail <span>(requerido - no será publicado)</span></label>
                    </div>
                    <div>
                        <input id="eMail" name="eMail" type="text" tabindex="2"/>
                    </div>
                    <div class="requisitos">
                        <label for="web">Web</label>
                    </div>
                    <div>
                        <input id="web" name="web" type="text" tabindex="3"/> 
                    </div>
                    <button id="enviar" name="enviar" type="submit">ENVIAR COMENTARIO</button>
                </div>
                <div id="der">
                    <div class="requisitos">
                        <label for="comentario">Comentario</label>
                    </div>  
                    <div>
                        <textarea id="comentario" name="comentario" tabindex="4"></textarea>
                    </div>
                </div>
            </form>
        </div>
    </body>
</html>