var tablaTransiciones = 
    [
        ["",	"I",	"V",	"X",	"L",	"C",	"D",	"M"],
        ["q0",	"q1",	"q4",	"q6",	"q9",	"q11",	"q14",	"q16"],
        ["q1",	"q2",	"q3",	"q3",	"R",	"R",	"R",	"R"],
        ["q2",	"q3",	"R",	"R",	"R",	"R",	"R",	"R"],
        ["q3",	"R",	"R",	"R",	"R",	"R",	"R",	"R"],
        ["q4",	"q5",	"R",	"R",	"R",	"R",	"R",	"R"],
        ["q5",	"q2",	"R",	"R",	"R",	"R",	"R",	"R"],
        ["q6",	"q1",	"q4",	"q7",	"q8",	"q8",	"R",	"R"],
        ["q7",	"q1",	"q4",	"q8",	"R",	"R",	"R",	"R"],
        ["q8",	"q1",	"q4",	"R",	"R",	"R",	"R",	"R"],
        ["q9",	"q1",	"q4",	"q10",	"R",	"R",	"R",	"R"],
        ["q10",	"q1",	"q4",	"q7",	"R",	"R",	"R",	"R"],
        ["q11",	"q1",	"q4",	"q6",	"q9",	"q12",	"q13",	"q13"],
        ["q12",	"q1",	"q4",	"q6",	"q9",	"q13",	"R",	"R"],
        ["q13",	"q1",	"q4",	"q6",	"q9",	"R",	"R",	"R"],
        ["q14",	"q1",	"q4",	"q6",	"q9",	"q15",	"R",	"R"],
        ["q15",	"q1",	"q4",	"q6",	"q9",	"q12",	"R",	"R"],
        ["q16",	"q1",	"q4",	"q6",	"q9",	"q11",	"q14",	"q17"],
        ["q17",	"q1",	"q4",	"q6",	"q9",	"q11",	"q14",	"q18"],
        ["q18",	"q1",	"q4",	"q6",	"q9",	"q11",	"q14",	"R"],
        ["R",	"R",	"R",	"R",	"R",	"R",	"R",	"R"]
    ];
var div_resultados = document.getElementById("div_resultados");

//Si se tocan teclas que no corresponden con las letras del alfabeto no se escribe nada
//En caso de que se toque una tecla valida se la transforma a mayuscula
$('#romano').on('input', function (e){
    if (!/^[ivxlcdmIVXLCDM]*$/i.test(this.value)){
        this.value = this.value.replace(/[^ivxlcdmIVXLCDM]+/ig,"");
    }
    else{
        this.value = this.value.toLocaleUpperCase();
    }
});

//Si se toca "Enter" dentro del input se toma como si fuese un click en el boton analizar.
$("#romano").keyup(function(event) {
    if (event.keyCode === 13) {
        $("#analizar").click();
    }
});

function reset(){
    document.getElementById("romano").value = "";
    document.getElementById("romano").focus();
    document.getElementById("numeroRomano").innerHTML = "";
    document.getElementById("estadoFinal").innerHTML = "";
    document.getElementById("resultado").innerHTML = "";
    document.getElementById("recorrido").innerHTML = "";
    ocultar();
}

function analizar(){
    if(document.getElementById("romano").value !== ""){
        ejecutar();
        mostrar();
    }
    document.getElementById("romano").focus();
}

function ejecutar(){
        var estadoActual = "q0";
        var entrada = document.getElementById("romano").value;
        var numeroRomano = entrada;
        var letra;
        var recorrido = "q0 -> ";
        
        document.getElementById("romano").value = "";
        
        while(entrada.length !== 0 && estadoActual !== "R"){
                letra = entrada.charAt(0);
                estadoActual = transicion(estadoActual, letra);
                recorrido += estadoActual+" -> ";
                entrada = entrada.substring(1);
        }
        recorrido = recorrido.substring(0, recorrido.length - 4);
        
        document.getElementById("numeroRomano").innerHTML = numeroRomano;
        document.getElementById("estadoFinal").innerHTML = estadoActual;
        document.getElementById("recorrido").innerHTML = recorrido;
        
        if(estadoActual !== "R"){
            //document.getElementById("romano").value = convertir(numeroRomano);
            document.getElementById("resultado").innerHTML = "Aceptada";
        }
        else{
            document.getElementById("resultado").innerHTML = "Rechazada";
        }
    }

function transicion(estadoActual, letra){
    var estadoSiguiente = "";
    for(var i=1; i<21; i++){
        if(tablaTransiciones[i][0] === estadoActual){
            for(var j=1; j<8; j++){
                if(tablaTransiciones[0][j] === letra){
                    estadoSiguiente = tablaTransiciones[i][j];
                }
            }
        }
    }
    return estadoSiguiente;
}

function ocultar(){
    div_resultados.style.display = "none";
}

function mostrar(){
    div_resultados.style.display = "block";
}

/*
function convertir(numeroRomano){
    var decimal = 0;
    var ultimoDigito = 0;
    
    for(var x = (numeroRomano.length - 1); x >= 0 ; x--){
        switch (numeroRomano.charAt(x)){
            case "M":
                decimal = procesar(1000, ultimoDigito, decimal);
                ultimoDigito = 1000;
                break;

            case "D":
                decimal = procesar(500, ultimoDigito, decimal);
                ultimoDigito = 500;
                break;

            case "C":
                decimal = procesar(100, ultimoDigito, decimal);
                ultimoDigito = 100;
                break;

            case "L":
                decimal = procesar(50, ultimoDigito, decimal);
                ultimoDigito = 50;
                break;

            case "X":
                decimal = procesar(10, ultimoDigito, decimal);
                ultimoDigito = 10;
                break;

            case "V":
                decimal = procesar(5, ultimoDigito, decimal);
                ultimoDigito = 5;
                break;

            case "I":
                decimal = procesar(1, ultimoDigito, decimal);
                ultimoDigito = 1;
                break;
        }
    }
    return decimal;
}

function procesar(decimal, ultimoDigito, ultimoDecimal){
    if(ultimoDigito > decimal){
        return ultimoDecimal - decimal;
    }
    else{
        return ultimoDecimal + decimal;
    }
}
*/