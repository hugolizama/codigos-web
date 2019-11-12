<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title></title>		
  </head>
  <body>
    <!-- Formulario -->
    Num 1: <input name="num1" id="num1" /><br/>
    Num 2: <input name="num2" id="num2" /></span><br/>
    <input id="btnEnviar" type="button" value="Sumar"/><br/>
    <!-- Fin Formulario -->
    <br/><br>
    Resultado: 
    <div id="resultado"></div>    
    
    <!-- importar jquery -->
    <script src="../jquery-1.11.2.min.js" type="text/javascript"></script> 
    <script>
			$(document).ready(function () {
				//Disparar funcion al hacer clic en el boton Enviar
				$('#btnEnviar').click(function () {
          
          //obtener los datos de las cajas de texto
          var varNum1 = $('#num1').val();
          var varNum2 = $('#num2').val();
          
					//llamada ajax          
          /*Para conformar data es {nomVariable1: contenidoVariable1, nomVariable2: contenidoVariable2}*/
          
					$.ajax({
            data: {num1: varNum1, num2: varNum2},
						url: "procesarDatos.php", //url de donde obtener los datos
						dataType: 'json', //tipo de datos retornados
						type: 'post' //enviar variables como post
					}).done(function (data){
						console.log(data);
            
            //conformar respuesta final
            $('#resultado').html('El resultado es: <b>' + data['res'] + '</b>');
					});
				});
			});
    </script>
    
  </body>
</html>

