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
require_once 'assistControl/clases/Pais_A.php';
class Departamento_A {
    private $codigo;
    private $nombre;
    private $codPais;
    
    function __construct($campo, $valor) {
        global $BD, $P;
        if ($campo!=null) {
            if (is_array($campo)) {
                foreach ($campo as $Variable => $Valor) $this->$Variable = $Valor;
                $this->cargarAtributosConMayusculas($campo);
            } else {
                $cadenaSQL = "select codigo, nombre, codPais from {$P}departamento where $campo = $valor;";
                $resultado = Conector::ejecutarQuery($cadenaSQL, $BD);
                if (count($resultado)>0) {
                    foreach ($resultado[0] as $Variable => $Valor) $this->$Variable = $Valor;
                    $this->cargarAtributosConMayusculas($resultado[0]);
                }
            }
        }
    }

    function cargarAtributosConMayusculas($arreglo) {
        $this->codPais = $arreglo['codpais'];
    }
    
    function getCodigo() {
        return $this->codigo;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getCodPais() {
        return $this->codPais;
    }
    
    function getPais() {
        return new Pais_A('codigo', $this->codPais);
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setCodPais($codPais) {
        $this->codPais = $codPais;
    }

    function grabar() {
        global $BD, $P;
        $cadenaSQL = "insert into {$P}departamento (nombre, codPais) values ('$this->nombre', $this->codPais);";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function modificar() {
        global $BD, $P;
        $cadenaSQL = "update {$P}departamento set nombre = '$this->nombre', codPais = $this->codPais where codigo = $this->codigo;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function eliminar() {
        global $BD, $P;
        $cadenaSQL = "delete from {$P}departamento where codigo = $this->codigo;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getLista($filtro, $orden) {
        global $BD, $P;
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select codigo, nombre, codPais from {$P}departamento $filtro $orden;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getListaEnObjetos($filtro , $orden) {
        $datos = Departamento_A::getLista($filtro, $orden);
	$departamentos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $departamentos[$i] = new Departamento_A($datos[$i], null);
        }
        return $departamentos;
    }
    
    public static function getListaEnOptions($predeterminado) {
        $departamentos = Departamento_A::getListaEnObjetos(null, null);
        $lista = '';
        for ($i = 0; $i < count($departamentos); $i++) {
            $departamento = $departamentos[$i];
            if ($departamento->getCodigo()==$predeterminado) $auxiliar = 'selected';
            else $auxiliar = '';
            $lista.= "<option value ='{$departamento->getCodigo()}' $auxiliar>{$departamento->getNombre()}</option>";
        }
        return $lista;
    }
    
    public static function getListaEnArregloJS(){
        $departamentos= Departamento_A::getListaEnObjetos(null, null);
        $arregloJS="\nvar departamentos=new Array();";
        for ($i = 0; $i < count($departamentos); $i++) {
            $departamento=$departamentos[$i];
            $arregloJS.="\n\tdepartamentos[$i]=new Array({$departamento->getCodigo()},"
            . "'{$departamento->getNombre()}',{$departamento->getCodPais()});";
        }        
        return $arregloJS;
    }
}
