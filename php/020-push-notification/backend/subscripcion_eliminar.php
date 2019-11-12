<?php
header('Access-Control-Allow-Origin: *');

$resp = [
  'error' => true,
  'mensaje' => 'El registro no pudo ser eliminado.'
];

$id = filter_input(INPUT_GET, 'id');

if($id == ''){
  $resp['mensaje'] = 'Los parámetros necesarios no fueron recibidos.';
  echo json_encode($resp);
  exit;
}



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


  $sql = 'delete from notificaciones where id = :id';
  $stmt = $pdo->prepare($sql);

  $stmt->bindValue(':id', $id, PDO::PARAM_INT);

  $stmt->execute();
  
  if($stmt->rowCount() > 0){
    $resp = [
      'error' => false,
      'mensaje' => 'El registro fue eliminado.'
    ];
    
  }else{
    $resp['mensaje'] = 'El registro no existe en la base de datos.';
  }
  

echo json_encode($resp);




    
    
