<?php

include_once 'BaseDatos.php';
include_once 'Persona.php'; 

class ResponsableV extends Persona {

    private $IDEmpleado;
    private $IDLicencia;
    private $mensaje;

    public function __construct(
        $IDEmpleado = 0, 
        $IDLicencia = 0
    ) {
        parent::__construct("", "", "");
        $this->IDEmpleado = $IDEmpleado;
        $this->IDLicencia = $IDLicencia;
        $this->mensaje = "";
    }

    public function getIDEmpleado() {
        return $this->IDEmpleado;
    }

    public function setIDEmpleado($IDEmpleado) {
        $this->IDEmpleado = $IDEmpleado;
    }

    public function getIDLicencia() {
        return $this->IDLicencia;
    }

    public function setIDLicencia($IDLicencia) {
        $this->IDLicencia = $IDLicencia;
    }

    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

    public function getMensaje() {
        return $this->mensaje;
    }

    public function cargarResponsableV($nombrePersona, $apellidoPersona, $IDEmpleado, $IDLicencia) {
        $this->setNombrePersona($nombrePersona);
        $this->setApellidoPersona($apellidoPersona);
        $this->setIDEmpleado($IDEmpleado);
        $this->setIDLicencia($IDLicencia);
    }

    public function insertarResponsableV() {
        $base = new BaseDatos();
        $resp = false;
        $consultaResponsableV = "INSERT INTO ResponsableV(nombrePersona, apellidoPersona, IDEmpleado, IDLicencia) 
            VALUES (
                '" . $this->getNombrePersona() . "', 
                '" . $this->getApellidoPersona() . "', 
                '" . $this->getIDEmpleado() . "', 
                '" . $this->getIDLicencia() . "'
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
        $consultaResponsableV .= " ORDER BY IDEmpleado";
        if ($base->IniciarBase()) {
            if ($base->EjecutarBase($consultaResponsableV)) {
                $arregloResponsables = array();
                while ($row2 = $base->Registro()) {
                    $objResponsableV = new ResponsableV();
                    $objResponsableV->cargarResponsableV(
                        $row2['nombrePersona'], 
                        $row2['apellidoPersona'], 
                        $row2['IDEmpleado'],
                        $row2['IDLicencia']
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

    public function buscarResponsableV($IDEmpleado) {
        $base = new BaseDatos();
        $consultaResponsableV = "SELECT * FROM ResponsableV WHERE IDEmpleado = " . intval($IDEmpleado);
        $resp = false;
        if ($base->IniciarBase()) {
            if ($base->EjecutarBase($consultaResponsableV)) {
                if ($row2 = $base->Registro()) {
                    $this->cargarResponsableV(
                        $row2['nombrePersona'], 
                        $row2['apellidoPersona'], 
                        $row2['IDEmpleado'],
                        $row2['IDLicencia']
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
        $consultaResponsableV = "DELETE FROM ResponsableV WHERE IDEmpleado = " . intval($this->getIDEmpleado());
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
            IDLicencia = '" . $this->getIDLicencia() . "' 
            WHERE IDEmpleado = " . intval($this->getIDEmpleado());
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
            "IDEmpleado: " . $this->getIDEmpleado() . ", " . 
            "IDLicencia: " . $this->getIDLicencia();
    }

}
