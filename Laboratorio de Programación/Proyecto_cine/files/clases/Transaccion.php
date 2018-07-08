<?php
class Transaccion {
    /* Atributos */
    private $id = 0;
    private $fecha = "";
    private $monto_total = 0;
    private $id_usuario = 0;
    private $error = "";
   
    /* Getters */
    public function getId() {
        return $this->id;
    }
    public function getFecha() {
        return $this->fecha;
    }
    public function getMonto_total() {
        return $this->monto_total;
    }
    public function getId_usuario() {
        return $this->id_usario;
    }
    public function getError() {
        return $this->error;
    }

    /* Setters */
    private function setId($id) {
        if(is_numeric($id)) $this->id = $id = (int)$id;
        else $this->id = 0;
    }
    public function setFecha($fecha) {
        if(is_string($fecha))$this->fecha = trim($fecha);
        else $this->fecha = "";
    }
    public function setMonto_total($monto_total) {
        if(is_numeric($monto_total)) $this->monto_total = $monto_total = (int)$monto_total;
        else $this->monto_total = 0;
    }
    public function setId_usuario($id_usuario) {
        if(is_numeric($id_usuario)) $this->id_usuario = $id_usuario = (int)$id_usuario;
        else $this->id_usuario = 0;
    }
    private function setError($error) {
       if(is_string($error)) $this->error = trim($error);
       else $this->error = "";
    }

    /* Metodos */
    public function resetear(){
        $this->id = 0;
        $this->fecha = "";
        $this->monto_total = 0;
        $this->id_usuario = 0;
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
        $sql = "SELECT * FROM transacciones WHERE id_transaccion='".$id."'";
        if($res = $conexion->query($sql)){
            if($res->num_rows==1){
                $reg=$res->fetch_object();
                $this->setId($reg->id_transaccion);
                $this->setFecha($reg->tra_fecha);
                $this->setMonto_total($reg->tra_monto_total);
                $this->setId_usuario($reg->tra_id_usuario);
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
    
    private function validarTransaccion($asientosLibres, $entradasNuevas){
        if($this->getMonto_total()==null || $this->getMonto_total()=="" || $this->getMonto_total()<0){
            $this->setError("El monto total de la compra es inválido.");
            return false;
        }
        if(!is_numeric($entradasNuevas) || $entradasNuevas < 1 || $entradasNuevas > 5 || $entradasNuevas != round($entradasNuevas)) {
            $this->setError("La cantidad de entradas seleccionadas no es válida.");
            return false;
        }
        if(($asientosLibres-$entradasNuevas)<0){
            $this->setError("La cantidad de entradas seleccionadas supera a los asientos libres de la función. (Asientos libres: ".$asientosLibres.")");
            return false;
        }
        return true;
    }
    
    public function guardar($conexion, $id_funcion, $asientosLibres, $entradasNuevas, $costoEntrada, $id_usuario){
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
        //validacion interna
        if(!$this->validarTransaccion($asientosLibres, $entradasNuevas)){
            return false;
        }
        
        //Insercion
        $operacion=false;
        
        $conexion->autocommit(FALSE);
        $conexion->begin_transaction();
        
        $sql = "INSERT INTO transacciones VALUES(null,STR_TO_DATE('".$this->getFecha()."','%Y-%m-%d %H:%i:%s'),".$this->getMonto_total().",".$id_usuario.")";
        if($conexion->query($sql)){
            $this->setId($conexion->insert_id);
            
            $sql = "INSERT INTO entradas VALUES"; 
            for($i=1; $i<=$entradasNuevas; $i++){
                if($i==1){
                    $sql .= "(null,".$id_funcion.",".$costoEntrada.",".$this->getId().")";
                }
                else{
                    $sql .= ",(null,".$id_funcion.",".$costoEntrada.",".$this->getId().")";
                }
            }
            if($conexion->query($sql)){
                $operacion = true;
            }
        }
        if($operacion){
            $conexion->commit();
        }else{
            $this->setError($conexion->error);
            $conexion->rollback();
        }
        $conexion->autocommit(TRUE);
        
        return $operacion;
    }
    
    public static function listar($conexion){
        if($conexion == null || $conexion->connect_error) return null;
        $sql = "SELECT * FROM transacciones ORDER BY id_transaccion ASC";
        if($resultado = $conexion->query($sql)) return $resultado;
        else return null;
    }
}
?>