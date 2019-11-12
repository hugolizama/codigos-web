<?php
/*En un arreglo agregar todos los datos a 
transportar al formulario */
$obj=array();
$obj['nombres']="Homero";
$obj['apellidos']="Simpson";
$obj['opciones']="<option value='1'>uno</option>"
  . "<option value='2'>dos</option>"
  . "<option value='3'>tres</option>";

//Imprimir los datos como una cadena JSON
echo json_encode($obj);