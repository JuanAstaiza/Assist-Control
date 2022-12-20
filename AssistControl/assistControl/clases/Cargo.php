<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Departamento
 *
 *  @author AssistControl
 */

require_once 'Perfil_A.php';
class Cargo {
    private $codigo;
    private $nombre;
    private $codPerfil;
    
    function __construct($campo, $valor) {
        global $BD, $P;
        if ($campo!=null) {
            if (is_array($campo)) {
                foreach ($campo as $Variable => $Valor) $this->$Variable = $Valor;
                $this->cargarAtributosConMayusculas($campo);
            } else {
                $cadenaSQL = "select codigo, nombre, codPerfil from {$P}cargo where $campo = $valor;";
                $resultado = Conector::ejecutarQuery($cadenaSQL, $BD);
                if (count($resultado)>0) {
                    foreach ($resultado[0] as $Variable => $Valor) $this->$Variable = $Valor;
                    $this->cargarAtributosConMayusculas($resultado[0]);
                }
            }
        }
    }
   

    function cargarAtributosConMayusculas($arreglo) {
        $this->codPerfil = $arreglo['codperfil'];
    }
    
    function getCodigo() {
        return $this->codigo;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getCodPerfil() {
        return $this->codPerfil;
    }
    
    function getPerfil() {
        return new Perfil_A('codigo', $this->codPerfil);
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setCodPerfil($codPerfil) {
        $this->codPerfil = $codPerfil;
    }

    function grabar() {
        global $BD, $P;
        $cadenaSQL = "insert into {$P}cargo (nombre, codPerfil) values ('$this->nombre', $this->codPerfil);";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function modificar() {
        global $BD, $P;
        $cadenaSQL = "update {$P}cargo set nombre = '$this->nombre', codPerfil = $this->codPerfil where codigo = $this->codigo;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function eliminar() {
        global $BD, $P;
        $cadenaSQL = "delete from {$P}cargo where codigo = $this->codigo;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getLista($filtro, $orden) {
        global $BD, $P;
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select codigo, nombre, codPerfil from {$P}cargo $filtro $orden;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos = Cargo::getLista($filtro, $orden);
	$cargos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $cargos[$i] = new Cargo($datos[$i], null);
        }
        return $cargos;
    }
    
    public static function getListaEnOptions($predeterminado) {
        $cargos = Cargo::getListaEnObjetos(null, null);
        $lista = '';
        for ($i = 0; $i < count($cargos); $i++) {
            $cargo = $cargos[$i];
            if ($cargo->getCodigo()==$predeterminado) $auxiliar = 'selected';
            else $auxiliar = '';
            $lista.= "<option value ='{$cargo->getCodigo()}' $auxiliar>{$cargo->getNombre()}</option>";
        }
        return $lista;
    }
    
    public static function getListaEnArregloJS(){
        $cargos = Cargo::getListaEnObjetos(null, null);
        $arregloJS = "\n\nvar cargos = new Array();";
        for ($i = 0; $i < count($cargos); $i++) {
            $cargo = $cargos[$i];
            $arregloJS.= "\n\tcargos[$i]=new Array({$cargo->getCodigo()},'{$cargo->getNombre()}',{$cargo->getCodPerfil()});";
        }
        return $arregloJS;
    }
}
