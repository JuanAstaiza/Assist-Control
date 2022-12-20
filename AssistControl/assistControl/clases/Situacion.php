<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Situacion
 *
 *  @author AssistControl
 */
class Situacion {
    private $codigo;
    private  $nombre;
    
    function __construct($campo, $valor) {
        global $BD, $P;
        if ($campo!=null) {
            if (is_array($campo)) {
                foreach ($campo as $Variable => $Valor) $this->$Variable = $Valor;
            } else {
                $cadenaSQL = "select codigo, nombre from {$P}situacion where $campo = $valor;";
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
        $cadenaSQL = "insert into {$P}situacion (nombre) values ('$this->nombre');";
        echo $cadenaSQL;
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function modificar($codigo) {
        global $BD, $P;
        $cadenaSQL = "update {$P}situacion set nombre = '$this->nombre' where codigo = $codigo;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function eliminar() {
        global $BD, $P;
        $cadenaSQL = "delete from {$P}situacion where codigo = $this->codigo;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getLista($filtro, $orden) {
        global $BD, $P;
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select codigo, nombre from {$P}situacion $filtro $orden;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos = Situacion::getLista($filtro, $orden);
        $situaciones=array();
        for ($i = 0; $i < count($datos); $i++) {
            $situaciones[$i] = new Situacion($datos[$i], null);
        }
        return $situaciones;
    }
    
    public static function getListaEnOptions($predeterminado) {
        $lista = '';
        $situaciones = Situacion::getListaEnObjetos(null, null);
        for ($i = 0; $i < count($situaciones); $i++) {
            $situacion = $situaciones[$i];
            if ($situacion->getCodigo()==$predeterminado) $auxiliar = 'selected';
            else $auxiliar = '';
            $lista.= "<option value='{$situacion->getCodigo()}' $auxiliar>{$situacion->getNombre()}</option>";
        }
        return $lista;
    }
}
