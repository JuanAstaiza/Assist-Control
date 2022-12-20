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
class Ciudad {
    private $codigo;
    private $nombre;
    private $codDepartamento;
    
    function __construct($campo,$valor) {
        $BD=null;$P='';
        if ($campo!=null){
            if (is_array($campo)){//constructor con todos los datos
                foreach ($campo as $Variable => $Valor) $this->$Variable=$Valor;
                $this->cargarAtributosConMayusculas($campo);
            } else { //constructor para cargar desde la bd
                $cadenaSQL="select codigo, nombre, codDepartamento from {$P}ciudad where $campo='$valor'";
                $resultado=Conector::ejecutarQuery($cadenaSQL, $BD);
                if (count($resultado)>0){//validación
                    foreach ($resultado[0] as $Variable => $Valor) $this->$Variable=$Valor;
                    $this->cargarAtributosConMayusculas($resultado[0]);
                }                
            }
        }        
    }
    
    private function cargarAtributosConMayusculas($arreglo){
        $this->codDepartamento=$arreglo['coddepartamento'];
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
    
    function getDepartamento(){
        return new Departamento('codigo', $this->codDepartamento);
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

    public function __toString() {
        return $this->nombre;
    }

    public function grabar(){
        $BD=null;$P='';
        $cadenaSQL="insert into {$P}ciudad (codigo, nombre, codDepartamento) values ('$this->codigo','$this->nombre','$this->codDepartamento');";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }

    public function modificar($codigoAnterior){
        $BD=null;$P='';
        $cadenaSQL="update {$P}ciudad set codigo='$this->codigo', nombre='$this->nombre', codDepartamento='$this->codDepartamento' where codigo='$codigoAnterior';";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }

    public function eliminar(){
        $BD=null;$P='';
        $cadenaSQL="delete from {$P}ciudad where codigo='$this->codigo';";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }

    public static function getLista($filtro, $orden){
        $BD=null;$P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $cadenaSQL="select codigo, nombre, codDepartamento from {$P}ciudad $filtro $orden;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getListaEnObjetos($filtro, $orden){
        $datos= Ciudad::getLista($filtro, $orden);
        for ($i = 0; $i < count($datos); $i++) {
            $ciudades[$i]=new Ciudad($datos[$i], null);
        }
        return $ciudades;
    }

    public static function getListaEnArregloJS(){
        $ciudades= Ciudad::getListaEnObjetos(null, null);
        $arregloJS="\n\nvar ciudades=new Array();";
        for ($i = 0; $i < count($ciudades); $i++) {
            $ciudad=$ciudades[$i];
            $arregloJS.="\n\tciudades[$i]=new Array({$ciudad->getCodigo()},"
            . "'{$ciudad->getNombre()}',{$ciudad->getCodDepartamento()});";
        }
        return $arregloJS;
    }
    
    public static function getListaEnOptions($predeterminado,$filtro){
        $ciudades= Ciudad::getListaEnObjetos($filtro, null);
        $lista='<option value="null">Escoja una ciudad</option>';
        for ($i = 0; $i < count($ciudades); $i++) {
            $ciudad=$ciudades[$i];
            if ($ciudad->getCodigo()==$predeterminado) $auxiliar='selected';
            else $auxiliar='';
            $lista.="<option value='{$ciudad->getCodigo()}' $auxiliar>{$ciudad->getNombre()}</option>";
        }
        return $lista;
    }
    
}
