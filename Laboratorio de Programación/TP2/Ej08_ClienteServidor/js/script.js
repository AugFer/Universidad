var cont = 0;

function enviarAlServidor(){
    if(validarFormulario()){
        publicarNoticia();
        generarLog("valido");
    }
    else{
        generarLog("error");
    }
}

function validarFormulario(){
    var titulo = document.forms["crearNoticia"]["titulo"].value;
    var cuerpo = document.forms["crearNoticia"]["noticia"].value;
    if(titulo == null || titulo == "" || cuerpo == null || cuerpo == ""){
        alert("No pueden haber campos vacíos.");
        return false;
    }
    else{
        return true;
    }
}

function publicarNoticia(){
    cont++;
    var publicaciones = document.getElementById("publicaciones");
    var div = document.createElement("div");
    div.setAttribute("id", "noticia"+cont);
    var titular = document.createElement("h3");
    var titulo = document.createTextNode(document.forms["crearNoticia"]["titulo"].value);
    titular.appendChild(titulo);
    var cuerpo = document.createElement("p");
    var noticia = document.createTextNode(document.forms["crearNoticia"]["noticia"].value);
    cuerpo.appendChild(noticia);
    var eliminar = document.createElement("a");
    var texto = document.createTextNode("Eliminar");
    eliminar.setAttribute("href","javascript:eliminarNoticia('noticia"+cont+"')");
    eliminar.appendChild(texto);
    
    div.appendChild(titular);
    div.appendChild(cuerpo);
    div.appendChild(eliminar);
    if(cont == 1){
        publicaciones.appendChild(div);
    }
    else{
        var anterior = document.getElementById("noticia"+(cont-1));
        publicaciones.insertBefore(div, anterior);
    }
}

function eliminarNoticia(id){
    var noticia = document.getElementById(id);
    document.getElementById("publicaciones").removeChild(noticia);
    cont--;
    generarLog("eliminado");
}

function generarLog(estado){
    var log = document.getElementById("log");
    var div = document.createElement("div");
    var informacion = document.createElement("p");
    var texto;
    if(estado=="valido"){
        texto = document.createTextNode("Se ha subido la noticia al servidor con exito.");
    }
    if(estado=="error"){
        texto = document.createTextNode("Error de formato. La noticia no se ha publicado.");
    }
    if(estado=="eliminado"){
        texto = document.createTextNode("Se ha eliminado la noticia con éxito");
    }
    informacion.appendChild(texto);
    div.appendChild(informacion);
    log.appendChild(div);
}