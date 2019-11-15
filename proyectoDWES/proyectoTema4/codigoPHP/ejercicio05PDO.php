<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Ejercicio 5PDO</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../WEBBROOT/css/estilos5.css">
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
            $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); //para que puedan saltar las excepciones
            $miDB->setAttribute(PDO::ATTR_EMULATE_PREPARES, 0); //nos permite prepara consultas multiples
            //mensaje por pantalla que todo ha ido bien
            echo "<h2>" . "Conexion PDO OK" . "</h2>";
            echo '<br>';
            echo "<h2>" . "Insercion de tres registros con un beginTransacion y un comit. y detiene la insercion si algo ha ido mal con rollBack" . "</h2>";
            echo '<br>';


            //control de excepciones con la clase PDOException solo de la conexion.
        } catch (PDOException $miExceptionPDO) {
            // Revierte o deshace los cambios
            //mostrar mensaje de errores
            echo'Error: ' . $miExceptionPDO->getMessage();
            echo'<Código de error: ' . $miExceptionPDO->getCode();
        }

        try {



            //consulta preparada
            $sql = "INSERT INTO Departamentos VALUES (:cod, :desc)";
            //guardamos la consulta en un objeto de la clase PDOstatement
            $resultadoConsulta = $miDB->prepare($sql);
            //Deshabilitamos  el modo autocommit
            $miDB->beginTransaction();
            //realizamos un array de arrays para imntroducir los valores a la consulta.
            $aInsert = array(
                array('cod' => 'PPP', 'desc' => 'soy ismael'),
                array('cod' => 'JST', 'desc' => 'soy jose'),
                array('cod' => 'PRJ', 'desc' => 'soy pedro'),
            );

            //se realiza el foreach con la consulta preparada para insertar los valores en la tabla.
            foreach ($aInsert as $value) {
                $resultadoConsulta->execute(array(':cod' => $value["cod"], ':desc' => $value["desc"]));
            }
            echo "<br>";
            //Confirma los cambios y los consolida
            $miDB->commit();

            //mostramos por pantalla los insert que queremos realizar
            echo "<h1>" ."Estos son los inserts que queremos realizar". "</h1>";
            echo "'cod'=> 'PPP','desc'=>'soy ismael'";
            echo "<br>";
            echo "'cod'=> 'JST','desc'=>'soy jose'";
            echo "<br>";
            echo "'cod'=> 'PRJ','desc'=>'soy pedro'";

            echo "<h2>" . "Insercion realizada con exito" . "</h2>";
            echo '<a href="ejercicio2PDO.php">Pulse aqui para comprobar la insercion</a>';
        } catch (Exception $miExceptionPDO) {
            echo "<h1>Se ha producido un error</h1>";
            if ($miExceptionPDO->getCode() == 1045) { //codigo de error de conexion
                echo "<h4>Conexion fallida</h4>";
            } else {
                echo "<p>Error,Inserción Fallida, Clave primaria duplicada</p>";
                // Revierte o deshace los cambios si hay un solo fallo en la insercion.
                $miDB->rollBack();           
                  //mostramos por pantalla los insert que queremos realizar
            echo "<h1>" ."Estos son los inserts que queriamos realizar". "</h1>";
            echo "'cod'=> 'PPP','desc'=>'soy ismael'";
            echo "<br>";
            echo "'cod'=> 'JST','desc'=>'soy jose'";
            echo "<br>";
            echo "'cod'=> 'PRJ','desc'=>'soy pedro'";
                echo "<h2>" . "Insercion realizada sin exito" . "</h2>";
                echo '<a href="ejercicio2PDO.php">Pulse aqui para comprobar que  la insercion no se realizo</a>';
            }
        } finally {
            //cierre de la conexion
            unset($miDB2);
        }
        ?>
    </body>
</html>
