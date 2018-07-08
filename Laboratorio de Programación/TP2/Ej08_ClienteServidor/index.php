<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Clente - Servidor</title>
        <base href="http://localhost/Ej08_ClienteServidor/"/>
        <link href="css/estilo.css" rel="stylesheet" type="text/css"/>
        <script type="text/javascript" src="js/script.js"></script>
    </head>
    <body>
        <div id="contenedor">
            <div id="cliente">
                <div><h3>Cliente</h3></div>
                <div id="nuevaNoticia">
                    <form id="crearNoticia" name="crearNoticia" method="post" autocomplete="off">
                        <div><label for="titulo">Titulo de la noticia</label></div>
                        <div><input id="titulo" name="titulo" type="text" tabindex="1"/></div>
                        <div><label for="noticia">Noticia:</label></div>
                        <div><textarea id="noticia" name="noticia" tabindex="2"></textarea></div>
                        <div><button type="button" id="enviar" name="enviar" onclick="enviarAlServidor()">Enviar noticia</button></div>
                    </form>
                </div>
                <div id="log"></div>
            </div>
            
            <div id="servidor">
                <div><h3>Servidor</h3></div>
                <div id="ultimasNoticias"><h2>ULTIMAS NOTICIAS</h2></div>
                <div id="publicaciones"></div>
            </div>
        </div>
    </body>
</html>