<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AreaEnsenanza
 *
 *  @author AssistControl
 */
class AreaEnsenanza {
    private $codigo;
    private $nombre;
    
    function __construct($campo, $valor) {
        global $BD, $P;
        if ($campo!=null) {
            if (is_array($campo)) {
                foreach ($campo as $Variable => $Valor) $this->$Variable = $Valor;
            } else {
                $cadenaSQL = "select codigo, nombre from {$P}areaEnsenanza where $campo = $valor;";
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
        $cadenaSQL = "insert into {$P}areaEnsenanza (nombre) values ('$this->nombre');";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function modificar() {
        global $BD, $P;
        $cadenaSQL = "update {$P}areaEnsenanza set nombre = '$this->nombre' where codigo = $this->codigo;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function eliminar() {
        global $BD, $P;
        $cadenaSQL = "delete from {$P}areaEnsenanza where codigo = $this->codigo;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getLista($filtro, $orden) {
        global $BD, $P;
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select codigo, nombre from {$P}areaEnsenanza $filtro $orden;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos = AreaEnsenanza::getLista($filtro, $orden);
        $areasEnsenanza=array();
        for ($i = 0; $i < count($datos); $i++) {
            $areasEnsenanza[$i] = new AreaEnsenanza($datos[$i], null);
        }
        return $areasEnsenanza;
    }
    
    public static function getListaEnOptions($predeterminado) {
        $areasEnsenanza = AreaEnsenanza::getListaEnObjetos(null, null);
        $lista = '';
        for ($i = 0; $i < count($areasEnsenanza); $i++) {
            $areaEnsenanza = $areasEnsenanza[$i];
            if ($areaEnsenanza->getCodigo()==$predeterminado) $auxiliar = 'selected';
            else $auxiliar = '';
            $lista.= "<option value='{$areaEnsenanza->getCodigo()}' $auxiliar>{$areaEnsenanza->getNombre()}</option>";
        }
        return $lista;
    }
}
