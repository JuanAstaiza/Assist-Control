<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Titulo
 *
 *  @author AssistControl
 */
class Titulo {
    private $codigo;
    private $cedulaPersona;
    private $nombre;
    private $codnivelEducativo;
    
    
    function __construct($campo, $valor) {
        global $BD, $P;
        if ($campo!=null) {
            if (is_array($campo)) {
                foreach ($campo as $Variable => $Valor) $this->$Variable = $Valor;
                $this->cargarAtributosConMayusculas($campo);
            } else {
                $cadenaSQL = "select codigo, cedulaPersona, nombre, codnivelEducativo from {$P}titulo where $campo = $valor;";
                $resultado = Conector::ejecutarQuery($cadenaSQL, $BD);
                if (count($resultado)>0) {
                    foreach ($resultado[0] as $Variable => $Valor) $this->$Variable = $Valor;
                    $this->cargarAtributosConMayusculas($resultado[0]);
                }
            }
        }
    }
    
    
    function cargarAtributosConMayusculas($arreglo) {
        $this->cedulaPersona = $arreglo['cedulapersona'];
        $this->codnivelEducativo = $arreglo['codniveleducativo'];
    }
    
    function getCodigo() {
        return $this->codigo;
    }

    function getCedulaPersona() {
        return $this->cedulaPersona;
    }

    function getNombre() {
        return $this->nombre;
    }

    function getCodnivelEducativo() {
        return $this->codnivelEducativo;
    }

    function getNivelEducativoEnLetras() {
        return new NivelEducativo($this->codnivelEducativo);
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setCedulaPersona($cedulaPersona) {
        $this->cedulaPersona = $cedulaPersona;
    }

    function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    function setCodnivelEducativo($codnivelEducativo) {
        $this->codnivelEducativo = $codnivelEducativo;
    }

    
    function grabar() {
        global $BD, $P;
        $cadenaSQL = "insert into {$P}titulo (cedulaPersona, nombre, codnivelEducativo) values ($this->cedulaPersona,'$this->nombre', $this->codnivelEducativo);";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }

    function modificar() {
        global $BD, $P;
        $cadenaSQL = "update {$P}titulo set nombre = '$this->nombre', codnivelEducativo = $this->codnivelEducativo where codigo = $this->codigo;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function eliminar() {
        global $BD, $P;
        $cadenaSQL = "delete from {$P}titulo where codigo = $this->codigo;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getLista($filtro) {
        global $BD, $P;
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select codigo, cedulaPersona, nombre, codnivelEducativo from {$P}titulo $filtro;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    
    public static function getListaEnObjetos($filtro) {
        $datos = Titulo::getLista($filtro);
	$titulos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $titulos[$i] = new Titulo($datos[$i], null);
        }
        return $titulos;
    }
}
