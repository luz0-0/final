CREATE DATABASE IF NOT EXISTS bdviajes;

USE bdviajes;

CREATE TABLE IF NOT EXISTS Empresa (
    IDempresa BIGINT AUTO_INCREMENT,
    nombreEmpresa VARCHAR(150),
    direccionEmpresa VARCHAR(150),
    PRIMARY KEY (IDempresa)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS ResponsableV (
    IDempleado BIGINT AUTO_INCREMENT,
    IDlicencia BIGINT,
    nombrePersona VARCHAR(150), 
    apellidoPersona VARCHAR(150), 
    PRIMARY KEY (IDempleado)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS Viaje (
    IDviaje BIGINT AUTO_INCREMENT, /*codigo de viaje*/
    destinoViaje VARCHAR(150),
    cantMaxPasajeros INT,
    IDempresa BIGINT,
    IDempleado BIGINT,
    importeViaje FLOAT,
    PRIMARY KEY (IDviaje),
    FOREIGN KEY (IDempresa) REFERENCES Empresa (IDempresa)
        ON UPDATE CASCADE ON DELETE CASCADE,
    FOREIGN KEY (IDempleado) REFERENCES ResponsableV (IDempleado)
        ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;

CREATE TABLE IF NOT EXISTS Pasajero (
    IDpasajero VARCHAR(15),
    nombrePersona VARCHAR(150), 
    apellidoPersona VARCHAR(150), 
    telefonoPasajero VARCHAR(15), 
    IDviaje BIGINT,
    PRIMARY KEY (IDpasajero),
    FOREIGN KEY (IDviaje) REFERENCES Viaje (IDviaje)
        ON UPDATE CASCADE ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS Persona (
    nombrePersona VARCHAR(150), 
    apellidoPersona VARCHAR(150),
    IDpersona VARCHAR(15),
    PRIMARY KEY (IDpersona)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
