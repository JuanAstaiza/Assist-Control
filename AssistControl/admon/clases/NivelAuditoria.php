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
class NivelAuditoria {
    private $codigo;

    function __construct($codigo) {
        $this->codigo = $codigo;
    }

    function getCodigo() {
        return $this->codigo;
    }

    function getNombre(){
        switch ($this->codigo) {
            case '0': return 'Sin auditoria'; break;
            case '1': return 'Accesos al sistema'; break;
            case '2': return 'Actualizacion de informacion'; break;
            default: return 'Desconocido'; break;
        }
    }

    public function __toString() {
        return $this->getNombre();
    }
    public static function getListaEnOptions($predeterminado){
        switch ($predeterminado) {            
            case '1': return '<option value="0">Sin auditor&iacute;a</option><option value="1" selected>Accesos al sistema</option><option value="2">Actualizaci&oacute;n de informaci&oacute;n</option>'; break;
            case '2': return '<option value="0">Sin auditor&iacute;a</option><option value="1">Accesos al sistema</option><option value="2" selected>Actualizaci&oacute;n de informaci&oacute;n</option>'; break;
            default: return '<option value="0">Sin auditor&iacute;a</option><option value="1">Accesos al sistema</option><option value="2">Actualizaci&oacute;n de informaci&oacute;n</option>'; break;
        }
    }
}
