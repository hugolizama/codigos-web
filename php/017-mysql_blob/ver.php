<?php

//obtener el id de la imagen
$id=  filter_input(INPUT_GET, 'id');
if($id==''){
  die ("No tenemos el id");
}

//conectar a mysql---------
$conn = mysqli_connect('localhost', 'root', '', 'tutoriales-kiuvox') or die("Error al conectar al servidor");	
//---------------------------

$sql="SELECT ARCHIVO, TIPO FROM ARCHIVOS WHERE ID = $id";

//ejecutar la sentencia sql
$resultado = mysqli_query($conn, $sql) or die("Error: no se pudo hacer la consulta.");

while($row = mysqli_fetch_array($resultado)){
  $archivo= $row[0]; //obtener el archivo
  $tipo=$row[1]; //obtener el tipo de archivo
}

mysqli_close($conn);

//header para tranformar la salida en el tipo de archivo que hemos guardado
header("Content-type: $tipo"); 

//header('Content-Disposition: attachment; filename="archivo.pdf"'); //forzar a la descarga

//imprimir el archivo
echo $archivo;