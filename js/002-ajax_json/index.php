<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title></title>
		<!-- importar jquery -->
    <script src="../jquery-1.11.2.min.js" type="text/javascript"></script> 
    <script>
			$(document).ready(function () {
				//Disparar funcion al hacer clic en el boton Ajax
				$('#btnAjax').click(function () {
					//llamada ajax
					$.ajax({
						url: "getDatos.php", //url de donde obtener los datos
						dataType: 'json', //tipo de datos retornados
						type: 'post' //enviar variables como post
					}).done(function (data){
						/*ejecutar las siguientes instrucciones
						 * al terminar de ejecutar la llamada
						 * ajax*/
						
						//convertir el objeto JSON a texto
						var json_string = JSON.stringify(data);
						
						//convertir el texto a un nuevo objeto
						var obj = $.parseJSON(json_string);

						/*asignar los valores obtenidos del objeto
						 * a cada unos de losc controlres deseados
						 * en el formulario*/
						$('#nombres').html(obj.nombres);
						$('#apellidos').html(obj.apellidos);
						$('#opciones').html(obj.opciones);
					});
				});
			});
    </script>
  </head>
  <body>
    <input id="btnAjax" type="button" value="Cargar Ajax"/><br/>
    Nombres: <span id="nombres"></span><br/>
    Apellidos: <span id="apellidos"></span>
    <br/>
    <select id="opciones">
      <option value="0">cero</option>
    </select>
  </body>
</html>

