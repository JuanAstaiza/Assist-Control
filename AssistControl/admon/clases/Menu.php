<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Menu
 *
 *  @author AssistControl
 */
class Menu {
    private $id;
    private $nombre;
    private $descripcion;
    private $idSI;

    function __construct($campo,$valor) { 
        $BD=null;$P='';
        if ($campo!=null){
            if (is_array($campo)){//constructor con todos los datos
                foreach ($campo as $Variable => $Valor) $this->$Variable=$Valor;
                $this->cargarAtributosConMayusculas($campo);
            } else { //constructor para cargar desde la bd
                $cadenaSQL="select id, nombre, descripcion, idSI from {$P}opcion where ruta is null and $campo=$valor";
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

    function getIdSI() {
        return $this->idSI;
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

    function setIdSI($idSI) {
        $this->idSI = $idSI;
    }
    
    function getSI(){
        return new SI('id', $this->getIdSI());
    }

    public function grabar(){
        $BD=null;$P='';
        $cadenaSQL="insert into {$P}opcion (nombre, descripcion, idSI) values ('$this->nombre','$this->descripcion',$this->idSI);";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }

    public function modificar(){
        $BD=null;$P='';
        $cadenaSQL="update {$P}opcion set nombre='$this->nombre', descripcion='$this->descripcion', idSI=$this->idSI where id=$this->id;";
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
        $cadenaSQL="select id, nombre, descripcion, idSI from {$P}opcion where ruta is null $filtro;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getListaEnObjetos($filtro){
        $datos=Menu::getLista($filtro);
        $menu=array();
        for ($i = 0; $i < count($datos); $i++) {
            $menu[$i]=new Menu($datos[$i], null);
        }
        return $menu;
    }
    
}
