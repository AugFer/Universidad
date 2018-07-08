//------- Mensajes generales -------//
function mensajeError(errores){
    var listaErrores = document.getElementById("listaErrores");
    while(listaErrores.hasChildNodes()){
        listaErrores.removeChild(listaErrores.firstChild);
    }
    for (var i = 0; i < errores.length; i++) {
        var li = document.createElement('li');
        li.innerHTML = li.innerHTML + errores[i];
        listaErrores.appendChild(li);
    }
    $('#ventanaError').modal('show');
}
function confirmacion(){
    $('#ventanaConfirm').modal('show');
}
//------- Validaciones varias -------//
function esNumero(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57)){
        return false;
    }
    return true;
}

//------- Usuario -------//
function validarMail(eMail){
    // cualquier string excluyendo el @ + @ + cualquier string excluyendo el @ + . + cualquier string excluyendo el @
    var platilla = /[^\s@]+@[^\s@]+\.[^\s@]+/;
    return platilla.test(eMail);
}
function validarUsuario(){
    var tipo = document.getElementById("tipo").value;
    var apellido = document.getElementById("apellido").value;
    var nombre = document.getElementById("nombre").value;
    var cuenta = document.getElementById("cuenta").value;
    var clave = document.getElementById("clave").value;
    var correo = document.getElementById("correo").value;
    var errores = [];
    
    if(tipo == null || tipo == ""){
        errores.push("El campo 'Tipo' de usuario es obligatorio.");
    }
    if(apellido == null || apellido == ""){
        errores.push("El campo 'Apellido' es obligatorio.");
    }
    else{
        if(apellido.length>45){
            errores.push("La longitud del campo 'Apellido' no debe superar los 45 caracteres.");
        }
    }
    if(nombre == null || nombre == ""){
        errores.push("El campo 'Nombre' es obligatorio.");
    }
    else{
        if(nombre.length>45){
            errores.push("La longitud del campo 'Nombre' no debe superar los 45 caracteres.");
        }
    }
    if(cuenta == null || cuenta == ""){
        errores.push("El campo 'Usuario' es obligatorio.");
    }
    else{
        if(cuenta.length>20){
            errores.push("La longitud del campo 'Usuario' no debe superar los 20 caracteres.");
        }
    }
    if(clave == null || clave == ""){
        errores.push("El campo 'Contraseña' es obligatorio.");
    }
    else{
        if(clave.length<6){
            errores.push("La longitud del campo 'Contraseña' debe ser de al menos 6 caracteres.");
        }
        else{
            if(clave.length>32){
                errores.push("La longitud del campo 'Contraseña' no debe superar los 32 caracteres.");
            }
        }
    }
    if(correo == null || correo == ""){
        errores.push("El campo 'Correo electrónico' es obligatorio.");
    }
    else{
        if(correo.length>80){
            errores.push("La longitud del campo 'Correo electrónico' no debe superar los 80 caracteres.");
        }
        else{
            if(!validarMail(correo)){
                errores.push("La campo 'Correo electrónico' no posee un formato válido.");
            }
        }
    }
    if(errores.length>0){
        mensajeError(errores);
        return false;
    }
    return true;
}
function validarActualizacionUsuario(){
    var tipo = document.getElementById("tipo").value;
    var apellido = document.getElementById("apellido").value;
    var nombre = document.getElementById("nombre").value;
    var cuenta = document.getElementById("cuenta").value;
    var clave = document.getElementById("clave").value;
    var correo = document.getElementById("correo").value;
    var errores = [];
    
    if(tipo == null || tipo == ""){
        errores.push("El campo 'Tipo' de usuario es obligatorio.");
    }
    if(apellido == null || apellido == ""){
        errores.push("El campo 'Apellido' es obligatorio.");
    }
    else{
        if(apellido.length>45){
            errores.push("La longitud del campo 'Apellido' no debe superar los 45 caracteres.");
        }
    }
    if(nombre == null || nombre == ""){
        errores.push("El campo 'Nombre' es obligatorio.");
    }
    else{
        if(nombre.length>45){
            errores.push("La longitud del campo 'Nombre' no debe superar los 45 caracteres.");
        }
    }
    if(cuenta == null || cuenta == ""){
        errores.push("El campo 'Usuario' es obligatorio.");
    }
    else{
        if(cuenta.length>20){
            errores.push("La longitud del campo 'Usuario' no debe superar los 20 caracteres.");
        }
    }
    if(clave != null && clave != ""){
        if(clave.length<6){
            errores.push("La longitud del campo 'Contraseña' debe ser de al menos 6 caracteres.");
        }
        else{
            if(clave.length>32){
                errores.push("La longitud del campo 'Contraseña' no debe superar los 32 caracteres.");
            }
        }
    }
    if(correo == null || correo == ""){
        errores.push("El campo 'Correo electrónico' es obligatorio.");
    }
    else{
        if(correo.length>80){
            errores.push("La longitud del campo 'Correo electrónico' no debe superar los 80 caracteres.");
        }
        else{
            if(!validarMail(correo)){
                errores.push("La campo 'Correo electrónico' no posee un formato válido.");
            }
        }
    }
    if(errores.length>0){
        mensajeError(errores);
        return false;
    }
    return true;
}
//------- Pelicula -------//
function validarPelicula(){
    var nombre = document.getElementById("nombre").value;
    var año = document.getElementById("año").value;
    var nacionalidad = document.getElementById("nacionalidad").value;
    var director = document.getElementById("director").value;
    var actores_pri = document.getElementById("actores_pri").value;
    var actores_sec = document.getElementById("actores_sec").value;
    var web = document.getElementById("web").value;
    var sinopsis = document.getElementById("sinopsis").value;
    var genero = document.getElementById("genero").value;
    var duracion = document.getElementById("duracion").value;
    var errores = [];
    
    if(nombre == null || nombre == ""){
        errores.push("El campo 'Nombre' es obligatorio.");
    }
    else{
        if(nombre.length>80){
            errores.push("La longitud del campo 'Nombre' no debe superar los 80 caracteres.");
        }
    }
    if(año == null || año == "" || año == 0){
        errores.push("El campo 'Año' es obligatorio.");
    }
    else{
        if(año < 1900){
            errores.push("El valor seleccionado en el 'Año' no es válido.");
        }
        else{
            if(año%1 !== 0){
                errores.push("El 'Año' debe ser un número entero.");
            }
        }
    }
    if(nacionalidad == null || nacionalidad == ""){
        errores.push("El campo 'Nacionalidad' es obligatorio.");
    }
    else{
        if(nacionalidad.length>45){
            errores.push("La longitud del campo 'Nacionalidad' no debe superar los 45 caracteres.");
        }
    }
    if(director == null || director == ""){
        errores.push("El campo 'Director' es obligatorio.");
    }
    else{
        if(director.length>45){
            errores.push("La longitud del campo 'Director' no debe superar los 45 caracteres.");
        }
    }
    if(actores_pri == null || actores_pri == ""){
        errores.push("El campo 'Actores primarios' es obligatorio.");
    }
    else{
        if(actores_pri.length>150){
            errores.push("La longitud del campo 'Actores primarios' no debe superar los 150 caracteres.");
        }
    }
    if(actores_sec == null || actores_sec == ""){
        errores.push("El campo 'Actores secundarios' es obligatorio.");
    }
    else{
        if(actores_sec.length>150){
            errores.push("La longitud del campo 'Actores secundarios' no debe superar los 150 caracteres.");
        }
    }
    if(web == null || web == ""){
        errores.push("El campo 'Web oficial' es obligatorio.");
    }
    else{
        if(web.length>80){
            errores.push("La longitud del campo 'Web oficial' no debe superar los 80 caracteres.");
        }
    }
    if(sinopsis == null || sinopsis == ""){
        errores.push("El campo 'Sinópsis' es obligatorio.");
    }
    else{
        if(sinopsis.length>700){
            errores.push("La longitud del campo 'Sinópsis' no debe superar los 700 caracteres.");
        }
    }
    if(genero == null || genero == "" || genero == 0){
        errores.push("El campo 'Genero' es obligatorio.");
    }
    else{
        if(genero%1 !== 0){
            errores.push("El 'Genero' no existe.");
        }
    }
    if(duracion == null || duracion == ""){
        errores.push("El campo 'Duración' es obligatorio.");
    }
    else{
        if(duracion.length>3){
            errores.push("La longitud del campo 'Duración' no debe superar los 3 caracteres.");
        }
        if(duracion%1 !== 0) {
            errores.push("La 'Duración' debe ser un número entero.");
        }
    }
    
    validarImagen(errores);
    
    if(errores.length>0){
        mensajeError(errores);
        return false;
    }
    return true;
}
function validarActualizacionPelicula(){
    var nombre = document.getElementById("nombre").value;
    var año = document.getElementById("año").value;
    var nacionalidad = document.getElementById("nacionalidad").value;
    var director = document.getElementById("director").value;
    var actores_pri = document.getElementById("actores_pri").value;
    var actores_sec = document.getElementById("actores_sec").value;
    var web = document.getElementById("web").value;
    var sinopsis = document.getElementById("sinopsis").value;
    var genero = document.getElementById("genero").value;
    var duracion = document.getElementById("duracion").value;
    var imagen =  document.getElementById("imagen").value;
    var errores = [];
    
    if(nombre == null || nombre == ""){
        errores.push("El campo 'Nombre' es obligatorio.");
    }
    else{
        if(nombre.length>80){
            errores.push("La longitud del campo 'Nombre' no debe superar los 80 caracteres.");
        }
    }
    if(año == null || año == "" || año == 0){
        errores.push("El campo 'Año' es obligatorio.");
    }
    else{
        if(año%1 !== 0){
            errores.push("El 'Año' debe ser un número entero.");
        }
    }
    if(nacionalidad == null || nacionalidad == ""){
        errores.push("El campo 'Nacionalidad' es obligatorio.");
    }
    else{
        if(nacionalidad.length>45){
            errores.push("La longitud del campo 'Nacionalidad' no debe superar los 45 caracteres.");
        }
    }
    if(director == null || director == ""){
        errores.push("El campo 'Director' es obligatorio.");
    }
    else{
        if(director.length>45){
            errores.push("La longitud del campo 'Director' no debe superar los 45 caracteres.");
        }
    }
    if(actores_pri == null || actores_pri == ""){
        errores.push("El campo 'Actores primarios' es obligatorio.");
    }
    else{
        if(actores_pri.length>150){
            errores.push("La longitud del campo 'Actores primarios' no debe superar los 150 caracteres.");
        }
    }
    if(actores_sec == null || actores_sec == ""){
        errores.push("El campo 'Actores secundarios' es obligatorio.");
    }
    else{
        if(actores_sec.length>150){
            errores.push("La longitud del campo 'Actores secundarios' no debe superar los 150 caracteres.");
        }
    }
    if(web == null || web == ""){
        errores.push("El campo 'Web oficial' es obligatorio.");
    }
    else{
        if(web.length>80){
            errores.push("La longitud del campo 'Web oficial' no debe superar los 80 caracteres.");
        }
    }
    if(sinopsis == null || sinopsis == ""){
        errores.push("El campo 'Sinópsis' es obligatorio.");
    }
    else{
        if(sinopsis.length>700){
            errores.push("La longitud del campo 'Sinópsis' no debe superar los 700 caracteres.");
        }
    }
    if(genero == null || genero == "" || genero == 0){
        errores.push("El campo 'Genero' es obligatorio.");
    }
    else{
        if(genero%1 !== 0){
            errores.push("El 'Genero' no existe.");
        }
    }
    if(duracion == null || duracion == ""){
        errores.push("El campo 'Duración' es obligatorio.");
    }
    else{
        if(duracion.length>3){
            errores.push("La longitud del campo 'Duración' no debe superar los 3 caracteres.");
        }
        if(typeof duracion !== 'number'){
            if(duracion%1 !== 0) {
                errores.push("La 'Duración' debe ser un número entero.");
            }
        }
    }
    if(imagen != ""){
        validarActualizarImagen(errores);
    }
    
    if(errores.length>0){
        mensajeError(errores);
        return false;
    }
    return true;
}
function validarImagen(errores){
    var element =  document.getElementById("imagen");
    if(element.value != ""){
        var imagen = element.files[0];
        var tamaño = imagen.size/1024/1024;
        if (!(/\.(png|jpg|jpeg)$/i).test(imagen.name)){
            errores.push("El archivo debe ser una imagen (.png, .jpg, .jpeg)");
        }
        if(tamaño > 5){
            errores.push("La 'Imagen' seleccionada no debe tener un tamaño superior a 5Mb.");
        }
    }
    else{
        errores.push("El campo 'Imagen' es obligatorio.");
    }
}
function validarActualizarImagen(errores){
    var element =  document.getElementById("imagen");
    var imagen = element.files[0];
    var tamaño = imagen.size/1024/1024;
    if (!(/\.(png|jpg|jpeg)$/i).test(imagen.name)){
        errores.push("El archivo debe ser una imagen (.png, .jpg, .jpeg)");
    }
    if(tamaño > 5){
        errores.push("La 'Imagen' seleccionada no debe tener un tamaño superior a 5Mb.");
    }
}
function previsualizarImagen(imagenCargada){
    var element =  document.getElementById("previsualizacion");
    if (typeof(element) != "undefined" && element != null)
    {
        element.remove();
    }
    
    var files = imagenCargada.files;
    var file = files[0]; 
    var img = document.createElement("img");
    img.setAttribute("id","previsualizacion");
    img.file = file;
    var reader = new FileReader();
    reader.onload = (function(aImg){
        return function(e){
            aImg.src = e.target.result;
        };
    })(img);
    reader.readAsDataURL(file);

    document.getElementById("contenedor-previsualizacion").appendChild(img);
}
function cargarImagen(imagen){
    var img = document.createElement("img");
    img.setAttribute("id","previsualizacion");
    img.src = "img/peliculas/"+imagen;
    document.getElementById("contenedor-previsualizacion").appendChild(img);
}
function eliminarImagen(){
    var element =  document.getElementById("previsualizacion");
    if (typeof(element) != "undefined" && element != null)
    {
      element.remove();
    }
}
//------- Sala -------//
function validarSala(){
    var capacidad = document.getElementById("capacidad").value;
    var disponibilidad = document.getElementById("disponibilidad").value;
    var errores = [];
    
    if(capacidad == null || capacidad == ""){
        errores.push("El campo 'Capacidad' es obligatorio.");
    }
    else{
        if(capacidad<1){
            errores.push("La 'Capacidad' debe ser un número mayor que cero (0).");
        }
        if(capacidad%1 !== 0){
            errores.push("La 'Capacidad' debe ser un número entero.");
        }
    }
    if(disponibilidad == null || disponibilidad == ""){
        errores.push("El campo 'Disponibilidad' es obligatorio.");
    }
    if(errores.length>0){
        mensajeError(errores);
        return false;
    }
    return true;
}
//------- Funcion -------//
function validarFuncion(){
    var pelicula = document.getElementById("pelicula").value;
    var sala = document.getElementById("sala").value;
    var fecha = document.getElementById("fecha").value;
    var errores = [];
    
    if(pelicula == null || pelicula == "" || pelicula == 0){
        errores.push("El campo 'Pelicula' es obligatorio.");
    }
    if(sala == null || sala == "" || sala == 0){
        errores.push("El campo 'Sala' es obligatorio.");
    }
    if(fecha == null || fecha == ""){
        errores.push("El campo 'Fecha' es obligatorio.");
    }
    
    var contador=0;
    for(var i=1; i<=6;i++){
        var campo = document.getElementById("H"+i).value;
        if (campo == ''){
            contador++;
        }
        else{
            break;
        }
    }
    if(contador==6){
        errores.push("Debe especificar al menos un 'Horario'.");
    }
    
    if(errores.length>0){
        mensajeError(errores);
        return false;
    }
    return true;
}
//------- Recuperacion de clave -------//
function validarRecuperacion(){
    var correo = document.getElementById("correo").value;
    var errores = [];
    
    if(correo == null || correo == ""){
        errores.push("El campo 'Correo electrónico' es obligatorio.");
    }
    else{
        if(correo.length>80){
            errores.push("La longitud del campo 'Correo electrónico' no debe superar los 80 caracteres.");
        }
        else{
            if(!validarMail(correo)){
                errores.push("La campo 'Correo electrónico' no posee un formato válido.");
            }
        }
    }
    if(errores.length>0){
        mensajeError(errores);
        return false;
    }
    return true;
}
//------- Busqueda de peliculas -------//
function limpiarFiltrosPelicula(){
    document.getElementById("por_nombre").value = "";
    document.getElementById("por_año").value = 0;
    document.getElementById("por_nacionalidad").value = "";
    document.getElementById("por_genero").value = 0;
}
//------- Busqueda de usuarios -------//
function limpiarFiltrosUsuario(){
    document.getElementById("por_nombre").value = "";
    document.getElementById("por_apellido").value = "";
    document.getElementById("por_cuenta").value = "";
    document.getElementById("por_correo").value = "";
}
//------- Busqueda de salas -------//
function limpiarFiltrosSala(){
    document.getElementById("por_id").value = "";
    document.getElementById("por_capacidad").value = "";
    document.getElementById("por_disponibilidad").value = "";
}
//------- Busqueda de funciones -------//
function limpiarFiltrosFuncion(){
    document.getElementById("por_fecha").value = "";
    document.getElementById("por_sala").value = 0;
    document.getElementById("por_id").value = "";
}
//------- Configuracion de precios y dia de estrenos -------//
function validarConfiguracion(){
    var dia_estrenos = document.getElementById("dia_estrenos").value;
    var Lunes = document.getElementById("Lunes").value;
    var Martes = document.getElementById("Martes").value;
    var Miércoles = document.getElementById("Miércoles").value;
    var Jueves = document.getElementById("Jueves").value;
    var Viernes = document.getElementById("Viernes").value;
    var Sábado = document.getElementById("Sábado").value;
    var Domingo = document.getElementById("Domingo").value;
    var errores = [];
    
    if(dia_estrenos == null || dia_estrenos == ""){
        errores.push("El campo 'Día de estrenos' es obligatorio.");
    }
    else{
        if(dia_estrenos < 1 || dia_estrenos > 7){
            errores.push("El valor seleccionado en 'Día de estrenos' no corresponde con ningun día.");
        }
    }
    if(Lunes == null || Lunes == ""){
        errores.push("El valor de la entrada del día 'Lunes' debe ser igual o mayor que cero.");
    }
    else{
        if(Lunes < 0){
            errores.push("El valor de la entrada del día 'Lunes' debe ser igual o mayor que cero.");
        }
    }
    if(Martes == null || Martes == ""){
        errores.push("El valor de la entrada del día 'Martes' debe ser igual o mayor que cero.");
    }
    else{
        if(Martes < 0){
            errores.push("El valor de la entrada del día 'Martes' debe ser igual o mayor que cero.");
        }
    }
    if(Miércoles == null || Miércoles == ""){
        errores.push("El valor de la entrada del día 'Miércoles' debe ser igual o mayor que cero.");
    }
    else{
        if(Miércoles < 0){
            errores.push("El valor de la entrada del día 'Miércoles' debe ser igual o mayor que cero.");
        }
    }
    if(Jueves == null || Jueves == ""){
        errores.push("El valor de la entrada del día 'Jueves' debe ser igual o mayor que cero.");
    }
    else{
        if(Jueves < 0){
            errores.push("El valor de la entrada del día 'Jueves' debe ser igual o mayor que cero.");
        }
    }
    if(Viernes == null || Viernes == ""){
        errores.push("El valor de la entrada del día 'Viernes' debe ser igual o mayor que cero.");
    }
    else{
        if(Viernes < 0){
            errores.push("El valor de la entrada del día 'Viernes' debe ser igual o mayor que cero.");
        }
    }
    if(Sábado == null || Sábado == ""){
        errores.push("El valor de la entrada del día 'Sábado' debe ser igual o mayor que cero.");
    }
    else{
        if(Sábado < 0){
            errores.push("El valor de la entrada del día 'Sábado' debe ser igual o mayor que cero.");
        }
    }
    if(Domingo == null || Domingo == ""){
        errores.push("El valor de la entrada del día 'Domingo' debe ser igual o mayor que cero.");
    }
    else{
        if(Domingo < 0){
            errores.push("El valor de la entrada del día 'Domingo' debe ser igual o mayor que cero.");
        }
    }
    
    if(errores.length>0){
        mensajeError(errores);
        return false;
    }
    return true;
}
//------- Compra de entradas -------//
function validarFormularioPago(){
    var cantidad = document.getElementById("cantidad").value;
    var propietario = document.getElementById("propietario").value;
    var tarjeta = document.getElementById("tarjeta").value;
    var vencimiento_M = document.getElementById("vencimiento_M").value;
    var vencimiento_A = document.getElementById("vencimiento_A").value;
    var codigo = document.getElementById("codigo").value;
    var errores = [];
    
    if(cantidad == null || cantidad == ""){
        errores.push("La cantidad de entradas a comprar es obligatoria.");
    }
    else{
        if(cantidad<1 || cantidad>5 || cantidad%1 !== 0){
            errores.push("La cantidad de entradas seleccionadas no es válida.");
        }
    }
    if(propietario == null || propietario == ""){
        errores.push("El nombre del propietario es obligatorio.");
    }
    else{
        if(propietario.length > 80){
            errores.push("La longitud nombre del propietario no debe superar los 80 caracteres.");
        }
    }
    if(tarjeta == null || tarjeta == ""){
        errores.push("El número de la tarjeta es obligatorio.");
    }
    else{
        var result = $('#tarjeta').validateCreditCard();
        if(!result.valid){
            errores.push("El número de la tarjeta no es válido.");
        }
        /*
            Si el numero es valido (true/false):    result.valid
            Tipo de tarjeta (visa, etc):            result.card_type.name
            Longitud numerica valida (true/false):  result.length_valid
            Luhn checksum valido (true/false):      result.luhn_valid);
         */
    }
    if(vencimiento_M == null || vencimiento_M == "" || vencimiento_M == 0){
        errores.push("El mes de la fecha de vencimiento es obligatorio.");
    }
    else{
        if(vencimiento_M < 1 || vencimiento_M > 12 || vencimiento_M%1 !== 0){
            errores.push("El valor del mes de la fecha de vencimiento no es válido.");
        }
    }
    if(vencimiento_A == null || vencimiento_A == "" || vencimiento_A == 0){
        errores.push("El año de la fecha de vencimiento es obligatorio.");
    }
    else{
        var actual = new Date().getFullYear();
        var final = new Date();
        final.setFullYear(actual+6);
        final = final.getFullYear();
        if(vencimiento_A < actual || vencimiento_A > final || vencimiento_A%1 !== 0){
            errores.push("El valor del año de la fecha de vencimiento no es válido.");
        }
    }
    if(codigo == null || codigo == ""){
        errores.push("El código de seguridad de la tarjeta obligatorio.");
    }
    else{
        if(codigo.length>4 || codigo<1 || codigo%1 !== 0){
            errores.push("El código de seguridad de la tarjeta no es válido.");
        }
    }
    
    if(errores.length>0){
        mensajeError(errores);
        return false;
    }
    return true;
}
//------- Historial -------//
function limpiarFiltrosHistorial(){
    document.getElementById("por_numero").value = "";
    document.getElementById("por_fecha").value = "";
}
