<?php

//ejemplo 1
$texto_html="<div><a href='#'><b>Este es un texto</b></a></div>";
$texto_limpio= strip_tags($texto_html);
echo $texto_limpio;

echo "<br/><br/>";

//ejemplo 2
$texto_html="<div><a href='#'><b><i>Este es un texto</i></b></a></div>";
$texto_limpio= strip_tags($texto_html,"<i></i><b></b>");
echo $texto_limpio;

?>
