<?php

/* url: https://github.com/web-push-libs/web-push-php */

$url_base = "http://localhost";
//$url_base = "http://192.168.23.1";

$pag = filter_input(INPUT_GET, 'pag');

if($pag == ''){
  echo "Debe agregar el par&aacute;metro ?pag=x a la url.";
  exit;
}

$resp = [
  'error' => true,
  'mensaje' => 'Las notificaciones no pudieron ser enviadas.'
];


require './bdcon.php';

$conn = new DBConnection();
$pdo = $conn->connect();
//$pdo = new \PDO("sqlite:db.db");

if ($pdo != null && !is_string($pdo)){
  //echo '<div>Connected to the SQLite database successfully!</div>';
}else{
  $resp['mensaje'] = $pdo;
  echo json_encode($resp);
  exit;
}

$sql = 'select * from notificaciones where pagina = :pag order by id';
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':pag', $pag, PDO::PARAM_INT);

$stmt->execute();




require './vendor/autoload.php';

use Minishlink\WebPush\WebPush;
use Minishlink\WebPush\Subscription;

//arreglo de multiples notificaciones
$notificaciones = [];
while($fila = $stmt->fetch(\PDO::FETCH_ASSOC)){
  
  $payload = [
    'mensaje' => "Página {$fila['pagina']} actualizada para el navegador {$fila['navegador']}",
    'url' => $url_base."/pruebas/push-notification/pag{$fila['pagina']}.html"

  ];
  
  $notificaciones[] = [
    'subscription' => Subscription::create([
      'endpoint' => $fila['endpoint'], //endpoint
      'publicKey' => $fila['p256dh'], //p256dh
      'authToken' => $fila['auth'] //auth
    ]),
    'payload' => json_encode($payload)
  ];
}

//autenticacion del servidor
$auth = [
  'GCM' => 'MY_GCM_API_KEY', // deprecated and optional, it's here only for compatibility reasons
  'VAPID' => [
    'subject' => 'mailto:hugolizama22@gmail.com',
    'publicKey' => 'BJ-RnDbqhXzPxLWp1aEZk43hL4kreRg9XYrSsBzWS0OZ5qzEhI3GbGrjcr0AE2YJbKOUW_7ry2rhfA8vRGh1jVg',
    'privateKey' => 'YO9CUkXpIPCA1OdKwMDiEjC26OW5Y6oUkRNcLw-s0Tw'
  ],
];

//declaramos una nueva funcion webpush
$webPush = new WebPush($auth);


// enviar todas las notificaciones del arreglo
foreach ($notificaciones as $notif) {
  $webPush->sendNotification($notif['subscription'], $notif['payload']);
}


/**
 * Check sent results
 * @var MessageSentReport $report
 */
foreach ($webPush->flush() as $report) {
  $endpoint = $report->getRequest()->getUri()->__toString();

  if ($report->isSuccess()) {
    echo "[v] Message sent successfully for subscription {$endpoint}.<br/>";
  } else {
    echo "[x] Message failed to sent for subscription {$endpoint}: <pre>{$report->getReason()}</pre><br/>";
  }
}