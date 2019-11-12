<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Ajax con JQuery</title>
    <!-- Agregamos la libreria Jquery -->
    <script type="text/javascript" src="../jquery-1.11.2.min.js"></script>

    <!--inicio: script para llamar por ajax -->
    <script>
      $(document).ready(function () {

        //Detectamos cuando hagan clic en el boton de sumar
        $('#btnSumar').click(function () {

          //recogemos el contenido de las cajas de texto
          var num1 = $('#num1').val();
          var num2 = $('#num2').val();

          //formamos un array con los datos que vamos
          //a enviar por medio de la funcion ajax
          var parametros = {
            'num1': num1,
            'num2': num2
          };


          $.ajax({//inicia la funcion ajax
            type: 'POST', //tipo de envio: post o get como en un formulario web
            data: parametros, //ajuntamos los parametros con los datos
            url: "getSuma.php", //url del archivo a llamar y que hace el procedimiento
            dataType: 'html' //tipo de data que retorna
          })
          //done se ejecuta al terminar la ejecucion del archivo getSuma.php
          .done(function (data) {
            //llenamos el div "resultado" con lo obtenido de getSuma.php
            $('#resultado').html(data);
          });
        });
      });
    </script>
    <!--fin: script para llamar por ajax -->
  </head>
  <body>
    <h3>SUMA DE DOS NUMEROS CON AJAX-JQUERY (DEVUELVE HTML)</h3>
    <input type="text" id="num1" /> + <input type="text" id="num2" />
    <input type="button" id="btnSumar" value="Sumar" /> <br/>
    <br/>
    <!-- Este div es el que se llena con el resultado de getSuma.php -->
    <div id="resultado"></div>
  </body>
</html>