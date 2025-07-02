<?php

include_once 'BaseDatos.php';
include_once 'Empresa.php';
include_once 'ResponsableV.php';

class Viaje {

    private $IDviaje;
    private $destinoViaje;
    private $cantMaxPasajeros;
    private $objEmpresa;
    private $objResponsableV;
    private $importeViaje;
    private $mensaje;

   public function __construct() {
    $this->IDviaje = 0;
    $this->destinoViaje = "";
    $this->cantMaxPasajeros = "";
    $this->objEmpresa = null;
    $this->objResponsableV = null;
    $this->importeViaje = 0;
    $this->mensaje = "";
}

    public function getIDviaje() {
        return $this->IDviaje;
    }

    public function setIDviaje($IDviaje) {
        $this->IDviaje = $IDviaje;
    }

    public function getDestinoViaje() {
        return $this->destinoViaje;
    }

    public function setDestinoViaje($destinoViaje) {
        $this->destinoViaje = $destinoViaje;
    }

    public function getCantMaxPasajeros() {
        return $this->cantMaxPasajeros;
    }

    public function setCantMaxPasajeros($cantMaxPasajeros) {
        $this->cantMaxPasajeros = $cantMaxPasajeros;
    }

    public function getObjEmpresa() {
        return $this->objEmpresa;
    }

    public function setObjEmpresa($objEmpresa) {
        $this->objEmpresa = $objEmpresa;
    }

    public function getObjResponsableV() {
        return $this->objResponsableV;
    }

    public function setObjResponsableV($objResponsableV) {
        $this->objResponsableV = $objResponsableV;
    }

   
    public function getImporteViaje() {
        return $this->importeViaje;
    }

    public function setImporteViaje($importeViaje) {
        $this->importeViaje = $importeViaje;
    }

    public function getMensaje() {
        return $this->mensaje;
    }

    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

