<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Registro
 *
 *  @author AssistControl
 */
class Registro_RegistroDiario {
    private $codigo;
    private $cedulaPersona;
    private $fecha;
    private $tipo;
    
    function __construct($campo, $valor) {
        global $BD, $P;
        if ($campo!=null) {
            if (is_array($campo)) {
                foreach ($campo as $Variable => $Valor) $this->$Variable = $Valor;
                $this->cargarAtributosConMayusculas($campo);
            } else {
                $cadenaSQL = "select codigo, cedulaPersona, fecha, tipo from {$P}registro where $campo = $valor;";
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
    }
    
    function getCodigo() {
        return $this->codigo;
    }

    function getCedulaPersona() {
        return $this->cedulaPersona;
    }

        
   function getPersona(){
       return new PersonaRegistroDiario('cedula', $this->cedulaPersona); 
    }

    function getFecha() {
        return $this->fecha;
    }

    function getTipo() {
        return $this->tipo;
    }
    
    function getTipoEnLetras() {
        if ($this->tipo) return 'Entrada';
        else return 'Salida';
    }
    
    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }
    
    function setCedulaPersona($cedulaPersona) {
        $this->cedulaPersona = $cedulaPersona;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function grabar() {
        global $BD, $P;
        $cadenaSQL = "insert into {$P}registro (cedulaPersona, fecha, tipo) values ($this->cedulaPersona, '$this->fecha', '$this->tipo');";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function modificar() {
        global $BD, $P;
        $cadenaSQL = "update {$P}registro set cedulaPersona = $this->cedulaPersona, fecha = '$this->fecha', tipo = '$this->tipo' where codigo = $this->codigo;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function eliminar() {
        global $BD, $P;
        $cadenaSQL = "delete from {$P}registro where codigo = $this->codigo;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getLista($filtro, $orden) {
        global $BD, $P;
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select codigo, cedulaPersona, fecha, tipo from {$P}registro $filtro $orden;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
 
    public static function getListaEnObjetos($filtro, $orden) {
        $datos = Registro_RegistroDiario::getLista($filtro, $orden);
	$registros=array();
        for ($i = 0; $i < count($datos); $i++) {
            $registros[$i] = new Registro_RegistroDiario($datos[$i], null);
        }
        return $registros;
    }
    
    public static function getListaReporte($filtro) {
        //LA DIFERENCIA ES QUE VA INCLUIDA LA TABLA PERSONA EN LA CLAUSURA FROM PARA BUSCAR POR CARGO
        global $BD, $P;
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select codigo, cedulaPersona, fecha, tipo from {$P}registro,{$P}persona $filtro;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getListaEnObjetosReporte($filtro) {
        $datos = Registro_RegistroDiario::getListaReporte($filtro);
	$registros=array();
        for ($i = 0; $i < count($datos); $i++) {
            $registros[$i] = new Registro_RegistroDiario($datos[$i], null);
        }
        return $registros;
    }
}
