CREATE DATABASE AsesoriasDB;
USE AsesoriasDB;

-- Tabla de roles
CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(50) NOT NULL
);

-- Tabla de usuarios
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role_id INT,
    FOREIGN KEY (role_id) REFERENCES roles(id)
);

-- Tabla de alumnos
CREATE TABLE alumnos (
    matricula INT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    apellido_pa VARCHAR(255) NOT NULL,
    apellido_ma VARCHAR(255) NOT NULL,
    grupo VARCHAR(50),
    semestre VARCHAR(50)
);

-- Tabla de maestros
CREATE TABLE maestros (
    matricula INT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    apellido_pa VARCHAR(255) NOT NULL,
    apellido_ma VARCHAR(255) NOT NULL,
    carrera VARCHAR(255)
);

-- Tabla de asesorías
CREATE TABLE asesorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    matricula_alumno INT,
    motivo_asesoria VARCHAR(255) NOT NULL,
    fecha_asesoria DATE,
    FOREIGN KEY (matricula_alumno) REFERENCES alumnos(matricula)
);
CREATE TABLE preguntas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pregunta TEXT NOT NULL
);

CREATE TABLE opciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_pregunta INT,
    opcion TEXT NOT NULL,
    FOREIGN KEY (id_pregunta) REFERENCES preguntas(id) ON DELETE CASCADE
);
CREATE TABLE respuestas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    id_pregunta INT,
    id_opcion INT,
    FOREIGN KEY (id_pregunta) REFERENCES preguntas(id),
    FOREIGN KEY (id_opcion) REFERENCES opciones(id)
);
CREATE TABLE asignaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pregunta_id INT,
    alumno_id INT,
    FOREIGN KEY (pregunta_id) REFERENCES preguntas(id),
    FOREIGN KEY (alumno_id) REFERENCES alumnos(matricula)
);
ALTER TABLE alumnos
ADD COLUMN user_id INT,
ADD FOREIGN KEY (user_id) REFERENCES users(id);

ALTER TABLE alumnos
ADD COLUMN fecha_nacimiento DATE,
ADD COLUMN licenciatura VARCHAR(100);

ALTER TABLE alumnos
ADD COLUMN email varchar(255),
ADD COLUMN telefono VARCHAR(100),
ADD COLUMN direccion varchar(100);
-- prueba
ALTER TABLE maestros
ADD COLUMN user_id INT,
ADD FOREIGN KEY (user_id) REFERENCES users(id);

ALTER TABLE preguntas
ADD COLUMN user_id INT,
ADD FOREIGN KEY (user_id) REFERENCES users(id);

ALTER TABLE asignaciones
ADD COLUMN user_id INT,
ADD FOREIGN KEY (user_id) REFERENCES users(id);

ALTER TABLE asignaciones
ADD COLUMN maestro_id INT,
ADD FOREIGN KEY (maestro_id) REFERENCES maestros(matricula);


ALTER TABLE respuestas
ADD COLUMN alumno_id INT,
ADD FOREIGN KEY (alumno_id) REFERENCES alumnos(matricula);


ALTER TABLE asignaciones
ADD COLUMN respuesta INT NOT NULL; 

ALTER TABLE asesorias
ADD COLUMN tipo_asesoria VARCHAR(50) NOT NULL;

ALTER TABLE asesorias
ADD COLUMN maestro_id INT,
ADD FOREIGN KEY (maestro_id) REFERENCES maestros(matricula);

ALTER TABLE respuestas
ADD COLUMN maestro_id INT,
ADD FOREIGN KEY (maestro_id) REFERENCES maestros(matricula);




-- Inserta roles de ejemplo
INSERT INTO roles (nombre) VALUES ('Admin'), ('Maestro'), ('Alumno');

INSERT INTO users (username, password, role_id) VALUES
('admin2', '$123', 1); -- Admin
select * from users;
drop database Asesoriasdb;
select * from alumnos;
select * from maestros;
SELECT * FROM roles;
SELECT * FROM respuestas;
SELECT username, password FROM users;
SELECT * FROM asignaciones WHERE alumno_id =202;
select * from asignaciones;
select * from asesorias;
SELECT r.id, r.id_pregunta, r.id_opcion, r.alumno_id, a.maestro_id
FROM respuestas r
JOIN asignaciones a ON r.id_pregunta = a.pregunta_id
WHERE a.maestro_id = 4;  -- Reemplaza '?' con el ID del maestro seleccionado
SELECT p.pregunta, o.opcion, m.nombre AS maestro_nombre
FROM asignaciones AS a
JOIN preguntas AS p ON a.pregunta_id = p.id
LEFT JOIN respuestas AS r ON r.id_pregunta = p.id AND r.alumno_id = a.alumno_id
LEFT JOIN opciones AS o ON r.id_opcion = o.id
JOIN maestros AS m ON a.maestro_id = m.matricula
JOIN users AS u ON a.user_id = u.id
WHERE a.user_id = 213129;
SELECT a.user_id, p.pregunta, o.opcion
FROM asignaciones AS a
JOIN preguntas AS p ON a.pregunta_id = p.id
LEFT JOIN respuestas AS r ON r.id_pregunta = p.id AND r.alumno_id = a.alumno_id
LEFT JOIN opciones AS o ON r.id_opcion = o.id
WHERE a.user_id = 4;
SELECT * FROM respuestas WHERE alumno_id = 2021060520;
SELECT * FROM asignaciones WHERE alumno_id = 202;
SELECT * FROM respuestas;

INSERT INTO respuestas (id_pregunta, alumno_id, id_opcion) 
VALUES (1, 202, 1);
SELECT * FROM asignaciones WHERE alumno_id = 2021060520;
DESCRIBE asesorias;
DESCRIBE maestros;
SELECT * FROM asesorias WHERE maestro_id = 1;

ALTER TABLE asignaciones MODIFY respuesta TEXT DEFAULT NULL;
SELECT matricula, nombre, apellido_pa, apellido_ma FROM maestros;

SELECT 
    al.nombre AS nombre_alumno, 
    al.apellido_pa AS apellido_pa, 
    al.apellido_ma AS apellido_ma, 
    asr.motivo_asesoria, 
    asr.fecha_asesoria, 
    asr.tipo_asesoria 
FROM asesorias asr
INNER JOIN alumnos al ON asr.matricula_alumno = al.matricula
WHERE asr.maestro_id = 213123;

select * from alumnos;
select * from maestros;

SELECT 
    p.id AS pregunta_id,
    p.pregunta AS texto_pregunta,
    a.maestro_id AS id_maestro
FROM preguntas p
JOIN asignaciones a ON p.id = a.pregunta_id;

SELECT * FROM asignaciones;

 SELECT p.pregunta, o.opcion
    FROM respuestas r
    JOIN preguntas p ON r.id_pregunta = p.id
    JOIN opciones o ON r.id_opcion = o.id
    WHERE r.alumno_id = 2021060520;
select * from preguntas;
select * from respuestas;
SELECT * FROM respuestas WHERE maestro_id = 213129;  -- Usa el ID del maestro que está logueado





