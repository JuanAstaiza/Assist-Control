<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Pais
 *
 *  @author AssistControl
 */
class Pais {
    private $codigo;
    private $nombre;
    
    function __construct($campo,$valor) {
        $BD=null;$P='';
        if ($campo!=null){
            if (is_array($campo)){//constructor con todos los datos
                foreach ($campo as $Variable => $Valor) $this->$Variable=$Valor;
            } else { //constructor para cargar desde la bd
                $cadenaSQL="select codigo, nombre from {$P}pais where $campo='$valor'";
                $resultado=Conector::ejecutarQuery($cadenaSQL, $BD);
                if (count($resultado)>0){//validación
                    foreach ($resultado[0] as $Variable => $Valor) $this->$Variable=$Valor;
                }                
            }
        }        
    }
    
    function getCodigo() {
        return $this->codigo;
    }

    function getNombre() {
        return $this->nombre;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function grabar(){
        $BD=null;$P='';
        $cadenaSQL="insert into {$P}pais (codigo, nombre) values ('$this->codigo','$this->nombre');";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }

    public function modificar($codigoAnterior){
        $BD=null;$P='';
        $cadenaSQL="update {$P}pais set codigo='$this->codigo', nombre='$this->nombre' where codigo='$codigoAnterior';";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }

    public function eliminar(){
        $BD=null;$P='';
        $cadenaSQL="delete from {$P}pais where codigo='$this->codigo';";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public function getDepartamentosEnOptions($predeterminado){
        return Departamento::getListaEnOptions($predeterminado, "codPais='$this->codigo'");
    }

    public static function getLista($filtro, $orden){
        $BD=null;$P='';
        if ($filtro!=null) $filtro=" where $filtro";
        $cadenaSQL="select codigo, nombre from {$P}pais $filtro $orden;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getListaEnObjetos($filtro, $orden){
        $datos= Pais::getLista($filtro, $orden);
        $paises=array();
        for ($i = 0; $i < count($datos); $i++) {
            $paises[$i]=new Pais($datos[$i], null);
        }
        return $paises;
    }

    public static function getListaEnOptions($predeterminado){
        $paises=Pais::getListaEnObjetos(null, null);
        $lista='<option value="0">Escoja</option> ';
        for ($i = 0; $i < count($paises); $i++) {
            $pais=$paises[$i];
            if ($pais->getCodigo()==$predeterminado) $auxiliar='selected';
            else $auxiliar='';
            $lista.="<option value='{$pais->getCodigo()}' $auxiliar>{$pais->getNombre()}</option>";
        }
        return $lista;
    }
}

if (isset($_POST['metodo'])){
    switch ($_POST['metodo']){
        case 'getDepartamentosEnOptions':
            //echo '<option>1</option><option>2</option>';
            require_once dirname(__FILE__) . '/../../clases/Conector.php';
            require_once dirname(__FILE__) . '/./Departamento.php';
            $pais=new Pais('codigo', $_POST['codPais']);
            echo $pais->getDepartamentosEnOptions($_POST['predeterminado']);
            break;
    }
}