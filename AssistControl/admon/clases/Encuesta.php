<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Encuesta
 *
 *  @author AssistControl
 */
class Encuesta {
    private $id;
    private $nombre;
    private $objetivo;
    private $descripcion;
    
    function __construct($campo,$valor) { 
        $BD=null;$P='';
        if ($campo!=null){
            if (is_array($campo)){//constructor con todos los datos
                foreach ($campo as $Variable => $Valor) $this->$Variable=$Valor;
            } else { //constructor para cargar desde la bd
                $cadenaSQL="select id, nombre, objetivo, descripcion from {$P}encuesta where $campo=$valor";
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

    function getObjetivo() {
        return $this->objetivo;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setObjetivo($objetivo) {
        $this->objetivo = $objetivo;
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    public function grabar(){
        $BD=null;$P='';
        $cadenaSQL="insert into {$P}encuesta (nombre, objetivo, descripcion) values ('$this->nombre','$this->objetivo','$this->descripcion');";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }

    public function modificar(){
        $BD=null;$P='';
        $cadenaSQL="update {$P}encuesta set nombre='$this->nombre', objetivo='$this->objetivo', descripcion='$this->descripcion' where id=$this->id;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }

    public function eliminar(){
        $BD=null;$P='';
        $cadenaSQL="delete from {$P}encuesta where id=$this->id;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public function getPreguntasEnObjetos($orden){
        $BD=null;$P='';
        $cadenaSQL="select pregunta.id, enunciado, tipo from {$P}pregunta as pregunta, {$P}encuestaPregunta where pregunta.id=idPregunta and idEncuesta={$this->id} $orden;";
        $datos=Conector::ejecutarQuery($cadenaSQL, $BD);        
        $preguntas=Array();
        for ($i = 0; $i < count($datos); $i++) {
            $preguntas[$i]=new Pregunta($datos[$i], null);
        }
        return $preguntas;
    }
    
    public function getPreguntasEnId(){
        $datos=$this->getPreguntasEnObjetos();
        $vector=array();
        for ($i = 0; $i < count($datos); $i++) {
            $vector[$i]=$datos[$i]->getId();
        }
        return $vector;
    }        

    public function actualizarPreguntas($opciones){
        $BD=null;$P='';        
        $cadenaSQL="delete from {$P}encuestaPregunta where idEncuesta={$this->id};";
        Conector::ejecutarQuery($cadenaSQL, $BD);
        for ($i = 0; $i < count($opciones); $i++) {
            $cadenaSQL="insert into {$P}encuestaPregunta (idEncuesta, idPregunta) values "
            . "($this->id,{$opciones[$i]});";
            echo "$cadenaSQL<br>";
            Conector::ejecutarQuery($cadenaSQL, $BD);            
        }        
    }

    public static function getLista($filtro){
        $BD=null;$P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $cadenaSQL="select id, nombre, objetivo, descripcion from {$P}encuesta $filtro;";
        //echo $cadenaSQL;
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getListaEnObjetos($filtro){
        $datos=Encuesta::getLista($filtro);
        $encuestas=Array();
        for ($i = 0; $i < count($datos); $i++) {
            $encuestas[$i]=new Encuesta($datos[$i], null);
        }
        return $encuestas;
    }

    public static function getListaEnOptions($predeterminado){
        $objetos=Encuesta::getListaEnObjetos(null);
        $lista='';
        for ($i = 0; $i < count($objetos); $i++) {
            $objeto=$objetos[$i];
            if ($objeto->getId()==$predeterminado) $auxiliar='selected';
            else $auxiliar='';
            $lista.="<option value='{$objeto->getId()}' $auxiliar>{$objeto->getEnunciado()}</option>";
        }
        return $lista;
    }    
    
}
