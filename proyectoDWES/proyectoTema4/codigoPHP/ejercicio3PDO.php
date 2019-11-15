<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Ejercicio 3PDO</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../WEBBROOT/css/estilos3.css">
    </head>
    <body>
        <?php
        /**
          @author Ismael Heras Salvador
          @since 6/11/2019
         */
        require '../core/validacionFormularios.php'; //importamos la libreria de validacion  
        require '../config/constantes.php'; //requerimos las constantes para la conexion
        $entradaOK = true; //Inicializamos una variable que nos ayudara a controlar si todo esta correcto
        //manejo del control de errores.
        $aErrores = ['CodDepartamentos' => null,
            'DescDepartamentos' => null];
        //manejo de las variables del formulario
        $aFormulario = ['CodDepartamentos' => null,
            'DescDepartamentos' => null];

        if (isset($_POST['enviar']) && $_POST['enviar'] == 'Enviar') {
            //La posición del array de errores recibe el mensaje de error si hubiera.
            $aErrores['CodDepartamentos'] = validacionFormularios::comprobarAlfabetico($_POST['CodDepartamentos'], 4, 1, 1);
            $aErrores['DescDepartamentos'] = validacionFormularios::comprobarAlfabetico($_POST['DescDepartamentos'], 300, 1, 1);
            //foreach para recorrer el array de errores
            foreach ($aErrores as $campo => $error) {
                if (!is_null($error)) {
                    $_REQUEST[$campo] = "";
                    $entradaOK = false;
                }
            }
        } else {
            $entradaOK = false;
        }

        if ($entradaOK) {
            try {
                //conexion a la base de datos
                $miDB = new PDO(MAQUINA, USUARIO, PASSWD);
                //mensaje por pantalla que todo ha ido bien
                $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo "<h2>" . "Conexion PDO OK" . "</h2>";
                echo '<br>';

                echo "<br>";
                $sql = "select *from Departamentos";
                $resultadoConsulta = $miDB->query($sql);

                //tabla para formatear la salida en modo tabla.
                echo '<table border="1">';
                echo '<caption>Tabla Departamentos</caption>';
                echo '<tr>';
                echo '<th>Código</th>';
                echo '<th>Descripción</th>';
                echo '</tr>';
                echo '<h2>' . "Los campos de la tabla Departamentos antes de hacer la inseccion son: " . $resultadoConsulta->rowCount() . '</h2>';

                //dentro del while realizamos un FechObject y extraemos toda la informacion del objeto
                while ($campoTabla = $resultadoConsulta->fetchObject()) {
                    echo '<tr>';
                    echo "<td>" . '<b>' . $campoTabla->CodDepartamento . "</td>" . "<td>" . '</b>' . '<b>' . $campoTabla->DescDepartamento . "</td>";
                    echo '</tr>';
                }
                echo "<br>";
                //consulta preparada para ingresar valores a la tabla
                $sql = "INSERT INTO Departamentos (CodDepartamento, DescDepartamento) VALUES(:CodDepartamento, :DescDepartamento)";
                $sentencia = $miDB->prepare($sql);
                //con el bind param introducimos en la sentencia preparada el valor del campo del formulario
                $sentencia->bindParam(":CodDepartamento", $_POST["CodDepartamentos"]);
                $sentencia->bindParam(":DescDepartamento", $_POST["DescDepartamentos"]);
                $sentencia->execute();


                echo "<br>";

                //consulta para saber los datos de la tabla.
                $sql = "select *from Departamentos";
                $resultadoConsulta = $miDB->query($sql);

                echo '<table border="1">';
                echo '<caption>Tabla Departamentos</caption>';
                echo '<tr>';
                echo '<th>Código</th>';
                echo '<th>Descripción</th>';
                echo '</tr>';

                echo "<br>";
                //hacemos un rowCount para saber el numero de registros de la tabla.
                echo '<h2>' . "Los campos de la tabla Departamentos despues de hacer la inseccion son: " . $resultadoConsulta->rowCount() . '</h2>';
                //dentro del while realizamos un FechObject y extraemos toda la informacion del objeto
                while ($campoTabla = $resultadoConsulta->fetchObject()) {
                    echo '<tr>';
                    echo "<td>" . '<b>' . $campoTabla->CodDepartamento . "</td>" . "<td>" . '</b>' . '<b>' . $campoTabla->DescDepartamento . "</td>";
                    echo '</tr>';
                }


             //control de excepciones con la clase PDOException
        } catch (PDOException $miExceptionPDO) {
        echo "<h1>Se ha producido un error</h1>";
      
        if ($miExceptionPDO->getCode() == 23000 || $miExceptionPDO->getCode() == 2002) {
        echo "<h4>Error, Duplicado de clave primaria</h4>";
        }
        } finally {
        //cierre de conexion
        unset($miDB);
        }
            echo "<br>";
        } else {
            //Mostrar el formulario hasta que se rellene correctamente
            ?>
            <h1 class="h1">formulario para insertar campos en la tabla Departamentos</h1>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
                <fieldset>
                    <div class="obligatorio">
                        CODIGO: 
                        <input type="text" name="CodDepartamentos" placeholder="Alfabetico" value="<?php
                        if ($aErrores['CodDepartamentos'] == NULL && isset($_POST['CodDepartamentos'])) {
                            echo $_POST['CodDepartamentos'];
                        }
                        ?>"><br> <!--//Si el valor es bueno, lo escribe en el campo-->
                               <?php if ($aErrores['CodDepartamentos'] != NULL) { ?>
                            <div class="error">
                                <?php echo $aErrores['CodDepartamentos']; //Mensaje de error que tiene el array aErrores      ?>
                            </div>   
                        <?php } ?>                
                    </div>
                    <br>
                    <div class="obligatorio">
                        DESCRIPCION: 
                        <input type="text" name="DescDepartamentos" placeholder="Alfabetico" value="<?php
                        if ($aErrores['DescDepartamentos'] == NULL && isset($_POST['DescDepartamentos'])) {
                            echo $_POST['DescDepartamentos'];
                        }
                        ?>"><br> <!--//Si el valor es bueno, lo escribe en el campo-->
                               <?php if ($aErrores['DescDepartamentos'] != NULL) { ?>
                            <div class="error">
                                <?php echo $aErrores['DescDepartamentos']; //Mensaje de error que tiene el array aErrores      ?>
                            </div>   
                        <?php } ?>                
                    </div>
                    <br>
                    <div>
                        <input type="submit" name="enviar" value="Enviar">
                    </div>
                </fieldset>
            </form>
        <?php } ?>   
        <br/>
        <br/>
     
    </body>
</html>

















