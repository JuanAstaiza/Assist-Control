<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Persona_A
 *
 *  @author AssistControl
 */
require_once '../clases/Conector.php';


class PersonaRegistroDiario {
    private $foto;
    private $cedula;
    private $fechaExpedicion;
    private $lugarExpedicion;
    private $fechaNacimiento;
    private $codCiudad;
    private $primerNombre;
    private $segundoNombre;
    private $primerApellido;
    private $segundoApellido;
    private $direccionResidencia;
    private $telefono;
    private $genero;
    private $grupoSanguineo;
    private $profesion;
    private $codCargo;
    private $codTipoVinculacion;
    private $codAreaEnsenanza;
    private $email;
    private $codSituacion;
    private $estado;
    private $fechaIngreso;
    private $fechaSalida;
    
    function __construct($campo, $valor) {
        global $BD, $P;
        if ($campo!=null) {
            if (is_array($campo)) {
                foreach ($campo as $Variable => $Valor) $this->$Variable = $Valor;
                $this->cargarAtributosConMayusculas($campo);
            } else {
                $cadenaSQL = "select foto, cedula, fechaExpedicion, lugarExpedicion, fechaNacimiento, codCiudad, primerNombre, "
                . "segundoNombre, primerApellido, segundoApellido, direccionResidencia, genero, grupoSanguineo, profesion, "
                . "codCargo, codTipoVinculacion, codAreaEnsenanza, email, codSituacion, estado, telefono, fechaIngreso, fechaSalida from {$P}persona where $campo = $valor;";
                $resultado = Conector::ejecutarQuery($cadenaSQL, $BD);
                if (count($resultado)>0) {
                    foreach ($resultado[0] as $Variable => $Valor) $this->$Variable = $Valor;
                    $this->cargarAtributosConMayusculas($resultado[0]);
                }
            }
        }
    }

    function cargarAtributosConMayusculas($arreglo) {
        $this->fechaExpedicion = $arreglo['fechaexpedicion'];
        $this->lugarExpedicion = $arreglo['lugarexpedicion'];
        $this->fechaNacimiento = $arreglo['fechanacimiento'];
        $this->codCiudad = $arreglo['codciudad'];
        $this->primerNombre = $arreglo['primernombre'];
        $this->segundoNombre = $arreglo['segundonombre'];
        $this->primerApellido = $arreglo['primerapellido'];
        $this->segundoApellido = $arreglo['segundoapellido'];
        $this->direccionResidencia = $arreglo['direccionresidencia'];
        $this->grupoSanguineo = $arreglo['gruposanguineo'];
        $this->codCargo = $arreglo['codcargo'];
        $this->codTipoVinculacion = $arreglo['codtipovinculacion'];
        $this->codAreaEnsenanza = $arreglo['codareaensenanza'];
        $this->codSituacion = $arreglo['codsituacion'];
        $this->fechaIngreso = $arreglo['fechaingreso'];
        $this->fechaSalida = $arreglo['fechasalida'];
    }
    
    function getFoto() {
        return $this->foto;
    }

    function getCedula() {
        return $this->cedula;
    }

    function getFechaExpedicion() {
        return $this->fechaExpedicion;
    }

    function getLugarExpedicion() {
        return $this->lugarExpedicion;
    }

    function getFechaNacimiento() {
        return $this->fechaNacimiento;
    }

    function getCodCiudad() {
        return $this->codCiudad;
    }
    
    function getCiudad() {
        return new Ciudad_A('codigo', $this->codCiudad);
    }

    function getPrimerNombre() {
        return $this->primerNombre;
    }

    function getSegundoNombre() {
        return $this->segundoNombre;
    }

    function getPrimerApellido() {
        return $this->primerApellido;
    }

    function getSegundoApellido() {
        return $this->segundoApellido;
    }

    function getDireccionResidencia() {
        return $this->direccionResidencia;
    }

    function getGenero() {
        return new Genero($this->genero);
    }
    
    function getGeneroEnLetras() {
        return new Genero($this->genero);
    }

    function getGrupoSanguineo() {
        return $this->grupoSanguineo;
    }
    
    function getGrupoSanguineoEnLetras() {
        return new GrupoSanguineo($this->grupoSanguineo);
    }

    function getProfesion() {
        return $this->profesion;
    }

    function getCodCargo() {
        return $this->codCargo;
    }
    
    function getCargo() {
        return new Cargo('codigo', $this->codCargo);
    }

    function getCodTipoVinculacion() {
        return $this->codTipoVinculacion;
    }
    
    function getTipoVinculacion() {
        return new Vinculacion('codigo', $this->codTipoVinculacion);
    }

    function getCodAreaEnsenanza() {
        return $this->codAreaEnsenanza;
    }
    
    function getAreaEnsenanza() {
        return new AreaEnsenanza('codigo', $this->codAreaEnsenanza);
    }

    function getEmail() {
        return $this->email;
    }
    
    function getCodSituacion() {
        return $this->codSituacion;
    }
    
    function getSituacion() {
        return new Situacion('codigo', $this->codSituacion);
    }

    function getEstado() {
        return $this->estado;
    }

        
    function getEstadoEnLetras() {
        return new Estado($this->estado);
    }

    
    function getTelefono() {
        return $this->telefono;
    }
    
    function getFechaIngreso() {
        return $this->fechaIngreso;
    }

    function getFechaSalida() {
        return $this->fechaSalida;
    }

    
     function setFoto($foto) {
        $this->foto = $foto;
    }

