<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GrupoSanguineo
 *
 *  @author AssistControl
 */
class GrupoSanguineo {
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
            case '1': return 'A+'; break;
            case '2': return 'A-'; break;
            case '3': return 'B+'; break;
            case '4': return 'B-'; break;
            case '5': return 'AB+'; break;
            case '6': return 'AB-'; break;
            case '7': return 'O+'; break;
            case '8': return 'O-'; break;
            default: return 'Desconocido'; break;
        }
    }
    
    public static function getListaEnOptions($predeterminado) {
        switch ($predeterminado) {            
            case '1': return 
                '<option value="1" selected>A+</option><option value="2">A-</option><option value="3">B+</option><option value="4">B-</option><option value="5">AB+</option><option value="6">AB-</option><option value="7">O+</option><option value="8">O-</option>';
                break;
            case '2': return 
                '<option value="1">A+</option><option value="2" selected>A-</option><option value="3">B+</option><option value="4">B-</option><option value="5">AB+</option><option value="6">AB-</option><option value="7">O+</option><option value="8">O-</option>';
                break;
            case '3': return 
                '<option value="1">A+</option><option value="2">A-</option><option value="3" selected>B+</option><option value="4">B-</option><option value="5">AB+</option><option value="6">AB-</option><option value="7">O+</option><option value="8">O-</option>';
                break;
            case '4': return 
                '<option value="1">A+</option><option value="2">A-</option><option value="3">B+</option><option value="4" selected>B-</option><option value="5">AB+</option><option value="6">AB-</option><option value="7">O+</option><option value="8">O-</option>';
                break;
            case '5': return 
                '<option value="1">A+</option><option value="2">A-</option><option value="3">B+</option><option value="4">B-</option><option value="5" selected>AB+</option><option value="6">AB-</option><option value="7">O+</option><option value="8">O-</option>';
                break;
            case '6': return 
                '<option value="1">A+</option><option value="2">A-</option><option value="3">B+</option><option value="4">B-</option><option value="5">AB+</option><option value="6" selected>AB-</option><option value="7">O+</option><option value="8">O-</option>';
                break;
            case '7': return 
                '<option value="1">A+</option><option value="2">A-</option><option value="3">B+</option><option value="4">B-</option><option value="5">AB+</option><option value="6">AB-</option><option value="7" selected>O+</option><option value="8">O-</option>';
                break;
            default: return '<option value="1">A+</option><option value="2">A-</option><option value="3">B+</option><option value="4">B-</option><option value="5">AB+</option><option value="6">AB-</option><option value="7">O+</option><option value="8" selected>O-</option>';
                break;
        }
    }
}
