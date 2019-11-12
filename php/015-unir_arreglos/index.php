<?php

$array1 = ['a'=>1, 'b'=>2, 'c'=>3];
$array2 = ['c'=>4, 'd'=>5, 'e'=>6];
$array3 = ['f'=>7, 'g'=>8, 'h'=>9];


$merge1 = array_merge($array1, $array2, $array3); 

echo "<pre>";
print_r($merge1);
echo "</pre>";


$merge2 = array_merge_recursive($array1, $array2, $array3);

echo "<pre>";
print_r($merge2);
echo "</pre>";