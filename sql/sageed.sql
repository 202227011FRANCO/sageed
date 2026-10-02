-- Base de datos SAGEED
CREATE DATABASE IF NOT EXISTS sageed CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sageed;

-- Tabla de empresas (Unidades Económicas)
CREATE TABLE IF NOT EXISTS empresas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    giro VARCHAR(255) NOT NULL,
    rfc VARCHAR(20) NOT NULL,
    contacto VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabla de mentores académicos
CREATE TABLE IF NOT EXISTS mentores_academicos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    area VARCHAR(255) NOT NULL,
    telefono VARCHAR(50),
    correo VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabla de mentores de UE
CREATE TABLE IF NOT EXISTS mentores_ue (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    empresa_id INT NOT NULL,
    cargo VARCHAR(255) NOT NULL,
    correo VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (empresa_id) REFERENCES empresas(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Tabla de estudiantes
CREATE TABLE IF NOT EXISTS estudiantes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    control VARCHAR(20) NOT NULL UNIQUE,
    curp VARCHAR(18) NOT NULL, 
    nombre VARCHAR(255) NOT NULL,
    genero ENUM('H','M') NOT NULL,
    carrera VARCHAR(255) NOT NULL,
    empresa_id INT,
    mentor_acad_id INT,
    mentor_ue_id INT,
    tipo_ingreso ENUM('Ingreso','Reingreso') DEFAULT 'Ingreso',
    estatus ENUM('ACTIVO','EGRESADO') DEFAULT 'ACTIVO',
    convenio_pdf VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (empresa_id) REFERENCES empresas(id) ON DELETE SET NULL,
    FOREIGN KEY (mentor_acad_id) REFERENCES mentores_academicos(id) ON DELETE SET NULL,
    FOREIGN KEY (mentor_ue_id) REFERENCES mentores_ue(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- Tabla de competencias
CREATE TABLE IF NOT EXISTS competencias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    carrera VARCHAR(255) NOT NULL,
    codigo VARCHAR(50) NOT NULL,
    descripcion TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Tabla de anexos subidos
CREATE TABLE IF NOT EXISTS anexos_subidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    estudiante_id INT NOT NULL,
    tipo_anexo VARCHAR(20) NOT NULL,
    nombre_archivo VARCHAR(255) NOT NULL,
    ruta_archivo VARCHAR(500) NOT NULL,
    fecha_carga TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (estudiante_id) REFERENCES estudiantes(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Datos de ejemplo
INSERT INTO empresas (nombre, giro, rfc, contacto) VALUES
('Chrysler de México S.A de C.V', 'Automotriz y Manufactura', 'CME721015T90', 'Lic. Laura Escamilla'),
('Bimbo Toluca SA', 'Alimenticio / Producción', 'BIM820304U10', 'Ing. Arturo Solís'),
('Softtek Toluca', 'Tecnologías de la Información', 'SOF901201A31', 'Mtra. Silvia Medina');

INSERT INTO mentores_academicos (nombre, area, telefono, correo) VALUES
('M. en C. Roberto Cruz Valdés', 'Sistemas Computacionales', '7221029384', 'roberto.cruz@tecnm.mx'),
('Dra. Elvia Ramos González', 'Ingeniería Industrial', '7223409123', 'elvia.ramos@tecnm.mx');

INSERT INTO mentores_ue (nombre, empresa_id, cargo, correo) VALUES
('Ing. Guillermo Vázquez Tapia', 1, 'Gerente de Desarrollo de Planta', 'guillermo.vazquez@chrysler.com'),
('Lic. Daniela Hernández Gil', 2, 'Coordinador de Calidad Humana', 'daniela.hernandez@bimbo.com');

INSERT INTO estudiantes (control, curp, nombre, genero, carrera, empresa_id, mentor_acad_id, mentor_ue_id, tipo_ingreso, estatus) VALUES
('19100234', 'REJS990101HMCMNNA1', 'José Eduardo Reyes Sánchez', 'H', 'Ingeniería en Sistemas Computacionales', 1, 1, 1, 'Ingreso', 'ACTIVO'),
('20100451', 'AAJM000202MMCMNNA2', 'Mariana Alarcón Jiménez', 'M', 'Ingeniería Industrial', 2, 2, 2, 'Reingreso', 'ACTIVO'),
('18100129', 'TOCC980303HMCMNNA3', 'Carlos Alberto Torres Cruz', 'H', 'Ingeniería Mecatrónica', 1, 1, 1, 'Ingreso', 'EGRESADO');

INSERT INTO competencias (carrera, codigo, descripcion) VALUES
('Ingeniería en Sistemas Computacionales', 'ISC-DB01', 'Modelar estructuras de almacenamiento optimizadas para el procesamiento transaccional rápido y seguro en ambientes industriales de Big Data.'),
('Ingeniería Industrial', 'IND-PR02', 'Optimizar flujos logísticos y cuellos de botella mediante herramientas de manufactura esbelta en la línea de ensamble principal.');