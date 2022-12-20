<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Genero
 *
 *  @author AssistControl
 */
class Genero {
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

    function getNombre(){
        switch ($this->codigo) {
            case '0': return 'Masculino'; break;
            case '1': return 'Femenino'; break;
            default: return 'Desconocido'; break;
        }
    }
    
    public static function getListaEnOptions($predeterminado){
        switch ($predeterminado) {            
            case '0': return '<option value="0" selected>Masculino</option><option value="1">Femenino</option>'; break;
            case '1': return '<option value="0">Masculino</option><option value="1" seleted>Femenino</option>'; break;
            default: return '<option value="0">Masculino</option><option value="1">Femenino</option>'; break;
        }
    }
    
}
