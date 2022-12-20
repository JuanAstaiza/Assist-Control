<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Ciudad
 *
 *  @author AssistControl
 */
require_once 'assistControl/clases/Departamento_A.php';
class Ciudad_A {
    private $codigo;
    private $nombre;
    private $codDepartamento;
    
    function __construct($campo, $valor) {
        global $BD, $P;
        if ($campo!=null) {
            if (is_array($campo)) {
                foreach ($campo as $Variable => $Valor) $this->$Variable = $Valor;
                $this->cargarAtributosConMayusculas($campo);
            } else {
                $cadenaSQL = "select codigo, nombre, codDepartamento from {$P}ciudad where $campo = $valor;";
                $resultado = Conector::ejecutarQuery($cadenaSQL, $BD);
                if (count($resultado)>0) {
                    foreach ($resultado[0] as $Variable => $Valor) $this->$Variable = $Valor;
                    $this->cargarAtributosConMayusculas($resultado[0]);
                }
            }
        }
    }

    function cargarAtributosConMayusculas($arreglo) {
        $this->codDepartamento = $arreglo['coddepartamento'];
    }
    
    function getCodigo() {
        return $this->codigo;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getCodDepartamento() {
        return $this->codDepartamento;
    }
    
    function getDepartamento() {
        return new Departamento_A('codigo', $this->codDepartamento); 
    }
    
    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setCodDepartamento($codDepartamento) {
        $this->codDepartamento = $codDepartamento;
    }

    function grabar() {
        global $BD, $P;
        $cadenaSQL = "insert into {$P}ciudad (nombre, codDepartamento) values ('$this->nombre', $this->codDepartamento);";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function modificar($codigo) {
        global $BD, $P;
        $cadenaSQL = "update {$P}ciudad set nombre = '$this->nombre', codDepartamento = $this->codDepartamento where codigo = $codigo;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function eliminar() {
        global $BD, $P;
        $cadenaSQL = "delete from {$P}ciudad where codigo = $this->codigo;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getLista($filtro, $orden) {
        global $BD, $P;
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select codigo, nombre, codDepartamento from {$P}ciudad $filtro $orden;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getListaEnObjetos($filtro, $orden) {
        $datos = Ciudad_A::getLista($filtro, $orden);
        $ciudades=array();
        for ($i = 0; $i < count($datos); $i++) {
            $ciudades[$i] = new Ciudad_A($datos[$i], null);
        }
        return $ciudades;
    }
    
    public static function getListaEnArregloJS(){
        $ciudades= Ciudad_A::getListaEnObjetos(null, null);
        $arregloJS="\n\nvar ciudades=new Array();";
        for ($i = 0; $i < count($ciudades); $i++) {
            $ciudad=$ciudades[$i];
            $arregloJS.="\n\tciudades[$i]=new Array({$ciudad->getCodigo()},"
            . "'{$ciudad->getNombre()}',{$ciudad->getCodDepartamento()});";
        }
        return $arregloJS;
    }
    
     public static function getListaEnOptions($predeterminado) {
        $ciudades = Ciudad_A::getListaEnObjetos(null, null);
        $lista = '';
        for ($i = 0; $i < count($ciudades); $i++) {
            $ciudad = $ciudades[$i];
            if ($ciudad->getCodigo()==$predeterminado) $auxiliar = 'selected';
            else $auxiliar = '';
            $lista.= "<option value ='{$ciudad->getCodigo()}' $auxiliar>{$ciudad->getNombre()}</option>";
        }
        return $lista;
    }
}
