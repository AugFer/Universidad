var arreglo = [1,2,3,4,5,6,7,8,9,10];
function mostrarSuma(){
    var total = 0;
    for(var i=0; i<arreglo.length; i++){
        total = total + arreglo[i];
    }
    alert("La suma de los elementos del arreglo es igual a: "+total);
}