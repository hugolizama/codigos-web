<?php
//librerias requeridas
require_once('barcode_gen/class/BCGFontFile.php');
require_once('barcode_gen/class/BCGColor.php');
require_once('barcode_gen/class/BCGDrawing.php');
require_once('barcode_gen/class/BCGean13.barcode.php');

// Definiendo colores y fuente
$colorFront = new BCGColor(0, 0, 0);
$colorBack = new BCGColor(255, 255, 255);
$font = new BCGFontFile('barcode_gen/font/Arial.ttf', 16);

$code = new BCGean13(); //iniciar nuevo codigo
$code->setScale(8); //escala o tamanio
$code->setThickness(8); // modifica el alto
$code->setForegroundColor($colorFront); // color de las barras
$code->setBackgroundColor($colorBack); // color de fondo
$code->setFont($font); // tipo de letra
$code->parse('123456789012'); // codigo de 12 digitos

/***************CODIGO PARA AGREGAR ETIQUETA ADICIONAL****************/
$code->setOffsetY(1); //agregamos un pequeno espacio arriba del label

$label = new BCGLabel(); //creamos instancia del label
$label->setText('Blog Kiuvox - blog.kiuvox.com'); //asignamos texto
$label->setFont($font); //asignamos la fuente
$label->setPosition(BCGLabel::POSITION_TOP); //establecemos la posicion

$code->addLabel($label); //agregamos el label a la imagen
/***********FIN CODIGO PARA AGREGAR ETIQUETA ADICIONAL****************/

$drawing = new BCGDrawing('', $colorBack);
$drawing->setDPI(100);
$drawing->setBarcode($code);

/*guardar imagen en disco pero hay que comentar header*/
//$drawing->setFilename('one.png');

$drawing->draw(); // genera la imagen

/*Vista de la imagen en el navegador pero hay que comentar setFileName*/
header('Content-Type: image/png');
$drawing->finish(BCGDrawing::IMG_FORMAT_PNG); //formato de generacion
