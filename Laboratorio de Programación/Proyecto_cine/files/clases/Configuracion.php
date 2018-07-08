<?php
class Configuracion {
    /* Atributos */
    private $id = 0;
    private $dia = "";
    private $costo = 0;
    private $actualiza_cartelera = 0;
    private $error = "";
   
    /* Getters */
    public function getId(){
        return $this->id;
    }
    public function getDia(){
        return $this->dia;
    }
    public function getCosto(){
        return $this->costo;
    }
    public function getActualiza_cartelera(){
        return $this->actualiza_cartelera;
    }

    /* Setters */
    private function setId($id){
        if(is_numeric($id)) $this->id = $id = (int)$id;
        else $this->id = 0;
    }
    public function setDia($dia){
        if(is_string($dia))$this->dia = trim($dia);
        else $this->dia = "";
    }
    public function setCosto($costo){
        if(is_numeric($costo)) $this->costo = $costo = (int)$costo;
        else $this->costo = 0;
    }
    public function setActualiza_cartelera($actualiza_cartelera){
        if(is_numeric($actualiza_cartelera)) $this->actualiza_cartelera = $actualiza_cartelera = (int)$actualiza_cartelera;
        else $this->actualiza_cartelera = 0;
    }
    private function setError($error){
       if(is_string($error)) $this->error = trim($error);
       else $this->error = "";
    }

    /* Metodos */
    public function resetear(){
        $this->id = 0;
        $this->dia = "";
        $this->costo = 0;
        $this->actualiza_cartelera = 0;
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
        $sql = "SELECT * FROM configuraciones WHERE id_configuracion='".$id."'";
        if($res = $conexion->query($sql)){
            if($res->num_rows==1){
                $reg=$res->fetch_object();
                $this->setId($reg->id_configuracion);
                $this->setDia($reg->con_dia);
                $this->setCosto($reg->con_costo);
                $this->setActualiza_cartelera($reg->con_actualiza_cartelera);
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
    
    public static function actualizar($conexion, $arrayDias, $arrayPrecios, $diaEstrenos){
        $operacion=false;
        
        $sql = 'INSERT INTO configuraciones (id_configuracion,con_dia,con_costo,con_actualiza_cartelera) VALUES ';
        for($i=1; $i<=7; $i++){
            if($i==1){
                if($i==$diaEstrenos){
                    $sql .= '('.$i.',"Dia",'.$arrayPrecios[$i-1].',1)';
                }
                else{
                    $sql .= '('.$i.',"Dia",'.$arrayPrecios[$i-1].',0)';
                }
            }
            else{
                if($i==$diaEstrenos){
                    $sql .= ',('.$i.',"Dia",'.$arrayPrecios[$i-1].',1)';
                }
                else{
                    $sql .= ',('.$i.',"Dia",'.$arrayPrecios[$i-1].',0)';
                }
            }
        }
        $sql .= ' ON DUPLICATE KEY UPDATE con_costo=VALUES(con_costo),con_actualiza_cartelera=VALUES(con_actualiza_cartelera)';
        
        //Actualizacion
        if($conexion->query($sql)){
            $operacion = true;
        }
        return $operacion;
    }
    
    public static function listar($conexion){
        if($conexion == null || $conexion->connect_error) return null;
        $sql = "SELECT * FROM configuraciones ORDER BY id_configuracion ASC";
        if($resultado = $conexion->query($sql)) return $resultado;
        else return null;
    }
    public static function cargarPorNombre($conexion, $dia){
        if($conexion == null || $conexion->connect_error) return null;
        $sql = "SELECT * FROM configuraciones WHERE con_dia='".$dia."'";
        if($resultado = $conexion->query($sql)) return $resultado;
        else return null;
    }
    
    public function cargarDiaEstrenos($conexion){
        $this->setError("");
        if($conexion == null){
            $this->setError("Conexión invalida.");
            return false;
        }
        if($conexion->connect_error){
            $this->setError($conexion->connect_error);
            return false;
        }
        
        //Insercion
        $operacion=false;
        $sql = "SELECT * FROM configuraciones WHERE con_actualiza_cartelera=1";
        if($res = $conexion->query($sql)){
            if($res->num_rows==1){
                $reg=$res->fetch_object();
                $this->setId($reg->id_configuracion);
                $this->setDia($reg->con_dia);
                $this->setCosto($reg->con_costo);
                $this->setActualiza_cartelera($reg->con_actualiza_cartelera);
                $operacion = true;
            }
            else{
                $this->setError("El día de actualizacion de cartelera no está configuado.");
            }
        }
        else{
            $this->setError($conexion->error);
        }
        return $operacion;
    }
}
?>