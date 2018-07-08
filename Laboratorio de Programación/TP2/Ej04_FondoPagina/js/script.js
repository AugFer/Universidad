function limpiarFondo(){
    document.getElementById("body").style.backgroundColor = "white";
}

function cambiarFondo(){
    var color = document.getElementById("colorFondo");
    document.getElementById("body").style.backgroundColor = color.options[color.selectedIndex].value;
}