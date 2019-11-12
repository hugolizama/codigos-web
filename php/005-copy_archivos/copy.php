<?php
$ruta='carpeta1/';
$destino='carpeta2/';
$archivos=  glob($ruta.'*.*');

foreach ($archivos as $archivo){
  $archivo_copiar=  str_replace($ruta, $destino, $archivo);
  copy($archivo, $archivo_copiar);
}

echo "termino";