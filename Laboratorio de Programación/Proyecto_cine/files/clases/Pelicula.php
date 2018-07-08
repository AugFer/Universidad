<?php
class Pelicula {
    /* Atributos */
    private $id = 0;
    private $nombre = "";
    private $año = 0;
    private $nacionalidad = "";
    private $director = "";
    private $actores_pri = "";
    private $actores_sec = "";
    private $web = "";
    private $sinopsis = "";
    private $genero = 0;
    private $duracion = "";
    private $imagen = "";
    private $error = "";
   
    /* Getters */
    public function getId() {
        return $this->id;
    }
    public function getNombre() {
        return $this->nombre;
    }
    public function getAño() {
        return $this->año;
    }
    public function getNacionalidad() {
        return $this->nacionalidad;
    }
    public function getDirector() {
        return $this->director;
    }
    public function getActores_pri() {
        return $this->actores_pri;
    }
    public function getActores_sec() {
        return $this->actores_sec;
    }
    public function getWeb() {
        return $this->web;
    }
    public function getSinopsis() {
        return $this->sinopsis;
    }
    public function getGenero() {
        return $this->genero;
    }
    public function getDuracion() {
        return $this->duracion;
    }
    public function getImagen() {
        return $this->imagen;
    }
    public function getError() {
        return $this->error;
    }

    /* Setters */
    private function setId($id) {
        if(is_numeric($id)) $this->id = $id = (int)$id;
        else $this->id = 0;
    }
    public function setNombre($nombre) {
        if(is_string($nombre))$this->nombre = trim($nombre);
        else $this->nombre = "";
    }
    public function setAño($año) {
        if(is_numeric($año)) $this->año = $año = (int)$año;
        else $this->año = 0;
    }
    public function setNacionalidad($nacionalidad) {
        if(is_string($nacionalidad))$this->nacionalidad = trim($nacionalidad);
        else $this->nacionalidad = "";
    }
    public function setDirector($director) {
        if(is_string($director))$this->director = trim($director);
        else $this->director = "";
    }
    public function setActores_pri($actores_pri) {
        if(is_string($actores_pri))$this->actores_pri = trim($actores_pri);
        else $this->actores_pri = "";
    }
    public function setActores_sec($actores_sec) {
        if(is_string($actores_sec))$this->actores_sec = trim($actores_sec);
        else $this->actores_sec = "";
    }
    public function setWeb($web) {
        if(is_string($web))$this->web = trim($web);
        else $this->web = "";
    }
    public function setSinopsis($sinopsis) {
        if(is_string($sinopsis))$this->sinopsis = trim($sinopsis);
        else $this->sinopsis = "";
    }
    public function setGenero($genero) {
        if(is_numeric($genero)) $this->genero = $genero = (int)$genero;
        else $this->genero = 0;
    }
    public function setDuracion($duracion) {
        if(is_string($duracion))$this->duracion = trim($duracion);
        else $this->duracion = "";
    }
    public function setImagen($imagen) {
        if(is_string($imagen))$this->imagen = trim($imagen);
        else $this->imagen = "";
    }
    private function setError($error) {
       if(is_string($error)) $this->error = trim($error);
       else $this->error = "";
    }

    /* Metodos */
    public function resetear(){
        $this->id = 0;
        $this->nombre = "";
        $this->año = 0;
        $this->nacionalidad = "";
        $this->director = "";
        $this->actores_pri = "";
        $this->actores_sec = "";
        $this->web = "";
        $this->sinopsis = "";
        $this->genero = 0;
        $this->duracion = "";
        $this->imagen = "";
        $this->error = "";
    }
    
