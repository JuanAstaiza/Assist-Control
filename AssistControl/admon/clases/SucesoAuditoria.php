<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of SucesoAuditoria
 *
 * @author JUAN CARLOS ASTAIZA
 */
class SucesoAuditoria {
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
            case  'I': return 'Ingreso Exitoso al Sistema';break;
            case  'F': return 'Ingreso Fallido al Sistema';break;
            case  'A': return 'Adicion de Informacion';break;
            case  'M': return 'Modificacion de Informacion';break;
            case  'E': return 'Eliminacion de Informacion';break;
            case  'S': return 'Salida del Sistema';break;
            default: 'Desconocido';  break;
        }
    }
    
    
}
