<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title></title>
  </head>
  <body>
    <form>
      <!-- captcha -->
      <div id='gCaptcha'></div>
      <br/>
      <!-- mensaje verificacion -->
      <div id="msgVerificacion"></div>
    </form>
  </body>
</html>
<script src="../../js/jquery-1.11.2.min.js"></script>

<script>
  //funcion para dibujar captcha
  var widgetId1; 
  function generarCaptcha(){
    widgetId1 = grecaptcha.render('gCaptcha', {
      'sitekey' : '6Lc4KRATAAAAAIEOWIPOL5Cq9lkuXrrZQk75K3m6',
      'callback' : verifCaptcha //funcion para verificar el captcha en nuestra web
    });
  }
  
  //funcion para verificar el captcha
  function verifCaptcha(response){
    //ajax de verificacion
    $.ajax({
      type: 'POST',
      data: {captcha: response}, //enviamos la respuesta del captcha a la url especificada
      dataType: 'json',
      url: "verif_captcha.php"
    }).done(function(data){
      //convertimos la respuesta json en objetos
      var obj = $.parseJSON(JSON.stringify(data));
      var cod = parseInt(obj.cod);
      var mensaje = obj.mensaje;      

      //verificamos el codigo del mensaje
      switch(cod){
        case 0: //falla         
          $('#msgVerificacion').html(mensaje);
          grecaptcha.reset(widgetId1); //reseteamos el captcha (a tu gusto, no es necesario)
          break;

        case 1: //verificado         
          $('#msgVerificacion').html(mensaje);
          break;
      }        
    });
  }
</script>

<!-- api -->
<script src='https://www.google.com/recaptcha/api.js?onload=generarCaptcha&render=explicit' defer async></script>
