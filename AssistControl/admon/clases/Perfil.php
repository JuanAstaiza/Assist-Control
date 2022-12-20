<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Perfil
 *
 *  @author AssistControl
 */
class Perfil {
    private $id;
    private $nombre;
    private $descripcion;
    
    function __construct($campo,$valor) { 
        $BD=null;$P='';
        if ($campo!=null){
            if (is_array($campo)){//constructor con todos los datos
                foreach ($campo as $Variable => $Valor) $this->$Variable=$Valor;
            } else { //constructor para cargar desde la bd
                $cadenaSQL="select id, nombre, descripcion from {$P}perfil where $campo='$valor'";
                $resultado=Conector::ejecutarQuery($cadenaSQL, $BD);
                if (count($resultado)>0){//validación
                    foreach ($resultado[0] as $Variable => $Valor) $this->$Variable=$Valor;
                }                
            }
        }
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
    
    public function __toString() {
        return $this->nombre;
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

    public function grabar(){
        $BD=null;$P='';
        $cadenaSQL="insert into {$P}perfil (nombre, descripcion) values ('$this->nombre','$this->descripcion');";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }

    public function modificar(){
        $BD=null;$P='';
        $cadenaSQL="update {$P}perfil set nombre='$this->nombre', descripcion='$this->descripcion' where id=$this->id;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }

    public function eliminar(){
        $BD=null;$P='';
        $cadenaSQL="delete from {$P}perfil where id=$this->id;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }

    public static function getLista($filtro){
        $BD=null;$P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $cadenaSQL="select id, nombre, descripcion from {$P}perfil $filtro;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getListaEnObjetos($filtro){
        $datos=Perfil::getLista($filtro);
        for ($i = 0; $i < count($datos); $i++) {
            $perfiles[$i]=new Perfil($datos[$i], null);
        }
        return $perfiles;
    }

    public static function getListaEnOptions($predeterminado){
        $objetos=Perfil::getListaEnObjetos(null);
        $lista='';
        for ($i = 0; $i < count($objetos); $i++) {
            $objeto=$objetos[$i];
            if ($objeto->getId()==$predeterminado) $auxiliar='selected';
            else $auxiliar='';
            $lista.="\n<option value='{$objeto->getId()}' $auxiliar>{$objeto->getNombre()}</option>";
        }
        return $lista;
    }
    
    public function getAccesos(){
        $BD=null;$P='';
        $cadenaSQL="select opcion.id, nombre, descripcion, ruta, idSI, idMenu "
                . "from {$P}opcion as opcion, {$P}perfilAcceso as perfilAcceso "
                . "where opcion.id=idOpcion and idPerfil=$this->id order by idSI, idMenu, idOpcion";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
   
    public function getAccesosEnObjetos(){
        $datos= $this->getAccesos();
        $opciones=array();
        for ($i = 0; $i < count($datos); $i++) {
            $opciones[$i]=new Opcion($datos[$i], null);
        }
        return $opciones;
    }

    public function getAccesosEnId(){
        $datos=$this->getAccesosEnObjetos();
        $vector=array();
        for ($i = 0; $i < count($datos); $i++) {
            $vector[$i]=$datos[$i]->getId();
        }
        return $vector;
    }    
    public function actualizarAccesos($opciones){
        $BD=null;$P='';        
        $cadenaSQL="delete from {$P}perfilAcceso where idPerfil={$this->id};";
        Conector::ejecutarQuery($cadenaSQL, $BD);
        for ($i = 0; $i < count($opciones); $i++) {
            $cadenaSQL="insert into {$P}perfilAcceso (idPerfil, idOpcion) values "
            . "($this->id,{$opciones[$i]});";
            Conector::ejecutarQuery($cadenaSQL, $BD);            
        }        
    }
    
    public function getMenu(){
        $idSI=0;
        $idMenu=0;
        $opciones=$this->getAccesosEnObjetos();
        $menu='';
        for ($i = 0; $i < count($opciones); $i++) {
            $opcion=$opciones[$i];
            if ($opcion->getIdSI()!=$idSI) {
                $menu.="<li><a href='principal.php?CONTENIDO=admon/inicio.php' title='{$opcion->getSI()->getDescripcion()}'>" . strtoupper ($opcion->getSI()->getNombre()) . "</a></li>\n";
                $idSI=$opcion->getIdSI();
            }
            if ($opcion->getIdMenu()!=$idMenu) {
                if (($opcion->getIdMenu()!=null)){
                    if ($idMenu!=0) $menu.="</li></ul>\n";
                    $menu.="<li><a href='#' title='{$opcion->getMenu()->getDescripcion()}'>{$opcion->getMenu()->getNombre()}</a>\n<ul>\n";
                } else $menu.="</li></ul>\n";
                $idMenu=$opcion->getIdMenu();
            }
            $menu.="<li><a href='principal.php?CONTENIDO={$opcion->getRuta()}' title='{$opcion->getDescripcion()}'>{$opcion->getNombre()}</a></li>\n";
        }
        return $menu;
    }
}