    function setCedula($cedula) {
        $this->cedula = $cedula;
    }

    function setFechaExpedicion($fechaExpedicion) {
        $this->fechaExpedicion = $fechaExpedicion;
    }

    function setLugarExpedicion($lugarExpedicion) {
        $this->lugarExpedicion = $lugarExpedicion;
    }

    function setFechaNacimiento($fechaNacimiento) {
        $this->fechaNacimiento = $fechaNacimiento;
    }

    function setCodCiudad($codCiudad) {
        $this->codCiudad = $codCiudad;
    }

    function setPrimerNombre($primerNombre) {
        $this->primerNombre = $primerNombre;
    }

    function setSegundoNombre($segundoNombre) {
        $this->segundoNombre = $segundoNombre;
    }

    function setPrimerApellido($primerApellido) {
        $this->primerApellido = $primerApellido;
    }

    function setSegundoApellido($segundoApellido) {
        $this->segundoApellido = $segundoApellido;
    }

    function setDireccionResidencia($direccionResidencia) {
        $this->direccionResidencia = $direccionResidencia;
    }

    function setGenero($genero) {
        $this->genero = $genero;
    }

    function setGrupoSanguineo($grupoSanguineo) {
        $this->grupoSanguineo = $grupoSanguineo;
    }

    function setProfesion($profesion) {
        $this->profesion = $profesion;
    }

    function setCodCargo($codCargo) {
        $this->codCargo = $codCargo;
    }

    function setCodTipoVinculacion($codTipoVinculacion) {
        $this->codTipoVinculacion = $codTipoVinculacion;
    }

    function setCodAreaEnsenanza($codAreaEnsenanza) {
        $this->codAreaEnsenanza = $codAreaEnsenanza;
    }

    function setEmail($email) {
        $this->email = $email;
    }
    
    function setCodSituacion($codSituacion) {
        $this->codSituacion = $codSituacion;
    }
    
    function setEstado($estado) {
        $this->estado = $estado;
    }

        function setTelefono($telefono) {
        $this->telefono = $telefono;
    }

    function setFechaIngreso($fechaIngreso) {
        $this->fechaIngreso = $fechaIngreso;
    }

    function setFechaSalida($fechaSalida) {
        $this->fechaSalida = $fechaSalida;
    }

        
    function grabar() {
        global $BD, $P;
        $cadenaSQL = "insert into {$P}persona (foto, cedula, fechaExpedicion, lugarExpedicion, fechaNacimiento, codCiudad, "
        . "primerNombre, segundoNombre, primerApellido, segundoApellido, direccionResidencia, genero, grupoSanguineo, profesion, codCargo, "
        . "codTipoVinculacion, codAreaEnsenanza, email, codSituacion, estado, telefono, fechaIngreso, fechaSalida) values ('$this->foto', $this->cedula, '$this->fechaExpedicion', '$this->lugarExpedicion', '$this->fechaNacimiento', '$this->codCiudad', "
        . "'$this->primerNombre', '$this->segundoNombre', '$this->primerApellido', '$this->segundoApellido', '$this->direccionResidencia', '$this->genero', '$this->grupoSanguineo', '$this->profesion', $this->codCargo, "
        . "$this->codTipoVinculacion, $this->codAreaEnsenanza, '$this->email', $this->codSituacion, '$this->estado' ,'$this->telefono','$this->fechaIngreso','$this->fechaSalida');";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function modificar($cedulaanterior) {
        global $BD, $P;
        $cadenaSQL = "update {$P}persona set foto = '$this->foto', fechaExpedicion = '$this->fechaExpedicion', lugarExpedicion = '$this->lugarExpedicion', fechaNacimiento = '$this->fechaNacimiento', codCiudad = '$this->codCiudad', "
        . "primerNombre = '$this->primerNombre', segundoNombre = '$this->segundoNombre', primerApellido = '$this->primerApellido', segundoApellido = '$this->segundoApellido', direccionResidencia = '$this->direccionResidencia', genero = '$this->genero', grupoSanguineo = '$this->grupoSanguineo', profesion = '$this->profesion', codCargo = $this->codCargo, "
        . "codTipoVinculacion = $this->codTipoVinculacion, codAreaEnsenanza = $this->codAreaEnsenanza, email = '$this->email', codSituacion = $this->codSituacion, estado='$this->estado',telefono='$this->telefono', fechaIngreso='$this->fechaIngreso', fechaSalida='$this->fechaSalida' where cedula = $cedulaanterior;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function eliminar() {
        global $BD, $P;
        $cadenaSQL = "delete from {$P}persona where cedula = $this->cedula;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getLista($filtro, $orden) {
        global $BD, $P;
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select foto, cedula, fechaExpedicion, lugarExpedicion, fechaNacimiento, codCiudad, primerNombre, "
            . "segundoNombre, primerApellido, segundoApellido, direccionResidencia, genero, grupoSanguineo, profesion, "
            . "codCargo, codTipoVinculacion, codAreaEnsenanza, email, codSituacion, estado, telefono, fechaIngreso, fechaSalida from {$P}persona $filtro $orden;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getListaEnObjetos($filtro, $orden){
        $datos= PersonaRegistroDiario::getLista($filtro, $orden);
        $lista=array();
        for ($i = 0; $i < count($datos); $i++) {
            $lista[$i]=new PersonaRegistroDiario($datos[$i], null);
        }
        return $lista;
    }
    
    
    
}
