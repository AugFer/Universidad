<?php
class Conexion{
    public static function establecer(){
        $usuario = "root";
        $clave = "";
        $host = "localhost";
        $puerto = "3306";
        $baseDatos = "proyecto_cine";
        $conexion = new mysqli($host,$usuario,$clave,$baseDatos,$puerto);
        if(!$conexion->connect_error) $conexion->set_charset("utf8");
        return $conexion;
    }
}
?>