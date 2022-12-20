<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Persona
 *
 *  @author AssistControl
 */
class Persona {
    private $id;
    private $nombres;
    private $apellidos;
    private $telefono;
    private $email;
    private $fechaNacimiento;
    
    function __construct($campo, $valor) {
        if ($campo!=null){
            if (is_array($campo)){
                foreach ($campo as $Variable => $Valor) $this->$Variable=$Valor;
                $this->cargarAtributosConMayusculas($campo);
            } else {
                $BD=null;$P='';
                $cadenaSQL="select id, nombres, apellidos, telefono, email, fechaNacimiento from {$P}persona where $campo=$valor";
                $resultado=Conector::ejecutarQuery($cadenaSQL, $BD);
                if (count($resultado)>0){
                    foreach ($resultado[0] as $Variable => $Valor) $this->$Variable=$Valor;
                    $this->cargarAtributosConMayusculas($resultado[0]);
                }
            }
        }        
    }
    
    private function cargarAtributosConMayusculas($arreglo){
        $this->fechaNacimiento=$arreglo['fechanacimiento'];
    }
    
    function getId() {
        return $this->id;
    }

    function getNombres() {
        return $this->nombres;
    }

    function getNombresCompletos() {
        return $this->nombres . ' ' . $this->apellidos;
    }

    function getApellidos() {
        return $this->apellidos;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getEmail() {
        return $this->email;
    }

    function getFechaNacimiento() {
        return $this->fechaNacimiento;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombres($nombres) {
        $this->nombres = $nombres;
    }

    function setApellidos($apellidos) {
        $this->apellidos = $apellidos;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setFechaNacimiento($fechaNacimiento) {
        $this->fechaNacimiento = $fechaNacimiento;
    }

    public function grabar(){
        $BD=null;$P='';
        $cadenaSQL="insert into {$P}persona (nombres, apellidos, telefono, email, fechaNacimiento) values ('$this->nombres','$this->apellidos','$this->telefono','$this->email','$this->fechaNacimiento')";        
        Conector::ejecutarQuery($cadenaSQL, $BD);
        $cadenaSQL="select max(id) as id from {$P}persona;";
        $this->id=Conector::ejecutarQuery($cadenaSQL, $BD)[0]['id'];
        //http://php.net/manual/es/pdo.lastinsertid.php para asignarlo a id y asi lo tome en usuario para idpersona
        
    }
    
    public function modificar($id){
        $BD=null;$P='';
        $cadenaSQL="update {$P}persona set nombres='$this->nombres',apellidos='$this->apellidos',telefono='$this->telefono',email='$this->email',fechaNacimiento='$this->fechaNacimiento' where id=$this->id";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public function eliminar(){
        $BD=null;$P='';
        $cadenaSQL="delete from {$P}persona where id=$this->id";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getLista($filtro, $orden){
        $BD=null;$P='';
        if ($filtro!=null) $filtro="where $filtro";
        $cadenaSQL="select id, nombres, apellidos, telefono, email, fechaNacimiento from {$P}persona $filtro $orden;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getListaEnObjetos($filtro, $orden){
        $datos= Persona::getLista($filtro, $orden);
        for ($i = 0; $i < count($datos); $i++) {
            $personas[$i]=new Persona($datos[$i], null);
        }
        return $personas;
    }
}
