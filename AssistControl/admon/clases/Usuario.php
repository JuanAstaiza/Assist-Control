<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Usuario
 *
 *  @author AssistControl
 */
class Usuario extends Persona{
    private $usuario;
    private $clave;
    private $fechaIniciacion;
    private $fechaFinalizacion;
    private $estado;
    private $idPersona;
    private $idPerfil;
    private $idEmpresa;    
    
    function __construct($campo,$valor) {
        parent::__construct(null, null);
        if ($campo!=null){
            if (is_array($campo)){
                foreach ($campo as $Variable => $Valor) $this->$Variable=$Valor;
                $this->cargarAtributosConMayusculas($campo);
                $this->setClave($this->clave);
                parent::__construct('id', $this->idPersona);//revisar
            } else {
                $BD=null;$P='';
                $cadenaSQL="select usuario, clave, fechaIniciacion, fechaFinalizacion, estado, idPersona, idPerfil, idEmpresa from {$P}usuario where $campo='$valor'";
                $resultado= Conector::ejecutarQuery($cadenaSQL, $BD);
                if (count($resultado)>0) {
                    foreach ($resultado[0] as $Variable => $Valor) $this->$Variable=$Valor;                    
                    $this->cargarAtributosConMayusculas($resultado[0]);
                    parent::__construct('id', $this->idPersona);
                } 
            }
        }
    }    
    
    private function cargarAtributosConMayusculas($arreglo){
        $this->fechaIniciacion=$arreglo['fechainiciacion'];
        $this->fechaFinalizacion=$arreglo['fechafinalizacion'];
        $this->idPersona=$arreglo['idpersona'];
        $this->idPerfil=$arreglo['idperfil'];
        $this->idEmpresa=$arreglo['idempresa'];                            
    }
    
    function getUsuario() {
        return $this->usuario;
    }

    function getClave() {
        return $this->clave;
    }

    function getFechaIniciacion() {
        return $this->fechaIniciacion;
    }

    function getFechaFinalizacion() {
        return $this->fechaFinalizacion;
    }

    function getEstado() {
        return new EstadoUsuario($this->estado);
    }

    function getIdPersona() {
        return $this->idPersona;
    }
    
    function getPersona(){
        return new Persona('id', $this->idPersona);
    }

    function getIdPerfil() {
        return $this->idPerfil;
    }
    
    function getPerfil(){
        return new Perfil('id', $this->idPerfil);
    }

    function getIdEmpresa() {
        return $this->idEmpresa;
    }    
    
    function getEmpresa(){
        return new Empresa('id', $this->idEmpresa);
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setClave($clave) {
        if (strlen($clave)<=30) $clave=md5($clave);//si el usuario establece nueva clave, esta se encripta
        $this->clave = $clave;
    }

    function setFechaIniciacion($fechaInicializacion) {
        $this->fechaIniciacion = $fechaInicializacion;
    }

    function setFechaFinalizacion($fechaFinalizacion) {
        $this->fechaFinalizacion = $fechaFinalizacion;
    }

    function setEstado($estado) {
        if ($estado=='on') $estado='true';
        $this->estado = $estado;
    }

    function setIdPersona($idPersona) {
        $this->idPersona = $idPersona;
    }

    function setIdPerfil($idPerfil) {
        $this->idPerfil = $idPerfil;
    }

    function setIdEmpresa($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
    }

    public function grabar(){
        $BD=null;$P='';
        parent::grabar();
        $this->idPersona=parent::getId();
        if ($this->fechaFinalizacion!=null) {$fechaFin='fechaFinalizacion,'; $valor="'$this->fechaFinalizacion',";}
        else {$fechaFin=''; $valor='';}
        $cadenaSQL="insert into {$P}usuario (usuario, clave, fechaIniciacion, $fechaFin estado, idPersona, idPerfil, idEmpresa) values ('$this->usuario','$this->clave','$this->fechaIniciacion',$valor $this->estado, $this->idPersona, $this->idPerfil, $this->idEmpresa)";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }

    public function modificar($usuarioAnterior){
        $BD=null;$P='';
        parent::modificar();
        $this->idPersona=parent::getId();
        $cadenaSQL="update {$P}usuario set usuario='$this->usuario',clave='$this->clave',fechaIniciacion='$this->fechaIniciacion',fechaFinalizacion='$this->fechaFinalizacion',estado=$this->estado, idPersona=$this->idPersona, idPerfil=$this->idPerfil, idEmpresa=$this->idEmpresa where usuario='$usuarioAnterior'";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public function modificarClave($usuarioAnterior){
        $BD=null;$P='';
        $cadenaSQL="update {$P}usuario set clave='$this->clave' where usuario='$usuarioAnterior'";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    

    public function eliminar(){
        $BD=null;$P='';
        $cadenaSQL="delete from {$P}usuario where usuario='$this->usuario'";
        Conector::ejecutarQuery($cadenaSQL, $BD);
        parent::eliminar();
    }
    
    public static function getLista($filtro, $orden){
        $BD=null;$P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $cadenaSQL="select usuario, clave, fechaIniciacion, fechaFinalizacion, estado, idPersona, idPerfil, idEmpresa from {$P}usuario $filtro $orden;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getListaEnObjetos($filtro, $orden){
        $datos= Usuario::getLista($filtro, $orden);
        $usuarios=array();
        for ($i = 0; $i < count($datos); $i++) {
            $usuarios[$i]=new Usuario($datos[$i], null);
        }
        return $usuarios;
    }
    
    public static function validar($usuario, $clave){
        $valido=false;
        $usuario=new Usuario('usuario', $usuario);
        if ($usuario->getUsuario()!=null){ //el usuario existe
            if ($usuario->getClave()==md5($clave)) $valido=true;
        }
        return $valido;
    }
    
    public static function getListaEnOptions($predeterminado){
        $usuarios= Usuario::getListaEnObjetos(null,null);
        $lista='';
        for ($i = 0; $i < count($usuarios); $i++) {
            $usuario=$usuarios[$i];
            if ($usuario->getUsuario()==$predeterminado) $auxiliar='selected';
            else $auxiliar='';
            $lista.="<option value='{$usuario->getUsuario()}' $auxiliar>{$usuario->getUsuario()}</option>";
        }
        return $lista;
    }
}
