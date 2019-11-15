<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Ejercicio 6PDO</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../WEBBROOT/css/estilos6.css">
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
            $sql = "INSERT INTO Departamentos VALUES (:cod, :desc)";
            
            
            //realizamos un array de arrays para imntroducir los valores a la consulta.
            $aInsert = array(
                array('cod'=> 'IHS','desc'=>'soy ismael'),
                 array('cod'=> 'HHH','desc'=>'soy pepito'),
                 array('cod'=> 'TTT','desc'=>'soy menganito'),
            );         
            //guardamos la consulta en un objeto de la clase PDOstatement
                $resultadoConsulta = $miDB->prepare($sql);
            
                //se realiza el foreach con la consulta preparada para insertar los valores en la tabla.
                foreach ($aInsert as $value) {
                    $resultadoConsulta->execute(array(':cod' => $value["cod"],':desc' => $value["desc"]));
                }

            echo '<h1>Se han realizado tres inserciones</h1>';

            //hacemos la consulta a la base de datos.
           $sql = ('select * from Departamentos');
            $resultadoConsulta = $miDB->query($sql);
                    

            echo "<h3>" . "Las inserciones se han realizado con un array en el execute" . "</h3>";
            echo '<br>';
           
            //mostramos por pantalla los insert que queremos realizar
            echo "<h1>" ."Estos son los inserts que queremos realizar". "</h1>";
            echo '<br>';
            echo "'cod'=> 'IHS','desc'=>'soy ismael'";
            echo "<br>";
            echo "'cod'=> 'HHH','desc'=>'soy pepito'";
            echo "<br>";
            echo "'cod'=> 'TTT','desc'=>'soy menganito'";
            echo "<br>";
             echo "<br>";
            
              //tabla para formatear la salida en formato tabla.
        echo '<table border="1">';
        echo '<caption>Tabla Departamentos</caption>';
        echo '<tr>';
        echo '<th>Código</th>';
        echo '<th>Descripción</th>';
        echo '</tr>';

         echo "<h2>" . "Tabla con los insert realizados" . "</h2>";
            echo '<br>';
            //dentro del while realizamos un FechObject y extraemos toda la informacion del objeto
            while ($campoTabla = $resultadoConsulta->fetchObject()) {
                echo '<tr>';
                echo "<td>" . '<b>' . $campoTabla->CodDepartamento ."</td>". "<td>".'</b>' .'<b>' . $campoTabla->DescDepartamento ."</td>";
                echo '</tr>';
            }
            //control de excepciones con la clase PDOException
        } catch (PDOException $miExceptionPDO) {
 echo "<h1>Se ha producido un error</h1>";
            if($miExceptionPDO->getCode() == 23000 || $miExceptionPDO->getCode() == 2002 ){
                echo "<h4>Error, Duplicado de clave primaria</h4>";
            }
        } finally {
            //cierre de conexion
            unset($miDB);
        }
        ?>
    </body>
</html>
