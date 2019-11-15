/*
*autor: ismael heras
*fecha: 4/11/2019
*/


--creamos la base de datos 
create database IF NOT EXISTS DAW209DBdepartamentos;

--la usamos
use DAW209DBdepartamentos;

--creamos una tabla Departamentos si no existe, con los campos CodDepartamento(como clave privada) y descDepartamento.
create table IF NOT EXISTS Departamentos(
CodDepartamento varchar(4),
DescDepartamento varchar(100),
primary key (CodDepartamento))engine=innodb;

--creamos un usuario y una contraseña
CREATE USER 'usuarioDBdepartamentos'@'%' IDENTIFIED BY 'paso';

--le damos privilegios sobre la base de datos que ceamos y a la tabla.
GRANT ALL PRIVILEGES ON DAW209DBdepartamentos . Departamentos TO 'usuarioDBdepartamentos'@'%';

--recargamos los privilegios
FLUSH PRIVILEGES;

--mostramos las tablas de la bas e datos que  hemos creado.
show tables;
--mostramos los campos de las tablas
describe Departamentos;