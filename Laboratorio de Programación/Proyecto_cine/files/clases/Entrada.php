<?php
class Entrada {
    /* Atributos */
    private $id = 0;
    private $id_funcion = 0;
    private $precio = 0;
    private $id_transaccion = 0;
    private $error = "";
   
    /* Getters */
    public function getId() {
        return $this->id;
    }
    public function getId_funcion() {
        return $this->id_funcion;
    }
    public function getPrecio() {
        return $this->precio;
    }
    public function getId_transaccion() {
        return $this->id_transaccion;
    }
    public function getError() {
        return $this->error;
    }

    /* Setters */
    private function setId($id) {
        if(is_numeric($id)) $this->id = $id = (int)$id;
        else $this->id = 0;
    }
    public function setId_funcion($id_funcion) {
        if(is_numeric($id_funcion)) $this->id_funcion = $id_funcion = (int)$id_funcion;
        else $this->id_funcion = 0;
    }
    public function setPrecio($precio) {
        if(is_numeric($precio)) $this->precio = $precio = (int)$precio;
        else $this->precio = 0;
    }
    public function setId_transaccion($id_transaccion) {
        if(is_numeric($id_transaccion)) $this->id_transaccion = $id_transaccion = (int)$id_transaccion;
        else $this->id_transaccion = 0;
    }
    private function setError($error) {
       if(is_string($error)) $this->error = trim($error);
       else $this->error = "";
    }

    /* Metodos */
    public function resetear(){
        $this->id = 0;
        $this->id_funcion = 0;
        $this->precio = 0;
        $this->id_transaccion = 0;
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
        $sql = "SELECT * FROM entradas WHERE id_entrada='".$id."'";
        if($res = $conexion->query($sql)){
            if($res->num_rows==1){
                $reg=$res->fetch_object();
                $this->setId($reg->id_entrada);
                $this->setId_funcion($reg->ent_id_funcion);
                $this->setPrecio($reg->ent_precio);
                $this->setId_transaccion($reg->ent_id_transaccion);
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
        
        //Insercion
        $operacion=false;
        $sql = "INSERT INTO entradas VALUES(null,".$this->getId_funcion().",".$this->getPrecio().",".$this->getId_transaccion().")";
        if($conexion->query($sql)){
            $this->setId($conexion->insert_id);
            $operacion = true;
        }
        else{
            $this->setError($conexion->error);
        }
        return $operacion;
    }
    
    public static function listar($conexion){
        if($conexion == null || $conexion->connect_error) return null;
        $sql = "SELECT * FROM entradas ORDER BY id_entrada ASC";
        if($resultado = $conexion->query($sql)) return $resultado;
        else return null;
    }
    
    public static function listarPorTransaccion($conexion, $id_transaccion){
        if($conexion == null || $conexion->connect_error) return null;
        $sql = "SELECT * FROM entradas WHERE ent_id_transaccion=".$id_transaccion;
        if($resultado = $conexion->query($sql)) return $resultado;
        else return null;
    }
    
    public static function contarPorFuncion($conexion, $id_funcion){
        if($conexion == null || $conexion->connect_error) return null;
        $sql = "SELECT id_entrada FROM entradas WHERE ent_id_funcion=".$id_funcion;
        if($resultado = $conexion->query($sql)) return $resultado;
        else return null;
    }
}
?>