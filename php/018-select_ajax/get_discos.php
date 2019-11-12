<?php
require_once './con_db.php'; //libreria de conexion a la base

$banda_id = filter_input(INPUT_POST, 'banda_id'); //obtenemos el parametro que viene de ajax

if($banda_id != ''){ //verificamos nuevamente que sea una opcion valida
  $con = conDb();
  if(!$con){
    die("<br/>Sin conexi&oacute;n.");
  }
  
  /*Obtenemos los discos de la banda seleccionada*/
  $sql = "select id, nombre from discos where banda_id = ".$banda_id;  
  $query = mysqli_query($con, $sql);
  $filas = mysqli_fetch_all($query, MYSQLI_ASSOC); 
  mysqli_close($con);
}

/**
 * Como notaras vamos a generar codigo html, esto es lo que sera retornado a ajax para llenar 
 * el combo dependiente
 */
?>

<option value="">- Seleccione -</option>
<?php foreach($filas as $op): //creamos las opciones a partir de los datos obtenidos ?>
<option value="<?= $op['id'] ?>"><?= $op['nombre'] ?></option>
<?php endforeach; ?>