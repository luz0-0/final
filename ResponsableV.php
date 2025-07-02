<?php

include_once 'BaseDatos.php';
include_once 'Persona.php'; 

class ResponsableV extends Persona {

    private $numEmpleado;
    private $numLicencia;

    public function __construct() {
        parent::__construct();
        $this->numEmpleado = 0;
        $this->numLicencia = "";
    }
    
    public function getnumEmpleado() {
        return $this->numEmpleado;
    }

    public function setnumEmpleado($numEmpleado) {
        $this->numEmpleado = $numEmpleado;
    }

    public function getnumLicencia() {
        return $this->numLicencia;
    }

    public function setnumLicencia($numLicencia) {
        $this->numLicencia = $numLicencia;
    }

    public function cargarResponsableV($nombrePersona, $apellidoPersona, $IDpersona, $numLicencia) {
        parent::cargar($nombrePersona, $apellidoPersona, $IDpersona);
        $this->setnumLicencia($numLicencia);
    }

public function insertarResponsableV() {
    $base = new BaseDatos();
    $resp = false;
    
    if ($base->IniciarBase()) {
        $consultaPersona = "INSERT INTO Persona (nombrePersona, apellidoPersona) VALUES ('" . 
            $this->getNombrePersona() . "', '" . $this->getApellidoPersona() . "')";
        
        if ($base->EjecutarBase($consultaPersona)) {
            $consultaId = "SELECT LAST_INSERT_ID() as id";
            if ($base->EjecutarBase($consultaId)) {
                if ($row = $base->Registro()) {
                    $this->setIDpersona($row['id']);
                    
                   
                    $consultaInsertar = "INSERT INTO ResponsableV (IDpersona, numLicencia) VALUES (" . 
                        intval($this->getIDpersona()) . ", '" . $this->getnumLicencia() . "')";
                    
                    if ($base->EjecutarBase($consultaInsertar)) {
                        $consultaEmp = "SELECT LAST_INSERT_ID() as id";
                        if ($base->EjecutarBase($consultaEmp)) {
                            if ($row2 = $base->Registro()) {
                                $this->setnumEmpleado($row2['id']);
                            }
                        }
                        $resp = true;
                    } else {
                        $this->setMensaje("Error al insertar ResponsableV: " . $base->getERROR());
                    }
                } else {
                    $this->setMensaje("Error al obtener ID de persona insertada");
                }
            } else {
                $this->setMensaje("Error al obtener LAST_INSERT_ID: " . $base->getERROR());
            }
        } else {
            $this->setMensaje("Error al insertar persona: " . $base->getERROR());
        }
    } else {
        $this->setMensaje("Error al iniciar la base de datos: " . $base->getERROR());
    }
    
    return $resp;
}

    public static function listarResponsableV($condicion = "") {
        $arreglo = [];
        $base = new BaseDatos();
        $consulta = "SELECT * FROM ResponsableV";
        if ($condicion != "") {
            $consulta .= " WHERE " . $condicion;
        }
        $consulta .= " ORDER BY numEmpleado ";
        if ($base->IniciarBase()) {
            if ($base->EjecutarBase($consulta)) {
                while ($row2 = $base->Registro()) {
                    $obj = new ResponsableV();
                    $obj->buscarResponsableV($row2['numEmpleado']);
                    array_push($arreglo, $obj);
                }
            } else {
                self::setMensaje($base->getERROR());
            }
        } else {
            self::setMensaje($base->getERROR());
        }
        return $arreglo;
    }

    public function buscarResponsableV($numEmpleado) {
        $base = new BaseDatos();
        $consulta = "SELECT * FROM ResponsableV WHERE numEmpleado = " . intval($numEmpleado);
        $resp = false;
        if ($base->IniciarBase()) {
            if ($base->EjecutarBase($consulta)) {
                if ($row2 = $base->Registro()) {
                    parent::buscarPersona($row2['IDpersona']);
                    $this->setnumEmpleado($row2['numEmpleado']);
                    $this->setnumLicencia($row2['numLicencia']);
                    $resp = true;
                } else {
                    $this->setMensaje($base->getERROR());
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
        $consultaBorra = "DELETE FROM ResponsableV WHERE numEmpleado = " . intval($this->getnumEmpleado());
        if ($base->IniciarBase()) {
            if ($base->EjecutarBase($consultaBorra)) {
                if (parent::eliminarPersona()) {
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

public function modificarResponsableV() {
    $resp = false;
    $base = new BaseDatos();
    
    if (parent::modificarPersona()) {
        $consultaModifica = "UPDATE ResponsableV SET numLicencia='" . $this->getnumLicencia() . 
            "' WHERE numEmpleado=" . intval($this->getnumEmpleado());
        
        if ($base->IniciarBase()) {
            if ($base->EjecutarBase($consultaModifica)) {
                $resp = true;
            } else {
                $this->setMensaje("Error al modificar ResponsableV: " . $base->getERROR());
            }
        } else {
            $this->setMensaje("Error de conexión: " . $base->getERROR());
        }
    } else {
        $this->setMensaje("Error al modificar datos de persona");
    }
    
    return $resp;
}

    public function __toString() {
        return parent::__toString() . 
            "\n Numero de Empleado: " . $this->getnumEmpleado() . 
            "\n Numero de Licencia: " . $this->getnumLicencia();
    }
}
