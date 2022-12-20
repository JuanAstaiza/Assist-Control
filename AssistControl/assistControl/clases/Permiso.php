<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Permiso
 *
 *  @author AssistControl
 */
class Permiso {
    private $codigo;
    private $cedulaPersona;
    private $fechaSolicitud;
    private $fechaInicio;
    private $fechaFin;
    private $codMotivo;
    private $descripcion;
    private $anexo;
    
    function __construct($campo, $valor) {
        global $BD, $P;
        if ($campo!=null) {
            if (is_array($campo)) {
                foreach ($campo as $Variable => $Valor) $this->$Variable = $Valor;
                $this->cargarAtributosConMayusculas($campo);
            } else {
                $cadenaSQL = "select codigo, cedulaPersona, fechaSolicitud, fechaInicio, fechaFin, codMotivo, descripcion,anexo from {$P}permiso where $campo = $valor;";
                $resultado = Conector::ejecutarQuery($cadenaSQL, $BD);
                if (count($resultado)>0) {
                    foreach ($resultado[0] as $Variable => $Valor) $this->$Variable = $Valor;
                    $this->cargarAtributosConMayusculas($resultado[0]);
                }
            }
        }
    }

    function cargarAtributosConMayusculas($arreglo) {
        $this->cedulaPersona = $arreglo['cedulapersona'];
        $this->fechaSolicitud = $arreglo['fechasolicitud'];
        $this->fechaInicio = $arreglo['fechainicio'];
        $this->fechaFin = $arreglo['fechafin'];
        $this->codMotivo = $arreglo['codmotivo'];
    }
    
    function getCodigo() {
        return $this->codigo;
    }

    function getCedulaPersona() {
        return $this->cedulaPersona;
    }
    
    function getPersona(){
       return new Persona_A('cedula', $this->cedulaPersona); 
    }

    function getFechaSolicitud() {
        return $this->fechaSolicitud;
    }

    function getFechaInicio() {
        return $this->fechaInicio;
    }

    function getFechaFin() {
        return $this->fechaFin;
    }

    function getCodMotivo() {
        return $this->codMotivo;
    }
    
    function getMotivo(){
         return new Motivo('codigo', $this->codMotivo); 
    }

    function getDescripcion() {
        return $this->descripcion;
    }
    
    function getAnexo() {
        return $this->anexo;
    }

    
    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setCedulaPersona($cedulaPersona) {
        $this->cedulaPersona = $cedulaPersona;
    }

    function setFechaSolicitud($fechaSolicitud) {
        $this->fechaSolicitud = $fechaSolicitud;
    }

    function setFechaInicio($fechaInicio) {
        $this->fechaInicio = $fechaInicio;
    }

    function setFechaFin($fechaFin) {
        $this->fechaFin = $fechaFin;
    }

    function setCodMotivo($codMotivo) {
        $this->codMotivo = $codMotivo;
    }
     

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
    
    function setAnexo($anexo) {
        $this->anexo = $anexo;
    }

    
    function grabar() {
        global $BD, $P;
        $cadenaSQL = "insert into {$P}permiso (cedulaPersona, fechaSolicitud, fechaInicio, fechaFin, codMotivo, descripcion,anexo) values ($this->cedulaPersona, '$this->fechaSolicitud', '$this->fechaInicio', '$this->fechaFin', $this->codMotivo, '$this->descripcion','$this->anexo');";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function modificar() {
        global $BD, $P;
        $cadenaSQL = "update {$P}permiso set cedulaPersona = $this->cedulaPersona, fechaSolicitud = '$this->fechaSolicitud', fechaInicio = '$this->fechaInicio', fechaFin = '$this->fechaFin', codMotivo = $this->codMotivo, descripcion = '$this->descripcion',anexo = '$this->anexo' where codigo = $this->codigo;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function eliminar() {
        global $BD, $P;
        $cadenaSQL = "delete from {$P}permiso where codigo = $this->codigo;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getLista($filtro, $orden) {
        global $BD, $P;
        if ($filtro!=null) $filtro = "and $filtro";
        //$cadenaSQL = "select codigo, cedulaPersona, fechaSolicitud, fechaInicio, fechaFin, codMotivo, descripcion, anexo from {$P}permiso $filtro $orden;";
        $cadenaSQL = "select codigo, cedulaPersona, {$P}persona.primerNombre,{$P}persona.segundoNombre,{$P}persona.primerApellido,{$P}persona.segundoApellido,fechaSolicitud, fechaInicio, fechaFin, codMotivo, descripcion, anexo from {$P}permiso,{$P}persona where {$P}permiso.cedulapersona={$P}persona.cedula $filtro $orden;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos = Permiso::getLista($filtro, $orden);
        $permisos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $permisos[$i] = new Permiso($datos[$i], null);
        }
        return $permisos;
    }
    
    
}

