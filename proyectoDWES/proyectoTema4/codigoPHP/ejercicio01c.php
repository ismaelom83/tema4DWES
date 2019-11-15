<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Ejercicio 1</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            *{
                
                font-size: 1.1em;
            }
        </style>
    </head>
    <body>

        <?php
        /**
          @author Ismael Heras Salvador
          @since 4/11/2019
         */
        try {
            //conexion a la base de datos
            $miDB = new PDO('mysql:3300=http://192.168.1.245; dbname=DAW209DBdepartament','usuarioDBdepartamentos','paso');
            //mensaje por pantalla que todo ha ido bien
            echo "<h2>"."Conexion PDO OK"."</h2>";
            echo '<br>';
            //selecccion del query
            $resultadoConsulta = $miDB->query('select * from Departamentos');
            
            echo "<h3>"."La consulta de la descripcion de el departamento es la siguiente"."</h3>";
            echo '<br>';
            //foreach para mostrar los resultados de la consulta
            foreach ($resultadoConsulta as $filas) {
               echo $filas['DescDepartamento'].'<br>';
            }
            //control de excepciones con la clase PDOException
        } catch (PDOException $miExceptionPDO) {
            //mostrar mensaje de errores
            echo'Error: ' . $miExceptionPDO->getMessage();
            echo'Código de error: ' . $miExceptionPDO->getCode();
        }
        
        //cierre de conexion
        unset($miDB); 
        ?>

    </body>
</html>
