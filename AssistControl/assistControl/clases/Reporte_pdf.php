<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Reporte
 *
 * @author JUAN CARLOS ASTAIZA
 */
class Reporte_pdf {
    private $codigo;
    private $img_banner;
    private $direccion_sede;
    private $pagina_web;
    private $telefono;
    private $email;
    
    function __construct($campo, $valor) {
        global $BD, $P;
        if ($campo!=null) {
            if (is_array($campo)) {
                foreach ($campo as $Variable => $Valor) $this->$Variable = $Valor;
            } else {
                $cadenaSQL = "select codigo,img_banner, direccion_sede, pagina_web, telefono, email  from {$P}reporte_pdf where $campo = $valor;";
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

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    
    function getDireccion_sede() {
        return $this->direccion_sede;
    }

    function getImg_banner() {
        return $this->img_banner;
    }

    function getPagina_web() {
        return $this->pagina_web;
    }

    function getTelefono() {
        return $this->telefono;
    }

    function getEmail() {
        return $this->email;
    }

    function setDireccion_sede($direccion_sede) {
        $this->direccion_sede = $direccion_sede;
    }

    function setImg_banner($img_banner) {
        $this->img_banner = $img_banner;
    }

    function setPagina_web($pagina_web) {
        $this->pagina_web = $pagina_web;
    }

    function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function setEmail($email) {
        $this->email = $email;
    }
    /*
    function grabar() {
        global $BD, $P;
        $cadenaSQL = "insert into {$P}reporte_pdf values ('$this->img_banner', '$this->direccion_sede', '$this->pagina_web','$this->telefono','$this->email');";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    } */
    
    function modificar($codigo) {
        global $BD, $P;
        $cadenaSQL = "update {$P}reporte_pdf set img_banner = '$this->img_banner', direccion_sede = '$this->direccion_sede', pagina_web = '$this->pagina_web', telefono = '$this->telefono', email = '$this->email'   where codigo = $codigo;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    /*
    function eliminar() {
        global $BD, $P;
        $cadenaSQL = "delete from {$P}reporte_pdf where codigo = $this->codigo;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
     */

    
      public static function getLista($filtro) {
        global $BD, $P;
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select codigo,img_banner, direccion_sede, pagina_web, telefono, email from {$P}reporte_pdf $filtro;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getListaEnObjetos($filtro) {
        $datos = Reporte_pdf::getLista($filtro);
	$reporte_pdf=array();
        for ($i = 0; $i < count($datos); $i++) {
            $reporte_pdf[$i] = new Reporte_pdf($datos[$i], null);
        }
        return $reporte_pdf;
    }
    
    
    
    
}
