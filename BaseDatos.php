<?php

class BaseDatos {

    private $HOSTNAME;
    private $BASEDATOS;
    private $USUARIO;
    private $CLAVE;
    private $CONEXION;
    private $QUERY;
    private $RESULT;
    private $ERROR;

    public function __construct() {
        $this->HOSTNAME = "127.0.0.1";
        $this->BASEDATOS = "bdviajes";
        $this->USUARIO = "root";
        $this->CLAVE = "";
        $this->RESULT = null;
        $this->QUERY = "";
        $this->ERROR = "";
    }

    public function getHOSTNAME() {
        return $this->HOSTNAME; 
    }

    public function setHOSTNAME($HOSTNAME) {
        $this->HOSTNAME = $HOSTNAME;
    }

    public function getBASEDATOS() {
        return $this->BASEDATOS; 
    }

    public function setBASEDATOS($BASEDATOS) {
        $this->BASEDATOS = $BASEDATOS;
    }

    public function getUSUARIO() {
        return $this->USUARIO; 
    }

    public function setUSUARIO($USUARIO) {
        $this->USUARIO = $USUARIO;
    }

    public function getCLAVE() {
        return $this->CLAVE; 
    }

    public function setCLAVE($CLAVE) {
        $this->CLAVE = $CLAVE;
    }

    public function getCONEXION() {
        return $this->CONEXION; 
    }

    public function setCONEXION($CONEXION) {
        $this->CONEXION = $CONEXION;
    }

    public function getQUERY() {
        return $this->QUERY; 
    }

    public function setQUERY($QUERY) {
        $this->QUERY = $QUERY;
    }

    public function getRESULT() {
        return $this->RESULT; 
    }

    public function setRESULT($RESULT) {
        $this->RESULT = $RESULT;
    }

    public function getERROR() {
        return $this->ERROR; 
    }

    public function setERROR($ERROR) {
        $this->ERROR = $ERROR;
    }

    public function IniciarBase() {
        $conexion = mysqli_connect($this->HOSTNAME, $this->USUARIO, $this->CLAVE, $this->BASEDATOS);
        $resp = false;
        if ($conexion) {
            $resp = true;
            $this->setCONEXION($conexion);
        } else {
            $this->setERROR(mysqli_connect_error());
        }
        return $resp;
    }

    public function EjecutarBase($consulta) {
        $resp = false;
        $this->setQUERY($consulta);
        $this->setRESULT(mysqli_query($this->getCONEXION(), $consulta));

        if (!($this->getRESULT())) {
            $this->setERROR(mysqli_error($this->getCONEXION()));
        } else {
            $resp = true;
        }
        return $resp;
    }

    public function Registro() {
        $resp = null;
        if ($this->getRESULT()) {
            $this->setERROR("");
            if ($temp = mysqli_fetch_assoc($this->RESULT)) {
                $resp = $temp;
            } else {
                mysqli_free_result($this->RESULT);
            }
        } else {
            $this->setERROR(mysqli_errno($this->getCONEXION()) . ": " . mysqli_error($this->getCONEXION()));
        }
        return $resp;
    }

    public function devuelveIDInsercion($consulta) {
        $resp = null;
        $this->setQUERY($consulta);

        if ($this->IniciarBase()) {
            if ($this->RESULT = mysqli_query($this->getCONEXION(), $consulta)) {
                $resp = mysqli_insert_id($this->getCONEXION());
            } else {
                $this->setERROR(mysqli_error($this->getCONEXION()));
            }
        } else {
            $this->setERROR("Error al iniciar la conexión: " . $this->getERROR());
        }

        return $resp;
    }

}
