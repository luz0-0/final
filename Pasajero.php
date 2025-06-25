<?php
include_once 'BaseDatos.php';
include_once 'Persona.php';

class Pasajero extends Persona {

    private $docPasajero;
    private $telefonoPasajero;
    private $mensaje;

    public function __construct(
        $docPasajero = 0, 
        $telefonoPasajero = ""
    ) {
        parent::__construct("", "", 0);
        $this->docPasajero = $docPasajero;
        $this->telefonoPasajero = $telefonoPasajero;
        $this->mensaje = "";
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

    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

    public function getMensaje() {
        return $this->mensaje;
    }

    public function cargarPasajero($nombrePersona, $apellidoPersona, $docPasajero, $telefonoPasajero) {
        $this->setNombrePersona($nombrePersona);
        $this->setApellidoPersona($apellidoPersona);
        $this->setdocPasajero($docPasajero);
        $this->setTelefonoPasajero($telefonoPasajero);
    }

    public function buscarPasajero($docPasajero){
        $base = new BaseDatos();
        $consultaPasajero = "SELECT p.*, per.nombrePersona, per.apellidoPersona, per.IDpersona 
                            FROM Pasajero p 
                            INNER JOIN Persona per ON p.IDpersona = per.IDpersona 
                            WHERE p.docPasajero = " . intval($docPasajero);
        $resp = false;

        if ($base->IniciarBase()) {
            if ($base->EjecutarBase($consultaPasajero)) {
                if ($row2 = $base->Registro()) {					
                    $this->setdocPasajero($row2['docPasajero']);
                    $this->setIDpersona($row2['IDpersona']);
                    $this->setNombrePersona($row2['nombrePersona']);
                    $this->setApellidoPersona($row2['apellidoPersona']);
                    $this->setTelefonoPasajero($row2['telefonoPasajero']);
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

    public function listarPasajero($condicion = "") {
        $arregloPasajeros = null;
        $base = new BaseDatos();
        $consultaPasajero = "SELECT p.*, per.nombrePersona, per.apellidoPersona, per.IDpersona 
                            FROM Pasajero p 
                            INNER JOIN Persona per ON p.IDpersona = per.IDpersona";
        if ($condicion != "") {
            $consultaPasajero .= ' WHERE ' . $condicion;
        }
        $consultaPasajero .= " ORDER BY p.docPasajero ";
        
        if ($base->IniciarBase()) {
            if ($base->EjecutarBase($consultaPasajero)) {
                $arregloPasajeros = array();
                while ($row2 = $base->Registro()) {
                    $objPasajero = new Pasajero();
                    $objPasajero->setIDpersona($row2['IDpersona']);
                    $objPasajero->cargarPasajero(
                        $row2['nombrePersona'], 
                        $row2['apellidoPersona'],
                        $row2['docPasajero'], 
                        $row2['telefonoPasajero']
                    );
                    array_push($arregloPasajeros, $objPasajero);
                }
            } else {
                $this->setMensaje("Pasajero->listar: " . $base->getERROR());
            }
        } else {
            $this->setMensaje("Pasajero->listar: " . $base->getERROR());
        }
        return $arregloPasajeros;
    }

    public function insertarPasajero() {
        $base = new BaseDatos();
        $resp = false;
        
        if ($base->IniciarBase()) {
            $consultaVerificar = "SELECT docPasajero FROM Pasajero WHERE docPasajero = " . intval($this->getdocPasajero());
            if ($base->EjecutarBase($consultaVerificar)) {
                if ($base->Registro()) {
                    $this->setMensaje("El documento del pasajero ya existe.");
                    return false;
                }
            }

            $consultaPersona = "INSERT INTO Persona (nombrePersona, apellidoPersona) 
                VALUES ('" . $this->getNombrePersona() . "', '" . $this->getApellidoPersona() . "')";
            
            if ($base->EjecutarBase($consultaPersona)) {
                $idPersona = mysqli_insert_id($base->getCONEXION());
                $this->setIDpersona($idPersona);
                
                // Insertar en tabla Pasajero con referencia a Persona
                $consultaInsertar = "INSERT INTO Pasajero (docPasajero, IDpersona, telefonoPasajero) 
                    VALUES (
                    " . intval($this->getdocPasajero()) . ",
                    " . intval($this->getIDpersona()) . ",
                    '" . $this->getTelefonoPasajero() . "'
                    )";
                
                if ($base->EjecutarBase($consultaInsertar)) {
                    $resp = true;
                } else {
                    $this->setMensaje("Pasajero->insertar: " . $base->getERROR());
                }
            } else {
                $this->setMensaje("Pasajero->insertar (Persona): " . $base->getERROR());
            }
        } else {
            $this->setMensaje("Pasajero->insertar: " . $base->getERROR());
        }
        return $resp;
    }

    public function modificarPasajero() {
        $base = new BaseDatos();
        $resp = false;
        
        if ($base->IniciarBase()) {

            $consultaPersona = "UPDATE Persona SET 
                nombrePersona = '" . $this->getNombrePersona() . "', 
                apellidoPersona = '" . $this->getApellidoPersona() . "' 
                WHERE IDpersona = " . intval($this->getIDpersona());
            
            if ($base->EjecutarBase($consultaPersona)) {

                $consultaModificar = "UPDATE Pasajero SET 
                    telefonoPasajero = '" . $this->getTelefonoPasajero() . "' 
                    WHERE docPasajero = " . intval($this->getdocPasajero());
                
                if ($base->EjecutarBase($consultaModificar)) {
                    $resp = true;
                } else {
                    $this->setMensaje("Pasajero->modificar: " . $base->getERROR());
                }
            } else {
                $this->setMensaje("Pasajero->modificar (Persona): " . $base->getERROR());
            }
        } else {
            $this->setMensaje("Pasajero->modificar: " . $base->getERROR());
        }
        return $resp;
    }   

    public function eliminarPasajero() {
        $base = new BaseDatos();
        $resp = false;
        
        if ($base->IniciarBase()) {
            $consultaEliminarPasajero = "DELETE FROM Pasajero WHERE docPasajero = " . intval($this->getdocPasajero());
            if ($base->EjecutarBase($consultaEliminarPasajero)) {
                $consultaEliminarPersona = "DELETE FROM Persona WHERE IDpersona = " . intval($this->getIDpersona());
                if ($base->EjecutarBase($consultaEliminarPersona)) {
                    $resp = true;
                } else {
                    $this->setMensaje("Pasajero->eliminar (Persona): " . $base->getERROR());
                }
            } else {
                $this->setMensaje("Pasajero->eliminar: " . $base->getERROR());
            }
        } else {
            $this->setMensaje("Pasajero->eliminar: " . $base->getERROR());
        }
        return $resp;
    }

    public function __toString() {
        return 
               "Nombre: " . $this->getNombrePersona() . " " . $this->getApellidoPersona() . "\n" .
               "Documento pasajero: " . $this->getdocPasajero() . "\n" .
               "Teléfono: " . $this->getTelefonoPasajero() . "\n";
    }
}
