function validarFormularioContacto(){
    var nom = document.getElementById("nombre").value;
    var mail = document.getElementById("eMail").value;
    var msje = document.getElementById("mensaje").value;
    
    if(nom == null || nom == ""){
        alert("El nombre es un campo obligatorio.");
        document.getElementById("nombre").focus();
        return false;
    }
    if(mail == null || mail == ""){
        alert("El eMail es un campo obligatorio.");
        document.getElementById("eMail").focus();
        return false;
    }
    if(!validarMail(mail)){
        alert("El formato del eMail ingresado no es valido.");
        document.getElementById("eMail").focus();
        return false;
    }
    if(msje == null || msje == ""){
        alert("No se permiten comentarios en blanco.");
        document.getElementById("mensaje").focus();
        return false;
    }
}

function validarMail(eMail){
    //Un control suuper basico y propenso a fallas :P
    // cualquier string excluyendo el @ + @ + cualquier string excluyendo el @ + . + cualquier string excluyendo el @
    var plantilla = /[^\s@]+@[^\s@]+\.[^\s@]+/;
    return plantilla.test(eMail);
}