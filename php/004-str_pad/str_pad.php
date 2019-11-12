<?php

$original="blog kiuvox";

//relleno derecha
echo str_pad($original, 20, ":", STR_PAD_RIGHT)."<br>";   

//relleno izquierda
echo str_pad($original, 20, ":", STR_PAD_LEFT)."<br>";  

//relleno ambos lados
echo str_pad($original, 20, ":", STR_PAD_BOTH);   