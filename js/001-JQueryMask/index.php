<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>jquery mask - kiuvox</title>
    <script src="../jquery-1.11.2.min.js" type="text/javascript"></script>
    <script src="js/jquery.mask.min.js" type="text/javascript"></script>
    <script>
      $(document).ready(function(){
        //FORMATO DE MASCARAS
        $('#text1').mask('SSSSS');
        $('#text2').mask('00/00/0000');
        $('#text3').mask('(000) 0000-0000', {placeholder: '(000) 0000-0000'}); //placeholder
        $('#text4').mask('-99999999999999999.00', {
          //opciones
          placeholder: '[-]000[.00]',
          translation: {
            '-': {pattern: /[-]/, optional: true}            
          }
        }); 
      });
    </script>
  </head>
  <body>
    <h1>ENMASCARAR CAMPOS CON JQUERY MASK</h1>
    5 letras <input type="text" id='text1' /><br/>
    fecha: 00/00/0000 <input type="text" id='text2' /><br/>
    telefono: (000) 0000-0000 <input type="text" id='text3' /><br/>
    cantidad: [-]000[.00] <input type="text" id='text4' /><br/>
    nota: [*] opcional
  </body>
</html>
