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
                text-align: center;
                /*                font-size: 1.2em;*/
            }
        </style>
    </head>
    <body>
        <?php
        /**
          @author Ismael Heras Salvador
          @since 4/11/2019
         */
        require '../config/constantes.php'; //requerimos las constantes para la conexion
        try {

            //conexion a la base de datos
            $miDB = new PDO(MAQUINA, USUARIO, PASSWD);
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            //mensaje por pantalla que todo ha ido bien
            echo "<h2>" . "Conexion PDO OK" . "</h2>";
            echo '<br>';

            $atributos = array(
                "AUTOCOMMIT", "ERRMODE", "CASE", "CLIENT_VERSION", "CONNECTION_STATUS",
                "ORACLE_NULLS", "PERSISTENT", "SERVER_INFO", "SERVER_VERSION"
            );
            foreach ($atributos as $val) {
                echo "PDO::ATTR_$val: ";
                echo $miDB->getAttribute(constant("PDO::ATTR_$val")) . '<br>';
            }                      
            
            echo '<br>';
       echo '<h2>conexion con error</h2>';
        '<br>';
        //conexion a la base de datos
        $miDB2 = new PDO('mysql:3300=http://192.168.1.245; dbname=DAW209DBdepartament','usuarioDBdepartamentos','pa');
        $miDB2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            //control de excepciones con la clase PDOException
        } catch (PDOException $miExceptionPDO) {
            //mostrar mensaje de errores
            echo'Error: ' . $miExceptionPDO->getMessage();
            echo'Código de error: ' . $miExceptionPDO->getCode();
        } finally {
            //cierre de conexion
            unset($miDB);
        }
        ?>



    </body>
</html>
