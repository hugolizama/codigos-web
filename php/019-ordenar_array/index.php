<?php
$array1 = $array1_sort = $array1_rsort = $array1_asort =
  $array1_arsort = [0=>5,3,1,4,2];

$array2 = $array2_sort = $array2_rsort = $array2_asort =
  $array2_arsort = ['Sabaton', 'Freedom Call', 'Dimmu Borgir', 'Nightwish', 'Therion'];

echo "Originales:";
echo "<pre>";
print_r($array1);
print_r($array2);
echo "</pre><br/>";

echo "<b>sort:</b> Ordena por el valor de menor a mayor, no mantiene asociación con la llave.";
echo "<pre>";
sort($array1_sort);
print_r($array1_sort);

sort($array2_sort);
print_r($array2_sort);
echo "</pre><br/>";


echo "<b>rsort:</b> Ordena por el valor de mayor a menor, no mantiene asociación con la llave.";
echo "<pre>";
rsort($array1_rsort);
print_r($array1_rsort);

rsort($array2_rsort);
print_r($array2_rsort);
echo "</pre><br/>";


echo "<b>asort:</b> Ordena por el valor de menor a mayor, sí mantiene asociación con la llave.";
echo "<pre>";
asort($array1_asort);
print_r($array1_asort);

asort($array2_asort);
print_r($array2_asort);
echo "</pre><br/>";


echo "<b>arsort:</b> Ordena por el valor de mayor a menor, sí mantiene asociación con la llave.";
echo "<pre>";
arsort($array1_arsort);
print_r($array1_arsort);

arsort($array2_arsort);
print_r($array2_arsort);
echo "</pre><br/>";


//--------------------------------------------------------------

$k_array1 = $k_array1_ksort = $k_array1_krsort = [
  4=>'Sabaton', 
  3=>'Freedom Call', 
  2=>'Dimmu Borgir', 
  1=>'Nightwish', 
  0=>'Therion'
];

echo "<b>ksort:</b> Ordena por la llave de menor a mayor.";
echo "<pre>";
ksort($k_array1_ksort);
print_r($k_array1_ksort);
echo "</pre><br/>";


echo "<b>krsort:</b> Ordena por la llave de mayor a menor.";
echo "<pre>";
krsort($k_array1_krsort);
print_r($k_array1_krsort);
echo "</pre><br/>";