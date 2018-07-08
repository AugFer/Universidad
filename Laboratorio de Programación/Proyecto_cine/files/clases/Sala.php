<?php
class Sala {
    /* Atributos */
    private $id = 0;
    private $capacidad = 0;
    private $disponibilidad = "";
    private $error = "";
   
    /* Getters */
    public function getId() {
        return $this->id;
    }
    public function getCapacidad() {
        return $this->capacidad;
    }
    public function getDisponibilidad() {
        return $this->disponibilidad;
    }
    public function getError() {
        return $this->error;
    }

    /* Setters */
    private function setId($id) {
        if(is_numeric($id)) $this->id = $id = (int)$id;
        else $this->id = 0;
    }
    public function setCapacidad($capacidad) {
        if(is_numeric($capacidad)) $this->capacidad = $capacidad = (int)$capacidad;
        else $this->capacidad = 0;
    }
    public function setDisponibilidad($disponibilidad) {
        if(is_string($disponibilidad))$this->disponibilidad = trim($disponibilidad);
        else $this->disponibilidad = "";
    }
    private function setError($error) {
       if(is_string($error)) $this->error = trim($error);
       else $this->error = "";
    }

    /* Metodos */
    public function resetear(){
        $this->id = 0;
        $this->capacidad = 0;
        $this->disponibilidad = "";
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
        $sql = "SELECT * FROM salas WHERE id_sala='".$id."'";
        if($res = $conexion->query($sql)){
            if($res->num_rows==1){
                $reg=$res->fetch_object();
                $this->setId($reg->id_sala);
                $this->setCapacidad($reg->sal_capacidad);
                $this->setDisponibilidad($reg->sal_disponibilidad);
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
        if($this->getCapacidad()==null || $this->getCapacidad()==""){
            $this->setError("No se especifico la capacidad de la sala");
            return false;
        }
        else{
            if(!is_numeric($this->getCapacidad()) || $this->getCapacidad() < 1 || $this->getCapacidad() != round($this->getCapacidad())){
                $this->setError("La capacidad de la sala debe ser un número entero mayor que cero (0).");
                return false;
            }
        }
        if($this->getDisponibilidad()==null || $this->getDisponibilidad()==""){
            $this->setError("No se especifico la disponibilidad de la sala.");
            return false;
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
        $sql = "INSERT INTO salas VALUES(null,".$this->getCapacidad().",'".$this->getDisponibilidad()."')";
        if($conexion->query($sql)){
            $this->setId($conexion->insert_id);
            $operacion = true;
        }
        else{
            $this->setError($conexion->error);
        }
        return $operacion;
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
        if(!$this->validar()) return false;
        
        //Actualizacion
        $operacion=false;
        $sql = "UPDATE salas SET sal_capacidad=".$this->getCapacidad().",sal_disponibilidad='".$this->getDisponibilidad()."' WHERE id_sala='".$this->getId()."'";
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
        if($conexion == null){
            $this->setError("Conexión invalida");
            return false;
        }
        if($conexion->connect_error){
            $this->setError($conexion->connect_error);
            return false;
        }
        
        $operacion=false;
        $sql = "DELETE FROM salas WHERE id_sala='".$this->getId()."'";
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
        $sql = "SELECT * FROM salas ORDER BY id_sala ASC";
        if($resultado = $conexion->query($sql)) return $resultado;
        else return null;
    }
}
?>