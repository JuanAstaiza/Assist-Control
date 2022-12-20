<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AlternativaRespuesta
 *
 *  @author AssistControl
 */
class AlternativaRespuesta {
    private $id;
    private $idPregunta;
    private $texto;
    
    function __construct($campo,$valor) { 
        $BD=null;$P='';
        if ($campo!=null){
            if (is_array($campo)){//constructor con todos los datos
                foreach ($campo as $Variable => $Valor) $this->$Variable=$Valor;
                $this->cargarAtributosConMayusculas($campo);
            } else { //constructor para cargar desde la bd
                $cadenaSQL="select id, idPregunta, texto from {$P}alternativaRespuesta where $campo=$valor";
                $resultado=Conector::ejecutarQuery($cadenaSQL, $BD);
                if (count($resultado)>0){//validación
                    foreach ($resultado[0] as $Variable => $Valor) $this->$Variable=$Valor;
                    $this->cargarAtributosConMayusculas($resultado[0]);
                }                
            }
        }
    }

    private function cargarAtributosConMayusculas($arreglo){
        $this->idPregunta=$arreglo['idpregunta'];
    }
    
    function getId() {
        return $this->id;
    }

    function getIdPregunta() {
        return $this->idPregunta;
    }

    function getPregunta() {
        return new Pregunta('id', $this->idPregunta);
    }

    function getTexto() {
        return $this->texto;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setIdPregunta($idPregunta) {
        $this->idPregunta = $idPregunta;
    }

    function setTexto($texto) {
        $this->texto = $texto;
    }
  
    public function grabar(){
        $BD=null;$P='';
        $cadenaSQL="insert into {$P}alternativaRespuesta (idPregunta, texto) values ($this->idPregunta,'$this->texto');";
        echo $cadenaSQL;
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }

    public function modificar(){
        $BD=null;$P='';
        $cadenaSQL="update {$P}alternativaRespuesta set idPregunta=$this->idPregunta, texto='$this->texto' where id=$this->id;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }

    public function eliminar(){
        $BD=null;$P='';
        $cadenaSQL="delete from {$P}alternativaRespuesta where id=$this->id;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }

    public static function getLista($filtro){
        $BD=null;$P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $cadenaSQL="select id, idPregunta, texto from {$P}alternativaRespuesta $filtro;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getListaEnObjetos($filtro){
        $datos= AlternativaRespuesta::getLista($filtro);
        $lista=array();
        for ($i = 0; $i < count($datos); $i++) {
            $lista[$i]=new AlternativaRespuesta($datos[$i], null);
        }
        return $lista;
    }

}
