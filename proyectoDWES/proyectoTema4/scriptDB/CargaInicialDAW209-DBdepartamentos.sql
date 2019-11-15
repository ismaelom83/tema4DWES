/*
*autor: ismael heras
*fecha: 4/11/2019
*/
--base de datos a insertar
use DAW209DBdepartamentos;
--hacemos un insert into a la tabla Departamentos que habiamos.
insert into Departamentos values
(

'DWES','Desarrollo WEB entorno servidor'),

('DWEC','Desarrollo WEB entorno cliente'),

('DAW','Despliege de aplicaciones WEB'),

('DIW','Desarrollo interfaces WEB'),

('EIE','Empresa e inciativa Emprendedora');

--mostramos todos los valores que hemos introducido.
SELECT * FROM Departamentos;