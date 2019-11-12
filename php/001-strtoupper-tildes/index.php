<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title></title>
  </head>
  <body>
    PRUEBA 1:<br/>
    strtoupper('sábado') = 
    <?php
    echo strtoupper('sábado');
    ?>
    <br/><br/>
    PRUEBA 2:<br/>
    strtoupper('quiñones') = 
    <?php
    echo strtoupper('quiñones');
    ?>
    <br/><br/>
    Forma correcta con <b>mb_strtoupper</b> <br/>
    
    PRUEBA 3:<br/>
    strtoupper('sábado') = 
    <?php
    echo mb_strtoupper('sábado','utf-8');
    ?>
    <br/><br/>
    PRUEBA 4:<br/>
    strtoupper('quiñones') = 
    <?php
    echo mb_strtoupper('quiñones','utf-8');
    ?>
  </body>
</html>
