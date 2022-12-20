<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pais
 *
 *  @author AssistControl
 */
class Pais_A {
    private $codigo;
    private $nombre;
    
    function __construct($campo, $valor) {
        global $BD, $P;
        if ($campo!=null) {
            if (is_array($campo)) {
                foreach ($campo as $Variable => $Valor) $this->$Variable = $Valor;
            } else {
                $cadenaSQL = "select codigo, nombre from {$P}pais where $campo = $valor;";
                $resultado = Conector::ejecutarQuery($cadenaSQL, $BD);
                if (count($resultado)>0) {
                    foreach ($resultado[0] as $Variable => $Valor) $this->$Variable = $Valor;
                }
            }
        }
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getNombre() {
        return $this->nombre;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function grabar() {
        global $BD, $P;
        $cadenaSQL = "insert into {$P}pais (codigo, nombre) values ($this->codigo, '$this->nombre');";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function modificar($codigoAnterior) {
        global $BD, $P;
        $cadenaSQL = "update {$P}pais set codigo = $this->codigo, nombre = '$this->nombre' where codigo = $codigoAnterior;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function eliminar() {
        global $BD, $P;
        $cadenaSQL = "delete from {$P}pais where codigo = $this->codigo;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getLista($filtro, $orden) {
        global $BD, $P;
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select codigo, nombre from {$P}pais $filtro $orden;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos = Pais_A::getLista($filtro, $orden);
       $paises=array();
        for ($i = 0; $i < count($datos); $i++) {
            $paises[$i] = new Pais_A($datos[$i], null);
        }
        return $paises;
    }
    
    public static function getListaEnOptions($predeterminado) {
        $paises = Pais_A::getListaEnObjetos(null, null);
        $lista = '';
        for ($i = 0; $i < count($paises); $i++) {
            $pais = $paises[$i];
            if ($pais->getCodigo()==$predeterminado) $auxiliar = 'selected';
            else $auxiliar = '';
            $lista.= "<option value='{$pais->getCodigo()}' $auxiliar>{$pais->getNombre()}</option>";
        }
        return $lista;
    }
}
