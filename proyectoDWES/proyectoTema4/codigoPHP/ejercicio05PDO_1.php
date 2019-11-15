<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Luis Mateo Rivera Uriarte</title>
        <meta name="author" content="Luis Mateo Rivera Uriarte">
        <meta name="date" content="06-11-2019">
        <link rel="stylesheet" type="text/css" href="../webroot/css/styles.css" media="screen">
        <link rel="icon" type="image/png" href="../../../mifavicon.png">
        <style>
            form{
                width: 25%;
            }
            .obligatorio input{
                background-color: lightblue;
            }
            .error{
                background-color: #ff708c;
                transition: 10s;
                width: 30%;
                padding: 0.5%;
                border-radius: 10%;
            }
            .codigo{
                width: 10%;
            }
            .tabla{
                color: blue;
            }
        </style>
    </head>
    <body>  
        <h1>
            Inserción con una transacción
        </h1>
        <?php
        /**
          @author Luis Mateo Rivera Uriate
          @since 07/11/2019
         */
        try{
            $miBD = new PDO('mysql:host=192.168.20.19:33;dbname=DAW215DBdepartamentos', 'usuarioDAW215DBdepartamentos', 'paso');
            $miBD->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            //Inicializamos un array que contenga las 3 inserciones
            $aInserciones = array(
                "INSERT INTO Departamentos VALUES ('UUU', 'Transacción del U');", 
                "INSERT INTO Departamentos VALUES ('III', 'Transacción del I');", 
                "INSERT INTO Departamentos VALUES ('OOO', 'Transacción del O');");
            $miBD->beginTransaction();
                $miBD->exec($aInserciones[0]);
                $miBD->exec($aInserciones[1]);
                $miBD->exec($aInserciones[2]);
                
                $miBD->commit();

                echo "<h3>La transacción con las 3 funcionó correctamente</h3>";

            ?>
            <br/>
            <br/>
        <?php
        }catch(PDOException $excepcion){
            echo "<h1>Se ha producido un error, disculpe las molestias</h1>";
            if($excepcion->getCode() == 1045 || $excepcion->getCode() == 2002){ //codigo de error de conexion
                echo "<h4>No se ha podido establecer la conexión a la base de datos</h4>";
            }else{
                echo "<h4>Se ha producido un error en la inserción</h4>";
                $miBD->rollBack();
            }
        }finally{
            unset($miBD);
        }
        ?>
        <footer>
            <p>
                <a href="../../../..">
                    © Luis Mateo Rivera Uriarte 2019-2020
                </a>
            </p>
        </footer>
    </body>
</html>