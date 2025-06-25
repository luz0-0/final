<?php
include_once 'BaseDatos.php';
include_once 'Persona.php'; 

class ResponsableV extends Persona {

    private $numEmpleado;
    private $numLicencia;
    private $mensaje;

    public function __construct(
        $numEmpleado = 0, 
        $numLicencia = 0
    ) {
        parent::__construct("", "", 0);
        $this->numEmpleado = $numEmpleado;
        $this->numLicencia = $numLicencia;
        $this->mensaje = "";
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

    public function setMensaje($mensaje) {
        $this->mensaje = $mensaje;
    }

    public function getMensaje() {
        return $this->mensaje;
    }

    public function cargarResponsableV($nombrePersona, $apellidoPersona, $numLicencia) {
        $this->setNombrePersona($nombrePersona);
        $this->setApellidoPersona($apellidoPersona);
        $this->setnumLicencia($numLicencia);
    }

    public function insertarResponsableV() {
        $base = new BaseDatos();
        $resp = false;
        
        if ($base->IniciarBase()) {
            $consultaPersona = "INSERT INTO Persona (nombrePersona, apellidoPersona) 
                VALUES ('" . $this->getNombrePersona() . "', '" . $this->getApellidoPersona() . "')";
            
            if ($base->EjecutarBase($consultaPersona)) {
                $idPersona = mysqli_insert_id($base->getCONEXION());
                $this->setIDpersona($idPersona);

                $consultaResponsableV = "INSERT INTO ResponsableV(IDpersona, numLicencia) 
                    VALUES (" . intval($this->getIDpersona()) . ", '" . $this->getnumLicencia() . "')";
                
                if ($base->EjecutarBase($consultaResponsableV)) {
                    $this->setnumEmpleado(mysqli_insert_id($base->getCONEXION()));
                    $resp = true;
                } else {
                    $this->setMensaje("ResponsableV->insertar: " . $base->getERROR());
                }
            } else {
                $this->setMensaje("ResponsableV->insertar (Persona): " . $base->getERROR());
            }
        } else {
            $this->setMensaje("ResponsableV->insertar: " . $base->getERROR());
        }
        return $resp;
    }

    public function listarResponsableV($condicion = "") {
        $arregloResponsables = null;
        $base = new BaseDatos();
        $consultaResponsableV = "SELECT r.*, p.nombrePersona, p.apellidoPersona, p.IDpersona 
                                FROM ResponsableV r 
                                INNER JOIN Persona p ON r.IDpersona = p.IDpersona";
        if ($condicion != "") {
            $consultaResponsableV .= ' WHERE ' . $condicion;
        }
        $consultaResponsableV .= " ORDER BY r.numEmpleado";
        
        if ($base->IniciarBase()) {
            if ($base->EjecutarBase($consultaResponsableV)) {
                $arregloResponsables = array();
                while ($row2 = $base->Registro()) {
                    $objResponsableV = new ResponsableV();
                    $objResponsableV->setnumEmpleado($row2['numEmpleado']);
                    $objResponsableV->setIDpersona($row2['IDpersona']);
                    $objResponsableV->cargarResponsableV(
                        $row2['nombrePersona'], 
                        $row2['apellidoPersona'], 
                        $row2['numLicencia']
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

    public function buscarResponsableV($numEmpleado) {
        $base = new BaseDatos();
        $consultaResponsableV = "SELECT r.*, p.nombrePersona, p.apellidoPersona, p.IDpersona 
                                FROM ResponsableV r 
                                INNER JOIN Persona p ON r.IDpersona = p.IDpersona 
                                WHERE r.numEmpleado = " . intval($numEmpleado);
        $resp = false;
        
        if ($base->IniciarBase()) {
            if ($base->EjecutarBase($consultaResponsableV)) {
                if ($row2 = $base->Registro()) {
                    $this->setnumEmpleado($row2['numEmpleado']);
                    $this->setIDpersona($row2['IDpersona']);
                    $this->cargarResponsableV(
                        $row2['nombrePersona'], 
                        $row2['apellidoPersona'], 
                        $row2['numLicencia']
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
        
        if ($base->IniciarBase()) {
            $consultaResponsableV = "DELETE FROM ResponsableV WHERE numEmpleado = " . intval($this->getnumEmpleado());
            if ($base->EjecutarBase($consultaResponsableV)) {
                $consultaPersona = "DELETE FROM Persona WHERE IDpersona = " . intval($this->getIDpersona());
                if ($base->EjecutarBase($consultaPersona)) {
                    $resp = true;
                } else {
                    $this->setMensaje("ResponsableV->eliminar (Persona): " . $base->getERROR());
                }
            } else {
                $this->setMensaje("ResponsableV->eliminar: " . $base->getERROR());
            }
        } else {
            $this->setMensaje("ResponsableV->eliminar: " . $base->getERROR());
        }
        return $resp;
    }

    public function modificarResponsableV() {
        $base = new BaseDatos();
        $resp = false;
        
        if ($base->IniciarBase()) {
            $consultaPersona = "UPDATE Persona SET 
                nombrePersona = '" . $this->getNombrePersona() . "', 
                apellidoPersona = '" . $this->getApellidoPersona() . "' 
                WHERE IDpersona = " . intval($this->getIDpersona());
            
            if ($base->EjecutarBase($consultaPersona)) {
                $consultaResponsableV = "UPDATE ResponsableV SET 
                    numLicencia = '" . $this->getnumLicencia() . "' 
                    WHERE numEmpleado = " . intval($this->getnumEmpleado());
                
                if ($base->EjecutarBase($consultaResponsableV)) {
                    $resp = true;
                } else {
                    $this->setMensaje("ResponsableV->modificar: " . $base->getERROR());
                }
            } else {
                $this->setMensaje("ResponsableV->modificar (Persona): " . $base->getERROR());
            }
        } else {
            $this->setMensaje("ResponsableV->modificar: " . $base->getERROR());
        }
        return $resp;
    }

    public function __toString() {
        return 
               "ResponsableV: " . $this->getNombrePersona() . " " . $this->getApellidoPersona() . "\n" .
               "numEmpleado: " . $this->getnumEmpleado() . "\n" .
               "numLicencia: " . $this->getnumLicencia() . "\n";
    }
}
