<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Turno
 *
 *  @author AssistControl
 */
class Turno {
    private $codigo;
    private $cedulaPersona;
    private $horaInicio;
    private $horaFin;
    private $dia;
    private $descripcion;
 
  
    function __construct($campo, $valor) {
        global $BD, $P;
        if ($campo!=null) {
            if (is_array($campo)) {
                foreach ($campo as $Variable => $Valor) $this->$Variable = $Valor;
                $this->cargarAtributosConMayusculas($campo);
            } else {
                $cadenaSQL = "select codigo, cedulaPersona, horaInicio, horaFin, dia, descripcion from {$P}turno where $campo = $valor;";
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
        $this->horaInicio = $arreglo['horainicio'];
        $this->horaFin = $arreglo['horafin'];
    }
    
        
    function getCodigo() {
        return $this->codigo;
    }

    function getCedulaPersona() {
        return $this->cedulaPersona;
    }

    function getHoraInicio() {
        return $this->horaInicio;
    }

    function getHoraFin() {
        return $this->horaFin;
    }

    function getDia() {
        return $this->dia;
    }

    function getDescripcion() {
        return $this->descripcion;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function setCedulaPersona($cedulaPersona) {
        $this->cedulaPersona = $cedulaPersona;
    }

    function setHoraInicio($horaInicio) {
        $this->horaInicio = $horaInicio;
    }

    function setHoraFin($horaFin) {
        $this->horaFin = $horaFin;
    }

    function setDia($dia) {
        $this->dia = $dia;
    }
    
     function getDiaEnLetras(){
        switch ($this->dia) {
            case '1': return 'Lunes'; break;
            case '2': return 'Martes'; break;
            case '3': return 'Miercoles'; break;
            case '4': return 'Jueves'; break;
            case '5': return 'Viernes'; break;
            case '6': return 'Sabado'; break;
            case '7': return 'Domingo'; break;
            default: return 'Desconocido'; break;
        }
    }

    function setDescripcion($descripcion) {
        $this->descripcion = $descripcion;
    }
    
   
    function grabar() {
        global $BD, $P;
        $cadenaSQL = "insert into {$P}turno (cedulaPersona, horaInicio, horaFin, dia, descripcion) values ($this->cedulaPersona, '$this->horaInicio', '$this->horaFin', $this->dia, '$this->descripcion');";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function modificar() {
        global $BD, $P;
        $cadenaSQL = "update {$P}turno set cedulaPersona = $this->cedulaPersona, horaInicio = '$this->horaInicio', horaFin = '$this->horaFin', dia = $this->dia, descripcion = '$this->descripcion' where codigo = $this->codigo;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    function eliminar() {
        global $BD, $P;
        $cadenaSQL = "delete from {$P}turno where codigo = $this->codigo;";
        Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getLista($filtro) {
        global $BD, $P;
        if ($filtro!=null) $filtro = "where $filtro";
        $cadenaSQL = "select codigo, cedulaPersona, horaInicio, horaFin, dia, descripcion from {$P}turno $filtro order by dia;";
        return Conector::ejecutarQuery($cadenaSQL, $BD);
    }
    
    public static function getListaEnObjetos($filtro) {
        $datos = Turno::getLista($filtro);
	$turnos=array();
        for ($i = 0; $i < count($datos); $i++) {
            $turnos[$i] = new Turno($datos[$i], null);
        }
        return $turnos;
    }
    
 
   
    public static function getListaEnOptions($accion,$predeterminado) {
        if ($accion=="Adicionar") {            
            switch ($predeterminado) {            
                case '1': return 
                    '<option value="1" disabled>Lunes</option><option value="2">Martes</option><option value="3"disabled>Miercoles</option><option value="4"disabled>Jueves</option><option value="5" disabled>Viernes</option><option value="6" disabled>Sabado</option><option value="7" disabled>Domingo</option>';
                    break;
                case '2': return 
                    '<option value="1" disabled>Lunes</option><option value="2" disabled>Martes</option><option value="3" >Miercoles</option><option value="4" disabled>Jueves</option><option value="5" disabled>Viernes</option><option value="6" disabled>Sabado</option><option value="7" disabled>Domingo</option>';
                    break;
                case '3': return 
                    '<option value="1" disabled>Lunes</option><option value="2" disabled>Martes</option><option value="3" disabled>Miercoles</option><option value="4">Jueves</option><option value="5" disabled>Viernes</option><option value="6" disabled>Sabado</option><option value="7" disabled>Domingo</option>';
                    break;
                case '4': return 
                    '<option value="1" disabled>Lunes</option><option value="2" disabled>Martes</option><option value="3" disabled>Miercoles</option><option value="4" disabled>Jueves</option><option value="5">Viernes</option><option value="6" disabled>Sabado</option><option value="7" disabled>Domingo</option>';
                    break;
                case '5': return 
                    '<option value="1" disabled>Lunes</option><option value="2"  disabled>Martes</option><option value="3" disabled>Miercoles</option><option value="4" disabled>Jueves</option><option value="5" disabled>Viernes</option><option value="6">Sabado</option><option value="7" disabled>Domingo</option>';
                    break;
                case '6': return 
                    '<option value="1" disabled>Lunes</option><option value="2" disabled>Martes</option><option value="3" disabled>Miercoles</option><option value="4" disabled>Jueves</option><option value="5" disabled>Viernes</option><option value="6" disabled>Sabado</option><option value="7">Domingo</option>';
                    break;
                case '7': return 
                    '<option value="1" disabled>Lunes</option><option value="2" disabled>Martes</option><option value="3" disabled>Miercoles</option><option value="4" disabled>Jueves</option><option value="5" disabled>Viernes</option><option value="6" disabled>Sabado</option><option value="7" disabled>Domingo</option>';
                    break;
                default: return 
                    '<option value="1">Lunes</option><option value="2" disabled>Martes</option><option value="3" disabled>Miercoles</option><option value="4" disabled>Jueves</option><option value="5" disabled>Viernes</option><option value="6" disabled>Sabado</option><option value="7" disabled>Domingo</option>';
                    break;
            }
        }else{
            switch ($predeterminado) {            
                case '1': return 
                    '<option value="1">Lunes</option><option value="2" disabled>Martes</option><option value="3"disabled>Miercoles</option><option value="4"disabled>Jueves</option><option value="5" disabled>Viernes</option><option value="6" disabled>Sabado</option><option value="7" disabled>Domingo</option>';
                    break;
                case '2': return 
                    '<option value="1" disabled>Lunes</option><option value="2" >Martes</option><option value="3" disabled>Miercoles</option><option value="4" disabled>Jueves</option><option value="5" disabled>Viernes</option><option value="6" disabled>Sabado</option><option value="7" disabled>Domingo</option>';
                    break;
                case '3': return 
                    '<option value="1" disabled>Lunes</option><option value="2" disabled>Martes</option><option value="3" >Miercoles</option><option value="4" disabled>Jueves</option><option value="5" disabled>Viernes</option><option value="6" disabled>Sabado</option><option value="7" disabled>Domingo</option>';
                    break;
                case '4': return 
                    '<option value="1" disabled>Lunes</option><option value="2" disabled>Martes</option><option value="3" disabled>Miercoles</option><option value="4">Jueves</option><option value="5" disabled>Viernes</option><option value="6" disabled>Sabado</option><option value="7" disabled>Domingo</option>';
                    break;
                case '5': return 
                    '<option value="1" disabled>Lunes</option><option value="2"  disabled>Martes</option><option value="3" disabled>Miercoles</option><option value="4" disabled>Jueves</option><option value="5">Viernes</option><option value="6" disabled>Sabado</option><option value="7" disabled>Domingo</option>';
                    break;
                case '6': return 
                    '<option value="1" disabled>Lunes</option><option value="2" disabled>Martes</option><option value="3" disabled>Miercoles</option><option value="4" disabled>Jueves</option><option value="5" disabled>Viernes</option><option value="6">Sabado</option><option value="7" disabled>Domingo</option>';
                    break;
                case '7': return 
                    '<option value="1" disabled>Lunes</option><option value="2" disabled>Martes</option><option value="3" disabled>Miercoles</option><option value="4" disabled>Jueves</option><option value="5" disabled>Viernes</option><option value="6" disabled>Sabado</option><option value="7">Domingo</option>';
                    break;
                default: return 
                    '<option value="1">Lunes</option><option value="2" disabled>Martes</option><option value="3" disabled>Miercoles</option><option value="4" disabled>Jueves</option><option value="5" disabled>Viernes</option><option value="6" disabled>Sabado</option><option value="7" disabled>Domingo</option>';
                    break;
            }
        }   
    }
}