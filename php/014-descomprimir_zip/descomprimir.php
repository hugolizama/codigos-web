<?php
//creamos una instancia de ZipArchive
$zip = new ZipArchive;

//Asignamos el zip a decomprimir
$archivoZip = "kiuvox.zip";

//abrimos el zip
if ($zip->open($archivoZip) === TRUE) {

  //extraemos en una ruta
  //getcwd() es el directorio de trabajo actual
  $zip->extractTo(getcwd());

  //cerramos el zip
  $zip->close();

  echo 'Zip descomprimido!!';
} else {
  echo 'Zip no se ha encontrado!!';
}