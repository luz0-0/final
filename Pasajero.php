<?php

include_once 'BaseDatos.php';
include_once 'Persona.php';

class Pasajero extends Persona {

    private $telefonoPasajero;
    private $docPasajero;

    public function __construct() {
        parent::__construct();
        $this->telefonoPasajero = 0;
        $this->docPasajero = "";
    }

    public function getdocPasajero() {
        return $this->docPasajero;
    }

    public function setdocPasajero($docPasajero) {
        $this->docPasajero = $docPasajero;
    } 

    public function getTelefonoPasajero() {
        return $this->telefonoPasajero;
    }

    public function setTelefonoPasajero($telefonoPasajero) {
        $this->telefonoPasajero = $telefonoPasajero;
    }

public function cargarPasajero($nombrePersona, $apellidoPersona, $docPasajero, $telefonoPasajero, $IDpersona = 0) {
    parent::cargar($nombrePersona, $apellidoPersona, $IDpersona);
    $this->setTelefonoPasajero($telefonoPasajero);
    $this->setdocPasajero($docPasajero);
}

    public function buscar($docPasajero){
        $base = new BaseDatos();
        $consulta = "SELECT * FROM Pasajero WHERE docPasajero = " . intval($docPasajero);
        $resp = false;
        
        if ($base->IniciarBase()) {
            if ($base->EjecutarBase($consulta)) {
                if ($row2 = $base->Registro()) {
                    parent::buscar($row2['IDpersona']);
                    $this->setdocPasajero($row2['docPasajero']);
                    $this->setTelefonoPasajero($row2['telefonoPasajero']);
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


public function listar($condicion = "") {
    $arreglo = [];
    $base = new BaseDatos();
    $consulta = "SELECT p.*, per.nombrePersona, per.apellidoPersona 
                 FROM Pasajero p 
                 INNER JOIN Persona per ON p.IDpersona = per.IDpersona";
    if ($condicion != "") {
        $consulta .= ' WHERE ' . $condicion;
    }
    $consulta .= " ORDER BY docPasajero ";
    
    if ($base->IniciarBase()) {
        if ($base->EjecutarBase($consulta)) {
            while ($row2 = $base->Registro()) {
                $obj = new Pasajero();
                $obj->cargarPasajero(
                    $row2['nombrePersona'], 
                    $row2['apellidoPersona'], 
                    $row2['docPasajero'], 
                    $row2['telefonoPasajero']
                );
                $obj->setIDpersona($row2['IDpersona']);
                array_push($arreglo, $obj);
            }
        } else {
            $this->setMensaje($base->getERROR());
        }
    } else {
        $this->setMensaje($base->getERROR());
    }
    return $arreglo;
}


public function insertar() {
    $base = new BaseDatos();
    $resp = false;
    
    if ($this->buscar($this->getdocPasajero())) {
        $this->setMensaje("Error: Ya existe un pasajero con el documento " . $this->getdocPasajero());
        return false;
    }
    
    if ($base->IniciarBase()) {
        $consultaPersona = "INSERT INTO Persona (nombrePersona, apellidoPersona) VALUES ('" . 
            $this->getNombrePersona() . "', '" . $this->getApellidoPersona() . "')";
        
        if ($base->EjecutarBase($consultaPersona)) {
            $consultaId = "SELECT LAST_INSERT_ID() as id";
            if ($base->EjecutarBase($consultaId)) {
                if ($row = $base->Registro()) {
                    $this->setIDpersona($row['id']);
                    
                    $consultaPasajero = "INSERT INTO Pasajero (docPasajero, IDpersona, telefonoPasajero) VALUES (" .
                        intval($this->getdocPasajero()) . ", " . 
                        intval($this->getIDpersona()) . ", '" . 
                        $this->getTelefonoPasajero() . "')";
                    
                    if ($base->EjecutarBase($consultaPasajero)) {
                        $resp = true;
                    } else {
                        $this->setMensaje($base->getERROR());
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


public function modificar() {
    $base = new BaseDatos();
    $resp = false;
    
    if (parent::modificar()) {
        $consultaPasajero = "UPDATE Pasajero SET telefonoPasajero = '" . $this->getTelefonoPasajero() . 
            "' WHERE docPasajero = " . intval($this->getdocPasajero());
        if ($base->IniciarBase()) {
            if ($base->EjecutarBase($consultaPasajero)) {
                $resp = true;
            } else {
                $this->setMensaje($base->getERROR());
            }
        } else {
            $this->setMensaje($base->getERROR());
        }
    } else {
        $this->setMensaje("Error al modificar los datos de la persona");
    }
    return $resp;
}

    public function eliminar() {
        $base = new BaseDatos();
        $resp = false;
        $consultaEliminarPasajero = "DELETE FROM Pasajero WHERE docPasajero = " . intval($this->getdocPasajero());
        if ($base->IniciarBase()) {
            if ($base->EjecutarBase($consultaEliminarPasajero)) {
                if (parent::eliminar()) {
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

    public function __toString() {
        return parent::__toString() . 
            "\n Telefono Pasajero: " . $this->getTelefonoPasajero() . 
            "\n Documento Pasajero: " . $this->getdocPasajero();
    }
}
