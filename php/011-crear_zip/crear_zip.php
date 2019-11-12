<?php

//creamos una instancia de ZipArchive
$zip = new ZipArchive();

//ruta donde guardar los archivos zip, la creamos sino existe
$rutaFinal = "archivos";

if(!file_exists($rutaFinal)){
  mkdir($rutaFinal);
}

//Asignamos el nombre del archivo zip
$archivoZip = 'kiuvox.zip';

//Creamos y abrimos el archivo zip
if ($zip->open($archivoZip, ZIPARCHIVE::CREATE) === true) {

  //Agregamos los archivos uno a uno
  $zip->addFile("kiuvox.txt", "kiuvox.txt");
  $zip->addFile("Ejemplo para crear zip.txt", "Ejemplo para crear zip.txt");
  $zip->addFile("blog.kiuvox.com.txt", "blog.kiuvox.com.txt");

  //Cerramos el archivo zip
  $zip->close();

  //Muevo el archivo a una ruta
  //donde no se mezcle los zip con los demas archivos
  rename($archivoZip, "$rutaFinal/$archivoZip");

  //imrimimos un enlace para descargar el archivo zip
  echo "Descargar: <a href='$rutaFinal/$archivoZip'>$archivoZip</a>";
} else {
  echo 'Error creando ' . $archivoZip;
}
?>