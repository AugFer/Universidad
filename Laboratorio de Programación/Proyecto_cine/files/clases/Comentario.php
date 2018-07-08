<?php
class Comentario {
    /* Atributos */
    private $id = 0;
    private $id_usuario = 0;
    private $id_pelicula = 0;
    private $fecha = "";
    private $comentario = "";
    private $error = "";
   
    /* Getters */
    public function getId() {
        return $this->id;
    }
    public function getId_usuario() {
        return $this->id_usuario;
    }
    public function getId_pelicula() {
        return $this->id_pelicula;
    }
    public function getFecha() {
        return $this->fecha;
    }
    public function getComentario() {
        return $this->comentario;
    }
    public function getError() {
        return $this->error;
    }

    /* Setters */
    private function setId($id) {
        if(is_numeric($id)) $this->id = $id = (int)$id;
        else $this->id = 0;
    }
    public function setId_usuario($id_usuario) {
        if(is_numeric($id_usuario)) $this->id_usuario = $id_usuario = (int)$id_usuario;
        else $this->id_usuario = 0;
    }
    public function setId_pelicula($id_pelicula) {
        if(is_numeric($id_pelicula)) $this->id_pelicula = $id_pelicula = (int)$id_pelicula;
        else $this->id_pelicula = 0;
    }
    public function setFecha($fecha) {
        if(is_string($fecha))$this->fecha = trim($fecha);
        else $this->fecha = "";
    }
    public function setComentario($comentario) {
        if(is_string($comentario))$this->comentario = trim($comentario);
        else $this->comentario = "";
    }
    private function setError($error) {
       if(is_string($error)) $this->error = trim($error);
       else $this->error = "";
    }

    /* Metodos */
    public function resetear(){
        $this->id = 0;
        $this->id_usuario = 0;
        $this->id_pelicula = 0;
        $this->fecha = "";
        $this->comentario = "";
        $this->error = "";
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
        $sql = "SELECT * FROM comentarios WHERE com_id_pelicula='".$id."'";
        if($res = $conexion->query($sql)){
            if($res->num_rows==1){
                $reg=$res->fetch_object();
                $this->setId($reg->id_comentario);
                $this->setId_usuario($reg->com_id_usuario);
                $this->setId_pelicula($reg->com_id_pelicula);
                $this->setFecha($reg->com_fecha);
                $this->setComentario($reg->com_comentario);
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
    
    private function validar(){
        if($this->getComentario()==null || $this->getComentario()==""){
            $this->setError("El comentario esta en blanco.");
            return false;
        }
        else{
            if(strlen($this->getComentario())>300){
                $this->setError("La longitud del comentario no debe superar los 300 caracteres.");
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
        if(!$this->validar()) return false;
        
        //Insercion
        $operacion=false;
        $sql = "INSERT INTO comentarios VALUES(null,".$this->getId_usuario().",".$this->getId_pelicula().",STR_TO_DATE('".$this->getFecha()."','%Y-%m-%d %H:%i:%s'),'".$this->getComentario()."')";
        if($conexion->query($sql)){
            $this->setId($conexion->insert_id);
            $operacion = true;
        }
        else{
            $this->setError($conexion->error);
        }
        return $operacion;
    }
    
    public static function listar($conexion, $id_pelicula){
        if($conexion == null || $conexion->connect_error) return null;
        $sql = "SELECT * FROM comentarios, usuarios WHERE com_id_pelicula=".$id_pelicula." AND com_id_usuario=id_usuario ORDER BY com_fecha DESC";
        if($resultado = $conexion->query($sql)) return $resultado;
        else return null;
    }
}
?>