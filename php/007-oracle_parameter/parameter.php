<?php

//conexion con oracle
$conn=  oci_connect('usuario', 'contrasena', '127.0.0.1/ORCL', 'AL32UTF8');

//verificamos si no hay error en la conexion
if(!$conn){
  $error= oci_error();
  die("ERROR: ".$error["message"]);
}

/* preparamos la sentencia sql
 * como observan he declarado dos paramentros en la sentencia sql
 * que recibiran texto desde el oci_bind_by_name más abajo.
 */
$st= oci_parse($conn, "INSERT INTO USUARIOS (ID, NOMBRES, APELLIDOS) VALUES (:ID, :NOMBRES, :APELLIDOS)");

//variables con los datos
$id=1;
$nombres='hugo';
$apellidos='lizama';

//vinculamos las variables a la sentencia sql
oci_bind_by_name($st, ':ID', $id);
oci_bind_by_name($st, ':NOMBRES', $nombres);
oci_bind_by_name($st, ':APELLIDOS', $apellidos);

//ejecutamos el statement
oci_execute($st);

echo "termino";

//cerrar conexion
oci_close($conn);