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
class Estado {
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
            case '1': return 'Activo'; break;
            case '0': return 'Inactivo'; break;
            default: return 'Desconocido'; break;
        }
    }
    public static function getListaEnOptions($predeterminado){
        switch ($predeterminado) {            
            case '1': return '<option value="true" selected>Activo</option><option value="false">Inactivo</option>'; break;
            case '0': return '<option value="true">Activo</option><option value="false" selected>Inactivo</option>'; break;
            default: return '<option value="true" selected>Activo</option><option value="false">Inactivo</option>'; break;
        }
    }
    
}
