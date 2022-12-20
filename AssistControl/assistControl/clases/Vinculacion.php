<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Vinculacion
 *
 *  @author AssistControl
 */
class Vinculacion {
    private $codigo;
    private $nombre;
    
    function __construct($campo, $valor) {
        global $BD, $P;
        if ($campo!=null) {
            if (is_array($campo)) {
                foreach ($campo as $Variable => $Valor) $this->$Variable = $Valor;
            } else {
                $cadenaSQL = "select codigo, nombre from {$P}tipoVinculacion where $campo = $valor;";
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
        $cadenaSQL = "insert into {$P}tipoVinculacion (nombre) values ('$this->nombre');";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function modificar() {
        global $BD, $P;
        $cadenaSQL = "update {$P}tipoVinculacion set nombre = '$this->nombre' where codigo = $this->codigo;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function eliminar() {
        global $BD, $P;
        $cadenaSQL = "delete from {$P}tipoVinculacion where codigo = $this->codigo;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getLista($filtro, $orden) {
        global $BD, $P;
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select codigo, nombre from {$P}tipoVinculacion $filtro $orden;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos = Vinculacion::getLista($filtro, $orden);
        $vinculaciones=array();
        for ($i = 0; $i < count($datos); $i++) {
            $vinculaciones[$i] = new Vinculacion($datos[$i], null);
        }
        return $vinculaciones;
    }
    
    public static function getListaEnOptions($predeterminado) {
        $vinculaciones = Vinculacion::getListaEnObjetos(null, null);
        $lista = '';
        for ($i = 0; $i < count($vinculaciones); $i++) {
            $vinculacion = $vinculaciones[$i];
            if ($vinculacion->getCodigo()==$predeterminado) $auxiliar = 'selected';
            else $auxiliar = '';
            $lista.= "<option value='{$vinculacion->getCodigo()}' $auxiliar>{$vinculacion->getNombre()}</option>";
        }
        return $lista;
    }
}
