<?php

//recuperamos las variables enviadas por ajax
$num1 = filter_input(INPUT_POST, 'num1');
$num2 = filter_input(INPUT_POST, 'num2');

//Las utilizamos como necesitemos
$data = array(
  'res' => ($num1 + $num2)
);


//Imprimir los datos como una cadena JSON
echo json_encode($data);