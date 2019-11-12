<?php

	//obtener el id de la imagen
	$id=  filter_input(INPUT_GET, 'id');
	if($id==''){
		die ("No tenemos el id");
	}
	
	//conexion con oracle
  $conn=  oci_connect('usuario', 'contrasena', '127.0.0.1/ORCL', 'AL32UTF8');
	
	$sql="SELECT ARCHIVO, TIPO FROM ARCHIVOS WHERE ID = $id";
	
	$stmt = oci_parse($conn, $sql);
	oci_execute($stmt);
	
	$archivo= oci_fetch_array($stmt, OCI_ASSOC + OCI_NUM + OCI_RETURN_NULLS);      
	$blob=$archivo[0]->load();
	$tipo=$archivo[1];
	
	oci_free_statement($stmt);
	oci_close($conn);
	
	
	//header para tranformar la salida en el tipo de archivo que hemos guardado
	header("Content-type: $tipo"); 
	//header('Content-Disposition: attachment; filename="archivo.pdf"'); //forzar a la descarga
	
	echo $blob;