<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Idioma
 *
 *  @author AssistControl
 */
class Idioma {
    private $codigo;

    function __construct($codigo) {
        $this->codigo = $codigo;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getNombre(){
        switch ($this->codigo) {
            case '0': return 'Espa&ntilde;ol'; break;
            case '1': return 'Ingl&eacute;s'; break;
            default: return 'Desconocido'; break;
        }
    }
    
    public function __toString() {
        return $this->getNombre();
    }
    
    public static function getListaEnOptions($predeterminado){
        switch ($predeterminado) {            
            case '1': return '<option value="0">Espa&ntilde;ol</option><option value="1" selected>Ingl&eacute;s</option>'; break;
            default: return '<option value="0">Espa&ntilde;ol</option><option value="1">Ingl&eacute;s</option>'; break;
        }
    }

}
