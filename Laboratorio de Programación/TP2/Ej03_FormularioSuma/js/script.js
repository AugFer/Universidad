var suma;
function validar(){
    var x = document.forms["formSuma"]["valorX"].value;
    var y = document.forms["formSuma"]["valorY"].value;
    
    if(x == null || x == "" || y == null || y == ""){
        alert("No pueden haber campos vacíos.");
    }
    else{
        if(isNaN(x) || x%1!=0 || isNaN(y) || y%1!=0){
            alert("Ambos campos deben contener un número entero.");
        }
        else{
            x=parseInt(x);
            y=parseInt(y);
            suma = x+y;
            imprimir();
        }
    }
}

function imprimir(){
    var existe = document.getElementById("resultado");
    if(existe!=null){
        var element = document.getElementById("resultado");
        document.getElementById("contenedor").removeChild(element);
    }
    
    var resultadoH1 = document.createElement("H1");
    resultadoH1.setAttribute("id", "resultado");
    var texto = document.createTextNode("La suma es: "+suma);
    resultadoH1.appendChild(texto);
    var contenedor = document.getElementById("contenedor");
    contenedor.appendChild(resultadoH1);
    resultadoH1.style.textAlign = "center";
    resultadoH1.style.color = "green";
}