    public function cargarPorNombre($conexion, $nombre){
        $this->setError("");
        if($conexion == null){
            $this->setError("Conexión invalida.");
            return false;
        }
        if($conexion->connect_error){
            $this->setError($conexion->connect_error);
            return false;
        }
        if($nombre == null){
            $this->setError("Nombre inválido.");
            return false;
        }
        $operacion=false;
        $sql = "SELECT * FROM peliculas WHERE pel_nombre='".$nombre."'";
        if($res = $conexion->query($sql)){
            if($res->num_rows==1){
                $reg=$res->fetch_object();
                $this->setId($reg->id_pelicula);
                $this->setNombre($reg->pel_nombre);
                $this->setAño($reg->pel_año);
                $this->setNacionalidad($reg->pel_nacionalidad);
                $this->setDirector($reg->pel_director);
                $this->setActores_pri($reg->pel_actores_pri);
                $this->setActores_sec($reg->pel_actores_sec);
                $this->setWeb($reg->pel_web);
                $this->setSinopsis($reg->pel_sinopsis);
                $this->setGenero($reg->pel_genero);
                $this->setDuracion($reg->pel_duracion);
                $this->setImagen($reg->pel_imagen);
                $operacion = true;
            }
            else{
                $this->setError("No existe el registro con el nombre ".$nombre);
            }
        }
        else{
            $this->setError($conexion->error);
        }
        return $operacion;
    }
    
    public function cargar($conexion, $id){
        $this->setError("");
        if($conexion == null){
            $this->setError("Conexión invalida.");
            return false;
        }
        if($conexion->connect_error){
            $this->setError($conexion->connect_error);
            return false;
        }
        if($id == null){
            $this->setError("Id invalido.");
            return false;
        }
        //Insercion
        $operacion=false;
        $sql = "SELECT * FROM peliculas WHERE id_pelicula='".$id."'";
        if($res = $conexion->query($sql)){
            if($res->num_rows==1){
                $reg=$res->fetch_object();
                $this->setId($reg->id_pelicula);
                $this->setNombre($reg->pel_nombre);
                $this->setAño($reg->pel_año);
                $this->setNacionalidad($reg->pel_nacionalidad);
                $this->setDirector($reg->pel_director);
                $this->setActores_pri($reg->pel_actores_pri);
                $this->setActores_sec($reg->pel_actores_sec);
                $this->setWeb($reg->pel_web);
                $this->setSinopsis($reg->pel_sinopsis);
                $this->setGenero($reg->pel_genero);
                $this->setDuracion($reg->pel_duracion);
                $this->setImagen($reg->pel_imagen);
                $operacion = true;
            }
            else{
                $this->setError("No existe el registro con el id ".$id);
            }
        }
        else{
            $this->setError($conexion->error);
        }
        return $operacion;
    }
 
    private function validarDatos(){
        if($this->getNombre()==null || $this->getNombre()==""){
            $this->setError("No se especifico el nombre de la pelicula.");
            return false;
        }
        else{
            if(strlen($this->getNombre())>80){
                $this->setError("La longitud del campo 'Nombre' no debe superar los 80 caracteres.");
                return false;
            }
        }
        if($this->getAño()==null || $this->getAño()=="" || $this->getAño()==0){
            $this->setError("No se especifico el año de la pelicula.");
            return false;
        }
        else{
            if(!is_numeric($this->getAño()) || $this->getAño() < 1900 || $this->getAño() != round($this->getAño())){
                $this->setError("El 'Año' de la película debe ser un número entero igual o mayor a 1900.");
                return false;
            }
        }
        if($this->getNacionalidad()==null || $this->getNacionalidad()==""){
            $this->setError("No se especifico la nacionalidad de la pelicula.");
            return false;
        }
        else{
            if(strlen($this->getNacionalidad())>45){
                $this->setError("La longitud del campo 'Nacionalidad' no debe superar los 45 caracteres.");
                return false;
            }
        }
        if($this->getDirector()==null || $this->getDirector()==""){
            $this->setError("No se especifico el director de la pelicula.");
            return false;
        }
        else{
            if(strlen($this->getDirector())>45){
                $this->setError("La longitud del campo 'Director' no debe superar los 45 caracteres.");
                return false;
            }
        }
        if($this->getActores_pri()==null || $this->getActores_pri()==""){
            $this->setError("No se especificaron los actores principales de la pelicula.");
            return false;
        }
        else{
            if(strlen($this->getActores_pri())>150){
                $this->setError("La longitud del campo 'Actores primarios' no debe superar los 150 caracteres.");
                return false;
            }
        }
        if($this->getActores_sec()==null || $this->getActores_sec()==""){
            $this->setError("No se especificaron los actores secundarios de la pelicula.");
            return false;
        }
        else{
            if(strlen($this->getActores_sec())>150){
                $this->setError("La longitud del campo 'Actores secundarios' no debe superar los 150 caracteres.");
                return false;
            }
        }
        if($this->getWeb()==null || $this->getWeb()==""){
            $this->setError("No se especifico la web oficial de la pelicula.");
            return false;
        }
        else{
            if(strlen($this->getWeb())>80){
                $this->setError("La longitud del campo 'Web oficial' no debe superar los 80 caracteres.");
                return false;
            }
        }
        if($this->getSinopsis()==null || $this->getSinopsis()==""){
            $this->setError("No se especifico la sinopsis de la pelicula.");
            return false;
        }
        else{
            if(strlen($this->getSinopsis())>700){
                $this->setError("La longitud del campo 'Sinópsis' no debe superar los 700 caracteres.");
                return false;
            }
        }
        if($this->getGenero()==null || $this->getGenero()=="" || $this->getGenero()==0){
            $this->setError("No se especifico el genero de la pelicula.");
            return false;
        }
        else{
            if(!is_numeric($this->getGenero()) || $this->getGenero() < 1 || $this->getGenero() != round($this->getGenero())){
                $this->setError("El 'Genero' de la película no corresponde con un valor válido");
                return false;
            }
        }
        if($this->getDuracion()==null || $this->getDuracion()==""){
            $this->setError("No se especifico la duración de la pelicula.");
            return false;
        }
        else{
            if(!is_numeric($this->getDuracion()) || $this->getDuracion() < 1 || $this->getDuracion() > 999 || $this->getDuracion() != round($this->getDuracion())){
                $this->setError("La 'Duración' de la película no corresponde con un valor válido");
                return false;
            }
        }
        return true;
    }
    
