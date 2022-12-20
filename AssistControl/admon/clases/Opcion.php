<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Opcion
 *
 *  @author AssistControl
 */
class Opcion {
    private $id;
    private $nombre;
    private $descripcion;
    private $ruta;
    private $idSI;
    private $idMenu;
    
    function __construct($campo,$valor) { 
        $BD=null;$P='';
        if ($campo!=null){
            if (is_array($campo)){//constructor con todos los datos
                foreach ($campo as $Variable => $Valor) $this->$Variable=$Valor;
                $this->cargarAtributosConMayusculas($campo);
            } else { //constructor para cargar desde la bd
                $cadenaSQL="select id, nombre, descripcion, ruta, idSI, idMenu from {$P}opcion where ruta is not null and $campo=$valor";
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
        $this->idMenu=$arreglo['idmenu'];
    }
    
    function getId() {
        return $this->id;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function getRuta() {
        return $this->ruta;
    }

    function getIdSI() {
        return $this->idSI;
    }

    function getIdMenu() {
        return $this->idMenu;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function setRuta($ruta) {
        $this->ruta = $ruta;
    }

    function setIdSI($idSI) {
        $this->idSI = $idSI;
    }

    function setIdMenu($idMenu) {
        $this->idMenu = $idMenu;
    }
    
    function getSI(){
        return new SI('id', $this->getIdSI());
    }

    function getMenu(){
        return new Menu('id', $this->getIdMenu());
    }

    public function grabar(){
        $BD=null;$P='';
        $cadenaSQL="insert into {$P}opcion (nombre, descripcion, ruta, idSI, idMenu) values ('$this->nombre','$this->descripcion','$this->ruta',$this->idSI,$this->idMenu);";
        echo $cadenaSQL;
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }

    public function modificar(){
        $BD=null;$P='';
        $cadenaSQL="update {$P}opcion set nombre='$this->nombre', descripcion='$this->descripcion', ruta='$this->ruta',idSI=$this->idSI,idMenu=$this->idMenu where id=$this->id;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }

    public function eliminar(){
        $BD=null;$P='';
        $cadenaSQL="delete from {$P}opcion where id=$this->id;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }

    public static function getLista($filtro){
        $BD=null;$P='';
        if ($filtro!=null) $filtro=" and $filtro";
        $cadenaSQL="select id, nombre, descripcion, ruta, idSI, idMenu from {$P}opcion where ruta is not null $filtro;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getListaEnObjetos($filtro){
        $datos=Opcion::getLista($filtro);
        $opciones=array();
        for ($i = 0; $i < count($datos); $i++) {
            $opciones[$i]=new Opcion($datos[$i], null);
        }
        return $opciones;
    }
    
}
