<?php

// verificamos que los datos viene por el metodo post
if(filter_input(INPUT_POST, 'num1') && filter_input(INPUT_POST, 'num2')){
  //recogemos las variables
  $num1=filter_input(INPUT_POST, 'num1');
  $num2=filter_input(INPUT_POST, 'num2');

  //sumamos
  $resultado=$num1 + $num2;

  //imprimimos resultado
  echo "<div style='font-size: 20px; font-weight: bold; padding: 5px; border: 1px solid red;'>EL RESULTADO ES: ".$resultado. "<div>";
}