    public function guardar($conexion){
        $this->setError("");
        //Validacion de argumentos
        if($conexion == null){
            $this->setError("Conexión invalida");
            return false;
        }
        if($conexion->connect_error){
            $this->setError($conexion->connect_error);
            return false;
        }
        //Validacion interna
        if(!$this->validarDatos()) return false;
        
        if($this->existePelicula($conexion)){
            $this->setError("El nombre de la pelicula ingresada ya existe en la base de datos.");
            return false;
        }
        //Insercion
        $operacion=false;
//Año y genero estan solo con " por que son numeros, en caso de cambiar a string, cambiar acá igual!!!!!
        $sql = "INSERT INTO peliculas VALUES(null,'".$this->getNombre()."',".$this->getAño().",'".$this->getNacionalidad()."','".$this->getDirector()."','".$this->getActores_pri()."','".$this->getActores_sec()."','".$this->getWeb()."','".$this->getSinopsis()."',".$this->getGenero().",'".$this->getDuracion()."','".$this->getImagen()."')";
        if($conexion->query($sql)){
            $this->setId($conexion->insert_id);
            $operacion = true;
        }
        else{
            $this->setError($conexion->error);
        }
        return $operacion;
    }
    
    private function existePelicula($conexion){
        $sql = "SELECT pel_nombre FROM peliculas WHERE pel_nombre='".$this->getNombre()."' AND id_pelicula<>'".$this->getId()."'";
        $result = $conexion->query($sql);
        $existe=false;
        if($conexion->error) echo $conexion->error;
        else{
            if($result->num_rows>0){
                $existe=true;
            }
            $result->free_result();
        }
        return $existe;
    }
    
    public function actualizar($conexion){
        $this->setError("");
        //Validacion de argumentos
        if($conexion == null){
            $this->setError("Conexión invalida");
            return false;
        }
        if($conexion->connect_error){
            $this->setError($conexion->connect_error);
            return false;
        }
        //Validacion interna
        if(!$this->validarDatos()) return false;
              
        if($this->existePelicula($conexion)){
            $this->setError("El nombre de la pelicula ya existe en la base de datos.");
            return false;
        }
        
        //Actualizacion
        $operacion=false;
        $sql = "UPDATE peliculas SET pel_nombre='".$this->getNombre()."',pel_año=".$this->getAño().",pel_nacionalidad='".$this->getNacionalidad()."',pel_director='".$this->getDirector()."',pel_actores_pri='".$this->getActores_pri()."',pel_actores_sec='".$this->getActores_sec()."',pel_web='".$this->getWeb()."',pel_sinopsis='".$this->getSinopsis()."',pel_genero='".$this->getGenero()."',pel_duracion='".$this->getDuracion()."',pel_imagen='".$this->getImagen()."' WHERE id_pelicula='".$this->getId()."'";
        if($conexion->query($sql)){
            $operacion = true;
        }
        else{
            $this->setError($conexion->error);
        }
        return $operacion;
    }
    
