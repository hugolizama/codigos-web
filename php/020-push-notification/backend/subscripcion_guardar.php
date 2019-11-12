<?php
header('Access-Control-Allow-Origin: *');

$resp = [
  'error' => true,
  'id' => 0,
  'mensaje' => 'El registro no pudo ser guardado.'
];

$subscripcion_json = filter_input(INPUT_GET, 'subscripcion');
$pag = filter_input(INPUT_GET, 'pag');
$navegador = filter_input(INPUT_GET, 'navegador');

if($subscripcion_json == '' || $pag == '' || $navegador == ''){
  $resp['mensaje'] = 'Los parámetros necesarios no fueron recibidos.';
  echo json_encode($resp);
  exit;
}

$subscripcion = json_decode($subscripcion_json);
/*echo "<pre>";
print_r($subscripcion);
echo "</pre>";
echo "<hr/>";*/


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
$p256dh = $subscripcion->keys->p256dh;
$auth = $subscripcion->keys->auth;

$sql = 'insert into notificaciones(endpoint, p256dh, auth, pagina, navegador) values (:endpoint, :p256dh, :auth, :pag, :navegador)';
$stmt = $pdo->prepare($sql);

$stmt->bindValue(':endpoint', $endpoint, PDO::PARAM_STR);
$stmt->bindValue(':p256dh', $p256dh, PDO::PARAM_STR);
$stmt->bindValue(':auth', $auth, PDO::PARAM_STR);
$stmt->bindValue(':pag', $pag, PDO::PARAM_INT);
$stmt->bindValue(':navegador', $navegador, PDO::PARAM_STR);

$stmt->execute();

//echo "<div>Ultimo id insertado: {$pdo->lastInsertId()}</div>";

if($pdo->lastInsertId() > 0){
  $resp = [
    'error' => false,
    'id' => $pdo->lastInsertId(),
    'mensaje' => 'El registro ha sido guardado.'
  ];  
}

echo json_encode($resp);




    
    
