<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title></title>
  </head>
  <body>
    <?php
    //incluimos la libreria
    include "lib_fecha_texto.php";

    //llamamos a la funcion y pasamos como paramentro una fecha
    //con el formato dd/mm/yyyy
    $fecha_texto = fechaATexto("16/04/2015");

    //imprimirmos el resultado
    echo "Fecha a texto: <strong>$fecha_texto</strong>";
    ?>
  </body>
</html>
