<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NivelAuditoria
 *
 *  @author AssistControl
 */
class TipoPregunta {
    private $codigo;

    function __construct($codigo) {
        $this->codigo = $codigo;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getNombre(){
        switch ($this->codigo) {
            case 'F': return 'Falso y verdadero'; break;
            case 'S': return 'Seleccion'; break;
            case 'A': return 'Abierta'; break;
            default: return 'Desconocido'; break;
        }
    }

    public function __toString() {
        return $this->getNombre();
    }
    public static function getListaEnOptions($predeterminado){
        switch ($predeterminado) {            
            case 'S': return '<option value="F">Falso y verdadero</option><option value="S" selected>Selecci&oacute;n</option><option value="A">Abierta</option>'; break;
            case 'A': return '<option value="F">Falso y verdadero</option><option value="S">Selecci&oacute;n</option><option value="A" selected>Abierta</option>'; break;
            default: return '<option value="F">Falso y verdadero</option><option value="S">Selecci&oacute;n</option><option value="A">Abierta</option>'; break;
        }
    }
}
