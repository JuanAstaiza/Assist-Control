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
class Perfil_A {
    private $codigo;
    private $nombre;
    private $descripcion;
            
    function __construct($campo, $valor) {
        global $BD, $P;
        if ($campo!=null) {
            if (is_array($campo)) {
                foreach ($campo as $Variable => $Valor) $this->$Variable = $Valor;
            } else {
                $cadenaSQL = "select codigo, nombre, descripcion from {$P}perfil where $campo = $valor;";
                $resultado = Conector::ejecutarQuery($cadenaSQL, $BD);
                if (count($resultado)>0) {
                    foreach ($resultado[0] as $Variable => $Valor) $this->$Variable = $Valor;
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
    
    function getDescripcion() {
        return $this->descripcion;
    }
    
    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }
    
    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }

    function grabar() {
        global $BD, $P;
        $cadenaSQL = "insert into {$P}perfil (nombre, descripcion) values ('$this->nombre', '$this->descripcion');";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function modificar() {
        global $BD, $P;
        $cadenaSQL = "update {$P}perfil set nombre = '$this->nombre', descripcion = '$this->descripcion' where codigo = $this->codigo;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function eliminar() {
        global $BD, $P;
        $cadenaSQL = "delete from {$P}perfil where codigo = $this->codigo;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getLista($filtro) {
        global $BD, $P;
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select codigo, nombre, descripcion from {$P}perfil $filtro;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getListaEnObjetos($filtro) {
        $datos = Perfil_A::getLista($filtro);
        $perfiles=array();
        for ($i = 0; $i < count($datos); $i++) {
            $perfiles[$i] = new Perfil_A($datos[$i], null);
        }
        return $perfiles;
    }
    
    public static function getListaEnOptions($predeterminado) {
        $perfiles = Perfil_A::getListaEnObjetos(null);
        $lista = '';
        for ($i = 0; $i < count($perfiles); $i++) {
            $perfil = $perfiles[$i];
            if ($perfil->getCodigo()==$predeterminado) $auxiliar = 'selected';
            else $auxiliar = '';
            $lista.= "<option value ='{$perfil->getCodigo()}' $auxiliar>{$perfil->getNombre()}</option>";
        }
        return $lista;
    }
    
    public  function procesarEnAdminsys($accion){
        switch ($accion){
            case 'Adicionar':
                $perfil=new Perfil(null, null);
                $perfil->setNombre($this->nombre);
                $perfil->setDescripcion($this->descripcion);
                $perfil->grabar();
                break;
            case 'Modificar':
                $perfil=new Perfil('id', $this->codigo);
                $perfil->setNombre($this->nombre);
                $perfil->setDescripcion($this->descripcion);
                $perfil->modificar();
                break;
            case 'Eliminar':
                $perfil=new Perfil('id', $this->codigo);
                $perfil->eliminar();
                break;
        }
    }
}
