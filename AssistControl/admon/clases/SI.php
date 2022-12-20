<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SI
 *
 *  @author AssistControl
 */
class SI {
    private $id;
    private $nombre;
    private $descripcion;
    private $version;
    private $autor;
    private $scriptBD;
    
    function __construct($campo,$valor) {
        $BD=null;$P='';
        if ($campo!=null){
            if (is_array($campo)){//constructor con todos los datos
                foreach ($campo as $Variable => $Valor) $this->$Variable=$Valor;
                $this->cargarAtributosConMayusculas($campo);
            } else { //constructor para cargar desde la bd
                $cadenaSQL="select id, nombre, descripcion, version, autor, scriptBD from {$P}si where $campo=$valor";
                $resultado=Conector::ejecutarQuery($cadenaSQL, $BD);
                if (count($resultado)>0){//validación
                    foreach ($resultado[0] as $Variable => $Valor) $this->$Variable=$Valor;
                    $this->cargarAtributosConMayusculas($resultado[0]);
                }                
            }
        }        
    }
    
    private function cargarAtributosConMayusculas($arreglo){
        $this->scriptBD=$arreglo['scriptbd'];
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

    function getVersion() {
        return $this->version;
    }

    function getAutor() {
        return $this->autor;
    }

    function getScriptBD() {
        return $this->scriptBD;
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

    function setVersion($version) {
        $this->version = $version;
    }

    function setAutor($autor) {
        $this->autor = $autor;
    }
    
    public function __toString() {
        return $this->nombre;
    }

    function setScriptBD($scriptBD) {
        $this->scriptBD = $scriptBD;
    }

    public function grabar(){
        $BD=null;$P='';
        $cadenaSQL="insert into {$P}si (nombre, descripcion, version, autor, scriptBD) values ('$this->nombre','$this->descripcion','$this->version','$this->autor','$this->scriptBD');";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }

    public function modificar(){
        $BD=null;$P='';
        $cadenaSQL="update {$P}si set nombre='$this->nombre', descripcion='$this->descripcion', version='$this->version',autor='$this->autor',scriptBD='$this->scriptBD' where id=$this->id;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }

    public function eliminar(){
        $BD=null;$P='';
        $cadenaSQL="delete from {$P}si where id=$this->id;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }

    public static function getLista($filtro){
        $BD=null;$P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $cadenaSQL="select id, nombre, descripcion, version, autor, scriptBD from {$P}si $filtro;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getListaEnObjetos($filtro){
        $datos=SI::getLista($filtro);
        for ($i = 0; $i < count($datos); $i++) {
            $si[$i]=new SI($datos[$i], null);
        }
        return $si;
    }

    public static function getListaEnOptions($predeterminado){
        $objetos=SI::getListaEnObjetos(null);
        $lista='';
        for ($i = 0; $i < count($objetos); $i++) {
            $objeto=$objetos[$i];
            if ($objeto->getId()==$predeterminado) $auxiliar='selected';
            else $auxiliar='';
            $lista.="<option value='{$objeto->getId()}' $auxiliar>{$objeto->getNombre()}</option>";
        }
        return $lista;
    }

}
