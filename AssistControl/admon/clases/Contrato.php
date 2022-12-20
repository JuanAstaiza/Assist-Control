<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Contrato
 *
 *  @author AssistControl
 */
class Contrato {
    private $id;
    private $idSI;
    private $idEmpresa;
    private $fechaInicio;
    private $fechaFin;
    private $valor;
    
    function __construct($campo,$valor) { 
        $BD=null;$P='';
        if ($campo!=null){
            if (is_array($campo)){//constructor con todos los datos
                foreach ($campo as $Variable => $Valor) $this->$Variable=$Valor;
                $this->cargarAtributosConMayusculas($campo);
            } else { //constructor para cargar desde la bd
                $cadenaSQL="select id, idSI, idEmpresa, fechaInicio, fechaFin, valor from {$P}contrato where $campo=$valor";
                $resultado=Conector::ejecutarQuery($cadenaSQL, $BD);
                if (count($resultado)>0){//validación
                    foreach ($resultado[0] as $Variable => $Valor) $this->$Variable=$Valor;
                    $this->cargarAtributosConMayusculas($resultado[0]);
                }                
            }
        }
    }

    private function cargarAtributosConMayusculas($arreglo){
        $this->idSI=$arreglo['idsi'];
        $this->idEmpresa=$arreglo['idempresa'];
        $this->fechaInicio=$arreglo['fechainicio'];
        $this->fechaFin=$arreglo['fechafin'];
    }
    
    function getId() {
        return $this->id;
    }

    function getIdSI() {
        return $this->idSI;
    }
    
    function getSI(){
        return new SI('id', $this->idSI);
    }

    function getIdEmpresa() {
        return $this->idEmpresa;
    }

    function getEmpresa(){
        return new Empresa('id', $this->idEmpresa);
    }

    function getFechaInicio() {
        return $this->fechaInicio;
    }

    function getFechaFin() {
        return $this->fechaFin;
    }

    function getValor() {
        return $this->valor;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdSI($idSI) {
        $this->idSI = $idSI;
    }

    function setIdEmpresa($idEmpresa) {
        $this->idEmpresa = $idEmpresa;
    }

    function setFechaInicio($fechaInicio) {
        $this->fechaInicio = $fechaInicio;
    }

    function setFechaFin($fechaFin) {
        $this->fechaFin = $fechaFin;
    }

    function setValor($valor) {
        $this->valor = $valor;
    }

    private function crearTablas(){
        $script=file_get_contents('datos/'.$this->getSI()->getScriptBD());
        $script= str_replace('table ', "table {$this->getEmpresa()->getPrefijo()}_", $script);
        $script= str_replace('references ', "references {$this->getEmpresa()->getPrefijo()}_", $script);
        $script= str_replace('into ', "into {$this->getEmpresa()->getPrefijo()}_", $script);
        Conector::ejecutarQueryMultiple($script, $this->getEmpresa()->getBd());
    }
    
    public function grabar(){
        $BD=null;$P='';
        $cadenaSQL="insert into {$P}contrato (idSI, idEmpresa, fechaInicio, fechaFin, valor) values ($this->idSI,$this->idEmpresa,'$this->fechaInicio','$this->fechaFin',$this->valor);";
        Conector::ejecutarQuery($cadenaSQL, $BD);
        $this->crearTablas();
    }

    public function modificar(){
        $BD=null;$P='';
        $cadenaSQL="update {$P}contrato set idSI=$this->idSI, idEmpresa=$this->idEmpresa, fechaInicio='$this->fechaInicio',fechaFin='$this->fechaFin',valor=$this->valor where id=$this->id;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }

    public function eliminar(){
        $BD=null;$P='';
        $cadenaSQL="delete from {$P}contrato where id=$this->id;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }

    public static function getLista($filtro){
        $BD=null;$P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $cadenaSQL="select id, idSI, idEmpresa, fechaInicio, fechaFin, valor from {$P}contrato $filtro;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getListaEnObjetos($filtro){
        $datos= Contrato::getLista($filtro);
        $lista=array();
        for ($i = 0; $i < count($datos); $i++) {
            $lista[$i]=new Contrato($datos[$i], null);
        }
        return $lista;
    }

}
