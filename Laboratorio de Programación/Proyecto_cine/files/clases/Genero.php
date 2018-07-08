<?php
class Genero {
    /* Atributos */
    private $id = 0;
    private $nombre = "";
    private $error = "";
   
    /* Getters */
    public function getId() {
        return $this->id;
    }
    public function getNombre() {
        return $this->nombre;
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
    private function setError($error) {
       if(is_string($error)) $this->error = trim($error);
       else $this->error = "";
    }

    /* Metodos */
    public function resetear(){
        $this->id = 0;
        $this->nombre = "";
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
            $this->setError("Cuenta invalida.");
            return false;
        }
        $operacion=false;
        $sql = "SELECT * FROM generos WHERE gen_nombre='".$nombre."'";
        if($res = $conexion->query($sql)){
            if($res->num_rows==1){
                $reg=$res->fetch_object();
                $this->setId($reg->id_genero);
                $this->setNombre($reg->gen_nombre);
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
        $sql = "SELECT * FROM generos WHERE id_genero='".$id."'";
        if($res = $conexion->query($sql)){
            if($res->num_rows==1){
                $reg=$res->fetch_object();
                $this->setId($reg->id_genero);
                $this->setNombre($reg->gen_nombre);
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
    
    public static function listar($conexion){
        if($conexion == null || $conexion->connect_error) return null;
        $sql = "SELECT * FROM generos ORDER BY id_genero ASC";
        if($resultado = $conexion->query($sql)) return $resultado;
        else return null;
    }
}
?>