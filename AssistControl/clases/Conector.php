<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Conector
 *
 *  @author AssistControl
 */
class Conector {
    private $servidor;
    private $puerto;
    private $controlador;
    private $usuario;
    private $clave;
    private $bd;
    private $conexion;
    
    function __construct() {
        $archivo= dirname(__FILE__) . '/../configuracion.ini';
        if (!file_exists($archivo)){
            echo "ERROR: No existe el archivo de $archivo";
            die();
        }
        if (!$parametros=parse_ini_file($archivo, true)){
            echo "ERROR: No se puedo leer el archivo $archivo";
            die();
        }
        $this->servidor = $parametros['BaseDatos']['servidor'];
        $this->puerto = $parametros['BaseDatos']['puerto'];
        $this->controlador = $parametros['BaseDatos']['controlador'];
        $this->usuario = $parametros['BaseDatos']['usuario'];
        $this->clave = $parametros['BaseDatos']['clave'];
        $this->bd = $parametros['BaseDatos']['bd'];
    }

    private function conectar($bd){
        try {
            if ($bd==null) $bd=$this->bd;
            $opciones=array();
            $this->conexion=new PDO("$this->controlador:host=$this->servidor;port=$this->puerto;dbname=$bd",$this->usuario, $this->clave,$opciones);
        } catch (Exception $exc) {
            $this->conexion=null;            
            echo 'Error en la conexion con la bd' . $exc->getMessage();
            die();
        }
    }
    
    private function desconectar(){
        $this->conexion=null;
    }
    
    public static function ejecutarQuery($cadenaSQL,$bd){
        global $USUARIO, $NIVELAUDITORIA;
        $conector=new Conector();
        $conector->conectar($bd);
        $sentencia=$conector->conexion->prepare($cadenaSQL);//seguramente hay error aqui
         $tipoSQL= substr($cadenaSQL, 0, strpos($cadenaSQL, ' '));
        if($NIVELAUDITORIA==2 && $tipoSQL!='select') BitacoraAuditoria::registrar($USUARIO->getUsuario(), $tipoSQL, $cadenaSQL, $_GET['CONTENIDO']);
        if (!$sentencia->execute()){
            echo "Error al ejecutar $cadenaSQL en $bd";
            $conector->desconectar();
            return(false);
        } else {
            $consulta=$sentencia->fetchAll();
            $sentencia->closeCursor();
            $conector->desconectar();            
            return($consulta);//comprobar qué retorna en un insert, delete y update
        }
    }

    public static function ejecutarQueryMultiple($cadenaSQL,$bd){
        $cadenasSQL= explode(';', $cadenaSQL);
        $conector=new Conector();
        $conector->conectar($bd);
        for ($i = 0; $i < count($cadenasSQL); $i++) {
            $cadenaSQL=$cadenasSQL[$i];
            $sentencia=$conector->conexion->prepare($cadenaSQL);//seguramente hay error aqui
            if (!$sentencia->execute()){
                echo "Error al ejecutar $cadenaSQL en $bd";
                $conector->desconectar();
                return(false);
            } else {
                $consulta=$sentencia->fetchAll();
                $sentencia->closeCursor();
            }            
        }
        $conector->desconectar();
        return(true);
    }
    
}
