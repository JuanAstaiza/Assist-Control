<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Motivo
 *
 *  @author AssistControl
 */
class Motivo {
    private $codigo;
    private  $nombre;
    
    function __construct($campo, $valor) {
        global $BD, $P;
        if ($campo!=null) {
            if (is_array($campo)) {
                foreach ($campo as $Variable => $Valor) $this->$Variable = $Valor;
            } else {
                $cadenaSQL = "select codigo, nombre from {$P}motivo where $campo = $valor;";
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
        $cadenaSQL = "insert into {$P}motivo (nombre) values ('$this->nombre');";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function modificar() {
        global $BD, $P;
        $cadenaSQL = "update {$P}motivo set nombre = '$this->nombre' where codigo = $this->codigo;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function eliminar() {
        global $BD, $P;
        $cadenaSQL = "delete from {$P}motivo where codigo = $this->codigo;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getLista($filtro) {
        global $BD, $P;
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select codigo, nombre from {$P}motivo $filtro;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getListaEnObjetos($filtro) {
        $datos = Motivo::getLista($filtro);
        $motivos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $motivos[$i] = new Motivo($datos[$i], null);
        }
        return $motivos;
    }
    
    public static function getListaEnOptions($predeterminado) {
        $lista = '';
        $motivos = Motivo::getListaEnObjetos(null);
        for ($i = 0; $i < count($motivos); $i++) {
            $motivo = $motivos[$i];
            if ($motivo->getCodigo()==$predeterminado) $auxiliar = 'selected';
            else $auxiliar='';
            $lista.= "<option value='{$motivo->getCodigo()}' $auxiliar>{$motivo->getNombre()}</option>";
        }
        return $lista;
    }
}