    public function eliminar($conexion){
        $this->setError("");
        //Validacion de argumentos
        if($conexion == null){
            $this->setError("Conexión invalida");
            return false;
        }
        if($conexion->connect_error){
            $this->setError($conexion->connect_error);
            return false;
        }
        
        $operacion=false;
        $sql = "DELETE FROM peliculas WHERE id_pelicula='".$this->getId()."'";
        if($conexion->query($sql)){
            $operacion = true;
        }
        else{
            $this->setError($conexion->error);
        }
        return $operacion;
    }
    
    public static function listar($conexion){
        if($conexion == null || $conexion->connect_error) return null;
        $sql = "SELECT * FROM peliculas ORDER BY pel_nombre ASC, pel_año ASC";
        if($resultado = $conexion->query($sql)) return $resultado;
        else return null;
    }
    
    public static function listarEstrenos($conexion, $diaActualizaCartelera){
        if($conexion == null || $conexion->connect_error) return null;
        
        setlocale(LC_ALL,"es_ES", 'Spanish_Spain', 'Spanish');
        $hoy = new DateTime('NOW'); //fecha de hoy
        $dia = ucfirst(utf8_encode(strftime("%A",$hoy->getTimestamp()))); //nombre del dia de hoy
        
        while($dia!=$diaActualizaCartelera){
            $hoy->modify('-1 day');
            $dia = ucfirst(utf8_encode(strftime("%A",$hoy->getTimestamp())));
        }
        $semana = clone $hoy;
        $semana->modify('+6 day');
        $sql = "SELECT * FROM peliculas INNER JOIN funciones ON (id_pelicula=fun_id_pelicula) WHERE DATE(fun_fecha) BETWEEN DATE('".$hoy->format('Y-m-d')."') AND DATE('".$semana->format('Y-m-d')."') GROUP BY id_pelicula ORDER BY pel_nombre ASC, pel_año ASC";
        if($resultado = $conexion->query($sql)) return $resultado;
        else return null;
    }
    
    public static function listarProximas($conexion, $diaActualizaCartelera){
        if($conexion == null || $conexion->connect_error) return null;
        
        //$hoy = new DateTime('NOW');
        //$semana= clone $hoy;
        //$semana->modify('+6 day');
        // Cambiar la consulta para que traiga todas las peliculas que:
            // TENGAN funciones cargadas para la semana despues de la actual
            // O
            // NO TENGAN ninguna funcion cargada
        //$sql = "SELECT * FROM peliculas p LEFT JOIN funciones f ON (f.fun_id_pelicula = p.id_pelicula) WHERE f.fun_id_pelicula IS NULL AND p.id_pelicula IS NOT NULL GROUP BY id_pelicula ORDER BY pel_nombre ASC, pel_año ASC";
        
        setlocale(LC_ALL,"es_ES", 'Spanish_Spain', 'Spanish');
        $hoy = new DateTime('NOW'); //fecha de hoy
        $dia = ucfirst(utf8_encode(strftime("%A",$hoy->getTimestamp()))); //nombre del dia de hoy
        
        while($dia!=$diaActualizaCartelera){
            $hoy->modify('-1 day');
            $dia = ucfirst(utf8_encode(strftime("%A",$hoy->getTimestamp())));
        }
        $semana = clone $hoy;
        $semana->modify('+6 day');
        
        $sql = "SELECT * FROM peliculas p LEFT JOIN funciones f ON (f.fun_id_pelicula = p.id_pelicula) WHERE f.fun_id_pelicula IS NULL AND p.id_pelicula IS NOT NULL 
            UNION 
            SELECT * FROM peliculas INNER JOIN funciones ON (id_pelicula=fun_id_pelicula) WHERE DATE(fun_fecha) > DATE('".$semana->format('Y-m-d')."') 
            GROUP BY id_pelicula ORDER BY pel_nombre ASC, pel_año ASC";
        
        if($resultado = $conexion->query($sql)) return $resultado;
        else return null;
    }
}
?>