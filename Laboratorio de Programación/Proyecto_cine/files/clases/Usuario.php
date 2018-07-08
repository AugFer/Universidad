<?php
class Usuario {
    /* Atributos */
    private $id = 0;
    private $tipo = "";
    private $apellido = "";
    private $nombre = "";
    private $cuenta = "";
    private $clave = "";
    private $correo = "";
    private $error = "";
   
    /* Getters */
    public function getId() {
        return $this->id;
    }
    public function getTipo() {
        return $this->tipo;
    }
    public function getApellido() {
        return $this->apellido;
    }
    public function getNombre() {
        return $this->nombre;
    }
    public function getCuenta() {
        return $this->cuenta;
    }
    public function getClave() {
        return $this->clave;
    }
    public function getCorreo() {
        return $this->correo;
    }
    public function getError() {
        return $this->error;
    }

    /* Setters */
    private function setId($id) {
        if(is_numeric($id)) $this->id = $id = (int)$id;
        else $this->id = 0;
    }
    public function setTipo($tipo) {
        if(is_string($tipo))$this->tipo = trim($tipo);
        else $this->tipo = "";
    }
    public function setApellido($apellido) {
        if(is_string($apellido))$this->apellido = trim($apellido);
        else $this->apellido = "";
    }
    public function setNombre($nombre) {
        if(is_string($nombre))$this->nombre = trim($nombre);
        else $this->nombre = "";
    }
    public function setCuenta($cuenta) {
        if(is_string($cuenta))$this->cuenta = trim($cuenta);
        else $this->cuenta = "";
    }
    public function setClave($clave) {
        if(is_string($clave))$this->clave = trim($clave);
        else $this->clave = "";
    }
    public function setCorreo($correo) {
        if(is_string($correo))$this->correo = trim($correo);
        else $this->correo = "";
    }
    private function setError($error) {
       if(is_string($error)) $this->error = trim($error);
       else $this->error = "";
    }

    /* Metodos */
    public function resetear(){
        $this->id = 0;
        $this->tipo = "";
        $this->apellido = "";
        $this->nombre = "";
        $this->cuenta = "";
        $this->clave = "";
        $this->correo = "";
        $this->error = "";
    }
    
