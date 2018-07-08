function generarMatrices(){
    var existe = document.getElementById("contenedorMatrizA");
    if(existe!=null){
        var element = document.getElementById("contenedorMatrizA");
        document.getElementById("contenedor").removeChild(element);
        element = document.getElementById("contenedorMatrizB");
        document.getElementById("contenedor").removeChild(element);
    }
    
    fA = document.forms["crearMatrices"]["filasA"].value;
    fB = document.forms["crearMatrices"]["filasB"].value;
    cA = document.forms["crearMatrices"]["columnasA"].value;
    cB = document.forms["crearMatrices"]["columnasB"].value;
    
    if(fA == null || fA == "" || fB == null || fB == "" || cA == null || cA == "" || cB == null || cB == ""){
        alert("No pueden haber campos vacíos.");
    }
    else{
        if(isNaN(fA) || fA%1!=0 || isNaN(fB) || fB%1!=0 || isNaN(cA) || cA%1!=0 || isNaN(cB) || cB%1!=0){
            alert("Todos los campos deben contener un número entero.");
        }
        else{
            if(cA != fB){
                alert("Las matrices no son multiplicables.");
            }
            else{
                fA=parseInt(fA);
                fB=parseInt(fB);
                cA=parseInt(cA);
                cB=parseInt(cB);
                
                constructor(fA,cA,"Matriz A","MatrizA");
                constructor(fB,cB,"Matriz B","MatrizB");
                
                document.getElementById("calcular").disabled=false;
            }
        }
    }
}

function constructor(filas, columnas, nombre, identificador){
    var contenedor = document.getElementById("contenedor");
    var div = document.createElement("div");
    div.setAttribute("id", "contenedor"+identificador);
    var titulo = document.createElement("H3");
    var texto = document.createTextNode(nombre);
    titulo.appendChild(texto);
    var form = document.createElement("form");
    form.setAttribute("id", identificador);
    var tabla = document.createElement("table");
    var tablaBody = document.createElement("tbody");
    
    for (var i=1; i<=filas; i++){
        var fila = document.createElement("tr");
        for (var j=1; j<=columnas; j++){
            var columna = document.createElement("td");
            var input = document.createElement("INPUT");
            input.setAttribute("type", "text");
            input.setAttribute("id", identificador+"celda["+i+"]["+j+"]");
            columna.appendChild(input);
            fila.appendChild(columna);
        }
        tablaBody.appendChild(fila);
    }
    tabla.appendChild(tablaBody);
    form.appendChild(tabla);
    div.appendChild(titulo);
    div.appendChild(form);
    contenedor.appendChild(div);
}

function calcularMultiplicacion(){
    if(validar("A") && validar("B")){
        
        var existe = document.getElementById("contenedorMatrizProducto");
        if(existe!=null){
            var element = document.getElementById("contenedorMatrizProducto");
            document.getElementById("contenedor").removeChild(element);
        }
        
        constructor(fA,cB,"Producto","MatrizProducto");
        for(var i=1; i<=fA; i++){
            for(var j=1; j<=cB; j++){
                for (var k=1; k<=cA; k++){
                    if(isNaN(parseInt(document.getElementById("MatrizProductocelda["+i+"]["+j+"]").value))){
                        document.getElementById("MatrizProductocelda["+i+"]["+j+"]").value = 0;
                    }
                    document.getElementById("MatrizProductocelda["+i+"]["+j+"]").value = parseInt(document.getElementById("MatrizProductocelda["+i+"]["+j+"]").value) + parseInt((document.getElementById("MatrizAcelda["+i+"]["+k+"]").value)*(document.getElementById("MatrizBcelda["+k+"]["+j+"]").value));
                }
            }
        }
    }
}

function validar(nombre){
    if(nombre=="A"){
        var matriz=document.forms["MatrizA"];
        var filas=fA;
        var columnas=cA;
    }
    if(nombre=="B"){
        var matriz=document.forms["MatrizB"];
        var filas=fB;
        var columnas=cB;
    }
    
    for(var i=1; i<=filas; i++){
        for(var j=1; j<=columnas; j++){
            var celda = document.getElementById(matriz.id+"celda["+i+"]["+j+"]").value;
            if(celda == null || celda == ""){
                alert("No pueden haber campos vacíos.");
                return false;
            }
            else{
                if(isNaN(celda) || celda%1!=0){
                    alert("Todos los campos deben contener un número entero.");
                    return false;
                }
            }
        }
    }
    return true;
}