<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Ejercicio 1b</title>
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
       //requerimos un archivo donde hemos guardado las constantes pra la conexion
       require '../tmp/constantes.php';
       //instanciamos el objeto
      $miDB = new mysqli();
      //creamos la conexion
       $miDB->connect(MAQUINA,USUARIO,PASSWD,BASEDATOS);
               
      //comprobamos si hay algin error
      if( $miDB->connect_errno){
          //mensaje si hay error
          die('Lo siento hubo un problema con la conexion');
      }else{
          //mensaje que la conexion ha sido exitosa
          echo "<h2>"."Conexion mysqli OK"."</h2>";
          //query de consulta
           $resultadoConsulta = $miDB->query('select * from Departamentos');         
            echo "<h3>"."La consulta de el codigo de departamento es la siguiente"."</h3>";
            echo '<br>';
            //foreach para mostrar los resultados de la consulta
            foreach ($resultadoConsulta as $filas) {
               echo $filas['CodDepartamento'].'<br>';
            }
      }      
      //cierre de la aconexion
      $miDB->close();
        ?>
    </body>
</html>