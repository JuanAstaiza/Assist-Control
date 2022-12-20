<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NivelEducativo
 *
 *  @author AssistControl
 */
class NivelEducativo {
    private $codigo;
    
    function __construct($codigo) {
        $this->codigo = $codigo;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

    function getNombre() {
        switch ($this->codigo) {
            case '1': return 'Bachiller'; break;
            case '2': return 'T&eacute;cnico'; break;
            case '3': return 'Tecn&oacute;logo'; break;
            case '4': return 'Profesional'; break;
            case '5': return 'Postgrado'; break;
            case '6': return 'Licenciado'; break;
            case '7': return 'Especialista'; break;
            case '8': return 'Magister'; break;
            case '9': return 'Decano'; break;
            default: return 'Desconocido'; break;
        }
    }
    
    public static function getListaEnOptions($predeterminado) {
        switch ($predeterminado) {            
            case '1': return 
           '<option value="1" selected>Bachiller</option>
            <option value="2">T&eacute;cnico</option>
            <option value="3">Tecn&oacute;logo</option>
            <option value="4">Profesional</option>
            <option value="5">Postgrado</option>
            <option value="6">Licenciado</option>
            <option value="7">Especialista</option>
            <option value="8">Magister</option>
            <option value="9">Decano</option>';                
                break;
            case '2': return 
           '<option value="1">Bachiller</option>
            <option value="2" selected>T&eacute;cnico</option>
            <option value="3">Tecn&oacute;logo</option>
            <option value="4">Profesional</option>
            <option value="5">Postgrado</option>
            <option value="6">Licenciado</option>
            <option value="7">Especialista</option>
            <option value="8">Magister</option>
            <option value="9">Decano</option>'; 
                break;
            case '3': return 
           '<option value="1">Bachiller</option>
            <option value="2">T&eacute;cnico</option>
            <option value="3" selected>Tecn&oacute;logo</option>
            <option value="4">Profesional</option>
            <option value="5">Postgrado</option>
            <option value="6">Licenciado</option>
            <option value="7">Especialista</option>
            <option value="8">Magister</option>
            <option value="9">Decano</option>';                
                break;
            case '4': return 
           '<option value="1">Bachiller</option>
            <option value="2">T&eacute;cnico</option>
            <option value="3">Tecn&oacute;logo</option>
            <option value="4" selected>Profesional</option>
            <option value="5">Postgrado</option>
            <option value="6">Licenciado</option>
            <option value="7">Especialista</option>
            <option value="8">Magister</option>
            <option value="9">Decano</option>';                
                break;
            case '5': return 
           '<option value="1">Bachiller</option>
            <option value="2">T&eacute;cnico</option>
            <option value="3">Tecn&oacute;logo</option>
            <option value="4">Profesional</option>
            <option value="5" selected>Postgrado</option>
            <option value="6">Licenciado</option>
            <option value="7">Especialista</option>
            <option value="8">Magister</option>
            <option value="9">Decano</option>';                
                break;
            case '6': return 
           '<option value="1">Bachiller</option>
            <option value="2">T&eacute;cnico</option>
            <option value="3">Tecn&oacute;logo</option>
            <option value="4">Profesional</option>
            <option value="5">Postgrado</option>
            <option value="6" selected>Licenciado</option>
            <option value="7">Especialista</option>
            <option value="8">Magister</option>
            <option value="9">Decano</option>';                
                break;
            case '7': return 
           '<option value="1">Bachiller</option>
            <option value="2">T&eacute;cnico</option>
            <option value="3">Tecn&oacute;logo</option>
            <option value="4">Profesional</option>
            <option value="5">Postgrado</option>
            <option value="6">Licenciado</option>
            <option value="7" selected>Especialista</option>
            <option value="8">Magister</option>
            <option value="9">Decano</option>';                
                break;
            case '8': return 
           '<option value="1">Bachiller</option>
            <option value="2">T&eacute;cnico</option>
            <option value="3">Tecn&oacute;logo</option>
            <option value="4">Profesional</option>
            <option value="5">Postgrado</option>
            <option value="6">Licenciado</option>
            <option value="7">Especialista</option>
            <option value="8" selected>Magister</option>
            <option value="9">Decano</option>';                
                break;
            case '9': return 
           '<option value="1">Bachiller</option>
            <option value="2">T&eacute;cnico</option>
            <option value="3">Tecn&oacute;logo</option>
            <option value="4">Profesional</option>
            <option value="5">Postgrado</option>
            <option value="6">Licenciado</option>
            <option value="7">Especialista</option>
            <option value="8">Magister</option>
            <option value="9" selected>Decano</option>';                
                break;
            default: return
           '<option value="1">Bachiller</option>
            <option value="2">T&eacute;cnico</option>
            <option value="3">Tecn&oacute;logo</option>
            <option value="4">Profesional</option>
            <option value="5">Postgrado</option>
            <option value="6">Licenciado</option>
            <option value="7">Especialista</option>
            <option value="8">Magister</option>
            <option value="9">Decano</option>';  
              break;
        }
    }
}
