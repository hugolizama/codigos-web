<?php
$captcha = filter_input(INPUT_POST, 'captcha'); //respuesta del captcha

//inicio un codigo y mensaje de error
$respuesta = ['cod'=>0, 'mensaje'=>'<span style="color:red; font-size: 12px;">El captcha no fue verificado<span>'];

//opciones para evitar verificacion ssl
$arrContextOptions = array(
  "ssl" => array(
    "verify_peer" => false,
    "verify_peer_name" => false,
  ),
);

//llamada a la api de google que nos devuelve una cadena json con la respuesta si la verificacion fue exitosa
$verif=file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=6Lc4KRATAAAAALN5MyljS9sLuCyo_J1_v5JWGD0b&response=".$captcha."&remoteip=".$_SERVER['REMOTE_ADDR'], false, stream_context_create($arrContextOptions));
$obj = json_decode($verif);

//si el campo success es true entonces todo salio bien =)
if($obj->success==true){ //captcha verificado con exito
  $respuesta = ['cod'=>1, 'mensaje'=>'<span style="color:green; font-size: 12px;">Chan chan, no eres un robot, felicidades!!<span>'];
}

//respuesta con el codigo y mensaje
echo json_encode($respuesta);