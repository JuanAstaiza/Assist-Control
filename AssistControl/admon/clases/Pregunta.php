<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pregunta
 *
 *  @author AssistControl
 */
class Pregunta {
    private $id;
    private $enunciado;
    private $tipo;
    
    function __construct($campo,$valor) { 
        $BD=null;$P='';
        if ($campo!=null){
            if (is_array($campo)){//constructor con todos los datos
                foreach ($campo as $Variable => $Valor) $this->$Variable=$Valor;
            } else { //constructor para cargar desde la bd
                $cadenaSQL="select id, enunciado, tipo from {$P}pregunta where $campo=$valor";
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

    function getEnunciado() {
        return $this->enunciado;
    }

    function getTipo() {
        return new TipoPregunta($this->tipo);
    }

    function setId($id) {
        $this->id = $id;
    }

    function setEnunciado($enunciado) {
        $this->enunciado = $enunciado;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }
    
    public function grabar(){
        $BD=null;$P='';
        $cadenaSQL="insert into {$P}pregunta (enunciado, tipo) values ('$this->enunciado','$this->tipo');";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }

    public function modificar(){
        $BD=null;$P='';
        $cadenaSQL="update {$P}pregunta set enunciado='$this->enunciado', tipo='$this->tipo' where id=$this->id;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }

    public function eliminar(){
        $BD=null;$P='';
        $cadenaSQL="delete from {$P}pregunta where id=$this->id;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public function getRespuestasTabuladas($idProgramacionEncuesta){
        $BD=null;$P='';
        if ($this->tipo=='A'){
        
        } else { // tipo F y S
             $cadenaSQL="select alternativarespuesta,count(*) as cantidad from {$P}respuestaEncuesta "
                . " where idProgramacionEncuesta=$idProgramacionEncuesta and idPregunta={$this->id}"
                ." group by alternativaRespuesta;";
            $datos=Conector::ejecutarQuery($cadenaSQL, $BD);
            $respuesta=array();
            for ($i = 0; $i < count($datos); $i++) {
                if ($this->tipo=='F'){
                    if ($datos[$i]['alternativarespuesta']=='V')
                        $respuesta[$i]['Verdadero']=$datos[$i]['cantidad'];
                    else $respuesta[$i]['Falso']=$datos[$i]['cantidad'];
                } else { //tipo==S
                    $alternativaRespuesta=new AlternativaRespuesta('id',
                    $datos[$i]['alternativarespuesta']);
                    // echo "{$alternativaRespuesta->getTexto()}<br>";
                    $respuesta[$i][$alternativaRespuesta->getTexto()]=$datos[$i]['cantidad'];
                }
            }
        }
    return $respuesta;
    }
    
    

    public static function getLista($filtro){
        $BD=null;$P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $cadenaSQL="select id, enunciado, tipo from {$P}pregunta $filtro;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getListaEnObjetos($filtro){
        $datos=Pregunta::getLista($filtro);
        $preguntas=Array();
        for ($i = 0; $i < count($datos); $i++) {
            $preguntas[$i]=new Pregunta($datos[$i], null);
        }
        return $preguntas;
    }

    public static function getListaEnOptions($predeterminado){
        $objetos=Pregunta::getListaEnObjetos(null);
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
