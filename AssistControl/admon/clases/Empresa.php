<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Empresa
 *
 *  @author AssistControl
 */
class Empresa {
    private $id;
    private $nit;
    private $razonSocial;
    private $direccion;
    private $codCiudad;
    private $url;
    private $email;
    private $css;
    private $bd;
    private $prefijo;
    private $nivelAuditoria;
    private $idioma;

    function __construct($campo,$valor) {
        $BD=null;$P='';
        if($campo!=null){
            if (is_array($campo)){
                foreach ($campo as $Variable => $Valor) $this->$Variable=$Valor;
                $this->cargarAtributosConMayusculas($campo);
            } else {
                $cadenaSQL="select id, nit, razonSocial, direccion, codCiudad, url, email, css, bd, prefijo, nivelAuditoria, idioma from {$P}empresa where $campo=$valor;";
                $resultado=Conector::ejecutarQuery($cadenaSQL, $BD);
                if (count($resultado)>0){
                    foreach ($resultado[0] as $Variable => $Valor) $this->$Variable=$Valor;
                    $this->cargarAtributosConMayusculas($resultado[0]);
                }
            }
        }
    }

    private function cargarAtributosConMayusculas($arreglo){
        $this->razonSocial=$arreglo['razonsocial'];
        $this->codCiudad=$arreglo['codciudad'];
        $this->nivelAuditoria=$arreglo['nivelauditoria'];
    }
    
    function getId() {
        return $this->id;
    }

    function getNit() {
        return $this->nit;
    }

    function getRazonSocial() {
        return $this->razonSocial;
    }

    function getDireccion() {
        return $this->direccion;
    }

    function getCodCiudad() {
        return $this->codCiudad;
    }
    
    function getCiudad(){
        return new Ciudad('codigo', $this->codCiudad);
    }

    function getUrl() {
        return $this->url;
    }

    function getEmail() {
        return $this->email;
    }

    function getCss() {
        return $this->css;
    }

    function getBd() {
        return $this->bd;
    }

    function getPrefijo() {
        return $this->prefijo;
    }

    function getNivelAuditoria() {
        return $this->nivelAuditoria;
    }

    function getNivelAuditoriaEnLetras(){
        return new NivelAuditoria($this->nivelAuditoria);
    }
    
    function getIdioma() {
        return $this->idioma;
    }
    
    function getIdiomaEnLetras() {
        return new Idioma($this->idioma);
    }
       
    function setId($id) {
        $this->id = $id;
    }

    function setNit($nit) {
        $this->nit = $nit;
    }

    function setRazonSocial($razonSocial) {
        $this->razonSocial = $razonSocial;
    }

    function setDireccion($direccion) {
        $this->direccion = $direccion;
    }

    function setCodCiudad($codCiudad) {
        $this->codCiudad = $codCiudad;
    }

    function setUrl($url) {
        $this->url = $url;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setCss($css) {
        $this->css = $css;
    }

    function setBd($bd) {
        $this->bd = $bd;
    }

    function setPrefijo($prefijo) {
        $this->prefijo = $prefijo;
    }

    function setNivelAuditoria($nivelAuditoria) {
        $this->nivelAuditoria = $nivelAuditoria;
    }

    function setIdioma($idioma) {
        $this->idioma = $idioma;
    }
    
    public function __toString() {
        return $this->razonSocial;
    }
    
    function crearBD(){
        $BD=null;$P='';
        $cadenaSQL="create database {$this->getBd()};";
        Conector::ejecutarQuery($cadenaSQL, $BD);        
    }

    public function grabar(){
        $BD=null;$P='';
        $cadenaSQL="insert into {$P}empresa (nit, razonSocial, direccion, codCiudad, url, email, css, bd, prefijo, nivelAuditoria, idioma) values ('$this->nit', '$this->razonSocial', '$this->direccion', '$this->codCiudad', '$this->url', '$this->email', '$this->css', '$this->bd', '$this->prefijo', '$this->nivelAuditoria','$this->idioma');";
        Conector::ejecutarQuery($cadenaSQL, $BD);
        $this->crearBD();
    }

    public function modificar(){
        $BD=null;$P='';
        $cadenaSQL="update {$P}empresa set nit='$this->nit', razonSocial='$this->razonSocial', direccion='$this->direccion', codCiudad='$this->codCiudad', url='$this->url', email='$this->email', css='$this->css', bd='$this->bd', prefijo='$this->prefijo', nivelAuditoria='$this->nivelAuditoria', idioma='$this->idioma' where id=$this->id;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }

    public function eliminar(){
        $BD=null;$P='';
        $cadenaSQL="delete from {$P}empresa where id=$this->id;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getLista(){
        $BD=null;$P='';
        $cadenaSQL="select id, nit, razonSocial, direccion, codCiudad, url, email, css, bd, prefijo, nivelAuditoria, idioma from {$P}empresa";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getListaEnObjetos(){
        $datos=Empresa::getLista();
        for ($i = 0; $i < count($datos); $i++) {
            $empresas[$i]=new Empresa($datos[$i], null);
        }
        return $empresas;
    }
    
    public static function getListaEnOptions($predeterminado){
        $objetos=Empresa::getListaEnObjetos(null);
        $lista='';
        for ($i = 0; $i < count($objetos); $i++) {
            $objeto=$objetos[$i];
            if ($objeto->getId()==$predeterminado) $auxiliar='selected';
            else $auxiliar='';
            $lista.="<option value='{$objeto->getId()}' $auxiliar>{$objeto->getRazonSocial()}</option>";
        }
        return $lista;
    }

}
