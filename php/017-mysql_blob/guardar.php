<?php

//verifica si se ha hecho clic en el boton guardar
if(filter_input(INPUT_POST, 'btnGuardar')){
  
  /*propiedades del archivo*/
  $archivo_nombre=$_FILES['archivo']['name'];
  $archivo_tipo = $_FILES['archivo']['type'];
  $archivo_temp = $_FILES['archivo']['tmp_name'];
  
  //conexion con mysql
  $conn = mysqli_connect('localhost', 'root', '', 'tutoriales-kiuvox') or die("Error al conectar al servidor");	

  //verificamos si no hay error en la conexion
  if(!$conn){
    $error= mysqli_error($conn);
    die("ERROR: ".$error["message"]);
  }

  //convertir la imagen en código binario
  $archivo_binario = (file_get_contents($archivo_temp));
	
  
  /* preparamos la sentencia sql
		* como observan he declarado unos paramentros en la sentencia sql (?)
		* que recibiran valores desde el bind_param.
		* Mas info:
		* http://php.net/manual/de/mysqli-stmt.bind-param.php
  */
  $sql = "INSERT INTO ARCHIVOS (NOMBRE, TIPO, ARCHIVO) VALUES (?, ?, ?)";	
	$stmt = mysqli_prepare($conn, $sql);
	
	$stmt->bind_param('sss', $archivo_nombre, $archivo_tipo, $archivo_binario);
	
	
	
	//ejecutamos la sentencia
  if(mysqli_stmt_execute($stmt)){
    echo "Ya guardamos el archivo en la base de datos<br/>
          &Uacute;ltimo id insertado: ". mysqli_stmt_insert_id($stmt);
  }else{
    echo "Chanfle, hubo un problema y no se guardo el archivo. ". mysqli_stmt_error($stmt)."<br/>";
  }  
	
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
  
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
		<h3>Guardar un archivo en MySQL</h3>
    <form method="post" action="" enctype="multipart/form-data">
      <input type="file" name="archivo" /><br/><br/>
      <input type="submit" name="btnGuardar" value="Guardar" />
    </form>
  </body>
</html>