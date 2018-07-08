<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ejemplo JavaScript</title>
        <base href="http://localhost/Ej02_SumarEnteros/"/>
        <script type="text/javascript">
            var nro1 = prompt("Ingrese un numero entero");
            if(validar(nro1)==false){
                do{
                    nro1 = prompt("Debes ingresar un número entero");
                }while(validar(nro1)==false);
            }
            var nro2 = prompt("Ingrese un numero entero");
            if(validar(nro2)==false){
                do{
                    nro2 = prompt("Debes ingresar un número entero");
                }while(validar(nro2)==false);
            }
            nro1 = parseInt(nro1);
            nro2 = parseInt(nro2);
            var suma = nro1 + nro2;
            
            function imprimir(){
            var resultadoH1 = document.createElement("H1");
            var texto = document.createTextNode("La suma de los valores "+nro1+" y "+nro2+" , da como resultado "+suma);
            resultadoH1.appendChild(texto);
            nodoBody = document.getElementById("body");
            nodoBody.appendChild(resultadoH1);
            resultadoH1.style.textAlign = "center";
            }
            
            function validar(nro){
                 if (isNaN(nro) || nro%1!=0 || nro==null || nro==""){
                     return false;
                 }
                 else{
                     return true;
                 }
            }
        </script>
    </head>
    <body id="body" onload="imprimir()">
        
    </body>
</html>
