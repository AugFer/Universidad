<?php
class Funcion {
    /* Atributos */
    private $id = 0;
    private $pelicula = 0;
    private $sala = 0;
    private $fecha = "";
    private $error = "";
   
    /* Getters */
    public function getId() {
        return $this->id;
    }
    public function getPelicula() {
        return $this->pelicula;
    }
    public function getSala() {
        return $this->sala;
    }
    public function getFecha() {
        return $this->fecha;
    }
    public function getError() {
        return $this->error;
    }

    /* Setters */
    private function setId($id) {
        if(is_numeric($id)) $this->id = $id = (int)$id;
        else $this->id = 0;
    }
    public function setPelicula($pelicula) {
        if(is_numeric($pelicula)) $this->pelicula = $pelicula = (int)$pelicula;
        else $this->pelicula = 0;
    }
    public function setSala($sala) {
        if(is_numeric($sala)) $this->sala = $sala = (int)$sala;
        else $this->sala = 0;
    }
    public function setFecha($fecha) {
        if(is_string($fecha))$this->fecha = trim($fecha);
        else $this->fecha = "";
    }
    private function setError($error) {
       if(is_string($error)) $this->error = trim($error);
       else $this->error = "";
    }

    /* Metodos */
    public function resetear(){
        $this->id = 0;
        $this->pelicula = 0;
        $this->sala = 0;
        $this->fecha = "";
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
        $sql = "SELECT * FROM funciones WHERE id_funcion='".$id."'";
        if($res = $conexion->query($sql)){
            if($res->num_rows==1){
                $reg=$res->fetch_object();
                $this->setId($reg->id_funcion);
                $this->setPelicula($reg->fun_id_pelicula);
                $this->setSala($reg->fun_id_sala);
                $this->setFecha($reg->fun_fecha);
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
    
    private function validarActualizacion($conexion, $fechaYHora, $duracionPelicula){
        $correcto = false;
        
        if($this->getPelicula()==null || $this->getPelicula()==""){
            $this->setError("No se especifico la película.");
            return $correcto;
        }
        if($this->getSala()==null || $this->getSala()==""){
            $this->setError("No se especifico la sala.");
            return $correcto;
        }
        if($this->getFecha()==null || $this->getFecha()==""){
            $this->setError("No se especifico la fecha.");
            return $correcto;
        }
        
        $inicio1 = $fechaYHora;
        $final1 = clone $fechaYHora;
        $final1->modify('+'.$duracionPelicula.' minutes');
        
        $listadoFunciones = Funcion::listarProgramacion($conexion, $this->getSala(),  $this->getFecha(), $this->getId());
        if($listadoFunciones != null){
            while($reg = $listadoFunciones->fetch_object()){
                $inicio2 = DateTime::createFromFormat('Y-m-d H:i:s', $reg->fun_fecha);
                $inicio2->format('d/m/Y H:i');
                $final2 = DateTime::createFromFormat('Y-m-d H:i:s', $reg->fun_fecha);
                $final2->modify('+'.$duracionPelicula.' minutes');
                $final2->format('d/m/Y H:i');
                if($inicio1<$final2 && $inicio2<$final1){
                    $this->setError("El horario de la función se superpone con el de otra ya programada (ID: ".$reg->id_funcion.", Fecha: ".$inicio2->format('d/m/Y H:i').").");
                    return $correcto;
                }
            }
            $listadoFunciones->free_result();
            $correcto=true;
        }
        return $correcto;
    }
    
    private function validarFunciones($conexion, $fechaHoraFunciones, $nroFunciones, $duracionPelicula){
        $correcto = false;
        
        if($this->getPelicula()==null || $this->getPelicula()==""){
            $this->setError("No se especifico la película.");
            return $correcto;
        }
        if($this->getSala()==null || $this->getSala()==""){
            $this->setError("No se especifico la sala.");
            return $correcto;
        }
        if($this->getFecha()==null || $this->getFecha()==""){
            $this->setError("No se especifico la fecha.");
            return $correcto;
        }
        
        if(count($fechaHoraFunciones)>0){
            $correcto = true;
            for($i=0; $i<count($fechaHoraFunciones);$i++){
                $superNuevas = $this->superposicionEntreNuevas($i, $fechaHoraFunciones, $nroFunciones, $duracionPelicula);
                if($superNuevas!=-1){
                    $correcto = false;
                    $this->setError("Las funciones ".$nroFunciones[$i]." y ".$superNuevas." tienen horarios superpuestos.");
                    break;
                }
                $superGuardadas = $this->superposicionEntreGuardadas($conexion, $i, $fechaHoraFunciones, $nroFunciones, $duracionPelicula);
                if($superGuardadas){
                    $correcto = false;
                    break;
                }
            }
        }
        else{
            $this->setError("Debe cargar al menos una función.");
        }
        return $correcto;
    }
    
    private function superposicionEntreNuevas($i, $fechaHoraFunciones, $nroFunciones, $duracionPelicula){
        $indiceColision=-1;
        $inicio1 = $fechaHoraFunciones[$i];
        $final1 = clone $fechaHoraFunciones[$i];
        $final1->modify('+'.$duracionPelicula.' minutes');
        for($j=0; $j<count($fechaHoraFunciones);$j++){
            if($j!=$i){
                $inicio2 = $fechaHoraFunciones[$j];
                $final2 = clone $fechaHoraFunciones[$j];
                $final2->modify('+'.$duracionPelicula.' minutes');
                if($inicio1<$final2 && $inicio2<$final1){
                    $indiceColision = $nroFunciones[$j];
                    break;
                }
            }
        }
        return $indiceColision;
    }
    
    private function superposicionEntreGuardadas($conexion, $i, $fechaHoraFunciones, $nroFunciones, $duracionPelicula){
        $superposicion=false;
        $inicio1 = $fechaHoraFunciones[$i];
        $final1 = clone $fechaHoraFunciones[$i];
        $final1->modify('+'.$duracionPelicula.' minutes');
        
        $listadoFunciones = Funcion::listarProgramacion($conexion, $this->getSala(),  $this->getFecha(), $this->getId());
        if($listadoFunciones != null){
            while($reg = $listadoFunciones->fetch_object()){
                $inicio2 = DateTime::createFromFormat('Y-m-d H:i:s', $reg->fun_fecha);
                $inicio2->format('d/m/Y H:i');
                $final2 = DateTime::createFromFormat('Y-m-d H:i:s', $reg->fun_fecha);
                $final2->modify('+'.$duracionPelicula.' minutes');
                $final2->format('d/m/Y H:i');
                if($inicio1<$final2 && $inicio2<$final1){
                    $superposicion=true;
                    $this->setError("El horario de la función ".$nroFunciones[$i]." se superpone con el de otra ya programada (ID: ".$reg->id_funcion.", Fecha: ".$inicio2->format('d/m/Y H:i').").");
                    break;
                }
            }
            $listadoFunciones->free_result();
        }
        return $superposicion;
    }
    
    public function guardar($conexion, $fechaHoraFunciones, $nroFunciones, $duracionPelicula){
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
        if(!$this->validarFunciones($conexion, $fechaHoraFunciones, $nroFunciones, $duracionPelicula)){
            return false;
        }
        //Insercion
        $operacion=false;
        $sql = "INSERT INTO funciones VALUES";
        for($i=0; $i<count($fechaHoraFunciones);$i++){
            $result = $fechaHoraFunciones[$i]->format('d/m/Y H:i');
            $this->setFecha($result);
            if($i==0){
                $sql .= "(null,".$this->getPelicula().",".$this->getSala().",STR_TO_DATE('".$this->getFecha()."','%d/%m/%Y %H:%i'))";
            }
            else{
                $sql .= ",(null,".$this->getPelicula().",".$this->getSala().",STR_TO_DATE('".$this->getFecha()."','%d/%m/%Y %H:%i'))";
            }
        }
        
        if($conexion->query($sql)){
            $operacion = true;
        }
        else{
            $this->setError($conexion->error);
        }
        return $operacion;
    }
    
    public function actualizar($conexion, $fechaYHora, $duracionPelicula){
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
        if(!$this->validarActualizacion($conexion, $fechaYHora, $duracionPelicula)){
            return false;
        }
        $result = $fechaYHora->format('d/m/Y H:i');
        $this->setFecha($result);
        
        //Actualizacion
        $operacion=false;
        $sql = "UPDATE funciones SET fun_id_pelicula=".$this->getPelicula().",fun_id_sala=".$this->getSala().",fun_fecha=STR_TO_DATE('".$this->getFecha()."','%d/%m/%Y %H:%i') WHERE id_funcion=".$this->getId()."";
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
        $sql = "DELETE FROM funciones WHERE id_funcion='".$this->getId()."'";
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
        $sql = "SELECT * FROM funciones ORDER BY id_funcion ASC";
        if($resultado = $conexion->query($sql)) return $resultado;
        else return null;
    }
    
    private static function listarProgramacion($conexion, $sala, $fecha, $id){
        if($conexion == null || $conexion->connect_error) return null;
        
        $date = DateTime::createFromFormat('d/m/Y', $fecha);
        $ayer = clone $date;
        $mañana = clone $date;
        $ayer->modify('-1 day');
        $mañana->modify('+1 day');
        $sql = "SELECT id_funcion, fun_id_pelicula, fun_id_sala, fun_fecha FROM funciones WHERE fun_id_sala=".$sala." AND DATE(fun_fecha) BETWEEN DATE('".$ayer->format('Y-m-d')."') AND DATE('".$mañana->format('Y-m-d')."') AND id_funcion<>'".$id."' ORDER BY id_funcion ASC";
        if($resultado = $conexion->query($sql)) return $resultado;
        else return null;
    }
    
    
    public static function listarFuncionesPelicula($conexion, $id, $diaActualizaCartelera){
        if($conexion == null || $conexion->connect_error) return null;
        
        setlocale(LC_ALL,"es_ES", 'Spanish_Spain', 'Spanish');
        $hoy = new DateTime('NOW');
        $dia = ucfirst(utf8_encode(strftime("%A",$hoy->getTimestamp())));
        
        while($dia!=$diaActualizaCartelera){
            $hoy->modify('-1 day');
            $dia = ucfirst(utf8_encode(strftime("%A",$hoy->getTimestamp())));
        }
        $semana= clone $hoy;
        $semana->modify('+6 day');
        $sql = "SELECT * FROM funciones WHERE (fun_id_pelicula=".$id.") AND DATE(fun_fecha) BETWEEN DATE('".$hoy->format('Y-m-d')."') AND DATE('".$semana->format('Y-m-d')."') GROUP BY fun_fecha ORDER BY fun_fecha ASC";
        if($resultado = $conexion->query($sql)) return $resultado;
        else return null;
    }
}
?>