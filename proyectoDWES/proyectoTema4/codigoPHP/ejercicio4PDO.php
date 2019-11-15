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
        <link rel="stylesheet" href="../WEBBROOT/css/estilos4.css">
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
        $aErrores['DescDepartamentos'] = null;
        //manejo de las variables del formulario
        $aFormulario ['DescDepartamentos'] = null;

        if (isset($_POST['enviar'])) {
            //La posición del array de errores recibe el mensaje de error si hubiera.
            $aErrores['DescDepartamentos'] = validacionFormularios::comprobarAlfabetico($_POST['DescDepartamentos'], 255, 1, 1);
            $aFormulario ['DescDepartamentos'] = $_POST['DescDepartamentos'];
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
        ?>
        <h1 class="h2">Buscar coincidencias en la descripcion en la tabla departamento</h1>
        <br>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
            <fieldset>
                <div class="obligatorio">
                    BUSCAR: <br>
                    <input type="text" name="DescDepartamentos" placeholder="Introduce coincidencia con departamento" id="buscar" value="<?php
                    if ($aErrores['DescDepartamentos'] == NULL && isset($_POST['DescDepartamentos'])) {
                        echo $_POST['DescDepartamentos'];
                    }
                    ?>"><br> <!--//Si el valor es bueno, lo escribe en el campo-->
                           <?php if ($aErrores['DescDepartamentos'] != NULL) { ?>
                        <div class="error">
                            <?php echo $aErrores['DescDepartamentos']; //Mensaje de error que tiene el array aErrores       ?>
                        </div>   
                    <?php } ?>                
                </div>
                <br>                 
                <br>
                <div>
                    <input type="submit" name="enviar" value="Enviar" id="enviar">
                </div>
            </fieldset>
        </form>
        <?php
        //estructura de control que nos indica que si un error es null y el array formulario diferente de null se ejecuta la instruccion
        if ($aErrores['DescDepartamentos'] == null && $aFormulario['DescDepartamentos'] != null) {
            try {
                //conexion a la base de datos
                $miDB = new PDO(MAQUINA, USUARIO, PASSWD);
                //mensaje por pantalla que todo ha ido bien
                $miDB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo '<br>';
                echo '<br>';
                //instruccion sql para saber las coincidencias
                $sql = "SELECT * FROM Departamentos where DescDepartamento LIKE '%" . $aFormulario["DescDepartamentos"] . "%'";
                $sentencia = $miDB->prepare($sql);
                //ejecutamos la sentencia
                $sentencia->execute();
                //guardamos en una variable la instruccion sql
                $resultadoConsulta = $miDB->query($sql);
                echo "<h2>" . "Coincidencias de busqueda" . "</h2>";
      
                //if que se utiliza para mostrar la consulta o si el rowCount es 0 se ejecuta la consulta original para mostrar todos los registros
                if ($resultadoConsulta->rowCount() != 0) {
                    
                    //tabla para formatear la salida en formato tabla
                echo '<table border="1">';
                echo '<caption>Tabla(campo descripcion)</caption>';
                echo '<tr>';
                echo '<th>Descripción</th>';
                echo '</tr>';
                    //muestra los registros que coinciden en la sentencia sql
                    while ($oResultado = $resultadoConsulta->fetchObject()) {
                        echo '<tr>';
                        echo "<td>" . 'Descripcion - ' . $oResultado->DescDepartamento . "</td>";
                        echo '</tr>';
                    }
                } else {
                    //al tener un valor 0 rowCount se ejecuta esta else con la instruccion select * from Departamentos
                    try {
                        //conexion a la base de datos
                        $miDB2 = new PDO(MAQUINA, USUARIO, PASSWD);
                        //mensaje por pantalla que todo ha ido bien
                        $miDB2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        echo "<h2>" . "Sin coincidencias de busqueda" . "</h2>";
                        echo "<h2>" . "Mostramos de nuevo los Registros de la tabla Departamentos" . "</h2>";
                        echo '<br>';

                        //tabla para formatear la salida en formato tabla.
                        echo '<table border="1">';
                        echo '<caption>Tabla Departamentos</caption>';
                        echo '<tr>';
                        echo '<th>Código</th>';
                        echo '<th>Descripción</th>';
                        echo '</tr>';

                        $sql = "SELECT * FROM Departamentos";
                        $resultadoConsulta = $miDB2->query($sql);
                        //while que recorre los campos de la tabla
                        while ($campoTabla = $resultadoConsulta->fetchObject()) {
                            echo '<tr>';
                            echo "<td>" . '<b>' . $campoTabla->CodDepartamento . "</td>" . "<td>" . '</b>' . '<b>' . $campoTabla->DescDepartamento . "</td>";
                            echo '</tr>';
                        }
                        //control de excepciones con la clase PDOException
                    } catch (PDOException $miExceptionPDO) {
                        //mostrar mensaje de errores
                        echo'Error: ' . $miExceptionPDO->getMessage();
                        echo'Código de error: ' . $miExceptionPDO->getCode();
                    } finally {

                        //cierre de la conexion
                        unset($miDB2);
                    }
                }



                //control de excepciones con la clase PDOException
            } catch (PDOException $miExceptionPDO) {
                //mostrar mensaje de errores
                echo'Error: ' . $miExceptionPDO->getMessage();
                echo'Código de error: ' . $miExceptionPDO->getCode();
            } finally {
                //cierre de la conexion
                unset($miDB);
            }
        } else {
            //por defecto si no se ha marcado nada en el input se ejecutra esta instruccion.
            try {
                //conexion a la base de datos
                $miDB2 = new PDO(MAQUINA, USUARIO, PASSWD);
                //mensaje por pantalla que todo ha ido bien
                $miDB2->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                echo "<h2>" . "Registros de la tabla Departamentos" . "</h2>";
                echo '<br>';


                //tabla para formatear la salida en formato tabla.
                echo '<table border="1">';
                echo '<caption>Tabla Departamentos</caption>';
                echo '<tr>';
                echo '<th>Código</th>';
                echo '<th>Descripción</th>';
                echo '</tr>';

                $sql = "SELECT * FROM Departamentos";
                $resultadoConsulta = $miDB2->query($sql);
                //while que recorre los campos de la tabla
                while ($campoTabla = $resultadoConsulta->fetchObject()) {
                    echo '<tr>';
                    echo "<td>" . '<b>' . $campoTabla->CodDepartamento . "</td>" . "<td>" . '</b>' . '<b>' . $campoTabla->DescDepartamento . "</td>";
                    echo '</tr>';
                }
                //control de excepciones con la clase PDOException
            } catch (PDOException $miExceptionPDO) {
                //mostrar mensaje de errores
                echo'Error: ' . $miExceptionPDO->getMessage();
                echo'Código de error: ' . $miExceptionPDO->getCode();
            } finally {

                //cierre de la conexion
                unset($miDB2);
            }
            ?>
        <?php } ?>   
        <br/>
        <br/>
    </body>
</html>

















