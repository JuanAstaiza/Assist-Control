<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of HoraExtra
 *
 *  @author AssistControl
 */
class HoraExtra {
    private $codigo;
    private $cedulaPersona;
    private $fechaInicio;
    private $horaInicio;
    private $fechaFin;
    private $horaFin;
    private $descripcion;
 
  
    function __construct($campo, $valor) {
        global $BD, $P;
        if ($campo!=null) {
            if (is_array($campo)) {
                foreach ($campo as $Variable => $Valor) $this->$Variable = $Valor;
                $this->cargarAtributosConMayusculas($campo);
            } else {
                $cadenaSQL = "select  codigo, cedulaPersona, fechaInicio, fechaFin, horaInicio, horaFin,descripcion from {$P}horaextra where $campo = $valor;";
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
        $this->fechaInicio = $arreglo['fechainicio'];
        $this->horaInicio = $arreglo['horainicio'];
        $this->fechaFin = $arreglo['fechafin'];
        $this->horaFin = $arreglo['horafin'];
    }
    
        
    function getCodigo() {
        return $this->codigo;
    }

    function getCedulaPersona() {
        return $this->cedulaPersona;
    }

    function getFechaInicio() {
        return $this->fechaInicio;
    }

    function getHoraInicio() {
        return $this->horaInicio;
    }

    function getFechaFin() {
        return $this->fechaFin;
    }

    function getHoraFin() {
        return $this->horaFin;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setCedulaPersona($cedulaPersona) {
        $this->cedulaPersona = $cedulaPersona;
    }

    function setFechaInicio($fechaInicio) {
        $this->fechaInicio = $fechaInicio;
    }

    function setHoraInicio($horaInicio) {
        $this->horaInicio = $horaInicio;
    }

    function setFechaFin($fechaFin) {
        $this->fechaFin = $fechaFin;
    }

    function setHoraFin($horaFin) {
        $this->horaFin = $horaFin;
    }


    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

        
       
    function grabar() {
        global $BD, $P;
        $cadenaSQL = "insert into {$P}horaextra (cedulaPersona, fechaInicio, fechaFin, horaInicio, horaFin, descripcion) values ($this->cedulaPersona, '$this->fechaInicio', '$this->fechaFin', '$this->horaInicio', '$this->horaFin', '$this->descripcion');";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function modificar() {
        global $BD, $P;
        $cadenaSQL = "update {$P}horaextra set cedulaPersona = $this->cedulaPersona, fechaInicio = '$this->fechaInicio', fechaFin = '$this->fechaFin',horaInicio = '$this->horaInicio', horaFin = '$this->horaFin',  descripcion = '$this->descripcion' where codigo = $this->codigo;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function eliminar() {
        global $BD, $P;
        $cadenaSQL = "delete from {$P}horaextra where codigo = $this->codigo;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getLista($filtro) {
        global $BD, $P;
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select codigo, cedulaPersona, fechaInicio, fechaFin, horaInicio, horaFin,descripcion from {$P}horaextra $filtro;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getListaEnObjetos($filtro) {
        $datos = HoraExtra::getLista($filtro);
	$HoraExtras=array();
        for ($i = 0; $i < count($datos); $i++) {
            $HoraExtras[$i] = new HoraExtra($datos[$i], null);
        }
        return $HoraExtras;
    }
    

}
    
 
   
   

