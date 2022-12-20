<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ProgramacionEncuesta
 *
 *  @author AssistControl
 */
class ProgramacionEncuesta {
    private $id;
    private $fechaInicio;
    private $fechaFin;
    private $idPerfil;
    private $idEncuesta;
    
    function __construct($campo,$valor) { 
        $BD=null;$P='';
        if ($campo!=null){
            if (is_array($campo)){//constructor con todos los datos
                foreach ($campo as $Variable => $Valor) $this->$Variable=$Valor;
                $this->cargarAtributosConMayusculas($campo);
            } else { //constructor para cargar desde la bd
                $cadenaSQL="select id, fechaInicio, fechaFin, idPerfil, idEncuesta from {$P}ProgramacionEncuesta where $campo=$valor";
                $resultado=Conector::ejecutarQuery($cadenaSQL, $BD);
                if (count($resultado)>0){//validación
                    foreach ($resultado[0] as $Variable => $Valor) $this->$Variable=$Valor;
                    $this->cargarAtributosConMayusculas($resultado[0]);
                }                
            }
        }
    }

    private function cargarAtributosConMayusculas($arreglo){
        $this->idPerfil=$arreglo['idperfil'];
        $this->idEncuesta=$arreglo['idencuesta'];
        $this->fechaInicio=$arreglo['fechainicio'];
        $this->fechaFin=$arreglo['fechafin'];
    }
    
    function getId() {
        return $this->id;
    }

    function getFechaInicio() {
        return $this->fechaInicio;
    }

    function getFechaFin() {
        return $this->fechaFin;
    }

    function getIdPerfil() {
        return $this->idPerfil;
    }

    function getPerfil() {        
        if ($this->idPerfil==null) return 'Todos';
        else return new Perfil('id',$this->idPerfil);
    }

    function setId($id) {
        $this->id = $id;
    }

    function setFechaInicio($fechaInicio) {
        $this->fechaInicio = $fechaInicio;
    }

    function setFechaFin($fechaFin) {
        $this->fechaFin = $fechaFin;
    }

    function setIdPerfil($idPerfil) {
        $this->idPerfil = $idPerfil;
    }
    
    function getIdEncuesta() {
        return $this->idEncuesta;
    }

    function getEncuesta() {
        return new Encuesta('id',$this->idEncuesta);
    }

    function setIdEncuesta($idEncuesta) {
        $this->idEncuesta = $idEncuesta;
    }

    public function grabar(){
        $BD=null;$P='';
        $cadenaSQL="insert into {$P}ProgramacionEncuesta (fechaInicio, fechaFin, idPerfil, idEncuesta) values ('$this->fechaInicio','$this->fechaFin',$this->idPerfil,$this->idEncuesta);";
        //echo $cadenaSQL;
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }

    public function modificar(){
        $BD=null;$P='';
        $cadenaSQL="update {$P}ProgramacionEncuesta set fechaInicio='$this->fechaInicio',fechaFin='$this->fechaFin',idPerfil=$this->idPerfil,idEncuesta=$this->idEncuesta where id=$this->id;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }

    public function eliminar(){
        $BD=null;$P='';
        $cadenaSQL="delete from {$P}ProgramacionEncuesta where id=$this->id;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }

    public function responder($usuario,$respuestas){
        $BD=null;$P='';                
        $fecha=date('Y-m-d H:i:s');
        foreach ($respuestas as $idPregunta => $respuesta) {
            $cadenaSQL="insert into {$P}respuestaEncuesta (idProgramacionEncuesta, usuario, idPregunta, alternativaRespuesta, fecha) values "
            . "($this->id,'$usuario', $idPregunta, '$respuesta','$fecha');";
            //echo "$cadenaSQL<br>";
            Conector::ejecutarQuery($cadenaSQL, $BD);                        
        }
    }

    public static function getLista($filtro){
        $BD=null;$P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $cadenaSQL="select id, fechaInicio, fechaFin, idPerfil, idEncuesta from {$P}ProgramacionEncuesta $filtro;";
        //echo $cadenaSQL;
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getListaEnObjetos($filtro){
        $datos= ProgramacionEncuesta::getLista($filtro);
        $lista=array();
        for ($i = 0; $i < count($datos); $i++) {
            $lista[$i]=new ProgramacionEncuesta($datos[$i], null);
        }
        return $lista;
    }
    
}
