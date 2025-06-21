<?php

include_once 'BaseDatos.php';
include_once 'Persona.php'; 

class ResponsableV extends Persona {

    private $IDempleado;
    private $IDlicencia;
    private $mensaje;

    public function __construct(
        $IDempleado = 0, 
        $IDlicencia = 0
    ) {
        parent::__construct("", "", "");
        $this->IDempleado = $IDempleado;
        $this->IDlicencia = $IDlicencia;
        $this->mensaje = "";
    }

    public function getIDempleado() {
        return $this->IDempleado;
    }

    public function setIDempleado($IDempleado) {
        $this->IDempleado = $IDempleado;
    }

    public function getIDlicencia() {
        return $this->IDlicencia;
    }

    public function setIDlicencia($IDlicencia) {
        $this->IDlicencia = $IDlicencia;
    }

    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

    public function getMensaje() {
        return $this->mensaje;
    }

    public function cargarResponsableV($nombrePersona, $apellidoPersona, $IDempleado, $IDlicencia) {
        $this->setNombrePersona($nombrePersona);
        $this->setApellidoPersona($apellidoPersona);
        $this->setIDempleado($IDempleado);
        $this->setIDlicencia($IDlicencia);
    }

    public function insertarResponsableV() {
    $base = new BaseDatos();
    $resp = false;
    $consultaResponsableV = "INSERT INTO ResponsableV(nombrePersona, apellidoPersona, IDlicencia) 
        VALUES (
            '" . $this->getNombrePersona() . "', 
            '" . $this->getApellidoPersona() . "', 
            '" . $this->getIDlicencia() . "'
        )";
    if ($base->IniciarBase()) {
        if ($base->EjecutarBase($consultaResponsableV)) {
            $resp = true;
        } else {
            $this->setMensaje($base->getERROR());
        }
    } else {
        $this->setMensaje($base->getERROR());
    }
    return $resp;
}

    public function listarResponsableV($condicion = "") {
        $arregloResponsables = null;
        $base = new BaseDatos();
        $consultaResponsableV = "SELECT * FROM ResponsableV";
        if ($condicion != "") {
            $consultaResponsableV .= ' WHERE ' . $condicion;
        }
        $consultaResponsableV .= " ORDER BY IDempleado";
        if ($base->IniciarBase()) {
            if ($base->EjecutarBase($consultaResponsableV)) {
                $arregloResponsables = array();
                while ($row2 = $base->Registro()) {
                    $objResponsableV = new ResponsableV();
                    $objResponsableV->cargarResponsableV(
                        $row2['nombrePersona'], 
                        $row2['apellidoPersona'], 
                        $row2['IDempleado'],
                        $row2['IDlicencia']
                    );
                    array_push($arregloResponsables, $objResponsableV);
                }
            } else {
                $this->setMensaje("ResponsableV->listar: " . $base->getERROR());
            }
        } else {
            $this->setMensaje("ResponsableV->listar: " . $base->getERROR());
        }
        return $arregloResponsables;
    }

    public function buscarResponsableV($IDempleado) {
        $base = new BaseDatos();
        $consultaResponsableV = "SELECT * FROM ResponsableV WHERE IDempleado = " . intval($IDempleado);
        $resp = false;
        if ($base->IniciarBase()) {
            if ($base->EjecutarBase($consultaResponsableV)) {
                if ($row2 = $base->Registro()) {
                    $this->cargarResponsableV(
                        $row2['nombrePersona'], 
                        $row2['apellidoPersona'], 
                        $row2['IDempleado'],
                        $row2['IDlicencia']
                    );
                    $resp = true;
                }
            } else {
                $this->setMensaje($base->getERROR());
            }
        } else {
            $this->setMensaje($base->getERROR());
        }
        return $resp;
    }

    public function eliminarResponsableV() {
        $base = new BaseDatos();
        $resp = false;
        $consultaResponsableV = "DELETE FROM ResponsableV WHERE IDempleado = " . intval($this->getIDempleado());
        if ($base->IniciarBase()) {
            if ($base->EjecutarBase($consultaResponsableV)) {
                $resp = true;
            } else {
                $this->setMensaje($base->getERROR());
            }
        } else {
            $this->setMensaje($base->getERROR());
        }
        return $resp;
    }

    public function modificarResponsableV() {
        $base = new BaseDatos();
        $resp = false;
        $consultaResponsableV = "UPDATE ResponsableV SET 
            nombrePersona = '" . $this->getNombrePersona() . "', 
            apellidoPersona = '" . $this->getApellidoPersona() . "', 
            IDlicencia = '" . $this->getIDlicencia() . "' 
            WHERE IDempleado = " . intval($this->getIDempleado());
        if ($base->IniciarBase()) {
            if ($base->EjecutarBase($consultaResponsableV)) {
                $resp = true;
            } else {
                $this->setMensaje($base->getERROR());
            }
        } else {
            $this->setMensaje($base->getERROR());
        }
        return $resp;
    }

    public function __toString() {
        return "ResponsableV: " . 
            $this->getNombrePersona() . " " . 
            $this->getApellidoPersona() . ", " . 
            "IDempleado: " . $this->getIDempleado() . ", " . 
            "IDlicencia: " . $this->getIDlicencia();
    }

}
