<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Ejercicio 8PDOjson</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../WEBBROOT/css/estilos8.css">
    </head>
    <body>    
        <?php
        /**
          @author Ismael Heras Salvador
          @since 12/11/2019
         */
         /*
          Exportacion JSON
         *          */
       
        require '../config/constantes.php'; //requerimos las constantes para la conexion
        try {
            //conexion a la base de datos
            $miDB = new PDO(MAQUINA, USUARIO, PASSWD);
            //mensaje por pantalla que todo ha ido bien
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $excepcionPDO) {
            die("Error al conectarse a la base de datos");
        }
        try {

            //preparamos una consulta preparada selecionando todos los registros de la tabla departamentos.
            $sql = "SELECT * FROM Departamentos";
            $consultaPreparada = $miDB->prepare($sql);
            $consultaPreparada->execute();

            //declaramos una variable array para introducir los registros de la tabla.
            $arrayJson = array();

            //while para darle formato al arcivo json con los registros de la tabla departamentos.
            while ($columnasBD = $consultaPreparada->fetch(PDO::FETCH_ASSOC)) {
                $arrayJson[] = $columnasBD;
            }                  
            //fretorna los datos en estructura json.
            $jEncodec = json_encode($arrayJson);
            //decimos la ruta y el nombre del archivo
            $archivoJSON = '../tmp/exportar.json';
            //escribe los datos en el fichero
            file_put_contents($archivoJSON, $jEncodec);

            echo '<br>';
            echo "<h2>" . "Exportacion de los archivos JSON correcta" . "</h2>";
            echo '<br>';
            echo '<a href="../tmp/">Pulse aqui para comprobar el  archivo json descargado</a>';
            //control de excepciones con la clase PDOException
        } catch (PDOException $miExceptionPDO) {
            //mostrar mensaje de errores
            echo'Error: ' . $miExceptionPDO->getMessage();
            echo'Código de error: ' . $miExceptionPDO->getCode();
        } finally {
            //cierre de la conexion
            unset($miDB);
        }
        ?>
    </body>
</html>
