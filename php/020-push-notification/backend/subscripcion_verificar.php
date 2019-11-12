<?php
/* Verificar si el usuario se ha subscripto a mas de una pagina, de ser asi solo se permite eliminar el registro 
de la base de datos en lugar de la subcripción de notificaciones a todo el sitio */

header('Access-Control-Allow-Origin: *');

$resp = [
  'error' => true,
  'permiso' => null,
  'mensaje' => 'El registro no pudo ser verificado.'
];

$subscripcion_json = filter_input(INPUT_GET, 'subscripcion');

if($subscripcion_json == ''){
  $resp['mensaje'] = 'Los parámetros necesarios no fueron recibidos.';
  echo json_encode($resp);
  exit;
}


$subscripcion = json_decode($subscripcion_json);
//echo "<pre>";
//print_r($subscripcion);
//echo "</pre>";
//echo "<hr/>";


require './bdcon.php';

$conn = new DBConnection();
$pdo = $conn->connect();

if ($pdo != null && !is_string($pdo)){
  //echo '<div>Connected to the SQLite database successfully!</div>';
}else{
  $resp['mensaje'] = $pdo;
  echo json_encode($resp);
  exit;
}

$endpoint = $subscripcion->endpoint;

$sql = 'select count(*) as contador from notificaciones where endpoint = :endpoint';
$stmt = $pdo->prepare($sql);

$stmt->bindValue(':endpoint', $endpoint, PDO::PARAM_STR);

$stmt->execute();

$contador = $stmt->fetch(PDO::FETCH_ASSOC)['contador'];

$resp['error'] = false;
if($contador > 1){ //si esta suscrito a mas de una pagina solo borrar el registro de la base
  $resp['permiso'] = false;
  $resp['mensaje'] = 'Solo borrar registro de la base de datos.';
}else{
  $resp['permiso'] = true;
  $resp['mensaje'] = 'Eliminar subscripción y borrar registro de la base de datos.';
}

echo json_encode($resp);