    public function cargarPorCuenta($conexion, $cuenta){
        $this->setError("");
        if($conexion == null){
            $this->setError("Conexión invalida.");
            return false;
        }
        if($conexion->connect_error){
            $this->setError($conexion->connect_error);
            return false;
        }
        if($cuenta == null){
            $this->setError("Cuenta invalida.");
            return false;
        }
        $operacion=false;
        $sql = "SELECT * FROM usuarios WHERE usu_cuenta='".$cuenta."'";
        if($res = $conexion->query($sql)){
            if($res->num_rows==1){
                $reg=$res->fetch_object();
                $this->setId($reg->id_usuario);
                $this->setTipo($reg->usu_tipo);
                $this->setApellido($reg->usu_apellido);
                $this->setNombre($reg->usu_nombre);
                $this->setCuenta($reg->usu_cuenta);
                $this->setClave($reg->usu_clave);
                $this->setCorreo($reg->usu_correo);
                $operacion = true;
            }
            else{
                $this->setError("No existe el registro con la cuenta ".$cuenta);
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
        $sql = "SELECT * FROM usuarios WHERE id_usuario='".$id."'";
        if($res = $conexion->query($sql)){
            if($res->num_rows==1){
                $reg=$res->fetch_object();
                $this->setId($reg->id_usuario);
                $this->setTipo($reg->usu_tipo);
                $this->setApellido($reg->usu_apellido);
                $this->setNombre($reg->usu_nombre);
                $this->setCuenta($reg->usu_cuenta);
                $this->setClave($reg->usu_clave);
                $this->setCorreo($reg->usu_correo);
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
        if($this->getCuenta()==null || $this->getCuenta()==""){
            $this->setError("No se especificó el usuario.");
            return false;
        }
        else{
            if(strlen($this->getCuenta())>20){
                $this->setError("La longitud del usuario no debe superar los 20 caracteres.");
                return false;
            }
        }
        if($this->getApellido()==null || $this->getApellido()==""){
            $this->setError("No se especificó el apellido del usuario.");
            return false;
        }
        else{
            if(strlen($this->getApellido())>45){
                $this->setError("La longitud del apellido no debe superar los 45 caracteres.");
                return false;
            }
        }
        if($this->getNombre()==null || $this->getNombre()==""){
            $this->setError("No se especificó el nombre del usuario.");
            return false;
        }
        else{
            if(strlen($this->getNombre())>45){
                $this->setError("La longitud del nombre no debe superar los 45 caracteres.");
                return false;
            }
        }
        if($this->getCorreo()==null || $this->getCorreo()==""){
            $this->setError("No se especificó el correo del usuario.");
            return false;
        }
        else{
            if(strlen($this->getCorreo())>80){
                $this->setError("La longitud del correo electrónico no debe superar los 80 caracteres.");
                return false;
            }
        }
        return true;
    }
    
    private function validarContraseña(){
        if($this->getClave()==null || $this->getClave()==""){
            $this->setError("No se especificó la clave del usuario.");
            return false;
        }
        else{
            if(strlen($this->getClave())<6){
                $this->setError("La longitud de la contraseña debe ser de al menos 6 caracteres.");
                return false;
            }
            else{
                if(strlen($this->getClave())>32){
                    $this->setError("La longitud de la contraseña no debe superar los 32 caracteres.");
                    return false;
                }
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
        if(!$this->validarContraseña()) return false;
        
        if($this->existeCuenta($conexion)){
            $this->setError("El nombre de la cuenta ingresado ya esta asociado a una cuenta.");
            return false;
        }
        if($this->existeCorreo($conexion)){
            $this->setError("El eMail ingresado ya esta asociado a una cuenta.");
            return false;
        }
        //Insercion
        $operacion=false;
        //Encriptar clave
        $this->setClave(md5($this->getClave()));
        $sql = "INSERT INTO usuarios VALUES(null,'".$this->getTipo()."','".$this->getApellido()."','".$this->getNombre()."','".$this->getCuenta()."','".$this->getClave()."','".$this->getCorreo()."')";
        if($conexion->query($sql)){
            $this->setId($conexion->insert_id);
            $operacion = true;
        }
        else{
            $this->setError($conexion->error);
        }
        return $operacion;
    }
    
    private function existeCuenta($conexion){
        $sql = "SELECT usu_cuenta FROM usuarios WHERE usu_cuenta='".$this->getCuenta()."' AND id_usuario<>'".$this->getId()."'";
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
    
    private function existeCorreo($conexion){
        $sql = "SELECT usu_correo FROM usuarios WHERE usu_correo='".$this->getCorreo()."' AND id_usuario<>'".$this->getId()."'";
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
              
        if($this->existeCuenta($conexion)){
            $this->setError("El nombre de la cuenta ya existe.");
            return false;
        }
        if($this->existeCorreo($conexion)){
            $this->setError("El eMail ingresado ya esta asociado a una cuenta.");
            return false;
        }
        
        //Actualizacion
        $operacion=false;
        if($this->getClave()!=""){
            if(!$this->validarContraseña()) return false;
            
            $this->setClave(md5($this->getClave()));
            $sql = "UPDATE usuarios SET usu_tipo='".$this->getTipo()."',usu_apellido='".$this->getApellido()."',usu_nombre='".$this->getNombre()."',usu_cuenta='".$this->getCuenta()."',usu_clave='".$this->getClave()."',usu_correo='".$this->getCorreo()."' WHERE id_usuario='".$this->getId()."'";
        }
        else{
            $sql = "UPDATE usuarios SET usu_tipo='".$this->getTipo()."',usu_apellido='".$this->getApellido()."',usu_nombre='".$this->getNombre()."',usu_cuenta='".$this->getCuenta()."',usu_correo='".$this->getCorreo()."' WHERE id_usuario='".$this->getId()."'";
        }
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
        $sql = "DELETE FROM usuarios WHERE id_usuario='".$this->getId()."'";
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
        $sql = "SELECT * FROM usuarios ORDER BY usu_apellido ASC, usu_nombre ASC";
        if($resultado = $conexion->query($sql)) return $resultado;
        else return null;
    }
    
    public static function validarAcceso($conexion, $cuenta, $clave){
        $sql = "SELECT usu_cuenta FROM usuarios WHERE usu_cuenta='".$cuenta."' AND usu_clave='".$clave."'";
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
    
    public function buscarCorreo($conexion, $correo){
        $sql = "SELECT id_usuario FROM usuarios WHERE usu_correo='".$correo."'";
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
}
?>