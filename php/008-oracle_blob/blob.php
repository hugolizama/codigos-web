<?php
//verifica si se ha hecho clic en el boton guardar
if(filter_input(INPUT_POST, 'btnGuardar')){
  $id=  filter_input(INPUT_POST, 'id');
  
  /*propiedades del archivo*/
  $archivo_nombre=$_FILES['archivo']['name'];
  $archivo_tipo = $_FILES['archivo']['type'];
  $archivo_temp = $_FILES['archivo']['tmp_name'];
  
  //conexion con oracle
  $conn=  oci_connect('usuario', 'contrasena', '127.0.0.1/ORCL', 'AL32UTF8');
  
  //verificamos si no hay error en la conexion
  if(!$conn){
    $error= oci_error();
    die("ERROR: ".$error["message"]);
  }
  
  //lee el archivo a un string
  $archivo_string=  file_get_contents($archivo_temp);
  
  /* preparamos la sentencia sql
    * como observan he declarado unos paramentros en la sentencia sql
    * que recibiran valores desde el oci_bind_by_name más abajo.
  */
  $st= oci_parse($conn, 'INSERT INTO ARCHIVOS (ID, ARCHIVO, NOMBRE, TIPO) 
    VALUES (:ID, empty_blob(), :NOMBRE, :TIPO) 
    RETURNING ARCHIVO INTO :ARCHIVO');
  
  //inicializamos una variable de tipo blob
  $blob=oci_new_descriptor($conn, OCI_D_LOB);
  
  //vinculamos los parametros con las variables
  oci_bind_by_name($st, ":ID", $id);
  oci_bind_by_name($st, ":NOMBRE", $archivo_nombre);
  oci_bind_by_name($st, ":TIPO", $archivo_tipo);
  oci_bind_by_name($st, ":ARCHIVO", $blob, -1, OCI_B_BLOB);
  
  //ejecutamos el statement sin hacer commit
  oci_execute($st, OCI_NO_AUTO_COMMIT);
  $blob->save($archivo_string); //guardamos el archivo como binario
  
  oci_commit($conn); //ejecutamos el commit
  
  //liberamos la variable y cerramos conexion
  $blob->free();
	oci_free_statement($st);
  oci_close($conn);
  
  echo 'termino';
}
?>



<!--FORMULARIO-->
<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title></title>
  </head>
  <body>
    <form method="post" action="" enctype="multipart/form-data">
      id <input type="number" name="id" /><br/>
      <input type="file" name="archivo" /><br/><br/>
      <input type="submit" name="btnGuardar" value="Guardar" />
    </form>
  </body>
</html>
