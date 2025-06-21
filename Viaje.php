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
    private $colObjPasajeros;
    private $importeViaje;
    private $mensaje;

    public function __construct(
        $IDviaje = 0, 
        $destinoViaje = "", 
        $cantMaxPasajeros = 0, 
        $objEmpresa = null, 
        $objResponsableV = null, 
        $colObjPasajeros = [], 
        $importeViaje = 0.0, 
        $mensaje = ""
    ) {
        $this->IDviaje = $IDviaje;
        $this->destinoViaje = $destinoViaje;
        $this->cantMaxPasajeros = $cantMaxPasajeros;
        $this->objEmpresa = $objEmpresa;
        $this->objResponsableV = $objResponsableV;
        $this->colObjPasajeros = $colObjPasajeros;
        $this->importeViaje = $importeViaje;
        $this->mensaje = $mensaje;
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

    public function getColObjPasajeros() {
        return $this->colObjPasajeros;
    }

    public function setColObjPasajeros($colObjPasajeros) {
        $this->colObjPasajeros = $colObjPasajeros;
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
        $colObjPasajeros, 
        $importeViaje
    ) {
        $this->setIDviaje($IDviaje);
        $this->setDestinoViaje($destinoViaje);
        $this->setCantMaxPasajeros($cantMaxPasajeros);
        $this->setObjEmpresa($objEmpresa);
        $this->setObjResponsableV($objResponsableV);
        $this->setColObjPasajeros($colObjPasajeros);
        $this->setImporteViaje($importeViaje);
    }

    public function buscarViaje($IDviaje) {
        $base = new BaseDatos();
        $consultaViaje = "SELECT * FROM Viaje WHERE IDviaje = " . intval($IDviaje);
        $resp = false;
        if ($base->IniciarBase()) {
            if ($base->EjecutarBase($consultaViaje)) {
                if ($row2 = $base->Registro()) {
                    $empresa = new Empresa();
                    $empresa->buscarEmpresa($row2['IDempresa']);

                    $responsable = new ResponsableV();
                    $responsable->buscarResponsableV($row2['IDempleado']);

                    $this->cargarViaje(
                        $row2['IDviaje'], 
                        $row2['destinoViaje'], 
                        $row2['cantMaxPasajeros'], 
                        $empresa, 
                        $responsable, 
                        [], 
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
        $consultaViaje = "INSERT INTO Viaje(destinoViaje, cantMaxPasajeros, IDempresa, IDempleado, importeViaje) 
            VALUES (
                '" . $this->getDestinoViaje() . "', 
                " . $this->getCantMaxPasajeros() . ",
                " . $this->getObjEmpresa()->getIDempresa() . ",
                " . $this->getObjResponsableV()->getIDempleado() . ",
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
        $consultaViaje = "SELECT * FROM Viaje";
        if ($condicion != "") {
            $consultaViaje .= ' WHERE ' . $condicion;
        }
        $consultaViaje .= " ORDER BY IDviaje ";
        if ($base->IniciarBase()) {
            if ($base->EjecutarBase($consultaViaje)) {
                $arregloViajes = array();
                while ($row2 = $base->Registro()) {
                    $objViaje = new Viaje();
                    $empresa = new Empresa();
                    $empresa->buscarEmpresa($row2['IDempresa']);

                    $responsable = new ResponsableV();
                    $responsable->buscarResponsableV($row2['IDempleado']);

                    $objViaje->cargarViaje(
                        $row2['IDviaje'], 
                        $row2['destinoViaje'], 
                        $row2['cantMaxPasajeros'], 
                        $empresa, 
                        $responsable, 
                        [], 
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
            IDempleado = " . $this->getObjResponsableV()->getIDempleado() . ", 
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
