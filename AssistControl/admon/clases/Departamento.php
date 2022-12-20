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
class Departamento {
    private $codigo;
    private $nombre;
    private $codPais;
    
    function __construct($campo,$valor) {
        $BD=null;$P='';
        if ($campo!=null){
            if (is_array($campo)){//constructor con todos los datos
                foreach ($campo as $Variable => $Valor) $this->$Variable=$Valor;
                $this->cargarAtributosConMayusculas($campo);
            } else { //constructor para cargar desde la bd
                $cadenaSQL="select codigo, nombre, codPais from {$P}departamento where $campo='$valor'";
                $resultado=Conector::ejecutarQuery($cadenaSQL, $BD);
                if (count($resultado)>0){//validación
                    foreach ($resultado[0] as $Variable => $Valor) $this->$Variable=$Valor;
                    $this->cargarAtributosConMayusculas($resultado[0]);
                }                
            }
        }        
    }
    
    private function cargarAtributosConMayusculas($arreglo){
        $this->codPais=$arreglo['codpais'];
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

    function getPais(){
        return new Pais('codigo', $this->codPais);
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

    public function grabar(){
        $BD=null;$P='';
        $cadenaSQL="insert into {$P}departamento (codigo, nombre, codPais) values ('$this->codigo','$this->nombre','$this->codPais');";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }

    public function modificar($codigoAnterior){
        $BD=null;$P='';
        $cadenaSQL="update {$P}departamento set codigo='$this->codigo', nombre='$this->nombre', codPais='$this->codPais' where codigo='$codigoAnterior';";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }

    public function eliminar(){
        $BD=null;$P='';
        $cadenaSQL="delete from {$P}departamento where codigo='$this->codigo';";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
 
    public function getCiudadesEnOptions($predeterminado){
        return Ciudad::getListaEnOptions($predeterminado, "codDepartamento='$this->codigo'");
    }

    public static function getLista($filtro, $orden){
        $BD=null;$P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $cadenaSQL="select codigo, nombre, codPais from {$P}departamento $filtro $orden;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getListaEnObjetos($filtro, $orden){
        $datos= Departamento::getLista($filtro, $orden);
        $departamentos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $departamentos[$i]=new Departamento($datos[$i], null);
        }
        return $departamentos;
    }

    public static function getListaEnArregloJS(){
        $departamentos= Departamento::getListaEnObjetos(null, null);
        $arregloJS="\nvar departamentos=new Array();";
        for ($i = 0; $i < count($departamentos); $i++) {
            $departamento=$departamentos[$i];
            $arregloJS.="\n\tdepartamentos[$i]=new Array({$departamento->getCodigo()},"
            . "'{$departamento->getNombre()}',{$departamento->getCodPais()});";
        }        
        return $arregloJS;
    }
    
    public static function getListaEnOptions($predeterminado,$filtro){
        $departamentos= Departamento::getListaEnObjetos($filtro, null);
        $lista='<option value="null">Escoja</option>';
        for ($i = 0; $i < count($departamentos); $i++) {
            $departamento=$departamentos[$i];
            if ($departamento->getCodigo()==$predeterminado) $auxiliar='selected';
            else $auxiliar='';
            $lista.="<option value='{$departamento->getCodigo()}' $auxiliar>{$departamento->getNombre()}</option>";
        }
        return $lista;
    }

}

if (isset($_POST['metodo'])){
    switch ($_POST['metodo']){
        case 'getCiudadesEnOptions':
            require_once dirname(__FILE__) . '/../../clases/Conector.php';
            require_once dirname(__FILE__) . '/./Ciudad.php';
            $departamento=new Departamento('codigo', $_POST['codDepartamento']);
            echo $departamento->getCiudadesEnOptions($_POST['predeterminado']);
            break;
    }
}