  public function cargarViaje(
    $IDviaje, 
    $destinoViaje, 
    $cantMaxPasajeros, 
    $objEmpresa, 
    $objResponsableV, 
    $importeViaje
) {
    $this->setIDviaje($IDviaje);
    $this->setDestinoViaje($destinoViaje);
    $this->setCantMaxPasajeros($cantMaxPasajeros);
    $this->setObjEmpresa($objEmpresa);
    $this->setObjResponsableV($objResponsableV);
    $this->setImporteViaje($importeViaje);
}

public function buscarViaje($IDviaje) {
    $base = new BaseDatos();
    $consultaViaje = "SELECT v.*, e.nombreEmpresa, e.direccionEmpresa, 
                             r.numLicencia, r.numEmpleado, r.IDpersona,
                             p.nombrePersona, p.apellidoPersona
                      FROM Viaje v 
                      INNER JOIN Empresa e ON v.IDempresa = e.IDempresa
                      INNER JOIN ResponsableV r ON v.numEmpleado = r.numEmpleado
                      INNER JOIN Persona p ON r.IDpersona = p.IDpersona
                      WHERE v.IDviaje = " . intval($IDviaje);
    $resp = false;
    if ($base->IniciarBase()) {
        if ($base->EjecutarBase($consultaViaje)) {
            if ($row2 = $base->Registro()) {
                
                $empresa = new Empresa();
                $empresa->cargarEmpresa($row2['IDempresa'], $row2['nombreEmpresa'], $row2['direccionEmpresa']);

                
                $responsable = new ResponsableV();
                $responsable->cargarResponsableV($row2['nombrePersona'], $row2['apellidoPersona'], $row2['IDpersona'], $row2['numLicencia']);
                $responsable->setnumEmpleado($row2['numEmpleado']);

                $this->cargarViaje(
                    $row2['IDviaje'], 
                    $row2['destinoViaje'], 
                    $row2['cantMaxPasajeros'], 
                    $empresa, 
                    $responsable, 
                    $row2['importeViaje']
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

    public function insertarViaje() {
        $base = new BaseDatos();
        $resp = false;
        $consultaViaje = "INSERT INTO Viaje(destinoViaje, cantMaxPasajeros, IDempresa, numEmpleado, importeViaje) 
            VALUES (
                '" . $this->getDestinoViaje() . "', 
                " . $this->getCantMaxPasajeros() . ",
                " . $this->getObjEmpresa()->getIDempresa() . ",
                " . $this->getObjResponsableV()->getnumEmpleado() . ",
                " . $this->getImporteViaje() . "
            )";
        if ($base->IniciarBase()) {
            if ($base->EjecutarBase($consultaViaje)) {
                $resp = true;
            } else {
                $this->setMensaje($base->getERROR());
            }
        } else {
            $this->setMensaje($base->getERROR());
        }
        return $resp;
    }

public function listarViaje($condicion = "") {
    $arregloViajes = null;
    $base = new BaseDatos();
    $consultaViaje = "SELECT v.*, e.nombreEmpresa, e.direccionEmpresa, 
                             r.numLicencia, r.numEmpleado, r.IDpersona,
                             p.nombrePersona, p.apellidoPersona
                      FROM Viaje v 
                      INNER JOIN Empresa e ON v.IDempresa = e.IDempresa
                      INNER JOIN ResponsableV r ON v.numEmpleado = r.numEmpleado
                      INNER JOIN Persona p ON r.IDpersona = p.IDpersona";
    if ($condicion != "") {
        $consultaViaje .= ' WHERE ' . $condicion;
    }
    $consultaViaje .= " ORDER BY v.IDviaje ";
    
    if ($base->IniciarBase()) {
        if ($base->EjecutarBase($consultaViaje)) {
            $arregloViajes = array();
            while ($row2 = $base->Registro()) {
                $objViaje = new Viaje();
                
                
                $empresa = new Empresa();
                $empresa->cargarEmpresa($row2['IDempresa'], $row2['nombreEmpresa'], $row2['direccionEmpresa']);

                
                $responsable = new ResponsableV();
                $responsable->cargarResponsableV($row2['nombrePersona'], $row2['apellidoPersona'], $row2['IDpersona'], $row2['numLicencia']);
                $responsable->setnumEmpleado($row2['numEmpleado']);

                $objViaje->cargarViaje(
                    $row2['IDviaje'], 
                    $row2['destinoViaje'], 
                    $row2['cantMaxPasajeros'], 
                    $empresa, 
                    $responsable, 
                    $row2['importeViaje']
                );
                array_push($arregloViajes, $objViaje);
            }
        } else {
            $this->setMensaje("Viaje->listar: " . $base->getERROR());
        }
    } else {
        $this->setMensaje("Viaje->listar: " . $base->getERROR());
    }
    return $arregloViajes;
}

    public function eliminarViaje() {
        $base = new BaseDatos();
        $resp = false;
        $consultaViaje = "DELETE FROM Viaje WHERE IDviaje = " . intval($this->getIDviaje());
        if ($base->IniciarBase()) {
            if ($base->EjecutarBase($consultaViaje)) {
                $resp = true;
            } else {
                $this->setMensaje($base->getERROR());
            }
        } else {
            $this->setMensaje($base->getERROR());
        }
        return $resp;
    }

    public function modificarViaje() {
        $base = new BaseDatos();
        $resp = false;
        $consultaViaje = "UPDATE Viaje SET 
            destinoViaje = '" . $this->getDestinoViaje() . "', 
            cantMaxPasajeros = " . $this->getCantMaxPasajeros() . ", 
            IDempresa = " . $this->getObjEmpresa()->getIDempresa() . ", 
            numEmpleado = " . $this->getObjResponsableV()->getnumEmpleado() . ", 
            importeViaje = " . $this->getImporteViaje() . "
            WHERE IDviaje = " . intval($this->getIDviaje());
        if ($base->IniciarBase()) {
            if ($base->EjecutarBase($consultaViaje)) {
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
        return "ID Viaje: " . $this->getIDviaje() . 
            ", Destino: " . $this->getDestinoViaje() . 
            ", Cantidad Maxima de Pasajeros: " . $this->getCantMaxPasajeros() . 
            ", Empresa: " . ($this->getObjEmpresa() ? $this->getObjEmpresa()->getNombreEmpresa() : "N/A") . 
            ", Responsable: " . ($this->getObjResponsableV() ? $this->getObjResponsableV()->getNombrePersona() : "N/A") . 
            ", Importe: " . $this->getImporteViaje();
    }

}
